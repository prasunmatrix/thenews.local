<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_About_Us_Table extends CI_Migration
{
    public $_table_name = 'about_us';
    
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
                'id' => array('type' => 'bigint', 'constraint' => 20, 'auto_increment' => TRUE, 'null' => false),
                'about_us' => array('type' => 'text'),
                'image' => array('type' => 'varchar','constraint' => 255),
                'seo_title' => array('type' => 'varchar', 'constraint' => 255,'null' => true),
                'seo_keywords' => array('type' => 'text','null' => true),
                'seo_desc' => array('type' => 'text','null' => true),
                'lang' => array('type' => 'varchar','constraint' => 255),
                'date_created' => array('type' => 'bigint','null' => true),
                'date_modified' => array('type' => 'bigint','null' => true),
                'user_created' => array('type' => 'bigint','null' => true),
                'user_modified' => array('type' => 'bigint','null' => true)
        );
      
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        //First create categories_groups
        $this->dbforge->create_table($this->_table_name, true, array('comment' => "'About us table'", 'engine' => 'InnoDB'));
        
        $data = array(
            array('id' => '1','about_us' => '','date_created'=>now(),'date_modified'=>now(),'user_created'=>$this->session->userdata('ds_user'),'user_modified'=>$this->session->userdata('ds_user'))
        );

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