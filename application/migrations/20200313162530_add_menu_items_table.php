<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Menu_Items_Table extends CI_Migration
{
    public $_table_name = 'menu_items';
    
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
                'item_id' => array('type' => 'bigint', 'constraint' => 20, 'auto_increment' => TRUE, 'null' => false),
                'rand_id' => array('type' => 'varchar', 'constraint' => 255),
                'item_title' => array('type' => 'varchar', 'constraint' => 255),
                'item_href' => array('type' => 'varchar', 'constraint' => 255),
                'item_icon' => array('type' => 'varchar', 'constraint' => 255),
                'lang' => array('type' => 'varchar', 'constraint' => 255),                
                'visibility' => array('type' => 'ENUM("0","1")', 'default' => '1', 'null' => false),
                'deleted' => array('type' => 'ENUM("0","1")', 'default' => '0', 'comment' => 'set true if user is deleted by admin', 'null' => false),
                'date_created' => array('type' => 'bigint'),
                'date_modified' => array('type' => 'bigint','null' => true),
                'user_created' => array('type' => 'bigint'),
                'user_modified' => array('type' => 'bigint','null' => true)
        );
      
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('item_id', TRUE);
        //First create categories_groups
        $this->dbforge->create_table($this->_table_name, true, array('comment' => "'Menu item table'", 'engine' => 'InnoDB'));
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