<?php

class Email_notification_model extends CI_Model
{

  /**
   * @var string what table is used in the database for the users
   */
  public $_users_table = 'users';

  /**
   * @var string what table is used in the database for the users
   */
  public $_blogs_table = 'blogs';

  /**
   * @var string what table is used in the database for the users
   */
  public $_bookings_table = 'bookings';

  /**
   * @var string what table is used in the database for the users
   */
  public $_contact_inquiries_table = 'contact_inquiries';


  /**
   * @var string what table is used in the database for the users
   */
  public $_albums_table = 'albums';

  /**
   * @var string what table is used in the database for the users
   */
  public $_remidners_table = 'reminders';


  /**
   * @var string what table is used in the database for the users
   */
  public $_email_settings_table = 'email_settings';


  /**
   * @var string what table is used in the database for the users
   */
  public $_subscribers_table = 'subscribers';

  /**
   * @var string what table is used in the database for the system_logs
   */
  public $_logs_table = 'system_logs';

  /**
   * @var string what table is used in the database for the system_logs
   */
  public $_general_config_table = 'general_config';

  /**
   * @var string what table is used in the database for the system_logs
   */
  public $_emails_table = 'emails';

  /**
   * @var string what table is used in the database for the system_logs
   */
  public $_our_services_table = 'our_services';

  /**
   * @var string what table is used in the database for the system_logs
   */
  public $_events_table = 'events';

  /**
   * @var string what table is used in the database for the users
   */
  public $_videos_table = 'videos';


  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->lang->load('email');
    $this->lang->load('header');
    $this->config->load('email');
    $this->load->library('email');
    $this->load->library("phpmailer_library");

    $mail = $this->phpmailer_library->load();
  }
  var $table = 'emails';
  var $column_order = array(null, 'email_to', 'email_title', 'date_created', null); //set column field database for datatable orderable
  var $column_search = array('email_to', 'email_cc', 'email_bcc', 'email_desc', 'email_title', 'date_created'); //set column field database for datatable searchable 
  var $order = array('email_id' => 'desc'); // default order 


  private function _get_datatables_query()
  {
    $this->db->from($this->table);

    $i = 0;

    foreach ($this->column_search as $item) // loop column 
    {
      if (isset($_REQUEST['search']['value'])) // if datatable send POST for search
      {

        if ($i === 0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_REQUEST['search']['value']);
        } else {
          $this->db->or_like($item, $_REQUEST['search']['value']);
        }

        if (count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
    //		print_r($_REQUEST['order']);
    if (isset($_REQUEST['order']) && $_REQUEST['order'][0]['column'] != 0) // here order processing
    {
      $this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    } else {
      $this->db->order_by('email_id', 'desc');
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_REQUEST['length'] != -1)
      $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
    $query = $this->db->get();

    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  function save_email($email_details)
  {
    // start database transaction
    $this->db->trans_start();

    //save user details
    $this->db->insert($this->_emails_table, $email_details);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $email_id = FALSE;
    } else {
      $e_details =  $this->get_where($this->_emails_table, array('email_rand_id' => $email_details['email_rand_id']));
      $email_id = $e_details[0]['email_id'];
    }

    //return user_id
    return $email_id;
  }

  function update_reminder_details($table, $reminder_details, $condition)
  {

    // start database transaction
    $this->db->trans_start();

    $this->db->where($condition);

    //save user details
    $this->db->update($table, $reminder_details);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $rem_id = FALSE;
    } else {
      $reminder_details =  $this->get_where($this->_remidners_table, $condition);
      $rem_id = $reminder_details[0]['rem_id'];
    }

    //return rem_id
    return $rem_id;
  }

  function add($log_type, $operation)
  {
    $ip = $this->input->ip_address();
    $os = $this->agent->platform();
    if ($this->agent->is_browser()) {
      $agent = $this->agent->browser() . ' ' . $this->agent->version();
    } elseif ($this->agent->is_robot()) {
      $agent = $this->agent->robot();
    } elseif ($this->agent->is_mobile()) {
      $agent = $this->agent->mobile();
    } else {
      $agent = 'Unidentified User Agent';
    }
    $browser = $agent;
    $url = $this->uri->uri_string();
    $rand_id = random_string('alnum', 6);
    $log_data = array(
      'rand_id' => $rand_id,
      'operation' => $operation,
      'log_type' => $log_type,
      'ip' => $ip,
      'os' => $os,
      'browser' => $browser,
      'url' => $url,
      'timestamp' => now()
    );
    $this->db->insert($this->_logs_table, $log_data);
  }

  public function get_where($tab, $condi)
  {
    $this->db->select('*');
    $this->db->from($tab);
    $this->db->where($condi);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function new_user_registered($user_id)
  {
    try {
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
      $email_configs = array();
      if (!empty($e_configs)) {
        foreach ($e_configs as $config) {
          $email_configs[$config['config_name']] = $config['config_value'];
        }
      }

      if ($email_configs['send_an_email_when_new_user_register']) {
        $user_details = $this->get_where($this->_users_table, array('user_id' => $user_id));

        $sender_details = $this->config->item('sender_details');

        $tmpl['to'] = $user_details[0]['email'];
        $tmpl['verify_token'] = $user_details[0]['email_verification_token'];
        $tmpl['to_user_name'] = $user_details[0]['first_name'] . " " . $user_details[0]['last_name'];
        $tmpl['from_username'] = $sender_details['smtp_user'];
        $tmpl['secret'] = $sender_details['smtp_pass'];
        $tmpl['reply_email'] = $tmpl['from_username'];
        $tmpl['smtp_host'] = $sender_details['smtp_host'];
        $tmpl['email_signature'] = $configs['email_signature'];
        $tmpl['logo'] = $configs['logo_black'];

        $email_title = lang('email_news_user_register_text_2');
        $to = $tmpl['to'];
        $cc = "";
        $bcc = "";

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $tmpl['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $tmpl['from_username'];                 // SMTP username
        $mail->Password = $tmpl['secret'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($sender_details['set_from'], "");

        $mail->addAddress($to, $tmpl['to_user_name']);     // Add a recipient
        $mail->addReplyTo($tmpl['reply_email'], $sender_details['reply_user_name']);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;
        $body = $this->load->view('emails/email.new_user_register.php', $tmpl, TRUE);

        $mail->Body    = $body;

        $mail->send();
        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $email_response = $this->save_email($e_details);
        if ($email_response) {
          $this->add('info', 'Welcome email sent to the new registered user. Email ID(' . $email_response . ')');
        } else {
          $this->add('error', 'Welcome email could not be sent to the new registered user.');
        }

        return true;
      }
    } catch (Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  public function send_subscription_details($user_id, $subscription_end_date, $subscription_payment_id)
  {
    try {

      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }


      $user_details = $this->get_where($this->_users_table, array('deleted' => '0', 'user_id=' => $user_id));

      $to = "";
      if (!empty($user_details)) {

        $to = $user_details[0]['email'];
        $sender_details = $this->config->item('sender_details');

        $tmpl['to'] = $to;

        $tmpl['logo'] = $configs['logo_black'];
        $tmpl['to_user_name'] = $user_details[0]['first_name'];

        $tmpl['end_date'] = date($configs['date_format'], strtotime($subscription_end_date));
        $tmpl['payment_id'] = $subscription_payment_id;

        $tmpl['from_username'] = $sender_details['smtp_user'];
        $tmpl['secret'] = $sender_details['smtp_pass'];
        $tmpl['reply_email'] = $tmpl['from_username'];
        $tmpl['smtp_host'] = $sender_details['smtp_host'];
        $tmpl['email_signature'] = $configs['email_signature'];

        $email_title = lang('thanks_for_the_subscription');
        $tmpl['email_title'] = $email_title;

        $cc = "";
        $bcc = "";

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $tmpl['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $tmpl['from_username'];                 // SMTP username
        $mail->Password = $tmpl['secret'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($sender_details['set_from'], "");

        $mail->addAddress($to, $tmpl['to_user_name']);     // Add a recipient

        $mail->addReplyTo($tmpl['reply_email'], $sender_details['reply_user_name']);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;
        $body = $this->load->view('emails/email.notify_to_user_about_subscription.php', $tmpl, TRUE);

        $mail->Body    = $body;

        $mail->send();

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_to'] = $to;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $email_response = $this->save_email($e_details);
        if ($email_response) {
          $this->add('info', 'User subscription email saved successfully. Email ID(' . $email_response . ')');
        } else {
          $this->add('error', 'User subscription email could not be saved. user ID(' . $user_id . ')');
        }

        return true;
      }
    } catch (Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  public function send_contact_us_details($name,$email,$contact_no,$message)
  {
    try {

      $to = "";
      if (!empty($email)) {

        $to = 'prasun@matrixnmedia.com';
        $sender_details = $this->config->item('sender_details');
        // echo "<pre>";
        // print_r($sender_details); die;
        $tmpl['to'] = $to;
        $tmpl['to_user_name'] ='Admin';

        $tmpl['from_username'] = $sender_details['smtp_user'];
        $tmpl['secret'] = $sender_details['smtp_pass'];
        $tmpl['reply_email'] = $tmpl['from_username'];
        $tmpl['smtp_host'] = $sender_details['smtp_host'];
        

        $email_title = lang($name. ' conatct you through conatct us form');
        $tmpl['email_title'] = $email_title;

        $cc = "";
        $bcc = "";

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $tmpl['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $tmpl['from_username'];                 // SMTP username
        $mail->Password = $tmpl['secret'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($sender_details['set_from'], "");

        $mail->addAddress($to, $tmpl['to_user_name']);     // Add a recipient

        $mail->addReplyTo($tmpl['reply_email'], $sender_details['reply_user_name']);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;
        //$body = $this->load->view('emails/email.notify_to_user_about_subscription.php', $tmpl, TRUE);
        $body='';
        $body.='<p>The following user  who conatct you through conatct us form</p>';
        $body.='<p>Name:'.$name.'</p>';
        $body.='<p>Email:'.$email.'</p>';
        $body.='<p>Contact No:'.$contact_no.'</p>';
        $body.='<p>Message:'.$message.'</p>';
        //echo $body; die;
        $mail->Body    = $body;

        $mail->send();

        return true;
      }
    } catch (Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
  }


  public function send_reset_password_email($user_id)
  {
    try {
      $user_details = $this->get_where($this->_users_table, array('user_id' => $user_id));

      $sender_details = $this->config->item('sender_details');

      $token = random_string('alnum', 50);

      $user_data = array();
      $user_data['password_reset_token'] = $token;
      $user_data['password_reset_token_validity'] = date('Y-m-d H:i:s', strtotime("+15 minutes", time()));

      $where = array();
      $where['user_id'] = $user_details[0]['user_id'];


      $res = $this->users_model->update_user_details($this->_users_table, $user_data, $where);

      if ($res) {
        $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

        $configs = array();
        if (!empty($general_config)) {
          foreach ($general_config as $config) {
            $configs[$config['config_name']] = $config['config_value'];
          }
        }

        $tmpl['to'] = $user_details[0]['email'];
        $tmpl['verify_token'] = $token;

        $full_name = "User";
        if (isset($user_details[0]['first_name'])) {
          $full_name = $user_details[0]['first_name'];
        }
        if (isset($user_details[0]['last_name'])) {
          $full_name .= " " . $user_details[0]['last_name'];
        }
        $tmpl['to_user_name'] = $full_name;
        $tmpl['from_username'] = $sender_details['smtp_user'];
        $tmpl['secret'] = $sender_details['smtp_pass'];
        $tmpl['reply_email'] = $tmpl['from_username'];
        $tmpl['smtp_host'] = $sender_details['smtp_host'];
        $tmpl['email_signature'] = $configs['email_signature'];
        $tmpl['logo'] = $configs['logo_black'];

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $tmpl['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $tmpl['from_username'];                 // SMTP username
        $mail->Password = $tmpl['secret'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];                                    // TCP port to connect to

        $to = $tmpl['to'];
        $cc = "";
        $bcc = "";
        //Recipients
        $mail->setFrom($tmpl['from_username'], $sender_details['from_user_name']);
        $mail->addAddress($tmpl['to'], $tmpl['to_user_name']);     // Add a recipient
        $mail->addReplyTo($tmpl['reply_email'], $sender_details['reply_user_name']);

        //Attachments
        //            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $email_title = lang('reset_your_account_password');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;
        $body = $this->load->view('emails/email.reset_account_password.php', $tmpl, TRUE);

        $mail->Body    = $body;

        $mail->send();

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_to'] = $to;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        return true;
      } else {
        return FALSE;
      }
    } catch (Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  public function send_newsletter_subscribe_email($subscribe_id)
  {
    try {

      $subscribe_details = $this->users_model->get_where($this->_subscribers_table, array('sub_id' => $subscribe_id));
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
      $email_configs = array();
      if (!empty($e_configs)) {
        foreach ($e_configs as $config) {
          $email_configs[$config['config_name']] = $config['config_value'];
        }
      }

      if ($email_configs['send_email_to_new_subscription']) {

        if (!empty($subscribe_details)) {

          $sender_details = $this->config->item('sender_details');

          //Server settings
          $mail = $this->phpmailer_library->load();
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->CharSet = 'UTF-8';
          $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $sender_details['smtp_user'];                 // SMTP username
          $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $sender_details['smtp_port'];
          // TCP port to connect to
          //Recipients
          $mail->setFrom($sender_details['set_from'], "");

          $to = $subscribe_details[0]['email'];
          $cc = "";
          $bcc = "";

          $mail->addAddress($subscribe_details[0]['email'], $subscribe_details[0]['name']);     // Add a recipient                //Content

          $mail->isHTML(true);                                  // Set email format to HTML
          $email_title = lang('your_email_is_subscribed_successfully');
          $mail->Subject = $email_title;

          $tmpl = array();
          $tmpl['user_name'] = $subscribe_details[0]['name'];
          $tmpl['verify_token'] = $subscribe_details[0]['rand_id'];
          $tmpl['reply_email'] = $sender_details['smtp_user'];
          $tmpl['logo'] = $configs['logo_black'];

          $tmpl['email_signature'] = $configs['email_signature'];

          $body = $this->load->view('emails/email.new_subscribe_email.php', $tmpl, TRUE);

          $mail->Body    = $body;

          if (!$mail->send()) {
            $error = "An Email notification could not be send to subscriber " . $subscribe_details[0]['name'] . "  for verify their email, Subscriber ID(" . $subscribe_details[0]['sub_id'] . ") Mailer Error: " . $mail->ErrorInfo;
            $this->add('error', $error);
            $return = false;
          } else {
            //save email details
            $e_details = array();
            $e_details['email_rand_id'] = random_string('alnum', 6);
            $e_details['email_title'] = $email_title;
            $e_details['email_cc'] = $cc;
            $e_details['email_bcc'] = $bcc;
            $e_details['email_to'] = $to;
            $e_details['email_desc'] = $body;
            $e_details['date_created'] = now();

            $this->save_email($e_details);

            $this->add('info', "Sent an email notification to new subscriber for verify their email, Name(" . $subscribe_details[0]['name'] . "), subscriber ID(" . $subscribe_details[0]['sub_id'] . ")");
            $return = true;
          }
        }
        return $return;
      } else {
        return false;
      }
    } catch (Exception $e) {
      $error = 'New subscription email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      $this->add('error', $error);
      return false;
    }
  }
  public function send_contact_inquiry_email($inq_id)
  {
    try {

      $inq_details = $this->users_model->get_where($this->_contact_inquiries_table, array('inq_id' => $inq_id));
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
      $email_configs = array();
      if (!empty($e_configs)) {
        foreach ($e_configs as $config) {
          $email_configs[$config['config_name']] = $config['config_value'];
        }
      }

      if ($email_configs['send_a_thanks_email_when_someone_contact_us']) {

        if (!empty($inq_details)) {

          $sender_details = $this->config->item('sender_details');

          //Server settings
          $mail = $this->phpmailer_library->load();
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
          $mail->isSMTP();
          $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
          $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $sender_details['smtp_user'];                 // SMTP username
          $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $sender_details['smtp_port'];
          // TCP port to connect to
          //Recipients
          $mail->setFrom($sender_details['set_from'], "");
          $to = $inq_details[0]['email'];
          $cc = "";
          $bcc = "";
          $mail->addAddress($inq_details[0]['email'], $inq_details[0]['first_name']);     // Add a recipient                //Content

          $mail->isHTML(true);                                  // Set email format to HTML
          $email_title = lang('thanks_for_contacting_us_we_will_get_in_touch_with_you_shortly');
          $mail->Subject = $email_title;

          $tmpl = array();
          $user_name = "";
          if (isset($inq_details[0]['first_name'])) {
            $user_name = $inq_details[0]['first_name'];
          }
          if (isset($inq_details[0]['last_name'])) {
            $user_name .= " " . $inq_details[0]['last_name'];
          }

          $tmpl['user_name'] = $user_name;
          $tmpl['subject'] = $inq_details[0]['subject'];

          $tmpl['reply_email'] = $sender_details['smtp_user'];
          $tmpl['logo'] = $configs['logo_black'];

          $tmpl['email_signature'] = $configs['email_signature'];

          $body = $this->load->view('emails/email.new_contact_email.php', $tmpl, TRUE);

          $mail->Body    = $body;

          if (!$mail->send()) {
            $error = "Contact inquiry thanks email could not be sent to " . $user_name . " , inquiry id(" . $inq_id . ") Mailer Error: " . $mail->ErrorInfo;
            $this->add('error', $error);
            $return = false;
          } else {
            //save email details
            $e_details = array();
            $e_details['email_rand_id'] = random_string('alnum', 6);
            $e_details['email_title'] = $email_title;
            $e_details['email_cc'] = $cc;
            $e_details['email_bcc'] = $bcc;
            $e_details['email_to'] = $to;
            $e_details['email_desc'] = $body;
            $e_details['date_created'] = now();

            $this->save_email($e_details);

            $this->add('info', "Contact inquiry thanks email sent successfully. name(" . $user_name . "), inquiry id(" . $inq_id . ")");
            $return = true;
          }
        }
        return $return;
      } else {
        return false;
      }
    } catch (Exception $e) {
      $error = 'New subscription email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      $this->add('error', $error);
      return false;
    }
  }
  public function send_email_to_client_for_share_public_url_of_album($link, $email)
  {
    try {

      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $sender_details = $this->config->item('sender_details');

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $to = $email;
      $cc = "";
      $bcc = "";

      $mail->addAddress($email);     // Add a recipient                //Content

      $mail->isHTML(true);                                  // Set email format to HTML
      $email_title = "" . ' ' . lang('share_an_album_link_with_you');
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];
      $tmpl['public_link'] = $link;
      $tmpl['studio_name'] = "";
      $tmpl['logo'] = $configs['logo_black'];
      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.share_album_public_link_with_client.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "Album public link could not be sent to the client(" . $email . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_to'] = $to;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $this->add('info', "Album public link sent to the client(" . $email . ")");
        $return = true;
      }
      return $return;
    } catch (Exception $e) {
      $error = 'Album public link could not be sent to the client(' . $email . '). Mailer Error: ' . $mail->ErrorInfo;
      $this->add('error', $error);
      return false;
    }
  }

  public function send_booking_email_to_admin($booking_id)
  {
    try {

      $email_config = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $email_configs = array();
      if (!empty($email_config)) {
        foreach ($email_config as $config) {
          $email_configs[$config['config_name']] = $config['config_value'];
        }
      }

      if ($email_configs['send_an_email_to_all_the_admins_when_new_booking']) {

        $sender_details = $this->config->item('sender_details');

        $all_admins = $this->users_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1', 'user_role_id' => '1'));
        $booking_details = $this->users_model->get_where($this->_bookings_table, array('book_id' => $booking_id));

        $email_title = sprintf(lang('new_booking_is_arrive_on_x'), "");
        $to = "";
        $cc = "";
        $bcc = "";

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
        $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $sender_details['smtp_user'];                 // SMTP username
        $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];
        // TCP port to connect to
        //Recipients
        $mail->setFrom($sender_details['set_from'], "");

        $i = 0;
        foreach ($all_admins as $user) {
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
          if ($i == 0) {
            $to .= $user['email'];
          } else {
            $to .= ", " . $user['email'];
          }
          $i++;
        }

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;

        $tmpl = array();

        $tmpl['reply_email'] = $sender_details['smtp_user'];
        $tmpl['bookings_user_name'] = $booking_details[0]['user_name'];
        $tmpl['bookings_mobile_no'] = $booking_details[0]['mobile_no'];
        $tmpl['bookings_email'] = $booking_details[0]['email'];
        $tmpl['bookings_date'] = $booking_details[0]['date'];
        $tmpl['bookings_time'] = $booking_details[0]['time'];
        $tmpl['bookings_descriptions'] = $booking_details[0]['descriptions'];
        $tmpl['bookings_url'] = $booking_details[0]['rand_id'];
        $tmpl['date_format'] = $configs['date_format'];
        $tmpl['studio_name'] = "";
        $tmpl['user_name'] = lang('administrator');
        $tmpl['logo'] = $configs['logo_black'];

        $tmpl['email_signature'] = $configs['email_signature'];

        $body = $this->load->view('emails/email.booking_email_to_admin.php', $tmpl, TRUE);

        $mail->Body    = $body;

        if (!$mail->send()) {
          $error = "New booking email could not be sent to the admins, booking ID(" . $booking_id . "). Mailer Error: " . $mail->ErrorInfo;
          $this->add('error', $error);
          $return = false;
        } else {
          $this->add('info', "New booking email sent to the admins, Booking ID(" . $booking_id . ")");

          //save email details
          $e_details = array();
          $e_details['email_rand_id'] = random_string('alnum', 6);
          $e_details['email_title'] = $email_title;
          $e_details['email_to'] = $to;
          $e_details['email_cc'] = $cc;
          $e_details['email_bcc'] = $bcc;
          $e_details['email_desc'] = $body;
          $e_details['date_created'] = now();

          $this->save_email($e_details);

          $return = true;
        }
        return $return;
      }
    } catch (Exception $e) {
      $error = 'Album public link could not be sent to the client(' . $email . '). Mailer Error: ' . $mail->ErrorInfo;
      $this->add('error', $error);
      return false;
    }
  }

  public function send_booking_email_to_user($booking_id, $email)
  {
    try {

      $email_config = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $email_configs = array();
      if (!empty($email_config)) {
        foreach ($email_config as $config) {
          $email_configs[$config['config_name']] = $config['config_value'];
        }
      }

      if ($email_configs['send_a_thanks_email_to_the_user_when_new_booking']) {

        $sender_details = $this->config->item('sender_details');

        $booking_details = $this->users_model->get_where($this->_bookings_table, array('book_id' => $booking_id));

        $email_title = sprintf(lang('title_thanks_for_booking_with_'), "");
        $to = $email;
        $cc = "";
        $bcc = "";

        //Server settings
        $mail = $this->phpmailer_library->load();
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
        $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $sender_details['smtp_user'];                 // SMTP username
        $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $sender_details['smtp_port'];
        // TCP port to connect to
        //Recipients
        $mail->setFrom($sender_details['set_from'], "");


        $mail->addAddress($email, "");

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_title;

        $tmpl = array();

        $tmpl['reply_email'] = $sender_details['smtp_user'];
        $tmpl['studio_name'] = "";
        $tmpl['user_name'] = '';
        $tmpl['logo'] = $configs['logo_black'];

        $tmpl['email_signature'] = $configs['email_signature'];

        $body = $this->load->view('emails/email.thanks_for_booking_with_us.php', $tmpl, TRUE);

        $mail->Body    = $body;

        if (!$mail->send()) {
          $error = "New booking email could not be sent to the admins, booking ID(" . $booking_id . "). Mailer Error: " . $mail->ErrorInfo;
          $this->add('error', $error);
          $return = false;
        } else {
          $this->add('info', "New booking email sent to the admins, Booking ID(" . $booking_id . ")");

          //save email details
          $e_details = array();
          $e_details['email_rand_id'] = random_string('alnum', 6);
          $e_details['email_title'] = $email_title;
          $e_details['email_to'] = $to;
          $e_details['email_cc'] = $cc;
          $e_details['email_bcc'] = $bcc;
          $e_details['email_desc'] = $body;
          $e_details['date_created'] = now();

          $this->save_email($e_details);

          $return = true;
        }
        return $return;
      }
    } catch (Exception $e) {
      $error = 'Album public link could not be sent to the client(' . $email . '). Mailer Error: ' . $mail->ErrorInfo;
      $this->add('error', $error);
      return false;
    }
  }




  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function send_reminder_email_notification()
  {

    try {
      $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

      $configs = array();
      if (!empty($general_config)) {
        foreach ($general_config as $config) {
          $configs[$config['config_name']] = $config['config_value'];
        }
      }

      $date = date('Y-m-d');
      $time = date('H:i:s');
      $remiders = $this->reminders_model->get_reminders_for_email_notification();
      if (!empty($remiders)) {
        $result = array();
        foreach ($remiders as $remider) {
          if ($remider['send_to_users']) {
            $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

            $sender_details = $this->config->item('sender_details');

            $email_title = $remider['rem_title'];
            $to = "";
            $cc = "";
            $bcc = "";

            //Server settings
            $mail = $this->phpmailer_library->load();
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
            $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $sender_details['smtp_user'];                 // SMTP username
            $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $sender_details['smtp_port'];
            // TCP port to connect to
            //Recipients
            $mail->setFrom($sender_details['set_from'], "");

            $i = 0;
            $k = 0;
            $bcc = "";
            foreach ($users as $user) {
              if ($i == 0) {
                $to .= $user['email'];
                $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
              } else {
                if ($k == 0) {
                  $bcc = $user['email'];
                } else {
                  $bcc .= ", " . $user['email'];
                }
                $k++;
              }
              $i++;
            }
            $mail->addBCC($bcc);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_title;

            $tmpl = array();

            $tmpl['reply_email'] = $sender_details['smtp_user'];

            $tmpl['reminder_title'] = $remider['rem_title'];
            $tmpl['reminder_desc'] = $remider['rem_desc'];

            $tmpl['user_name'] = lang('user');
            $tmpl['logo'] = $configs['logo_black'];

            $tmpl['email_signature'] = $configs['email_signature'];

            $body = $this->load->view('emails/email.reminder_email.php', $tmpl, TRUE);

            $mail->Body    = $body;

            if (!$mail->send()) {
              $error = "Reminder email could not be sent to the users, Reminder ID(" . $remider['rem_id'] . "). Mailer Error: " . $mail->ErrorInfo;
              $this->add('error', $error);
              $return = false;
            } else {
              $this->add('info', "Reminder email sent successfully to the all users, Reminder ID(" . $remider['rem_id'] . ")");

              //save email details
              $e_details = array();
              $e_details['email_rand_id'] = random_string('alnum', 6);
              $e_details['email_title'] = $email_title;
              $e_details['email_to'] = $to;
              $e_details['email_cc'] = $cc;
              $e_details['email_bcc'] = $bcc;
              $e_details['email_desc'] = $body;
              $e_details['date_created'] = now();

              $this->save_email($e_details);

              $wh = array();
              $wh['rem_id'] = $remider['rem_id'];

              $d = array();
              $d['status'] = "Completed";

              $r = $this->update_reminder_details($this->_remidners_table, $d, $wh);

              if ($r) {
                $this->add('info', "Reminder status marked as completed. Reminder ID(" . $r . ")");
              } else {
                $this->add('error', "Reminder status could not be marked as Completed. Reminder ID(" . $remider['rem_id'] . ")");
              }

              $return = true;
            }
          }
          if ($remider['send_to_subscribers']) {
            $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));


            $sender_details = $this->config->item('sender_details');

            $email_title = $remider['rem_title'];
            $to = "";
            $cc = "";
            $bcc = "";

            //Server settings
            $mail = $this->phpmailer_library->load();
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
            $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $sender_details['smtp_user'];                 // SMTP username
            $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $sender_details['smtp_port'];
            // TCP port to connect to
            //Recipients
            $mail->setFrom($sender_details['set_from'], "");

            $i = 0;
            $k = 0;
            $bcc = "";
            foreach ($users as $user) {
              if ($i == 0) {
                $to .= $user['email'];
                $mail->addAddress($user['email'], $user['name']);
              } else {
                if ($k == 0) {
                  $bcc = $user['email'];
                } else {
                  $bcc .= ", " . $user['email'];
                }
                $k++;
              }
              $i++;
            }
            $mail->addBCC($bcc);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_title;

            $tmpl = array();

            $tmpl['reply_email'] = $sender_details['smtp_user'];

            $tmpl['reminder_title'] = $remider['rem_title'];
            $tmpl['reminder_desc'] = $remider['rem_desc'];

            $tmpl['user_name'] = lang('user');
            $tmpl['logo'] = $configs['logo_black'];

            $tmpl['email_signature'] = $configs['email_signature'];

            $body = $this->load->view('emails/email.reminder_email.php', $tmpl, TRUE);

            $mail->Body    = $body;

            if (!$mail->send()) {
              $error = "Reminder email could not be sent to the subscribers, Reminder ID(" . $remider['rem_id'] . "). Mailer Error: " . $mail->ErrorInfo;
              $this->add('error', $error);
              $return = false;
            } else {
              $this->add('info', "Reminder email sent successfully to the all subscribers, Reminder ID(" . $remider['rem_id'] . ")");

              //save email details
              $e_details = array();
              $e_details['email_rand_id'] = random_string('alnum', 6);
              $e_details['email_title'] = $email_title;
              $e_details['email_to'] = $to;
              $e_details['email_cc'] = $cc;
              $e_details['email_bcc'] = $bcc;
              $e_details['email_desc'] = $body;
              $e_details['date_created'] = now();

              $this->save_email($e_details);

              $wh = array();
              $wh['rem_id'] = $remider['rem_id'];

              $d = array();
              $d['status'] = "Completed";

              $r = $this->update_reminder_details($this->_remidners_table, $d, $wh);

              if ($r) {
                $this->add('info', "Reminder status marked as completed. Reminder ID(" . $r . ")");
              } else {
                $this->add('error', "Reminder status could not be marked as Completed. Reminder ID(" . $remider['rem_id'] . ")");
              }
              $return = true;
            }
          }
        }
        $result = array('status' => true, 'data' => array(), 'message' => lang('reminder_email_notification_sent_successfully'));
        return $result;
      } else {
        $result = array('status' => true, 'data' => array(), 'message' => lang('no_reminder_found_for_send_an_email'));
        return $result;
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong') . ' ' . $e->getMessage());
      return $result;
    }
  }

  public function send_blog_post_email_to_users($blog_id)
  {
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_all_the_users_when_new_blog_is_published']) {
      $blog_details = $this->get_where($this->_blogs_table, array('blog_id' => $blog_id));

      $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_blog_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['blog_title'];
      $tmpl['blog_desc'] = $blog_details[0]['blog_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['blog_l_image'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_blog_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New blog post email could not be sent to the users, Blog ID(" . $blog_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New blog post email sent to all the users, Blog ID(" . $blog_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }

    if ($email_configs['send_an_email_to_all_the_subscribers_when_new_blog_is_published']) {
      $blog_details = $this->get_where($this->_blogs_table, array('blog_id' => $blog_id));

      $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_blog_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to = $user['email'];
          $mail->addAddress($user['email'], $user['name']);
        } else {
          if ($k == 0) {
            $bcc .= $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }

      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['blog_title'];
      $tmpl['blog_desc'] = $blog_details[0]['blog_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['blog_l_image'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_blog_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New blog post email could not be sent to the subscribers, Blog ID(" . $blog_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New blog post email sent to all the subscribers, Blog ID(" . $blog_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  public function send_new_service_post_email_to_users($service_id)
  {
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_all_the_users_when_new_service_is_added']) {
      $blog_details = $this->get_where($this->_our_services_table, array('ser_id' => $service_id));

      $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_service_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['ser_title'];
      $tmpl['blog_desc'] = $blog_details[0]['s_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['ser_l_img'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_service_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New service post email could not be sent to the users, Service ID(" . $service_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New service post email sent to all the users, Service ID(" . $service_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }

    if ($email_configs['send_an_email_to_all_the_subscribers_when_new_service_is_added']) {
      $blog_details = $this->get_where($this->_our_services_table, array('ser_id' => $service_id));

      $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_service_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['ser_title'];
      $tmpl['blog_desc'] = $blog_details[0]['s_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['ser_l_img'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_service_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New service post email could not be sent to the subscribers, Service ID(" . $service_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New service post email sent to all the subscribers, Service ID(" . $service_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  public function send_event_post_email_to_users($event_id)
  {
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_all_the_users_when_new_event_is_published']) {
      $blog_details = $this->get_where($this->_events_table, array('evt_id' => $event_id));

      $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_event_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['evt_title'];
      $tmpl['blog_desc'] = $blog_details[0]['evt_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['evt_l_image'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_event_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New event post email could not be sent to the users, Event ID(" . $event_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New event post email sent to all the users, Event ID(" . $event_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }

    if ($email_configs['send_an_email_to_all_the_subscribers_when_new_event_is_published']) {
      $blog_details = $this->get_where($this->_events_table, array('evt_id' => $event_id));

      $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_event_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['evt_title'];
      $tmpl['blog_desc'] = $blog_details[0]['evt_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['evt_l_image'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_event_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New event post email could not be sent to the subscribers, Event ID(" . $event_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New event post email sent to all the subscribers, Event ID(" . $event_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  public function send_video_post_email_to_users($video_id)
  {
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_all_the_users_when_new_video_is_published']) {
      $blog_details = $this->get_where($this->_videos_table, array('video_id' => $video_id));

      $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_video_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['video_title'];
      $tmpl['blog_desc'] = $blog_details[0]['video_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['video_l_thumb'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_video_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New video post email could not be sent to the users, Video ID(" . $video_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New video post email sent to all the users, Video ID(" . $video_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }

    if ($email_configs['send_an_email_to_all_the_subscribers_when_new_video_is_published']) {
      $blog_details = $this->get_where($this->_videos_table, array('video_id' => $video_id));

      $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_video_posted_on_x_'), "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['video_title'];
      $tmpl['blog_desc'] = $blog_details[0]['video_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['video_l_thumb'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_video_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New video post email could not be sent to the subscribers, Viedo ID(" . $video_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New video post email sent to all the subscribers, Video ID(" . $video_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  public function send_live_streaming_post_email_to_users($video_id)
  {
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_all_the_users_when_new_live_streaming_is_published']) {
      $blog_details = $this->get_where($this->_videos_table, array('video_id' => $video_id));

      $users = $this->reminders_model->get_where($this->_users_table, array('deleted' => '0', 'visibility' => '1'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('x_is_live_nowclick_here_to_watch_live_video_from_x'), "", "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['video_title'];
      $tmpl['blog_desc'] = $blog_details[0]['video_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['video_l_thumb'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_live_streaming_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New live streaming post email could not be sent to the users, Live streaming ID(" . $video_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New live streaming post email sent to all the users, Live streaming ID(" . $video_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }

    if ($email_configs['send_an_email_to_all_the_subscribers_when_new_live_streaming_is_published']) {
      $blog_details = $this->get_where($this->_videos_table, array('video_id' => $video_id));

      $users = $this->reminders_model->get_where($this->_subscribers_table, array('deleted' => '0'));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('x_is_live_nowclick_here_to_watch_live_video_from_x'), "", "");
      $to = "";
      $cc = "";
      $bcc = "";

      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $i = 0;
      $k = 0;
      $bcc = "";
      foreach ($users as $user) {
        if ($i == 0) {
          $to .= $user['email'];
          $mail->addAddress($user['email'], $user['name']);
        } else {
          if ($k == 0) {
            $bcc = $user['email'];
          } else {
            $bcc .= ", " . $user['email'];
          }
          $k++;
        }
        $i++;
      }
      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['blog_title'] = $blog_details[0]['video_title'];
      $tmpl['blog_desc'] = $blog_details[0]['video_desc'];
      $tmpl['blog_l_image'] = $blog_details[0]['video_l_thumb'];

      $tmpl['client_name'] = "";
      $tmpl['blog_url'] = $blog_details[0]['rand_id'];
      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_live_streaming_posted.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New live streaming post email could not be sent to the subscribers, live streaming ID(" . $video_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New live streaming post email sent to all the subscribers, live streaming ID(" . $video_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  function send_an_album_created_notificaion_to_the_users($to, $bcc, $album_id)
  {
    $cc = "";
    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));
    $configs = array();
    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $configs[$config['config_name']] = $config['config_value'];
      }
    }

    $e_configs = $this->users_model->get_where($this->_email_settings_table, array('deleted' => '0'));
    $email_configs = array();
    if (!empty($e_configs)) {
      foreach ($e_configs as $config) {
        $email_configs[$config['config_name']] = $config['config_value'];
      }
    }

    if ($email_configs['send_an_email_to_the_user_when_an_album_is_created_for_him']) {
      $album_details = $this->get_where($this->_albums_table, array('album_id' => $album_id));

      $sender_details = $this->config->item('sender_details');

      $email_title = sprintf(lang('a_new_album_is_created_on_x_for_you'), "");
      //Server settings
      $mail = $this->phpmailer_library->load();
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8'; // Set mailer to use SMTP
      $mail->Host = $sender_details['smtp_host'];  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = $sender_details['smtp_user'];                 // SMTP username
      $mail->Password = $sender_details['smtp_pass'];                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = $sender_details['smtp_port'];
      // TCP port to connect to
      //Recipients
      $mail->setFrom($sender_details['set_from'], "");

      $mail->addAddress($to, '');

      $mail->addBCC($bcc);
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $email_title;

      $tmpl = array();

      $tmpl['reply_email'] = $sender_details['smtp_user'];

      $tmpl['album_title'] = $album_details[0]['album_title'];
      $tmpl['album_desc'] = $album_details[0]['album_desc'];
      $tmpl['album_l_image'] = $album_details[0]['album_l_image'];
      $tmpl['album_url'] = $album_details[0]['rand_id'];

      $tmpl['client_name'] = "";

      $tmpl['logo'] = $configs['logo_black'];

      $tmpl['email_signature'] = $configs['email_signature'];

      $body = $this->load->view('emails/email.new_album_created_for_you.php', $tmpl, TRUE);

      $mail->Body    = $body;

      if (!$mail->send()) {
        $error = "New album created email could not be sent to the users, Album ID(" . $album_id . "). Mailer Error: " . $mail->ErrorInfo;
        $this->add('error', $error);
        $return = false;
      } else {
        $this->add('info', "New album created email sent to the users, Album ID(" . $album_id . ")");

        //save email details
        $e_details = array();
        $e_details['email_rand_id'] = random_string('alnum', 6);
        $e_details['email_title'] = $email_title;
        $e_details['email_to'] = $to;
        $e_details['email_cc'] = $cc;
        $e_details['email_bcc'] = $bcc;
        $e_details['email_desc'] = $body;
        $e_details['date_created'] = now();

        $this->save_email($e_details);

        $return = true;
      }
    }
  }
  function send_android_push_notification($noti_title, $noti_body, $noti_icon = "", $entity, $entity_id)
  {

    if ($noti_icon != "") {
      $noti_icon = $noti_icon;
    } else {
      $noti_icon = "ic_launcher";
    }

    $json_data = array(
      "to" => '/topics/weather',
      "notification" => [
        "body" => $noti_body,
        "title" => $noti_title,
        "icon" => $noti_icon
      ],
      "data" => [
        "url" => "http://vrpatel.in"
      ]
    );
    $data = json_encode($json_data);
    //FCM API end-point
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAAWuvjvo:APA91bHHwYrqS0UWKUyt52n0b8YiLvxezNstnoq7xYeEOjOSmgp9HINzmqfkQafi72RTpc1-EEXiAKbOmYuw9woSN1dv4eKEO7LA8cNGBSx9X-lyPYO4YFB6g6Ci9uBqXakQrLcF944N';
    //header with content_type api key
    $headers = array(
      'Content-Type:application/json',
      'Authorization:key=' . $server_key
    );
    //CURL request to route notification to FCM connection server (provided by Google)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if ($result === FALSE) {
      $this->add('error', 'Android push notification failed. Entity: ' . $entity . ', Entity ID: ' . $entity_id . ', Error: ' . curl_error($ch));
    }
    curl_close($ch);

    $result = json_decode($result);

    if (isset($result->message_id)) {
      $this->add('info', 'Android push notification successfully sent. Entity: ' . $entity . ', Entity ID: ' . $entity_id . ', Message ID: ' . $result->message_id);
    } else {
      $this->add('error', 'Android push notification failed. Entity: ' . $entity . ', Entity ID: ' . $entity_id);
    }
  }
}
