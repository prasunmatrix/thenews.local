<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Users Model
 *
 * @author		VR Patel
 * @copyright           Copyright (c) 2018, Survey-Polls.com
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.survey-polls.com
 */

/**
 * Class Users Model
 *
 * This class takes care of database actions performed on users
 *
 */
class Epaper_model extends CI_Model
{
    /**
     * @var string what table is used in the database for the users
     */
    public $_epaper_table = 'epaper';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table = 'users';
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_where($tab,$condi){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_where_with_order($tab,$condi,$order=array()){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $this->db->order_by(key($order), $order[key($order)]);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function save_epaper_details($table,$entity_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $entity_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $entity_id = FALSE;
        }
        else
        {
            $entity_details =  $this->get_where($table, array('rand_id'=>$entity_details['rand_id']));
            $entity_id = $entity_details[0]['epaper_id'];
        }
        
        return $entity_id;
    
    }
    function save_epaper_trans_details($table,$entity_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $entity_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $entity_id = FALSE;
        }
        else
        {
            $entity_id = TRUE;
        }
        
        return $entity_id;
    
    }
    
    function update_epaper_details($table,$entity_details, $condition){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($condition);
        
        //save user details
        $this->db->update($table, $entity_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $entity_id = FALSE;
        }
        else
        {
            $entity_details =  $this->get_where($table, $condition);
            $entity_id = $entity_details[0]['epaper_id'];
        }
        
        return $entity_id;
    
    }
    
    
    var $table = 'epaper';
    var $column_order = array(null,'epaper_title',null,null,'date_created'); //set column field database for datatable orderable
    var $column_search = array('epaper_title','first_name','last_name'); //set column field database for datatable searchable 
    var $order = array('epaper_title' => 'asc'); // default order 


    private function _get_datatables_query()
    {        
        $this->db->select("$this->_epaper_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_epaper_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_epaper_table.user_created","left");        
        $this->db->where(array("$this->_epaper_table.deleted"=>'0',"$this->_epaper_table.visibility"=>'1'));
        $this->db->group_by(array("$this->_epaper_table.epaper_id"));

        $i = 0;
	
        foreach ($this->column_search as $item) // loop column 
        {
            if(isset($_REQUEST['search']['value'])) // if datatable send POST for search
            {				
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_REQUEST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_REQUEST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('epaper_title','asc');
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_REQUEST['length'] != -1)
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
        $this->db->select("$this->_epaper_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_epaper_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_epaper_table.user_created","left");        
        $this->db->where(array("$this->_epaper_table.deleted"=>'0',"$this->_epaper_table.visibility"=>'1'));
        $this->db->group_by(array("$this->_epaper_table.epaper_id"));

        return $this->db->count_all_results();
    }
}
