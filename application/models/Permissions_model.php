<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clients Model
 *
 * @author		VR Patel
 * @copyright   Copyright (c) 2018, Survey-Polls.com
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.survey-polls.com
 */

/**
 * Class Clients Model
 *
 * This class takes care of database actions performed on users
 *
 */
class Permissions_model extends CI_Model
{
    /**
     * @var string what table is used in the database for the users
     */
    public $_permissions_table= 'permissions';

    /**
     * @var string what table is used in the database for the users
     */
    public $_user_roles_table= 'user_roles';

    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->database();
    }
    
    function get_where($tab,$condi){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function save_permission_details($table,$client_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $client_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $org_id = FALSE;
        }
        else
        {
            $client_details =  $this->get_where($table, $client_details);
            $org_id = $client_details[0]['per_id'];
        }
        
        //return user_id
        return $org_id;
    
    }
    
    function update_permission_details($table,$client_details, $conditions){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($conditions);
        
        //save user details
        $this->db->update($table, $client_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $org_id = FALSE;
        }
        else
        {
            $client_details =  $this->get_where($table, $client_details);
            $org_id = $client_details[0]['per_id'];
        }
        
        //return user_id
        return $org_id;
    
    }
    
    var $table = 'permissions';
	var $column_order = array('permissions.module', 'permissions.action','permissions.operation','user_roles.role','permissions.permission'); //set column field database for datatable orderable
	var $column_search = array('permissions.module','permissions.action','permissions.operation','user_roles.role','permissions.permission'); //set column field database for datatable searchable 
	var $order = array('per_id','asc'); // default order 


	private function _get_datatables_query()
	{
		
		$this->db->select("$this->_permissions_table.*, $this->_user_roles_table.`role`");
        $this->db->from($this->_permissions_table);
        $this->db->join("$this->_user_roles_table","$this->_user_roles_table.role_id= $this->_permissions_table.role_id","left");
        
        
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
		
		if(isset($_REQUEST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
        
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		$query = $this->db->get();
		return $query->result();
//        print_r($this->db->last_query());
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
        
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->select("$this->_permissions_table.*, $this->_user_roles_table.`role`");
        $this->db->from($this->_permissions_table);
        $this->db->join("$this->_user_roles_table","$this->_user_roles_table.role_id= $this->_permissions_table.role_id","left");
        
		return $this->db->count_all_results();
	}
    
    /**
     * Check for permission on the given module for the given action
     *
     */
    public function check($controller, $action)
    {
        $user_details = $this->users_model->get_where($this->_users_table,array('user_id'=>$this->session->userdata('ds_user')));
        
        if(!empty($user_details)){
            $user_role_id = $user_details[0]['user_role_id'];
            
            //check if user is root access
            if($user_details[0]['is_root']=='1'){
                return TRUE;
            }
            $where = array();
            $where['module'] = $controller;
            $where['action'] = $action;
            $where['role_id'] = $user_role_id;
            
            $permission = $this->get_where($this->_permissions_table,$where);
            
            if(!empty($permission)){
                if($permission[0]['permission']=='1'){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
                
        }
    }
    
    
    public function check_redirect($controller, $action)
    {
        $user_details = $this->users_model->get_where($this->_users_table,array('user_id'=>$this->session->userdata('ds_user')));
        
        if(!empty($user_details)){
            $user_role_id = $user_details[0]['user_role_id'];
            
            //check if user is root access
            if($user_details[0]['is_root']=='1'){
                return TRUE;
            }
            $where = array();
            $where['module'] = $controller;
            $where['action'] = $action;
            $where['role_id'] = $user_role_id;
            
            $permission = $this->get_where($this->_permissions_table,$where);
            
            if(!empty($permission)){
                if($permission[0]['permission']=='1'){
                    return true;
                }
                else{
                    redirect(site_url().DASHBOARD_DIR_NAME.'unauthorised');
                }
            }
            else{
                redirect(site_url().DASHBOARD_DIR_NAME.'unauthorised');
            }
                
        }
    }
}
