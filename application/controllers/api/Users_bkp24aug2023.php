<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Users API
 *
 * @author		VR Patel
 * @copyright	Copyright (c) 2019, VR Patel.
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.vrpatel.in
 */

/**
 * @SWG\Resource(
 *     apiVersion="1.0",
 *     resourcePath="/Users",
 *     basePath="http://anjanayuvasangthan.in/en/api",
 *     description="Operations on Users"
 * )
 */

require(APPPATH . 'libraries/REST_Controller.php');

/**
 * Class Users
 *
 */
class Users extends REST_Controller
{

  /**
   * @var string what table is used in the database for the users
   */
  public $_general_config_table = 'general_config';

  /**
   * Constructor
   *
   * Load required resources.
   *
   * @return void
   */

  public $configs = array();

  public function __construct()
  {
    parent::__construct();
    $this->lang->load('users');
    $this->lang->load('profile');
    $this->load->model('users_model');
    $this->load->model('email_notification_model');
    $this->load->model('log_model');

    $general_config = $this->users_model->get_where($this->_general_config_table, array('deleted' => '0'));

    if (!empty($general_config)) {
      foreach ($general_config as $config) {
        $this->configs[$config['config_name']] = $config['config_value'];
      }
    }
  }

  /**
   * @var string what table is used in the database for the users
   */
  public $_users_table = 'users';

  /**
   * User Login POST
   *
   * Responds with information about user if credentials are matched.
   *
   * @return string user_details with session.
   */

  public function user_login_post()
  {

    try {

      $_POST['email'] = trim($this->input->post('email'));
      //chheck form validation
      $run_validation = 'user_login';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => strip_tags(validation_errors()));
        $this->response($return, 200);
      } else {

        //get user data by email
        $where = array('email' => $this->input->post('email'), 'rand_id' => $this->input->post('email'));
        $res = $this->users_model->get_normal_user_details_by_email_or_username($this->input->post('email'));

        //check data is accessed
        if ($res) {

          //verify user password
          if (password_verify($this->input->post('password'), $res[0]['password'])) {

            //check user is active or not
            if ($res[0]['visibility'] == '0') {
              $result = array('status' => false, 'message' => lang('user_account_has_been_disabled'));

              $this->log_model->add('unauthorised', "User can't login because account is disabled, user_id(" . $res[0]['user_id'] . ")");
            } else {
              $this->session->set_userdata('normal_user', $res[0]['user_id']);
              $this->session->set_userdata('normal_subscribed_plan', $res[0]['subscribed_plan_id']);
              $this->session->set_userdata('normal_subscription_end_date', $res[0]['subscription_end_date']);
              $result = array('status' => true, 'message' => lang('login_successfully'), 'user_id' => $res[0]['user_id']);

              $this->log_model->add('login', "User successfully loggedin, User ID( " . $res[0]['user_id'] . ")");
            }
          } else {
            $result = array('status' => false, 'message' => lang('invalid_credentials'));

            $this->log_model->add('unauthorised', "User can't login due to wrong password, user_id( " . $res[0]['user_id'] . ")");
          }
        } else {
          $result = array('status' => false, 'message' => lang('data_not_found_in_database'), 'next' => site_url() . 'login/register');

          $this->log_model->add('unauthorised', "User can't login due to wrong credentials");
        }

        $this->response($result, 200);
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  public function admin_login_post()
  {

    try {

      $_POST['email'] = trim($this->input->post('email'));
      //chheck form validation
      $run_validation = 'user_login';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => validation_errors());
        $this->response($return, 200);
      } else {

        //get user data by email
        $where = array('email' => $this->input->post('email'), 'rand_id' => $this->input->post('email'));
        $res = $this->users_model->get_user_details_by_email_or_username($this->input->post('email'));

        //check data is accessed
        if ($res) {

          //verify user password
          if (password_verify($this->input->post('password'), $res[0]['password'])) {

            //check user is active or not
            if ($res[0]['visibility'] == '0') {
              $result = array('status' => false, 'message' => lang('user_account_has_been_disabled'));

              $this->log_model->add('unauthorised', "User can't login because account is disabled, user_id(" . $res[0]['user_id'] . ")");
            } else {
              $this->session->set_userdata('ds_user', $res[0]['user_id']);
              $result = array('status' => true, 'message' => lang('login_successfully'), 'user_id' => $res[0]['user_id']);

              $this->log_model->add('login', "User successfully loggedin, User ID( " . $res[0]['user_id'] . ")");
            }
          } else {
            $result = array('status' => false, 'message' => lang('invalid_credentials'));

            $this->log_model->add('unauthorised', "User can't login due to wrong password, user_id( " . $res[0]['user_id'] . ")");
          }
        } else {
          $result = array('status' => false, 'message' => lang('data_not_found_in_database'));

          $this->log_model->add('unauthorised', "User can't login due to wrong credentials");
        }

        $this->response($result, 200);
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * User Social Login POST
   *
   * Responds with information about user if credentials are matched.
   *
   * @return string user_details with session.
   */


  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function list_users_datatable_post()
  {

    try {

      $list = $this->users_model->get_datatables();

      $data = array();
      $no = $_REQUEST['start'];
      foreach ($list as $user) {
        $no++;
        $row = array();
        $row[] = $no;
        if ($this->permissions_model->check('users', 'view')) {
          $row[] = "<a class='text-capitalize' href='" . site_url() . DASHBOARD_DIR_NAME . "users/view/" . $user->rand_id . "'>" . $user->first_name . ' ' . $user->last_name . "</a>";
          $row[] = "<a href='" . site_url() . DASHBOARD_DIR_NAME . "users/view/" . $user->rand_id . "'>" . $user->email . "</a>";
        } else {
          $row[] = $user->first_name . ' ' . $user->last_name;
          $row[] = $user->email;
        }


        $row[] = $user->role;
        if ($user->subscription_end_date != '0000-00-00') {
          $row[] = date($this->configs['date_format'], strtotime($user->subscription_end_date));
        } else {
          $row[] = "";
        }


        $action = "";
        if ($this->permissions_model->check('users', 'edit')) {
          //$action .= "<a href='". site_url().DASHBOARD_DIR_NAME."users/edit/".$user->rand_id."' class=''><i class='fa fa-pencil'></i></a>";
        }
        if ($this->permissions_model->check('users', 'delete')) {
          //$action .= "&nbsp;&nbsp;<a onclick='delete_user(".$user->user_id.")'><i class='fa fa-trash-o'></i></a>";
        }

        $row[] = $action;
        $data[] = $row;
      }

      $result = array(
        "draw" => $_REQUEST['draw'],
        "recordsTotal" => $this->users_model->count_all(),
        "recordsFiltered" => $this->users_model->count_filtered(),
        "data" => $data,
      );

      $this->response($result, 200);
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }
  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function change_password_post()
  {

    try {
      //chheck form validation
      $run_validation = 'change_password';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => validation_errors());
        $this->response($return, 200);
      } else {

        //verify old password

        $where = array('user_id' => $this->session->userdata('normal_user'));
        $res = $this->users_model->get_where($this->_users_table, $where);

        //check data is accessed
        if ($res) {

          //verify user password
          if (password_verify($this->input->post('old_password'), $res[0]['password'])) {
            $data = array();
            $hashed_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            $data['password'] = $hashed_password;
            $data['date_modified'] = now();
            $data['user_modified'] = $this->session->userdata('normal_user');

            $where = array('user_id' => $this->session->userdata('normal_user'));

            $res = $this->users_model->update_user_details($this->_users_table, $data, $where);
            if ($res) {
              $return = array('status' => TRUE, 'message' => lang('password_changed_successfully'));
              $this->log_model->add('info', "Password reset successfully, user_id(" . $res . ")");
            } else {
              $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
              $this->log_model->add('error', "Password could not be updated, user_id(" . $this->input->post('user_id') . ")");
            }
            $this->response($return, 200);
          } else {
            $return = array('status' => FALSE, 'message' => lang('current_password_is_not_valid_please_enter_the_correct_password_and_try_again'));
            $this->response($return, 200);
          }
        }
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function reset_password_post()
  {

    try {
      //chheck form validation
      $run_validation = 'reset_password';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => validation_errors());
        $this->response($return, 200);
      } else {

        $where = array('user_id' => $this->input->post('user_id'));

        $data = array();
        $hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $hashed_password;
        $data['password_reset_token'] = "";
        $data['password_reset_token_validity'] = "";

        $data['date_modified'] = now();
        $data['user_modified'] = $this->session->userdata('normal_user');

        $res = $this->users_model->update_user_details($this->_users_table, $data, $where);
        if ($res) {
          $return = array('status' => TRUE, 'message' => lang('password_changed_successfully'));
          $this->log_model->add('info', "Password reset successfully, user_id(" . $res . ")");
        } else {
          $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
          $this->log_model->add('error', "Password could not be updated, user_id(" . $this->input->post('user_id') . ")");
        }
        $this->response($return, 200);
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function save_subscriber_details_post()
  {

    try {
      if ($this->input->post('email')) {

        $data = array();
        $data['rand_id'] = random_string('alnum', 50);
        $data['email'] = $this->input->post('email');

        $data['date_created'] = now();
        if ($this->session->userdata('ds_user')) {
          $data['user_created'] = $this->session->userdata('ds_user');
        } else {
          $data['user_created'] = '0';
        }

        $res = $this->users_model->save_subscriber_details('subscribers', $data);
        if ($res) {
          $this->log_model->add('info', "Subscriber saved successfully, Subscriber ID(" . $res . ")");
          $return = array('status' => TRUE, 'message' => lang('subscriber_saved_successfully'));
        } else {
          $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
          $this->log_model->add('error', "Subscriber could not saved. email(" . $data['email'] . ")");
        }
        $this->response($return, 200);
      } else {
        $return = array('status' => FALSE, 'message' => lang('email_field_is_required'));
        $this->response($return, 200);
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function save_user_details_post()
  {

    try {
      if ($this->input->post('user_id')) {
        //chheck form validation
        $run_validation = 'save_user_details';
        $this->form_validation->set_data($this->input->post());

        if ($this->form_validation->run($run_validation) == FALSE) {

          //return form validation errors
          $return = array('status' => false, 'message' => validation_errors());
          $this->response($return, 200);
        } else {

          $where = array();
          $where['user_id'] = $this->input->post('user_id');

          $data = array();
          if ($_FILES['user_profile']['name'] != "") {

            $config['upload_path']          = './public_html/upload/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
            $config['max_size']             = 25000;

            // get file extension
            $file_ext = pathinfo($_FILES["user_profile"]["name"], PATHINFO_EXTENSION);

            // change file name
            $_FILES['user_profile']['name'] = sha1(microtime()) . "." . $file_ext;

            //load library
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user_profile')) {
              $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
              $this->response($return, 200);
            } else {

              $img_data = array('upload_data' => $this->upload->data());
              $data['avatar'] = $img_data['upload_data']['file_name'];
            }
          }
          $data['rand_id'] = $this->input->post('rand_id');
          $data['first_name'] = $this->input->post('first_name');
          $data['last_name'] = $this->input->post('last_name');
          $data['email'] = $this->input->post('email');

          $dob = str_replace('/', '-', $this->input->post('dob'));
          $dob = date('Y-m-d', strtotime($dob));
          $data['dob'] = $dob;

          $data['gender'] = $this->input->post('gender');
          $data['user_role_id'] = $this->input->post('user_role');
          $data['address'] = $this->input->post('address');
          $data['city'] = $this->input->post('city');
          $data['state'] = $this->input->post('state');
          $data['phone'] = $this->input->post('phone');
          $data['pin_code'] = $this->input->post('pin_code');

          $data['date_modified'] = now();
          $data['user_modified'] = $this->session->userdata('ds_user');


          $res = $this->users_model->update_user_details($this->_users_table, $data, $where);
          if ($res) {
            $this->log_model->add('info', "User updated successfully, user_id(" . $res . ")");
            $return = array('status' => TRUE, 'message' => lang('user_updated_successfully'), 'next' => $data['rand_id']);
          } else {
            $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
            $this->log_model->add('error', "User can not be updated. user_id(" . $where['user_id'] . ")");
          }
          $this->response($return, 200);
        }
      } else {
        //chheck form validation
        $run_validation = 'save_user_details';
        $this->form_validation->set_data($this->input->post());

        if ($this->form_validation->run($run_validation) == FALSE) {

          //return form validation errors
          $return = array('status' => false, 'message' => validation_errors());
          $this->response($return, 200);
        } else {

          $data = array();

          $password = $this->input->post('password');

          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $data['email_verification_token'] = random_string('alnum', 50);
          $data['first_name'] = $this->input->post('full_name');

          $data['user_role_id'] = NORMAL_USER_ROLE_ID;
          $data['email'] = $this->input->post('email');
          $data['phone'] = $this->input->post('mobile_number');
          $data['rand_id'] = random_string('alnum', 6);
          $data['password'] = $hashed_password;

          $data['date_created'] = now();
          $data['user_created'] = $this->session->userdata('ds_user');


          $res = $this->users_model->save_user_details($this->_users_table, $data);
          if ($res) {

            $this->session->set_userdata('normal_user', $res);

            setcookie('loggedin_user_id', $res, time() + (86400 * 30), "/"); // 86400 = 1 day

            $this->log_model->add('info', "New user registered successfully, user_id(" . $res . ")");

            $email_response = $this->email_notification_model->new_user_registered($res);
            if ($email_response) {
              $this->log_model->add('info', "Email sent to new registered user, user_id(" . $res . ")");
              $return = array('status' => TRUE, 'message' => lang('user_successfully_registered_and_email_sent'), 'next' => $data['rand_id']);
            } else {
              $this->log_model->add('info', "Email could not be sent to new registered user, user_id(" . $res . ")");
              $return = array('status' => TRUE, 'message' => lang('user_successfully_registered_and_email_could_not_be_sent'), 'next' => $data['rand_id']);
            }
          } else {
            $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
            $this->log_model->add('error', "User can not be registered.");
          }
          $this->response($return, 200);
        }
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }
  public function update_user_profile_post()
  {

    try {
      if ($this->session->userdata('ds_user')) {
        //chheck form validation
        $run_validation = 'update_user_profile';
        $this->form_validation->set_data($this->input->post());

        if ($this->form_validation->run($run_validation) == FALSE) {

          //return form validation errors
          $return = array('status' => false, 'message' => validation_errors());
          $this->response($return, 200);
        } else {

          $where = array();
          $where['user_id'] = $this->session->userdata('ds_user');

          $data = array();
          if ($_FILES['user_profile']['name'] != "") {

            $config['upload_path']          = './public_html/upload/user_avatars/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
            $config['max_size']             = 25000;

            // get file extension
            $file_ext = pathinfo($_FILES["user_profile"]["name"], PATHINFO_EXTENSION);

            // change file name
            $_FILES['user_profile']['name'] = sha1(microtime()) . "." . $file_ext;

            //load library
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user_profile')) {
              $return = array('status' => FALSE, 'message' => $this->upload->display_errors());
              $this->response($return, 200);
            } else {

              $img_data = array('upload_data' => $this->upload->data());
              $data['avatar'] = $img_data['upload_data']['file_name'];
            }
          }
          $data['first_name'] = $this->input->post('first_name');
          $data['last_name'] = $this->input->post('last_name');
          $data['email'] = $this->input->post('email');

          $dob = str_replace('/', '-', $this->input->post('dob'));
          $dob = date('Y-m-d', strtotime($dob));
          $data['dob'] = $dob;

          $data['gender'] = $this->input->post('gender');
          $data['address'] = $this->input->post('address');
          $data['city'] = $this->input->post('city');
          $data['state'] = $this->input->post('state');
          $data['phone'] = $this->input->post('phone');
          $data['pin_code'] = $this->input->post('pin_code');

          $data['date_modified'] = now();
          $data['user_modified'] = $this->session->userdata('ds_user');


          $res = $this->users_model->update_user_details($this->_users_table, $data, $where);
          if ($res) {
            $this->log_model->add('info', "User profile updated successfully, user_id(" . $res . ")");
            $return = array('status' => TRUE, 'message' => lang('user_profile_updated_successfully'));
          } else {
            $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
            $this->log_model->add('error', "User profile could not be updated. user_id(" . $where['user_id'] . ")");
          }
          $this->response($return, 200);
        }
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }


  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function delete_user_details_post()
  {

    try {

      if ($this->input->post('user_id')) {

        $where = array();
        $where['user_id'] = $this->input->post('user_id');

        $user_data = array();
        $user_data['deleted'] = '1';
        $user_data['date_modified'] = now();
        $user_data['user_modified'] = $this->session->userdata('ds_user');

        $res = $this->users_model->update_user_details($this->_users_table, $user_data, $where);
        if ($res) {

          $this->log_model->add('info', "User deleted successfully, user_id(" . $res . ")");
          $return = array('status' => TRUE, 'message' => lang('user_deleted_successfully'));
        } else {
          $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
          $this->log_model->add('error', "User could not be deleted, user_id(" . $where['user_id'] . ")");
        }
        $this->response($return, 200);
      } else {
        $return = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
        $this->response($return, 400);
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function forgot_password_post()
  {

    try {
      $_POST['email'] = trim($this->input->post('email'));
      //chheck form validation
      $run_validation = 'forgot_password';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => validation_errors());
        $this->response($return, 200);
      } else {
        $where = array();
        $where['email'] = $this->input->post('email');

        $user_details = $this->users_model->get_where($this->_users_table, $where);

        if (!empty($user_details)) {
          $email_response = $this->email_notification_model->send_reset_password_email($user_details[0]['user_id']);
          if ($email_response) {
            $this->log_model->add('info', "Forgot password email sent to <strong>" . $where['email'] . "</strong>");
            $return = array('status' => TRUE, 'message' => lang('we_have_sent_you_an_email_with_a_link_to_initiate_a_password_reset_procedure'));
          } else {
            $this->log_model->add('error', "Forgot password email could not be sent to <strong>" . $where['email'] . "</strong>");
            $return = array('status' => TRUE, 'message' => lang('msg_something_went_wrong'));
          }
          $this->response($return, 200);
        } else {
          $return = array('status' => FALSE, 'message' => lang('the_provided_credentials_have_not_been_found_in_our_database'));
          $this->response($return, 200);
        }
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }


  /**
   * List GET
   *
   * Responds with information about all users available.
   *
   * @return string Data table supported JSON with users info
   */
  public function list_user_logs_datatable_post()
  {

    try {
      // check permission
      //             $this->check_permission('blogs', 'read');
      $list = $this->users_model->get_user_logs_datatables();

      $data = array();
      $no = $_REQUEST['start'];
      foreach ($list as $log) {
        $no++;
        $row = array();
        $row[] = $log->operation;
        $row[] = $log->log_type;
        $row[] = date('M d, Y h:i A', $log->timestamp);


        $data[] = $row;
      }

      $result = array(
        "draw" => $_REQUEST['draw'],
        "recordsTotal" => $this->users_model->count_user_logs_all(),
        "recordsFiltered" => $this->users_model->count_user_logs_filtered(),
        "data" => $data,
      );

      $this->response($result, 200);
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  public function get_loggedin_user_module_statistics_post()
  {
    $return_stat = array(
      'blogs' => 0,
      'reminders' => 0,
      'albums' => 0,
      'bookings' => 0,
      'live_streamings' => 0,
      'videos' => 0,
      'events' => 0,
      'event_types' => 0,
      'tags' => 0,
      'packages' => 0,
      'package_types' => 0,
    );
    if ($this->session->userdata('ds_user')) {
      $return_stat['blogs'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'blogs');
      $return_stat['reminders'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'reminders');
      $return_stat['albums'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'albums');
      $return_stat['bookings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'bookings');
      $return_stat['live_streamings'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'videos', VIDEO_TYPE_LIVE_STREAMING);
      $return_stat['videos'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'videos', VIDEO_TYPE_VIDEO);
      $return_stat['events'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'events');
      $return_stat['event_types'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'event_types');
      $return_stat['tags'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'tags');
      $return_stat['packages'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'packages');
      $return_stat['package_types'] = $this->users_model->get_user_module_stat($this->session->userdata('ds_user'), 'package_types');
    }
    $this->response($return_stat, 200);
  }



  /**
   * User Social Login POST
   *
   * Responds with information about user if credentials are matched.
   *
   * @return string user_details with session.
   */

  public function user_social_login_post()
  {
    try {

      $_POST['email'] = trim($this->input->post('email'));

      //chheck form validation
      $run_validation = 'user_social_login';
      $this->form_validation->set_data($this->input->post());

      if ($this->form_validation->run($run_validation) == FALSE) {

        //return form validation errors
        $return = array('status' => false, 'message' => validation_errors());
        $this->response($return, 400);
      } else {

        $email = $this->users_model->get_where($this->_users_table, array(
          'email' => $this->input->post('email'),
          'oauth_provider' => $this->input->post('oauth_provider'),
          'oauth_id' => $this->input->post('oauth_id'),
          'deleted' => '0'
        ));
        if (!empty($email)) {

          //user login via social login

          $this->session->set_userdata('normal_user', $email[0]['user_id']);
          $this->session->set_userdata('normal_subscribed_plan', $email[0]['subscribed_plan_id']);
          $this->session->set_userdata('normal_subscription_end_date', $email[0]['subscription_end_date']);

          $result = array('status' => true, 'message' => lang('login_successfully'), 'user_id' => $email[0]['user_id'], 'next' => site_url() . 'profile', 'user_details' => $email);

          $this->log_model->add('login', "User successfully login via " . $this->input->post('oauth_provider') . ", user_id(" . $email[0]['user_id'] . ")");

          $this->response($result, 200);
        } else {

          //check if user exists with this email
          $email = $this->users_model->get_where($this->_users_table, array(
            'email' => $this->input->post('email'),
            'deleted' => '0'
          ));
          if (!empty($email)) {

            $where = array('user_id' => $email[0]['user_id']);

            $user_data = array();

            $user_data['oauth_provider'] = $this->input->post('oauth_provider');
            $user_data['oauth_id'] = $this->input->post('oauth_id');

            $user_data['first_name'] = $this->input->post('full_name');
            $user_data['user_role_id'] = NORMAL_USER_ROLE_ID;
            $user_data['email_verified'] = '1';
            $user_data['avatar_small'] = $this->input->post('avatar_small');
            $user_data['avatar_medium'] = $this->input->post('avatar_medium');
            $user_data['avatar_large'] = $this->input->post('avatar_large');
            $user_data['date_modified'] = now();

            $slogin_res = $this->users_model->update_user_details($this->_users_table, $user_data, $where);

            if ($slogin_res) {
              $this->log_model->add('info', "User social login information updated successfully. User ID (" . $email[0]['user_id'] . ")");
              $result = array('status' => true, 'message' => lang('login_successfully'), 'user_id' => $email[0]['user_id'], 'next' => site_url() . 'profile', 'user_details' => $user_data);
            } else {
              $this->log_model->add('error', "User social login information could not be updated. User ID (" . $email[0]['user_id'] . ")");
            }
          } else {
            $user_data = array();

            $user_data['oauth_provider'] = $this->input->post('oauth_provider');
            $user_data['oauth_id'] = $this->input->post('oauth_id');

            $user_data['first_name'] = $this->input->post('full_name');
            $user_data['email'] = $this->input->post('email');

            $user_data['rand_id'] = random_string('alnum', 6);
            $user_data['user_role_id'] = NORMAL_USER_ROLE_ID;

            $user_data['email_verified'] = 1;
            $user_data['avatar_small'] = $this->input->post('avatar_small');
            $user_data['avatar_medium'] = $this->input->post('avatar_medium');
            $user_data['avatar_large'] = $this->input->post('avatar_large');

            $user_data['email_verification_token'] = random_string('alnum', 50);

            $user_data['date_created'] = now();


            //save user details in database
            $response = $this->users_model->save_user_details($this->_users_table, $user_data);

            if ($response) {

              $this->session->set_userdata('normal_user', $response);
              $this->session->set_userdata('normal_subscribed_plan', 0);
              $this->session->set_userdata('normal_subscription_end_date', '0000-00-00');

              //write log
              $this->log_model->add('login', "User successfully registered via " . $user_data['oauth_provider'] . ", user_id(" . $response . ")");

              //send email to new registered user
              $email_response = $this->email_notification_model->new_user_registered($response);

              if ($email_response) {
                $this->log_model->add('write', "Email sent to new registered user, user_id($response)");
              } else {
                $this->log_model->add('error', "Email could not be sent to new registered user, user_id($response)");
              }

              $result = array('status' => true, 'message' => lang('login_successfully'), 'user_id' => $response, 'next' => site_url() . 'profile', 'user_details' => $user_data);
            } else {
              // write to system log
              $this->log_model->add('unauthorised', "The user could not be registered");

              $result = array('status' => FALSE, 'message' => lang('msg_something_went_wrong'));
            }
          }

          $this->response($result, 200);
        }
      }
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * User Social Login POST
   *
   * Responds with information about user if credentials are matched.
   *
   * @return string user_details with session.
   */

  public function check_user_subscription_post()
  {
    try {

      $email = trim($this->input->post('email'));

      if ($email != "") {
        $user_details = $this->users_model->get_where($this->_users_table, array(
          'email' => $email
        ));
        if (!empty($user_details)) {
          $result = array('status' => TRUE, 'data' => $user_details);
        } else {
          $result = array('status' => false, 'message' => lang('user_not_found'));
        }
      } else {
        $result = array('status' => false, 'message' => lang('invalid_request'));
      }

      $this->response($result, 200);
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  /**
   * User Social Login POST
   *
   * Responds with information about user if credentials are matched.
   *
   * @return string user_details with session.
   */

  // public function save_user_subscription_plan_post()
  // {

  //   try {
  //     $rand_id = trim($this->input->post('rand_id'));
  //     $email = trim($this->input->post('email'));
  //     $plan_id = trim($this->input->post('plan_id'));
  //     $auth_tkn = $this->input->post('auth_tkn');
  //     $subscription_payment_id = $this->input->post('subscription_payment_id');

  //     if ($email != "" && $rand_id != "" && $plan_id != "" && $auth_tkn == "kjhdf876dw86324nldkle9d90dq09e2jkdjfh487yd9qwdlakfnsjgkehituyrowerwelkr34ihifjkh") {


  //       $where = array('rand_id' => $rand_id, 'email' => $email);

  //       //get_user details
  //       $user_details = $this->users_model->get_where($this->_users_table, $where);
  //       // echo "<pre>";
  //       // print_r($user_details); die;
  //       if (!empty($user_details)) {
  //         if ($plan_id == "1" || $plan_id == 1) {
  //           $subscription_end_date = date("Y-m-d", strtotime("+1 month", time()));
  //         }
  //         if ($plan_id == "2" || $plan_id == 2) {
  //           $subscription_end_date = date("Y-m-d", strtotime("+3 month", time()));
  //         }
  //         if ($plan_id == "3" || $plan_id == 3) {
  //           $subscription_end_date = date("Y-m-d", strtotime("+6 month", time()));
  //         }
  //         if ($plan_id == "4" || $plan_id == 4) {
  //           $subscription_end_date = date("Y-m-d", strtotime("+12 month", time()));
  //         }
  //         $update_data = array("subscribed_plan_id" => $plan_id, "subscription_end_date" => $subscription_end_date, "subscription_payment_id" => $subscription_payment_id);

  //         $res = $this->users_model->update_user_details($this->_users_table, $update_data, $where);
  //         // echo "<pre>";
  //         // print_r($res); die;
  //         if ($res) {

  //           $email_status = $this->email_notification_model->send_subscription_details($res, $subscription_end_date, $subscription_payment_id);

  //           if ($email_status) {
  //             $this->log_model->add('info', "User subscription email sent successfully. User RID(" . $res . ")");
  //           } else {
  //             $this->log_model->add('error', "User subscription email could not be sent. User RID(" . $res . ")");
  //           }

  //           $this->log_model->add('info', "User subscribed successfully, User RID(" . $res . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
  //           $result = array('status' => TRUE, 'message' => lang('your_payment_info_saved_successfully'));
  //         } else {
  //           $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, User RID(" . $rand_id . "), User Email(" . $email . "),Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
  //           $result = array('status' => false, 'message' => lang('subscription_details_could_not_be_saved'));
  //         }
  //       } else {
  //         $result = array('status' => false, 'message' => lang('user_not_found_in_db_please_contact_to_admin_to_fix_this_issue'));
  //         $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, because user is not found in DB. User RID(" . $rand_id . "), User Email(" . $email . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . ")");
  //       }
  //     } else {
  //       $result = array('status' => false, 'message' => lang('invalid_request'));
  //     }

  //     $this->response($result, 200);
  //   } catch (Exception $e) {
  //     // write to system log
  //     $this->log_model->add('error', $e->getMessage());

  //     $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
  //     $this->response($result, 500);
  //   }
  // }

  public function save_user_subscription_plan_post()
  {

    try {
      //header("HTTP/1.1 200 OK");
      $rand_id = trim($this->input->post('rand_id'));
      $email = trim($this->input->post('email'));
      $plan_id = trim($this->input->post('plan_id'));
      $auth_tkn = $this->input->post('auth_tkn');
      $subscription_payment_id = $this->input->post('subscription_payment_id');

      if ($email != "" && $rand_id != "" && $plan_id != "" && $auth_tkn == "kjhdf876dw86324nldkle9d90dq09e2jkdjfh487yd9qwdlakfnsjgkehituyrowerwelkr34ihifjkh") {


        $where = array('rand_id' => $rand_id, 'email' => $email);

        //get_user details
        $user_details = $this->users_model->get_where($this->_users_table, $where);
        // echo "<pre>";
        // print_r($user_details); die;
        if (!empty($user_details)) {
          if ($plan_id == "1" || $plan_id == 1) {
            $subscription_end_date = date("Y-m-d", strtotime("+1 month", time()));
          }
          if ($plan_id == "2" || $plan_id == 2) {
            $subscription_end_date = date("Y-m-d", strtotime("+3 month", time()));
          }
          if ($plan_id == "3" || $plan_id == 3) {
            $subscription_end_date = date("Y-m-d", strtotime("+6 month", time()));
          }
          if ($plan_id == "4" || $plan_id == 4) {
            $subscription_end_date = date("Y-m-d", strtotime("+12 month", time()));
          }
          $update_data = array("subscribed_plan_id" => $plan_id, "subscription_end_date" => $subscription_end_date, "subscription_payment_id" => $subscription_payment_id);

          $res = $this->users_model->update_user_details($this->_users_table, $update_data, $where);
          // echo "<pre>";
          // print_r($res); die;
          if ($res) {
            $user_id=$this->users_model->user_details($rand_id,$email);
            //echo $user_id; die;
            $sql="select * from orders WHERE user_id='$user_id' ORDER BY id DESC LIMIT 0,1";
            $query=$this->db->query($sql);
            $dataOrder=$query->row();
            $order_id=$dataOrder->order_id;

            //insert the webhooks
            // header("HTTP/1.1 200 OK");
            // $key_id = "rzp_test_ep4OUY40vD45OK";
            // $key_secret = "W4IM7wixClhJ1MpCG7SSS7wr";
            // $postdata = @file_get_contents("php://input");
            // $dataWebhook = json_decode($postdata,true);
            // if($dataWebhook['event']!='')
            // {
            //   $this->db->insert('razorpay_webhook',array('order_id'=>$order_id,'webhook_data'=>$dataWebhook['event']));
            // }
            //$this->db->insert('razorpay_webhook',array('order_id'=>$order_id,'webhook_data'=>'test2288'));
            //$razorpay=$this->save_user_subscription_plan_razorpay_post($order_id);
            //$razorpay=$this->save_razorpay($order_id);
            //insert the webhooks

            $email_status = $this->email_notification_model->send_subscription_details($res, $subscription_end_date, $subscription_payment_id);

            if ($email_status) {
              $this->log_model->add('info', "User subscription email sent successfully. User RID(" . $res . ")");
            } else {
              $this->log_model->add('error', "User subscription email could not be sent. User RID(" . $res . ")");
            }

            $this->log_model->add('info', "User subscribed successfully, User RID(" . $res . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
            $result = array('status' => TRUE, 'message' => lang('your_payment_info_saved_successfully'));
          } else {
            $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, User RID(" . $rand_id . "), User Email(" . $email . "),Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
            $result = array('status' => false, 'message' => lang('subscription_details_could_not_be_saved'));
          }
        } else {
          $result = array('status' => false, 'message' => lang('user_not_found_in_db_please_contact_to_admin_to_fix_this_issue'));
          $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, because user is not found in DB. User RID(" . $rand_id . "), User Email(" . $email . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . ")");
        }
      } else {
        $result = array('status' => false, 'message' => lang('invalid_request'));
      }

      $this->response($result, 200);
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }

  public function create_order_user_subscription_plan_post()
  {
    //echo "test"; die;
    try {
      $rand_id = trim($this->input->post('rand_id'));
      $email = trim($this->input->post('email'));
      $amount = trim($this->input->post('amount'));
      //$currency = trim($this->input->post('email'));
      $currency ="INR";
      $plan_id = trim($this->input->post('plan_id'));
      $auth_tkn = $this->input->post('auth_tkn');

      if ($email != "" && $rand_id != "" && $plan_id != "" && $auth_tkn == "kjhdf876dw86324nldkle9d90dq09e2jkdjfh487yd9qwdlakfnsjgkehituyrowerwelkr34ihifjkh") {


        $where = array('rand_id' => $rand_id, 'email' => $email);

        //get_user details
        $user_details = $this->users_model->get_where($this->_users_table, $where);
        //print_r($user_details); die;
        //echo $user_details[0]['user_id']; die;
        if (!empty($user_details)) {
          $ch = $this->get_curl_handle($amount, $currency);
          //execute post
          //echo $ch; die;
          $response = curl_exec($ch);
          //echo $response; die;  
          $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          if ($response === false) {
            $result['status'] = false;
            $result['message'] = 'Curl error: ' . curl_error($ch);
          } else {
            $response_array = json_decode($response, true);
            //echo "<pre>";print_r($response_array);exit;
            //Check success response
            if ($http_status === 200 and isset($response_array['error']) === false) {
              $result['status'] = true;
              $result['message'] = "Payment Successful";
              //$this->db->insert('orders', array('user_id' => $user_details[0]['id'], 'plan_id' => $plan_id, 'paymnet_id' => $response_array['id'], 'order_id' => $response_array['order_id'], 'create_date' => date('Y-m-d H:i:s')));
              $this->db->insert('orders', array('user_id' => $user_details[0]['user_id'], 'plan_id' => $plan_id, 'paymnet_id' => $response_array['id'], 'order_id' => $response_array['id'], 'create_date' => date('Y-m-d H:i:s')));
              //$result['order_id'] = $response_array['order_id'];
              $result['order_id'] = $response_array['id'];
              //echo "<pre>"; print_r($result); die;
            } else {
              $result['status'] = false;
              if (!empty($response_array['error']['code'])) {
                $result['message'] = $response_array['error']['code'] . ':' . $response_array['error']['description'];
              } else {
                $result['message'] = 'RAZORPAY_ERROR:Invalid Response <br/>' . $response;
              }
            }
          }
          //close connection
          curl_close($ch);
        } else {
          $result = array('status' => false, 'message' => lang('user_not_found_in_db_please_contact_to_admin_to_fix_this_issue'));
          $this->log_model->add('error', "User ordered successfully but not updated to the User Account, because user is not found in DB. User RID(" . $rand_id . "), User Email(" . $email . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $subscription_payment_id . ")");
        }
      } else {
        $result = array('status' => false, 'message' => lang('invalid_request'));
      }
      $this->response($result, 200);
    } catch (Exception $e) {
      // write to system log
      $this->log_model->add('error', $e->getMessage());

      $result = array('status' => false, 'data' => array(), 'message' => lang('msg_something_went_wrong'));
      $this->response($result, 500);
    }
  }
  public function save_user_subscription_plan_razorpay_post()
  {
    header("HTTP/1.1 200 OK");
    // $sql="select * from orders ORDER BY id DESC LIMIT 0,1";
    // $query=$this->db->query($sql);
    // $dataOrder=$query->row();
    // $order_id=$dataOrder->order_id;
    $key_id = "rzp_test_ep4OUY40vD45OK";
    $key_secret = "W4IM7wixClhJ1MpCG7SSS7wr";
    $postdata = @file_get_contents("php://input");
    $data = json_decode($postdata,true);
    $email_id=$data['payload']['payment']['entity']['email'];
    $payment_id=$data['payload']['payment']['entity']['id'];
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    // curl_setopt($ch, CURLOPT_HEADER, 0);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_URL, $postdata);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
    // $data = curl_exec($ch);
    // curl_close($ch);
    //return $data;
    //$this->db->insert('razorpay_webhook',array('webhook_data'=>$data['event']));
    //$this->db->insert('razorpay_webhook',array('order_id'=>$order_id,'webhook_data'=>$postdata));
    $sqlUser="select * from ".$this->_users_table." where email='$email_id'";
  	$queryUser=$this->db->query($sqlUser);
  	$dataUser=$queryUser->row();
    // echo "<pre>";
    // print_r($data); die;
    $userId=$dataUser->user_id;
    $rand_id=$dataUser->rand_id;
    $subscribed_plan_id=$dataUser->subscribed_plan_id;
    $subscription_payment_id=$dataUser->subscription_payment_id;
    $subscriptionEndDate=$dataUser->subscription_end_date;

    $sqlOrder="select * from orders where user_id='$userId' ORDER BY id DESC LIMIT 0,1";
  	$queryOrder=$this->db->query($sqlOrder);
  	$dataOrder=$queryOrder->row();
    $order_id=$dataOrder->order_id;
    $plan_id=$dataOrder->plan_id;
    $today=date('Y-m-d');

    $where = array('rand_id' => $rand_id, 'email' => $email_id);

    if(($subscribed_plan_id==0 || $subscriptionEndDate<$today) && ($data['event']=='payment.authorized'))
    {
      if ($plan_id == "1" || $plan_id == 1) {
        $subscription_end_date = date("Y-m-d", strtotime("+1 month", time()));
      }
      if ($plan_id == "2" || $plan_id == 2) {
        $subscription_end_date = date("Y-m-d", strtotime("+3 month", time()));
      }
      if ($plan_id == "3" || $plan_id == 3) {
        $subscription_end_date = date("Y-m-d", strtotime("+6 month", time()));
      }
      if ($plan_id == "4" || $plan_id == 4) {
        $subscription_end_date = date("Y-m-d", strtotime("+12 month", time()));
      }

      $update_data = array("subscribed_plan_id" => $plan_id, "subscription_end_date" => $subscription_end_date, "subscription_payment_id" => $payment_id);
      $res = $this->users_model->update_user_details($this->_users_table, $update_data, $where);

      if ($res) {
        $email_status = $this->email_notification_model->send_subscription_details($res, $subscription_end_date, $payment_id);

        if ($email_status) {
          $this->log_model->add('info', "User subscription email sent successfully. User RID(" . $res . ")");
        } else {
          $this->log_model->add('error', "User subscription email could not be sent. User RID(" . $res . ")");
        }

        $this->log_model->add('info', "User subscribed successfully, User RID(" . $res . "), Subscription Plan ID(" . $plan_id . "), Payment ID(" . $payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
        $result = array('status' => TRUE, 'message' => lang('your_payment_info_saved_successfully'));
      } else {
        $this->log_model->add('error', "User subscribed successfully but not updated to the User Account, User RID(" . $rand_id . "), User Email(" . $email_id . "),Subscription Plan ID(" . $plan_id . "), Payment ID(" . $payment_id . "), Subscription End Date(" . $subscription_end_date . ")");
        $result = array('status' => false, 'message' => lang('subscription_details_could_not_be_saved'));
      }

    } 
    $this->db->insert('razorpay_webhook',array('order_id'=>$order_id,'webhook_data'=>$data['event']));
  }
  
  // public function save_user_subscription_plan_razorpay_post($order_id)
  // {
  //   header("HTTP/1.1 200 OK");
  //   //$rand_id = trim($this->input->post('rand_id'));
  //   //$email = trim($this->input->post('email'));
  //   // $user_id=$this->users_model->user_details($rand_id,$email);
  //   // $sql="select * from orders WHERE user_id='$user_id' ORDER BY id DESC LIMIT 0,1";
  //   // $query=$this->db->query($sql);
  //   // $dataOrder=$query->row();
  //   // $order_id=$dataOrder->order_id;
  //   $key_id = "rzp_test_ep4OUY40vD45OK";
  //   $key_secret = "W4IM7wixClhJ1MpCG7SSS7wr";
  //   $postdata = @file_get_contents("php://input");
  //   $data = json_decode($postdata,true);
  //   return $this->db->insert('razorpay_webhook',array('order_id'=>$order_id,'webhook_data'=>$data['event']));
  // }

  // initialized cURL Request
  private function get_curl_handle($amount, $currency)
  {
    $url = 'https://api.razorpay.com/v1/orders/';
    $key_id = "rzp_test_ep4OUY40vD45OK";
    $key_secret = "W4IM7wixClhJ1MpCG7SSS7wr";
    $fields_string = "amount=$amount&currency=$currency";
    //cURL Request
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/ca-bundle.crt');
    return $ch;
  }
}
