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
class News_model extends CI_Model
{
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_types_table = 'news_types';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_module_statistics_table = 'module_statistics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_news_table = 'news';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_exclusive_news_table = 'exclusive_news';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_live_news_table = 'live_news';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_users_table = 'users';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topics_table= 'topics';
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_topic_entities_trans_table= 'topic_entities_trans';    
    
    /**
     * @var string what table is used in the database for the users
     */
    public $_videos_table= 'videos';    


    
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
    function get_where_with_order_limit($tab,$condi,$order=array(),$limit){
        $this->db->select("*");
        $this->db->from($tab);
        $this->db->where($condi);
        $this->db->order_by(key($order), $order[key($order)]);
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    function get_trending_news($limit){
        //$q = "SELECT news.rand_id, module_statistics.unique_view FROM news LEFT JOIN module_statistics ON module_statistics.module_id=news.rand_id WHERE deleted='0' AND visibility='1' ORDER BY unique_view DESC";
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`,$this->_module_statistics_table.unique_view");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_module_statistics_table","$this->_module_statistics_table.module_id = $this->_news_table.rand_id","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1'));
        $this->db->order_by("$this->_module_statistics_table.unique_view","DESC");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_editor_picks($where,$limit){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->join("$this->_topic_entities_trans_table","$this->_topic_entities_trans_table.entity_id = $this->_news_table.news_id","left");        
        $this->db->where($where);
        $this->db->order_by('rand()');
        $this->db->group_by(array("$this->_news_table.news_id"));
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_random_posts($limit){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1'));
        $this->db->order_by('rand()');
        $this->db->group_by(array("$this->_news_table.news_id"));
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_latest_posts($limit = 5, $topics = array()){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_small` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");
        $this->db->join("$this->_topic_entities_trans_table","$this->_topic_entities_trans_table.entity_id= $this->_news_table.news_id","left");
        $where = array();
        $where["$this->_news_table.deleted"] = "0";
        $where["$this->_news_table.visibility"] = "1";
        $where["$this->_news_table.add_to_home_slider"] = "0";
        $where["$this->_topic_entities_trans_table.entity"] = "News";
        
        if(!empty($topics)){
            foreach($topics as $topic){
                $where["$this->_topic_entities_trans_table.topic_id"] = $topic;
            }
        }
        $this->db->where($where);
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_slider_posts(){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_table.add_to_home_slider"=>'1'));
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_latest_category_posts($news_type_id,$news_id,$limit=3){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_table.news_type_id"=>$news_type_id,"$this->_news_table.news_id!="=>$news_id));
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_news_previous_post($news_id){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_table.news_id"=>($news_id-1)));
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_news_next_post($news_id){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_table.news_id"=>($news_id+1)));
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_news_by_topic_id($topic_id,$limit){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_topic_entities_trans_table","$this->_topic_entities_trans_table.entity_id= $this->_news_table.news_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_topic_entities_trans_table.entity"=>TOPICS_ENTITY_NEWS,"$this->_topic_entities_trans_table.topic_id"=>$topic_id));
        $this->db->order_by("$this->_news_table.`news_id`", "desc");
        $this->db->group_by(array("$this->_news_table.news_id"));
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_post_details($url){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.news_type_id as 'news_type_id', $this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_table.rand_id"=>$url));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_live_post_details($url){
        $this->db->select("$this->_live_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.rand_id"=>$url,"$this->_live_news_table.parent_news_id"=>"0"));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_exclusive_post_details($url){
        $this->db->select("$this->_exclusive_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id',$this->_users_table.`avatar_medium` as 'user_avatar'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.rand_id"=>$url,"$this->_exclusive_news_table.parent_news_id"=>"0"));
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_post_by_news_id_details($url){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.news_type_id as 'news_type_id', $this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1',"$this->_news_types_table.news_type_id"=>$url));
        $query = $this->db->get();
        return $query->result_array();
    }
    function search_news_by_query($query){
        $this->db->select("$this->_news_table.*,$this->_news_types_table.news_type_id as 'news_type_id', $this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by',$this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1'));
        $this->db->like("$this->_news_table.news_title", $query);
        $this->db->or_like("$this->_news_table.rand_id", $query);
        $this->db->or_like("$this->_news_table.news_desc", $query);
        $this->db->or_like("$this->_news_table.seo_title", $query);
        $this->db->or_like("$this->_news_table.seo_keywords", $query);
        $this->db->or_like("$this->_news_table.seo_desc", $query);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function save_bookmark($table,$entity_details){
        
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
    
    function delete_bookmark($table,$entity_details){
        
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
    
    function save_news_details($table,$entity_details){
        
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
            $entity_id = $entity_details[0]['news_id'];
        }
        
        return $entity_id;
    
    }
    
    function update_news_details($table,$entity_details, $condition){
        
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
            $entity_id = $entity_details[0]['news_id'];
        }
        
        return $entity_id;
    
    }
    
    
    var $table = 'news';
    var $column_order = array(null,"news.news_title",'news_types.news_type_title','users.first_name','news.date_created','news.add_to_home_slider'); //set column field database for datatable orderable
    var $column_search = array('news.news_title','news_types.news_type_title','users.first_name','users.last_name','news.date_created'); //set column field database for datatable searchable 
    var $exclusive_news_column_order = array(null,"exclusive_news.news_title",'users.first_name','exclusive_news.date_created','exclusive_news.add_to_home_slider'); //set column field database for datatable orderable
    var $exclusive_news_column_search = array('exclusive_news.news_title','users.first_name','users.last_name','exclusive_news.date_created'); //set column field database for datatable searchable 
    var $live_news_column_order = array(null,"live_news.news_title",'users.first_name','live_news.date_created','live_news.add_to_home_slider'); //set column field database for datatable orderable
    var $live_news_column_search = array('live_news.news_title','users.first_name','users.last_name','live_news.date_created'); //set column field database for datatable searchable 
    var $order = array('news_title' => 'asc'); // default order 


    private function _get_datatables_query()
    {        
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1'));
        $this->db->group_by(array("$this->_news_table.news_id"));

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
            $this->db->order_by('news_title','asc');
        }
    }
    
    private function _get_live_datatables_query()
    {        
        $this->db->select("$this->_live_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>'0'));
        $this->db->group_by(array("$this->_live_news_table.news_id"));

        $i = 0;
	
        foreach ($this->live_news_column_search as $item) // loop column 
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

                if(count($this->live_news_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->live_news_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('news_title','asc');
        }
    }
    
    private function _get_exclusive_datatables_query()
    {        
        $this->db->select("$this->_exclusive_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.parent_news_id"=>'0'));
        $this->db->group_by(array("$this->_exclusive_news_table.news_id"));

        $i = 0;
	
        foreach ($this->exclusive_news_column_search as $item) // loop column 
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

                if(count($this->exclusive_news_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->exclusive_news_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('news_title','asc');
        }
    }
    
    private function _get_live_sub_news_datatables_query($news_id)
    {        
        $this->db->select("$this->_live_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>$news_id));
        $this->db->group_by(array("$this->_live_news_table.news_id"));

        $i = 0;
	
        foreach ($this->live_news_column_search as $item) // loop column 
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

                if(count($this->live_news_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->live_news_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('news_title','asc');
        }
    }
    
    private function _get_exclusive_sub_news_datatables_query($news_id)
    {        
        $this->db->select("$this->_exclusive_news_table.*, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.parent_news_id"=>$news_id));
        $this->db->group_by(array("$this->_exclusive_news_table.news_id"));

        $i = 0;
	
        foreach ($this->exclusive_news_column_search as $item) // loop column 
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

                if(count($this->exclusive_news_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_REQUEST['order']) && $_REQUEST['order'][0]['column']!=0) // here order processing
        {
            $this->db->order_by($this->exclusive_news_column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        else{
            $this->db->order_by('news_title','asc');
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
        $this->db->select("$this->_news_table.*,$this->_news_types_table.rand_id as 'news_type_rand_id', $this->_news_types_table.`news_type_title`, CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_news_table);
        $this->db->join("$this->_news_types_table","$this->_news_table.news_type_id = $this->_news_types_table.news_type_id","left");        
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_news_table.user_created","left");        
        $this->db->where(array("$this->_news_table.deleted"=>'0',"$this->_news_table.visibility"=>'1'));
        $this->db->group_by(array("$this->_news_table.news_id"));
        return $this->db->count_all_results();
    }
    
    function get_live_datatables()
    {
        $this->_get_live_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function live_count_filtered()
    {
        $this->_get_live_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function live_count_all()
    {
        $this->db->select("$this->_live_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>'0'));
        $this->db->group_by(array("$this->_live_news_table.news_id"));
        return $this->db->count_all_results();
    }
    
    function get_exclusive_datatables()
    {
        $this->_get_exclusive_datatables_query();
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function exclusive_count_filtered()
    {
        $this->_get_exclusive_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function exclusive_count_all()
    {
        $this->db->select("$this->_exclusive_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.parent_news_id"=>'0'));
        $this->db->group_by(array("$this->_exclusive_news_table.news_id"));
        return $this->db->count_all_results();
    }
    
    function get_live_sub_news_datatables($news_id)
    {
        $this->_get_live_sub_news_datatables_query($news_id);
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function live_sub_news_count_filtered($news_id)
    {
        $this->_get_live_sub_news_datatables_query($news_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function live_sub_news_count_all($news_id)
    {
        $this->db->select("$this->_live_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>$news_id));
        $this->db->group_by(array("$this->_live_news_table.news_id"));
        return $this->db->count_all_results();
    }
    
    function get_exclusive_sub_news_datatables($news_id)
    {
        $this->_get_exclusive_sub_news_datatables_query($news_id);
        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function exclusive_sub_news_count_filtered($news_id)
    {
        $this->_get_exclusive_sub_news_datatables_query($news_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function exclusive_sub_news_count_all($news_id)
    {
        $this->db->select("$this->_exclusive_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.parent_news_id"=>$news_id));
        $this->db->group_by(array("$this->_exclusive_news_table.news_id"));
        return $this->db->count_all_results();
    }
    
    public function get_live_news_posts($past_timestamp){
        $this->db->select("$this->_live_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by', $this->_users_table.`avatar_small` as 'user_avatar', $this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>'0',"$this->_live_news_table.date_created>"=>$past_timestamp));
        $this->db->order_by("$this->_live_news_table.`news_id`", "desc");
        $query = $this->db->get();
        
        return $query->result_array();
    }
    public function get_live_sub_news($parent_news_id){
        $this->db->select("$this->_live_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by', $this->_users_table.`avatar_small` as 'user_avatar', $this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_live_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_live_news_table.user_created","left");        
        $this->db->where(array("$this->_live_news_table.deleted"=>'0',"$this->_live_news_table.visibility"=>'1',"$this->_live_news_table.parent_news_id"=>$parent_news_id));
        $this->db->order_by("$this->_live_news_table.`news_id`", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_exclusive_news_posts($limit){
        $this->db->select("$this->_exclusive_news_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by', $this->_users_table.`avatar_small` as 'user_avatar', $this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_exclusive_news_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_exclusive_news_table.user_created","left");        
        $this->db->where(array("$this->_exclusive_news_table.deleted"=>'0',"$this->_exclusive_news_table.visibility"=>'1',"$this->_exclusive_news_table.parent_news_id"=>'0'));
        $this->db->order_by("$this->_exclusive_news_table.`news_id`", "desc");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_recent_videos($limit){
        $this->db->select("$this->_videos_table.*,CONCAT($this->_users_table.`first_name`,' ',$this->_users_table.`last_name`) as 'created_by', $this->_users_table.`avatar_small` as 'user_avatar', $this->_users_table.`rand_id` as 'user_rand_id'");
        $this->db->from($this->_videos_table);
        $this->db->join("$this->_users_table","$this->_users_table.user_id = $this->_videos_table.user_created","left");        
        $this->db->where(array("$this->_videos_table.deleted"=>'0',"$this->_videos_table.visibility"=>'1'));
        $this->db->order_by("$this->_videos_table.`video_id`", "desc");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
}
