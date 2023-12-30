<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php  $this->load->view('dashboard/_head.php'); ?>

    </head>
    <body class="">
    <?php $this->load->view('dashboard/block.head.php'); ?>
        
<?php } ?>
                        <title><?php echo $page_title; ?> - <?php echo lang('site_title'); ?></title>
                        <section class="vbox bg-gradient content-vbox">
                            <header class="header b-b b-t b-light bg-light lter">
                                <ul class="breadcrumb no-border no-radius">
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>"><i class="fa fa-home"></i> &nbsp;<?= lang('dashboard'); ?></a></li>
                                    <li><a href="<?= site_url().DASHBOARD_DIR_NAME ?>artists"><i class="fa fa-male"></i> &nbsp;<?= lang('artists'); ?></a></li>
                                    <?php
                                        if($this->uri->segment(4)=='add'){
                                    ?>
                                        <li class="active"><i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_artist'); ?></li>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <li class="active"><i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_artist_details'); ?></li>
                                    <?php        
                                        }
                                    ?>
                                </ul>                                
                            </header>
                            <section class="scrollable wrapper no-padding">
                                <div id="my_account" class="wrapper">
                                    <div class="col-md-12 no-padding">
                                        <form method="post" class="artists_form">
                                            <div class="col-md-8 no-padding">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?php
                                                            if($this->uri->segment(4)=='add'){
                                                        ?>
                                                            <i class="fa fa-plus"></i> &nbsp;<?= lang('add_new_artist'); ?>
                                                        <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <i class="fa fa-pencil"></i> &nbsp;<?= lang('edit_artist_details'); ?>
                                                        <?php        
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="panel-body" style="padding-left: 0px; padding-right: 0px;">
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-circle"></i>
                                                                    </div>
                                                                    <input type="hidden" name="artist_id" class="form-control" value="<?php  if(isset($artist_details[0]['artist_id'])){ echo $artist_details[0]['artist_id']; }?>">
                                                                    <input type="text" name="artist_full_name" class="form-control artist" placeholder="<?= lang('artist_full_name'); ?>" value="<?php  if(isset($artist_details[0]['artist_full_name'])){ echo $artist_details[0]['artist_full_name']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-globe"></i>
                                                                    </div>
                                                                    <input type="text" name="artist_url" class="form-control artist_url" placeholder="<?= lang('artist_url'); ?>" value="<?php  if(isset($artist_details[0]['artist_rand_id'])){ echo $artist_details[0]['artist_rand_id']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-circle-o"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="artist_first_name" placeHolder="<?= lang('artist_first_name'); ?>" value="<?php  if(isset($artist_details[0]['artist_first_name'])){ echo $artist_details[0]['artist_first_name']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-circle-o"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="artist_middle_name" placeHolder="<?= lang('artist_middle_name'); ?>" value="<?php  if(isset($artist_details[0]['artist_middle_name'])){ echo $artist_details[0]['artist_middle_name']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-circle-o"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="artist_last_name" placeHolder="<?= lang('artist_last_name'); ?>" value="<?php  if(isset($artist_details[0]['artist_last_name'])){ echo $artist_details[0]['artist_last_name']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-md"></i>
                                                                    </div>
                                                                    <div id="artistNickNames" class="pillbox clearfix">
                                                                        <?php
                                                                            $keywords = array();
                                                                            if(isset($artist_details[0]['artist_nick_name'])){                                                                             
                                                                                $keywords = json_decode($artist_details[0]['artist_nick_name']);
                                                                            }
                                                                        ?>
                                                                        <ul>
                                                                            <?php
                                                                                if(!empty($keywords)){
                                                                                    foreach ($keywords as $key){
                                                                            ?>
                                                                                    <li class="label bg-dark"><?= $key->text; ?></li>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>

                                                                            <input type="text"  placeHolder="<?= lang('artist_nick_names'); ?>">
                                                                            <input type="hidden" id="artist_nick_names" name="artist_nick_names">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-male"></i>
                                                                    </div>
                                                                    <div class="radio" style="padding-left: 20px;">
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="gender" value="<?= lang('male'); ?>" <?php if(isset($artist_details[0]['artist_gender'])){ if($artist_details[0]['artist_gender']==lang('male')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('male'); ?>
                                                                        </label>
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="gender" value="<?= lang('female'); ?>" <?php if(isset($artist_details[0]['artist_gender'])){ if($artist_details[0]['artist_gender']==lang('female')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('female'); ?>
                                                                        </label>
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="gender" value="<?= lang('other'); ?>" <?php if(isset($artist_details[0]['artist_gender'])){ if($artist_details[0]['artist_gender']==lang('other')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('other'); ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-level-up"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="height" placeHolder="<?= lang('height'); ?>" value="<?php  if(isset($artist_details[0]['artist_height'])){ echo $artist_details[0]['artist_height']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-arrow-right"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="width" placeHolder="<?= lang('width'); ?>" value="<?php  if(isset($artist_details[0]['artist_width'])){ echo $artist_details[0]['artist_width']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-3" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control datepicker" name="date_of_birth" placeHolder="<?= lang('date_of_birth'); ?>" value="<?php  if(isset($artist_details[0]['artist_date_of_birth'])){ echo $artist_details[0]['artist_date_of_birth']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-map-marker"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="birth_place" placeHolder="<?= lang('birth_place'); ?>" value="<?php  if(isset($artist_details[0]['artist_birth_place'])){ echo $artist_details[0]['artist_birth_place']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-3" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control datepicker" name="date_of_death" placeHolder="<?= lang('date_of_death'); ?>" value="<?php  if(isset($artist_details[0]['artist_date_of_death'])){ echo $artist_details[0]['artist_date_of_death']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-map-marker"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="death_place" placeHolder="<?= lang('death_place'); ?>" value="<?php  if(isset($artist_details[0]['artist_death_place'])){ echo $artist_details[0]['artist_death_place']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-bookmark-o"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="body_measurements" placeHolder="<?= lang('body_measurements'); ?>" value="<?php  if(isset($artist_details[0]['artist_body_measurements'])){ echo $artist_details[0]['artist_body_measurements']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-eye"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="eye_color" placeHolder="<?= lang('eye_color'); ?>" value="<?php  if(isset($artist_details[0]['artist_eye_color'])){ echo $artist_details[0]['artist_eye_color']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-bold"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="hair_color" placeHolder="<?= lang('hair_color'); ?>" value="<?php  if(isset($artist_details[0]['artist_hair_color'])){ echo $artist_details[0]['artist_hair_color']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-flag"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="nationality" placeHolder="<?= lang('nationality'); ?>" value="<?php  if(isset($artist_details[0]['artist_nationality'])){ echo $artist_details[0]['artist_nationality']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-simplybuilt"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="zodiac_sign" placeHolder="<?= lang('zodiac_sign'); ?>" value="<?php  if(isset($artist_details[0]['artist_zodiac_sign'])){ echo $artist_details[0]['artist_zodiac_sign']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-flag-checkered"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="religion" placeHolder="<?= lang('religion'); ?>" value="<?php  if(isset($artist_details[0]['artist_religion'])){ echo $artist_details[0]['artist_religion']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-flag-o"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="caste" placeHolder="<?= lang('caste'); ?>" value="<?php  if(isset($artist_details[0]['artist_caste'])){ echo $artist_details[0]['artist_caste']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-asterisk"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="blood_group" placeHolder="<?= lang('blood_group'); ?>" value="<?php  if(isset($artist_details[0]['artist_blood_group'])){ echo $artist_details[0]['artist_blood_group']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-home"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="hometown" placeHolder="<?= lang('hometown'); ?>" value="<?php  if(isset($artist_details[0]['artist_hometown'])){ echo $artist_details[0]['artist_hometown']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-map-pin"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="address" placeHolder="<?= lang('address'); ?>" value="<?php  if(isset($artist_details[0]['artist_address'])){ echo $artist_details[0]['artist_address']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-5" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-male"></i>
                                                                    </div>
                                                                    <div class="radio" style="padding-left: 20px;">
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="relationship_status" value="<?= lang('single'); ?>" <?php if(isset($artist_details[0]['artist_marital_status'])){ if($artist_details[0]['artist_marital_status']==lang('single')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('single'); ?>
                                                                        </label>
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="relationship_status" value="<?= lang('married'); ?>" <?php if(isset($artist_details[0]['artist_marital_status'])){ if($artist_details[0]['artist_marital_status']==lang('married')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('married'); ?>
                                                                        </label>
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="relationship_status" value="<?= lang('engaged'); ?>" <?php if(isset($artist_details[0]['artist_marital_status'])){ if($artist_details[0]['artist_marital_status']==lang('engaged')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('engaged'); ?>
                                                                        </label>
                                                                        <label class="radio-custom">
                                                                            <input type="radio" name="relationship_status" value="<?= lang('inrelationship'); ?>" <?php if(isset($artist_details[0]['artist_marital_status'])){ if($artist_details[0]['artist_marital_status']==lang('inrelationship')){ echo "checked"; }}; ?>>
                                                                            <i class="fa fa-circle-o"></i>
                                                                            <?= lang('inrelationship'); ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-female"></i>
                                                                    </div>
                                                                    <select class="select2 form-control" name="partner_id">
                                                                        <option value="" selected disabled><?= lang('select_partner'); ?></option>
                                                                        <?php
                                                                            foreach($artists as $artist){
                                                                                if(isset($artist_details[0]['artist_role_id'])){
                                                                                    if($artist_details[0]['artist_role_id']==$artist['artist_role_id']){
                                                                                        echo "<option value='".$artist['artist_id']."' selected>".$artist['artist_full_name']."</option>";
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value='".$artist['artist_id']."'>".$artist['artist_full_name']."</option>";
                                                                                    }
                                                                                }
                                                                                else{
                                                                                    echo "<option value='".$artist['artist_id']."'>".$artist['artist_full_name']."</option>";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-money"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="net_worth" placeHolder="<?= lang('net_worth'); ?>" value="<?php  if(isset($artist_details[0]['artist_net_worth'])){ echo $artist_details[0]['artist_net_worth']; }?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-inr"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="income" placeHolder="<?= lang('income'); ?>" value="<?php  if(isset($artist_details[0]['artist_income'])){ echo $artist_details[0]['artist_income']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-angellist"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="food_habit" placeHolder="<?= lang('food_habit'); ?>" value="<?php  if(isset($artist_details[0]['artist_food_habit'])){ echo $artist_details[0]['artist_food_habit']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div id="editor"><div id='edit' style="margin-top: 10px;margin-bottom: 10px;"><?php if(isset($artist_details[0]['artist_bio'])){ echo $artist_details[0]['artist_bio']; } ?></div></div>
                                                                <textarea class="form-control" style="display: none;" id="artist_desc" name="artist_desc"><?php if(isset($artist_details[0]['artist_bio'])){ echo $artist_details[0]['artist_bio']; } ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <button type="submit" class="btn btn-dark submit_btn"><?= lang('save'); ?></button>
                                                                <a href="<?= site_url() . DASHBOARD_DIR_NAME ?>artists" class="btn btn-default"><?= lang('cancel'); ?></a>
                                                            </div>                                                    
                                                        </div>                                                    
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><i class="fa fa-info"></i> &nbsp;<?= lang('artist_information'); ?></div>
                                                    <div class="panel-body" style="padding-left: 0px;padding-right: 0px;">
                                                        <style>
                                                            .input-s{
                                                                width:70%;
                                                            }
                                                        </style>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group" data-toggle="tooltip" title="<?= lang('select_artist_roles') ;?>">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-user-md"></i>
                                                                    </div>
                                                                    <select class="select2 form-control" name="artist_roles[]" multiple="multiple">
                                                                        <?php
                                                                            $artist_roles_trans_arr = array();
                                                                            if(!empty($artist_roles_trans)){
                                                                                foreach($artist_roles_trans as $record){
                                                                                    $artist_roles_trans_arr[] = $record['artist_role_id'];
                                                                                }
                                                                            }
                                                                            if(!empty($artist_roles)){
                                                                                foreach($artist_roles as $artist_role){
                                                                                    if(isset($artist_role['artist_role_id'])){
                                                                                        if(in_array($artist_role['artist_role_id'],$artist_roles_trans_arr)){
                                                                                            echo "<option value='".$artist_role['artist_role_id']."' selected>".$artist_role['artist_role']."</option>";
                                                                                        }
                                                                                        else{
                                                                                            echo "<option value='".$artist_role['artist_role_id']."'>".$artist_role['artist_role']."</option>";
                                                                                        }
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value='".$artist_role['artist_role_id']."'>".$artist_role['artist_role']."</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>                                               
                                                        </div>                                               
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group" data-toggle="tooltip" title="<?= lang('select_industries') ;?>">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-video-camera"></i>
                                                                    </div>
                                                                    <select class="select2 form-control" name="industries[]" multiple="multiple">
                                                                        <?php
                                                                            $artist_industries_trans_arr = array();
                                                                            if(!empty($artist_industries_trans)){
                                                                                foreach($artist_industries_trans as $ind){
                                                                                    $artist_industries_trans_arr[] = $ind['industry_id'];
                                                                                }
                                                                            }
                                                                            if(!empty($industries)){
                                                                                foreach($industries as $industry){                                                                                    
                                                                                    if(in_array($industry['industry_id'], $artist_industries_trans_arr)){
                                                                                        echo "<option value='".$industry['industry_id']."' selected>".$industry['industry']."</option>";
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value='".$industry['industry_id']."'>".$industry['industry']."</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>                                               
                                                        </div>                                               
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group" data-toggle="tooltip" title="<?= lang('select_awards') ;?>">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-trophy"></i>
                                                                    </div>
                                                                    <select class="select2 form-control" name="awards[]" multiple="multiple">
                                                                        <?php
                                                                            $artist_awards_trans_arr = array();
                                                                            if(!empty($artist_awards_trans)){
                                                                                foreach($artist_awards_trans as $aw){
                                                                                    $artist_awards_trans_arr[] = $aw['award_id'];
                                                                                }
                                                                            }
                                                                            if(!empty($awards)){
                                                                                foreach($awards as $award){                                                                                    
                                                                                    if(in_array($award['award_id'], $artist_awards_trans_arr)){
                                                                                        echo "<option value='".$award['award_id']."' selected>".$award['award_name']."</option>";
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value='".$award['award_id']."'>".$award['award_name']."</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>                                               
                                                        </div>                                               
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group" data-toggle="tooltip" title="<?= lang('select_educational_qualifications') ;?>">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-building-o"></i>
                                                                    </div>
                                                                    <select class="select2 form-control" name="edu_institutes[]" multiple="multiple">
                                                                        <?php
                                                                            $artist_institutes_trans_arr = array();
                                                                            if(!empty($artist_institutes_trans)){
                                                                                foreach($artist_institutes_trans as $inst){
                                                                                    $artist_institutes_trans_arr[] = $inst['institute_id'];
                                                                                }
                                                                            }
                                                                            if(!empty($edu_institutes)){
                                                                                foreach($edu_institutes as $inst){                                                                                    
                                                                                    if(in_array($inst['inst_id'], $artist_institutes_trans_arr)){
                                                                                        echo "<option value='".$inst['inst_id']."' selected>".$inst['inst_name']."</option>";
                                                                                    }
                                                                                    else{
                                                                                        echo "<option value='".$inst['inst_id']."'>".$inst['inst_name']."</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-header"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="seo_title" placeHolder="<?= lang('seo_title'); ?>" value="<?php  if(isset($artist_details[0]['seo_title'])){ echo $artist_details[0]['seo_title']; }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-keyboard-o"></i>
                                                                    </div>
                                                                    <div id="MyPillbox" class="pillbox clearfix">
                                                                        <?php
                                                                            $keywords = array();
                                                                            if(isset($artist_details[0]['seo_keywords'])){                                                                             
                                                                                $keywords = json_decode($artist_details[0]['seo_keywords']);
                                                                            }
                                                                        ?>
                                                                        <ul>
                                                                            <?php
                                                                                if(!empty($keywords)){
                                                                                    foreach ($keywords as $key){
                                                                            ?>
                                                                                    <li class="label bg-dark"><?= $key->text; ?></li>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>

                                                                            <input type="text"  placeHolder="<?= lang('add_new_keyword'); ?>">
                                                                            <input type="hidden" id="seo_keywords" name="seo_keyword">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="padding: 0px;">
                                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-header"></i>
                                                                    </div>
                                                                    <textarea class="form-control" rows="5" name="seo_desc" placeholder="<?= lang('seo_descriptions'); ?>"><?php  if(isset($artist_details[0]['seo_desc'])){ echo $artist_details[0]['seo_desc']; }?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                               
                                                </div>                                               
                                                <div class="col-md-12 no_padding">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <?= lang('artist_image'); ?>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12 no-padding" style="margin-bottom: 10px;">
                                                                <p><label for="artist_image"><?= lang('upload_artist_image'); ?></label></p>
                                                                <input type="file" id="artist_image" name="artist_image" onchange="initImage(this)" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s">
                                                            </div>
                                                            <div class="col-md-12" style="padding: 0px;margin-bottom: 10px;">                                                            
                                                                <?php
                                                                    if(isset($artist_details[0]['thumbnail'])){
                                                                        if($artist_details[0]['thumbnail']!=""){
                                                                ?>
                                                                    <a id="beforeInitImg" href="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $artist_details[0]['l_thumbnail']; ?>" data-lightbox="institute" data-title="<?php if(isset($artist_details[0]['award_name'])){ echo $artist_details[0]['award_name']; } ?>"><img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $artist_details[0]['s_thumbnail']; ?>" class="img-responsive img-rounded"/></a>
                                                                    <img src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $artist_details[0]['s_thumbnail']; ?>" id="initImg" style="display: none;" class="img-responsive img-rounded"/>
                                                                <?php
                                                                        }
                                                                        else{
                                                                ?>
                                                                    <center><img src="/public_html/images/thumbnail.png" class="img-responsive img-rounded" id="initImg" style="max-width: 100%"/></center>
                                                                <?php            
                                                                        }
                                                                    }
                                                                    else{
                                                                ?>
                                                                    <center><img src="/public_html/images/thumbnail.png" class="img-responsive img-rounded" id="initImg" style="max-width: 100%"/></center>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </form>
                                    </div>                                    
                                </div>
                            </section>
                        </section>
                        <script>                            
                            $(".artists_form").submit(function(e){
                                pills = $('#MyPillbox').pillbox('items');
                                if(pills.length>0){
                                    $("#seo_keywords").val(JSON.stringify(pills));
                                }
                                pills = $('#artistNickNames').pillbox('items');
                                if(pills.length>0){
                                    $("#artist_nick_names").val(JSON.stringify(pills));
                                }                       
                                $("#artist_desc").html($(".fr-view").html());
                                e.preventDefault();                                
                                $(".submit_btn").prop('disabled',true);
                                $(".submit_btn").html("<?= lang('please_wait'); ?>");
                                form = $('.artists_form')[0];
                                data = new FormData(form);
                                $.ajax({
                                    data: data,
                                    type: "post",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    url: "<?= site_url() ?>api/artists/save_artist_details",
                                    success: function (data) {
                                        if (data.status) {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){
                                                window.location = "<?= site_url().DASHBOARD_DIR_NAME ?>artists/view/"+data.next;
                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();                                        
                                        } else {
                                            alertify.alert("<?= lang('notifications'); ?>", data.message , function(){

                                            }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                        }
                                        $(".submit_btn").html("<?= lang('save'); ?>");
                                        $(".submit_btn").prop("disabled",false);
                                    },
                                    error:function(err){
                                        alertify.alert("<?= lang('notifications'); ?>", "<?= lang('msg_something_went_wrong'); ?>" , function(){
                                            console.log();
                                            $(".submit_btn").html("<?= lang('save'); ?>");
                                            $(".submit_btn").prop("disabled",false);
                                        }).set({'label':'<?= lang('ok'); ?>',transition:'zoom'}).show();
                                    }
                                });
                            });
                            
                            $(".artist").bind("keyup change", function(e) {
                                name = $(".artist").val();
                                name = name.toLowerCase();
                                slug = name.replace(/[^A-Z0-9]+/ig, "-");
                                $(".artist_url").val(slug);
                            });

                            $(".artist_url").bind("keyup change", function(e) {
                                $(this).val($(this).val().replace(/[^a-z0-9]/gi, '-'));
                            });   
                            
                            $(function () {
                                $(".artist").focus();
                                
                                $('#edit').froalaEditor({
                                    placeholderText: "<?= lang('write_artist_description_here'); ?>",

                                    // Set the file upload URL.
                                    type: "post",
                                    imageUploadURL: "<?= site_url() ?>api/files/upload_image",
                                    imageUploadParams: {
                                        id: 'my_editor'
                                    },
                                    imageDefaultWidth: 0,
                                    // Set the file upload URL.
                                    type: "post",
                                    fileUploadURL:  "<?= site_url() ?>api/files/upload_file",
                                    fileUploadParams: {
                                        id: 'my_editor'
                                    },
                                    // Set the video upload URL.
                                    type: "post",
                                    videoUploadURL: "<?= site_url() ?>api/files/upload_video",
                                    videoUploadParams: {
                                        id: 'my_editor'
                                    },
                                });
                                $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').html("<?= lang('write_artist_description_here'); ?>");
                                $('.fr-wrapper a[href^="https://www.froala.com/wysiwyg-editor?k=u"]').click(function(e){
                                    e.preventDefault();
                                });
                            });
                            function initImage(input){
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        $('#initImg').attr('src', e.target.result)
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                    $("#beforeInitImg").css('display','none');
                                    $("#initImg").css('display','block');
                                }
                            }
                        </script>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
