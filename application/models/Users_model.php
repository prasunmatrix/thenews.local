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
class Users_model extends CI_Model
{
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_bookmarks_table= 'bookmarks';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_table= 'news';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_videos_table= 'videos';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table= 'users';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_system_logs_table= 'system_logs';
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_subscribers_table = 'subscribers';
    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_user_roles_table = 'user_roles';
    
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_where_now($token){
        $this->db->select(" * FROM `users` WHERE `password_reset_token` = '".$token."' AND `password_reset_token_validity` > NOW()");
//        $this->db->from($tab);
//        $this->db->where($condi);
        $query = $this->db->get();
//        if($print_qry){
//                print_r($this->db->last_query());exit;
//        }
        return $query->result_array();
    }

    function get_where($tab,$condi, $print_qry=FALSE){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $query = $this->db->get();
	if($print_qry){
		print_r($this->db->last_query());exit;
	}
        return $query->result_array();
    }
    
    function get_random_services($tab,$condi){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $this->db->order_by('RAND()');
        $this->db->limit(3);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_recent_events($tab,$condi,$limit){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $this->db->order_by('evt_id','desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_normal_user_details_by_email_or_username($value){

        $this->db->select(" * FROM ".$this->_users_table." WHERE deleted='0' AND user_role_id='" . NORMAL_USER_ROLE_ID . "' AND (email='".$value."' or rand_id='".$value."') ", FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_user_details_by_email_or_username($value){

        $this->db->select(" * FROM ".$this->_users_table." WHERE is_root='1' AND deleted='0' AND (email='".$value."' or rand_id='".$value."') ", FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function save_user_details($table,$user_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $user_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $user_id = FALSE;
        }
        else
        {
            $user_details =  $this->get_where($this->_users_table, array('rand_id'=>$user_details['rand_id']));
            $user_id = $user_details[0]['user_id'];
        }
        
        //return user_id
        return $user_id;
    
    }
    
     function save_subscriber_details($table,$user_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $user_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $user_id = FALSE;
        }
        else
        {
            $user_id = TRUE;
        }
        
        //return user_id
        return $user_id;
    
    }
    
    function update_user_details($table,$user_details, $condition){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($condition);
        
        //save user details
        $this->db->update($table, $user_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $user_id = FALSE;
        }
        else
        {
            $user_details =  $this->get_where($this->_users_table, $condition);
            $user_id = $user_details[0]['rand_id'];
        }
        
        //return user_id
        return $user_id;
    
    }
    function user_details($rand_id,$email)
    {
      $sql="select * from ".$this->_users_table." where rand_id='$rand_id' AND email='$email'";
  	  $query=$this->db->query($sql);
  	  $data=$query->row();
      // echo "<pre>";
      // print_r($data); die;
      return $data->user_id;
    }
    function update_user_subscribe_details($table,$user_details, $condition){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($condition);
        
        //save user details
        $this->db->update($table, $user_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $user_id = FALSE;
        }
        else
        {
            $user_details =  $this->get_where($this->_subscribers_table, $condition);
            $user_id = $user_details[0]['sub_id'];
        }
        
        //return user_id
        return $user_id;
    
    }
    
    
    var $table = 'users';
	var $column_order = array(null, 'users.first_name','users.email','user_roles.role'); //set column field database for datatable orderable
	var $column_search = array('users.first_name','users.last_name','users.last_name','users.email','user_roles.role'); //set column field database for datatable searchable 
	var $order = array('users.first_name' => 'asc'); // default order 


	private function _get_datatables_query()
	{
		$this->db->select("$this->_users_table.*, $this->_user_roles_table.role");
        $this->db->from($this->_users_table);
        $this->db->join("$this->_user_roles_table","$this->_user_roles_table.role_id= $this->_users_table.user_role_id","left");
        $this->db->where(array("$this->_users_table.deleted"=>'0',"$this->_users_table.is_root"=>'0'));

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
//		print_r($_REQUEST['order']);
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
            $this->db->order_by('first_name','asc');
        }
        
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		$query = $this->db->get();
//        print_r($this->db->last_query());
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
        $where = array();
        
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
        
        $where = array();
        $where['deleted'] = "0";
        $where['is_root'] = "0";
        
        $this->db->where($where);
		return $this->db->count_all_results();
	}
	public function count_all_records($table,$condition)
	{
		$this->db->from($table);
        $this->db->where($condition);
		return $this->db->count_all_results();
	}
    
    
    var $ul_table = 'system_logs';
	var $ul_column_order = array('system_logs.operation','system_logs.log_type','system_logs.url','users.first_name','system_logs.ip','system_logs.os','system_logs.browser'); //set column field database for datatable orderable
	var $ul_column_search = array('system_logs.operation','system_logs.log_type','system_logs.url','users.first_name','users.last_name','system_logs.ip','system_logs.os','system_logs.browser'); //set column field database for datatable searchable 
	var $ul_order = array('log_id' => 'desc'); // default order 


	private function _get_user_logs_datatables_query()
	{
		$this->db->select("$this->_system_logs_table.*, CONCAT($this->_users_table.`first_name`,' ', $this->_users_table.`last_name`) AS 'created_by'");
        $this->db->from($this->_system_logs_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_system_logs_table.`user_id","left");        

		$i = 0;
	
		foreach ($this->ul_column_search as $item) // loop column 
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

				if(count($this->ul_column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
//		print_r($_REQUEST['order']);
		if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
		{
			$this->db->order_by($this->ul_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} 
		else if(isset($this->ul_order))
		{
			$order = $this->ul_order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
        else{
            $this->db->order_by('log_id','desc');
        }
        $this->db->where(array($this->_system_logs_table.'.user_id'=>$this->session->userdata('ds_user')));        
	}

	function get_user_logs_datatables()
	{
		$this->_get_user_logs_datatables_query();
		if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_user_logs_filtered()
	{
		$this->_get_user_logs_datatables_query();
        $query = $this->db->get();
		return $query->num_rows();
	}

	public function count_user_logs_all()
	{
		$this->db->select("$this->_system_logs_table.*, CONCAT($this->_users_table.`first_name`,' ', $this->_users_table.`last_name`) AS 'created_by'");
        $this->db->from($this->_system_logs_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_system_logs_table.`user_id","left");        
        $this->db->where(array($this->_system_logs_table.'.user_id'=>$this->session->userdata('ds_user')));        
        return $this->db->count_all_results();
	}
	public function get_user_module_stat($user_id,$module_name,$peram1 = FALSE)
	{
        if($module_name=='videos'){
            if($peram1==VIDEO_TYPE_VIDEO){
                $this->db->select("*");
                $this->db->from($module_name);        
                $this->db->where(array('deleted'=>'0','user_created'=>$user_id,'video_type'=>VIDEO_TYPE_VIDEO));        
                return $this->db->count_all_results();
            }
            else{
                $this->db->select("*");
                $this->db->from($module_name);        
                $this->db->where(array('deleted'=>'0','user_created'=>$user_id,'video_type'=>VIDEO_TYPE_LIVE_STREAMING));        
                return $this->db->count_all_results();
            }
                
        }
        else{
            $this->db->select("*");
            $this->db->from($module_name);        
            $this->db->where(array('deleted'=>'0','user_created'=>$user_id));        
            return $this->db->count_all_results();
        }
		
	}
	
	public function get_user_bookmarks_news(){
	    $this->db->select("$this->_news_table.news_title, $this->_news_table.rand_id");
        $this->db->from($this->_bookmarks_table);
        $this->db->join("$this->_news_table","$this->_news_table.news_id = $this->_bookmarks_table.`entity_id","left");        
        $this->db->where(array($this->_bookmarks_table.'.user_id'=>$this->session->userdata('normal_user'),"entity"=>'news'));        
        $query = $this->db->get();
		return $query->result();
	}
	
	public function get_user_bookmarks_videos(){
	    $this->db->select("$this->_videos_table.video_title, $this->_videos_table.rand_id");
        $this->db->from($this->_bookmarks_table);
        $this->db->join("$this->_videos_table","$this->_videos_table.video_id = $this->_bookmarks_table.`entity_id","left");        
        $this->db->where(array($this->_bookmarks_table.'.user_id'=>$this->session->userdata('normal_user'),"entity"=>'video'));        
        $query = $this->db->get();
		return $query->result();
	}
}
