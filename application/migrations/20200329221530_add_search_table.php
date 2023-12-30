<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Search_Table extends CI_Migration
{
    public $_table_name = 'search_results';
    
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
                'search_id' => array('type' => 'bigint', 'constraint' => 20, 'auto_increment' => TRUE, 'null' => false),
                'rand_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'session_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'query' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'user_id' => array('type' => 'bigint', 'constraint' => 20, 'null' => true),
                'ip' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'os' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'browser' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'url' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'device' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'city' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'region' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'country' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'loc' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'org' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'timezone' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
                'timestamp' => array('type' => 'bigint'),
                
        );
      
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('search_id', TRUE);
        //First create categories_groups
        $this->dbforge->create_table($this->_table_name, true, array('comment' => "'Search results table'", 'engine' => 'InnoDB'));
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