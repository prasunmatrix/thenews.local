<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Blogs Model
 *
 * @author		VR Patel
 * @copyright   Copyright (c) 2018, Survey-Polls.com
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
class General_settings_model extends CI_Model
{
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_languages_table = 'languages';
    
    /**
     * @var string what table is used in the database for the Blogs
     */
    public $_general_config_table= 'general_config';
    
    
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
    
    function save_image_details($table,$event_details){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->insert($table, $event_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $evt_id = FALSE;
        }
        else
        {
            $event_details =  $this->get_where($this->_images_gallery_table, array('rand_id'=>$event_details['rand_id']));
            $evt_id = $event_details[0]['img_id'];
        }
        
        //return user_id
        return $evt_id;
    
    }
    
    function update_general_config_details($table,$event_details, $condition){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($condition);
        
        //save user details
        $this->db->update($table, $event_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $config_id = FALSE;
        }
        else
        {
            $event_details =  $this->get_where($this->_general_config_table, $condition);
            $config_id = $event_details[0]['config_id'];
        }
        
        return $config_id;
    
    }
    function update_languages_details($table,$event_details, $condition){
        
        // start database transaction
        $this->db->trans_start();
        
        $this->db->where($condition);
        
        //save user details
        $this->db->update($table, $event_details);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            $config_id = FALSE;
        }
        else
        {
            $event_details =  $this->get_where($this->_languages_table, $condition);
            $config_id = $event_details[0]['lang_id'];
        }
        
        return $config_id;
    
    }
    
    function update_entity_details($table,$details,$condition){
        
        // start database transaction
        $this->db->trans_start();
        
        //save user details
        $this->db->update($table, $details);
        
        $this->db->where($condition);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    
    }
    
    var $table = 'videos';
	var $column_order = array(null,'video_title'); //set column field database for datatable orderable
	var $column_search = array('video_title','video_desc','video_url','seo_title','seo_keywords','seo_desc'); //set column field database for datatable searchable 
	var $order = array('video_id' => 'desc'); // default order 


	private function _get_datatables_query()
	{
		$this->db->from($this->table);

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
            $this->db->order_by('blog_id','desc');
        }
        $this->db->where(array('deleted'=>'0'));
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
		$this->db->from($this->table);
        $this->db->where(array('deleted'=>'0'));
        return $this->db->count_all_results();
	}
}
