<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Module_Statistics_Table extends CI_Migration
{
    public $_table_name = 'module_statistics';
    
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
                'stat_id' => array('type' => 'bigint', 'constraint' => 20, 'auto_increment' => TRUE, 'null' => false),
                'rand_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'module' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'module_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => false),
                'first_visit' => array('type' => 'bigint'),
                'last_visit' => array('type' => 'bigint'),
                'unique_view' => array('type' => 'bigint'),
                'page_viewed' => array('type' => 'bigint'),
                'timestamp' => array('type' => 'bigint'),
        );
      
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('stat_id', TRUE);
        //First create categories_groups
        $this->dbforge->create_table($this->_table_name, true, array('comment' => "'Module statistics table'", 'engine' => 'InnoDB'));
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