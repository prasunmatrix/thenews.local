<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Subscriptions_Table extends CI_Migration
{
    public $_table_name = 'subscriptions';
    
    public function up()
    {
        if($this->session->userdata('migration_return_html')){
            $migration_return_html = $this->session->userdata('migration_return_html');
        }
        else{
            $migration_return_html = "";
        }
        $this->log_model->add('info', 'Starting migration UP for: ' . get_class($this));
 
        // keep track of progress by concatenating text to this variable (instead of doing echo's) 
        $migration_return_html .= 'Starting migration UP for: ' . get_class($this) . "\n<br />";
    
        $fields = array(
            'sub_id' => array('type' => 'bigint', 'constraint' => 20, 'auto_increment' => TRUE, 'null' => false),
            'sub_title' => array('type' => 'varchar', 'constraint' => 255),
            'sub_price' => array('type' => 'bigint'),
            'sub_btn' => array('type' => 'text'),
            'currency' => array('type' => 'varchar', 'constraint' => 255),
        );
      
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('sub_id', TRUE);
        //First create categories_groups
        $this->dbforge->create_table($this->_table_name, true, array('comment' => "'Subscriptions table'", 'engine' => 'InnoDB'));
        
        $data = array(
            array('sub_id' => "1",
                'sub_title' => "3 Months",
                'sub_price' => "30",
                'currency' => "INR",
                'sub_btn' => '<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_HTiqiviXaroMBs" async> </script> </form>'),
            array('sub_id' => "2",
                'sub_title' => "6 Months",
                'sub_price' => "50",
                'currency' => "INR",
                'sub_btn' => '<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_HTitB5CVpvNRcU" async> </script> </form>'),
            array('sub_id' => "3",
                'sub_title' => "1 Year",
                'sub_price' => "100",
                'currency' => "INR",
                'sub_btn' => '<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_HTivUHIDsuspAS" async> </script> </form>'),
        );
        //$this->db->insert('user_group', $data); I tried both
         $this->db->insert_batch($this->_table_name, $data);
        
        
        $migration_return_html .= "Creating table $this->_table_name , done<br/>";
        
        $migration_return_html .= 'Finished migration UP for: ' . get_class($this) . "\n<br /><br />";
        
        $this->session->set_userdata('migration_return_html',  $migration_return_html);

        $this->log_model->add('info', 'Finished migration UP for: ' . get_class($this));
    }

    public function down()
    {
        if($this->session->userdata('migration_return_html')){
            $migration_return_html = $this->session->userdata('migration_return_html');
        }
        else{
            $migration_return_html = "";
        }
        $this->log_model->add('info', 'Starting migration DOWN for: ' . get_class($this));

        // keep track of progress by concatenating text to this variable (instead of doing echo's)
        $migration_return_html .= 'Starting migration DOWN for: ' . get_class($this) . "\n<br />";

        $migration_return_html .= "Dropping table {$this->_table_name}<br>";
        $this->dbforge->drop_table($this->_table_name);
        
        $migration_return_html .= "Done";

        $migration_return_html .= 'Finished migration DOWN for: ' . get_class($this) . "\n<br /><br />";

        $this->session->set_userdata('migration_return_html',  $migration_return_html);

        $this->log_model->add('info', 'Finished migration DOWN for: ' . get_class($this));
    }
}