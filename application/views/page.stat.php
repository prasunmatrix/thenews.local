<?php
	/*
    //create session if not exists
    if ($this->session->userdata('visitor_session') == '') {
        $session = random_string('alnum',50);
        $this->session->set_userdata('visitor_session',$session);
    }
    else{
        $session = $this->session->userdata('visitor_session');
    }
    //get user details
    $this->load->library('user_agent');
    
    //check if visitor is already visited before
    $module = $this->uri->segment(2);
    $module_id = $this->uri->segment(4);
    if($module==""){
        $module = "home";
    }
    if($module_id==""){
        $module_id = "index";
    }
    
    $v_details = $this->log_model->get_where('visitor_statistics',array('session_id'=>$session,'module'=>$module,'module_id'=>$module_id));
    if(!empty($v_details)){
        //update visitor statistics
        
        $str = "UPDATE `visitor_statistics` SET `page_viewed` = page_viewed+1, `last_visit` = ".time()."
            WHERE `session_id` = '".$session."' AND `module` = '".$module."' AND `module_id` = '".$module_id."'";
        $this->log_model->run_direct_query($str);
        
        //get if module is available in module_statistics or not
        $module_stat = $this->log_model->get_where('module_statistics',array('module'=>$module,'module_id'=>$module_id));
        if(!empty($module_stat)){
            //save in module_stat
            $str = "UPDATE `module_statistics` SET `page_viewed` = page_viewed+1, `last_visit` = ".time()." WHERE `module` = '".$module."' AND `module_id` = '".$module_id."'";
            $this->log_model->run_direct_query($str);
        }
        else{
            //save in module_stat
            $str = "INSERT INTO `module_statistics` SET `rand_id`= '".random_string('alnum',6)."', `module` = '".$module."', `module_id` = '".$module_id."', `unique_view` = 1, `page_viewed` = 1, `first_visit` = ".time().", `last_visit` = ".time().", `timestamp`=".time();
            $this->log_model->run_direct_query($str);
        }   
    }
    else{
        //insert visitor statistics
        $v_stat_data = array();
        $v_stat_data['session_id'] = $session;
        if($this->session->userdata('ds_user')){
            $v_stat_data['user_id'] = $this->session->userdata('ds_user');
        }
        else{
            $v_stat_data['user_id'] = 0;
        }
        $v_stat_data['browser'] = $this->agent->browser() . ' ' . $this->agent->version();
        $v_stat_data['os'] = $this->agent->platform();
        $v_stat_data['ip'] = $this->input->ip_address();
        $v_stat_data['module'] = $module;
        $v_stat_data['module_id'] = $module_id;
        

        $getloc = json_decode(file_get_contents("http://ipinfo.io/"));

        $v_stat_data['city'] = $getloc->city;
        $v_stat_data['region'] = $getloc->region;
        $v_stat_data['country'] = $getloc->country;
        $v_stat_data['loc'] = $getloc->loc;
        $v_stat_data['org'] = $getloc->org;
        $v_stat_data['timezone'] = $getloc->timezone;
        $v_stat_data['url'] = current_url();
        $v_stat_data['page_viewed'] = '1';
        $v_stat_data['first_visit'] = time();
        $v_stat_data['last_visit'] = time();
        $v_stat_data['timestamp'] = time();
        $this->log_model->save_stat('visitor_statistics',$v_stat_data);
        
        //get if module is available in module_statistics or not
        $module_stat = $this->log_model->get_where('module_statistics',array('module'=>$module,'module_id'=>$module_id));
        if(!empty($module_stat)){
            //save in module_stat
            $str = "UPDATE `module_statistics` SET `unique_view` = unique_view+1, `page_viewed` = page_viewed+1, `last_visit` = ".time()." WHERE `module` = '".$module."' AND `module_id` = '".$module_id."'";
            $this->log_model->run_direct_query($str);
        }
        else{
            //save in module_stat
            $str = "INSERT INTO `module_statistics` SET `rand_id`= '".random_string('alnum',6)."', `module` = '".$module."', `module_id` = '".$module_id."', `unique_view` = 1, `page_viewed` = 1, `first_visit` = ".time().", `last_visit` = ".time().", `timestamp`=".time();
            $this->log_model->run_direct_query($str);
        }            
    }
*/
?>
