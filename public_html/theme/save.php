<?php
    $conn = mysqli_connect('localhost','root','123456','test');
    $qry = "update test set data='".addslashes($_REQUEST['data'])."' where id='1'";
    $res = mysqli_query($conn,$qry);
    if($res){
        $return = array('status'=>true,'message'=>"Successfully updated");
    }
    else{
        
        $return = array('status'=>false,'message'=>"Error description: " . mysqli_error($conn));
    }
    echo json_encode($return);
?>