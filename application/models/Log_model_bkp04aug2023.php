<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Users Model
 *
 * @author		VR Patel
 * @copyright   Copyright (c) 2018, vrpatel.in
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.vrpatel.in
 */

/**
 * Class Log Model
 *
 * This class takes care of database actions performed on system_logs
 *
 */
class Log_model extends CI_Model
{

    /**
     * @var string what table is used in the database for the system_logs
     */
    public $_logs_table = 'system_logs';
    
    /**
     * @var string what table is used in the database for the system_logs
     */
    public $_users_table = 'users';

    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->database();
    }

    
    function get_where($tab,$condi){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $query = $this->db->get();
        return $query->result_array();
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
        $loggedInUser = "";
        if($this->session->userdata('ds_user')){
            $loggedInUser = $this->session->userdata('ds_user');
        }
        $log_data = array(
            'rand_id' => $rand_id, 
            'operation' => $operation, 
            'log_type' => $log_type, 
            'ip' => $ip, 
            'os' => $os, 
            'browser' => $browser, 
            'url' => $url, 
            'user_id' => $loggedInUser, 
            'timestamp' => now()
        );
        $this->db->insert($this->_logs_table, $log_data);
    }
    
    
    function save_stat($table,$data){
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $data);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $ret_id = FALSE;
        }
        else
        {
            $ret_id = TRUE;
        }
        
        //return user_id
        return $ret_id;       
    }
    
    function save_topic_entities_details($table,$entity_details){
    
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
    function delete_topic_entities_details($table,$entity_details){
    
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->delete($table, $entity_details);
        
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
    
    function update_topic_entities_details($table, $condition){        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->delete($table, $condition);  
        
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
    
    function run_direct_query($qry){        
        // start database transaction
        $this->db->trans_start();

        $query = $this->db->query($qry);

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
    
    var $table = 'system_logs';
    var $column_order  = array('system_logs.log_id', 'system_logs.operation','system_logs.log_type','system_logs.ip','system_logs.os','system_logs.url','system_logs.browser','users.first_name','system_logs.timestamp');
    var $column_search = array('system_logs.log_id','system_logs.operation','system_logs.log_type','system_logs.ip','system_logs.os','system_logs.url','system_logs.browser','system_logs.timestamp','users.first_name','users.last_name'); 
    var $order = array('log_id' => 'desc'); // default order 


	private function _get_datatables_query()
    {
        $this->db->select("$this->_logs_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_logs_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_logs_table.user_id","left");        

            $i = 0;

        foreach ($this->column_search as $item) { // loop column 
            if (isset($_REQUEST['search']['value'])) { // if datatable send POST for search

                if ($i === 0) { // first loop
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

        if (isset($_REQUEST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        } else {
            $this->db->order_by('log_id', 'desc');
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
        $this->db->select("$this->_logs_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_logs_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_logs_table.user_id","left");        

        return $this->db->count_all_results();
    }
    
    
    var $subscribers_table = 'subscribers';
    var $subscribers_column_order  = array('subscribers.sub_id', 'subscribers.email','subscribers.date_created');
    var $subscribers_column_search = array('subscribers.email'); 
    var $subscribers_order = array('sub_id' => 'desc'); // default order 


    private function _get_subscribers_datatables_query()
    {
        $this->db->select("$this->subscribers_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->subscribers_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->subscribers_table.user_created","left");        

        $i = 0;

        foreach ($this->subscribers_column_search as $item) { // loop column 
            if (isset($_REQUEST['search']['value'])) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_REQUEST['search']['value']);
                } else {
                    $this->db->or_like($item, $_REQUEST['search']['value']);
                }

                if (count($this->subscribers_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_REQUEST['order'])) { // here order processing
            $this->db->order_by($this->subscribers_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } else if (isset($this->subscribers_order)) {
            $order = $this->subscribers_order;
            $this->db->order_by(key($order), $order[key($order)]);
        } else {
            $this->db->order_by('sub_id', 'desc');
        }
    }

    function get_subscribers_datatables()
    {
        $this->_get_subscribers_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function subscribers_count_filtered()
    {
        $this->_get_subscribers_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function subscribers_count_all()
    {
        $this->db->select("$this->subscribers_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->subscribers_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->subscribers_table.user_created","left");        

        return $this->db->count_all_results();
    }
}
