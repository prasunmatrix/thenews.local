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
class Settings_model extends CI_Model
{
    /**
     * @var string what table is used in the database for the topics
     */
    public $_users_table= 'users';
    /**
     * @var string what table is used in the database for the topics
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the topic_entities_trans
     */
    public $_topic_entities_table= 'topic_entities_trans';
    
    
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
    
    function save_topic_details($table,$entity_details){
        
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
            $entity_id = $entity_details[0]['topic_id'];
        }
        
        return $entity_id;
    
    }
    
    function update_terms_and_conditions_details($table,$entity_details, $condition){
        
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
            $entity_id = $entity_details[0]['id'];
        }
        
        return $entity_id;
    
    }
    function update_topic_details($table,$entity_details, $condition){
        
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
            $entity_id = $entity_details[0]['topic_id'];
        }
        
        return $entity_id;
    
    }
    
    function save_menu_item_details($table,$entity_details){
        
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
            $entity_id = $entity_details[0]['item_id'];
        }
        
        return $entity_id;
    
    }
    
    function update_menu_item_details($table,$entity_details, $condition){
        
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
            $entity_id = $entity_details[0]['item_id'];
        }
        
        return $entity_id;
    
    }
    
    function save_menu_sub_item_details($table,$entity_details){
        
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
            $entity_details =  $this->get_where($table, array('sub_rand_id'=>$entity_details['sub_rand_id']));
            $entity_id = $entity_details[0]['sub_item_lang'];
        }
        
        return $entity_id;
    
    }
    
    function update_menu_sub_item_details($table,$entity_details, $condition){
        
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
            $entity_id = $entity_details[0]['sub_item_id'];
        }
        
        return $entity_id;
    
    }
    function save_institute_details($table,$entity_details){
        
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
            $entity_details =  $this->get_where($table, array('inst_rand_id'=>$entity_details['inst_rand_id']));
            $entity_id = $entity_details[0]['inst_rand_id'];
        }
        
        return $entity_id;
    
    }
    
    var $topics_table = 'topics';
    var $topics_column_order = array(null,"topics.topic_name",null,'users.first_name','topics.date_created'); 
    var $topics_column_search = array('topics.topic_name','users.first_name','users.last_name'); 
    var $topics_order = array('topic_name' => 'asc'); // default order 


    private function _get_topics_datatables_query()
    {        
        $this->db->select("$this->_topics_table.`topic_id`, $this->_topics_table.`class_name`, $this->_topics_table.`rand_id`, $this->_topics_table.`topic_name`, COUNT($this->_topic_entities_table.`topic_id`) AS 'used_times', CONCAT($this->_users_table.`first_name`,' ', $this->_users_table.`last_name`) AS 'created_by',$this->_topics_table.`date_created`");
        $this->db->from($this->_topics_table);
        $this->db->join("$this->_topic_entities_table","$this->_topic_entities_table.topic_id = $this->_topics_table.`topic_id","left");
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_topics_table.`user_created","left");
        
        $this->db->where(array("$this->_topics_table.deleted"=>'0'));
        $this->db->group_by("$this->_topics_table.topic_id");

        $i = 0;
	
        foreach ($this->topics_column_search as $item) // loop column 
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

                if(count($this->topics_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->topics_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->topics_order))
        {
            $order = $this->topics_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('topic_name','asc');
        }
    }

    function get_topics_datatables()
    {
        $this->_get_topics_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_topics_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select("$this->_topics_table.`topic_id`, $this->_topics_table.`class_name`, $this->_topics_table.`rand_id`, $this->_topics_table.`topic_name`, COUNT($this->_topic_entities_table.`topic_id`) AS 'used_times', CONCAT($this->_users_table.`first_name`,' ', $this->_users_table.`last_name`) AS 'created_by',$this->_topics_table.`date_created`");
        $this->db->from($this->_topics_table);
        $this->db->join("$this->_topic_entities_table","$this->_topic_entities_table.topic_id = $this->_topics_table.`topic_id","left");
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_topics_table.`user_created","left");
        
        $this->db->where(array("$this->_topics_table.deleted"=>'0'));
        $this->db->group_by("$this->_topics_table.topic_id");

        return $this->db->count_all_results();
    }
    
    var $menu_items_table = 'menu_items';
    var $menu_items_column_order = array(null,"menu_items.item_title",null,'users.first_name','menu_items.date_created'); 
    var $menu_items_column_search = array('menu_items.item_title','users.first_name','users.last_name'); 
    var $menu_items_order = array('item_title' => 'asc'); // default order 


    private function _get_menu_items_datatables_query()
    {
        $this->db->select("$this->menu_items_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->menu_items_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->menu_items_table.`user_created","left");
        $this->db->where(array("$this->menu_items_table.deleted"=>'0',"$this->menu_items_table.visibility"=>'1'));
        
        $i = 0;
	
        foreach ($this->menu_items_column_search as $item) // loop column 
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

                if(count($this->menu_items_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->menu_items_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->menu_items_order))
        {
            $order = $this->menu_items_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('item_title','asc');
        }
    }

    function get_menu_items_datatables()
    {
        $this->_get_menu_items_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function menu_items_count_filtered()
    {
        $this->_get_menu_items_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function menu_items_count_all()
    {
        $this->db->select("$this->menu_items_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->menu_items_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->menu_items_table.`user_created","left");
        $this->db->where(array("$this->menu_items_table.deleted"=>'0',"$this->menu_items_table.visibility"=>'1'));
        
        return $this->db->count_all_results();
    }
    
    
    var $menu_sub_items_table = 'menu_sub_items';
    var $menu_sub_items_column_order = array(null,"menu_sub_items.sub_item_title",null,'users.first_name','menu_sub_items.date_created'); 
    var $menu_sub_items_column_search = array('menu_sub_items.sub_item_title','users.first_name','users.last_name'); 
    var $menu_sub_items_order = array('sub_item_title' => 'asc'); // default order 


    private function _get_menu_sub_items_datatables_query($parent_item_id)
    {
        $this->db->select("$this->menu_sub_items_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->menu_sub_items_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->menu_sub_items_table.`user_created","left");
        $this->db->where(array("$this->menu_sub_items_table.deleted"=>'0',"$this->menu_sub_items_table.visibility"=>'1',"$this->menu_sub_items_table.parent_item_id"=>$parent_item_id));
        
        $i = 0;
	
        foreach ($this->menu_sub_items_column_search as $item) // loop column 
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

                if(count($this->menu_sub_items_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->menu_sub_items_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->menu_sub_items_order))
        {
            $order = $this->menu_sub_items_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('sub_item_title','asc');
        }
    }

    function get_menu_sub_items_datatables($parent_item_id)
    {
        $this->_get_menu_sub_items_datatables_query($parent_item_id);
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function menu_sub_items_count_filtered($parent_item_id)
    {
        $this->_get_menu_sub_items_datatables_query($parent_item_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function menu_sub_items_count_all($parent_item_id)
    {
        $this->db->select("$this->menu_sub_items_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->menu_sub_items_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->menu_sub_items_table.`user_created","left");
        $this->db->where(array("$this->menu_sub_items_table.deleted"=>'0',"$this->menu_sub_items_table.visibility"=>'1',"$this->menu_sub_items_table.parent_item_id"=>$parent_item_id));
        
        return $this->db->count_all_results();
    }
    
    var $educational_institutes_table = 'educational_institutes';
    var $educational_institutes_column_order = array(null,"educational_institutes.inst_name",null,'users.first_name','educational_institutes.date_created'); 
    var $educational_institutes_column_search = array('educational_institutes.inst_name','users.first_name','users.last_name'); 
    var $educational_institutes_order = array('inst_name' => 'asc'); // default order 


    private function _get_educational_institutes_datatables_query()
    {
        $this->db->select("$this->educational_institutes_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->educational_institutes_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->educational_institutes_table.`user_created","left");
        $this->db->where(array("$this->educational_institutes_table.deleted"=>'0',"$this->educational_institutes_table.visibility"=>'1'));
        
        $i = 0;
	
        foreach ($this->educational_institutes_column_search as $item) // loop column 
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

                if(count($this->educational_institutes_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->educational_institutes_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->educational_institutes_order))
        {
            $order = $this->educational_institutes_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('inst_name','asc');
        }
    }

    function get_educational_institutes_datatables()
    {
        $this->_get_educational_institutes_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function educational_institutes_count_filtered()
    {
        $this->_get_educational_institutes_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function educational_institutes_count_all()
    {
        $this->db->select("$this->educational_institutes_table.*,CONCAT($this->_users_table.first_name,' ', $this->_users_table.last_name) as 'created_by'");
        $this->db->from($this->educational_institutes_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->educational_institutes_table.`user_created","left");
        $this->db->where(array("$this->educational_institutes_table.deleted"=>'0',"$this->educational_institutes_table.visibility"=>'1'));
        
        return $this->db->count_all_results();
    }
}
