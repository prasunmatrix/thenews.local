<?php
echo "Import finished";exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo "xxx";exit;
//$conn = mysqli_connect("pratibadikalam.c3nymi5miohr.ap-south-1.rds.amazonaws.com","pb24newsadmin","gxF6LjzWqd3OBh7UN9dC","pbdb") or die("Not connected");

/*$q = "SELECT * FROM users WHERE user_id>9";
$r =  mysqli_query($conn, $q);
if(mysqli_num_rows($r)){
	while($user = mysqli_fetch_assoc($r)){
		$up_q = "UPDATE users SET rand_id='". generateRandomString(8) ."' WHERE user_id=" . $user['user_id'];
mysqli_query($conn, $up_q);*/
//		echo $up_q;
//echo "<br>";



/*function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}*/

require 'vendor/autoload.php';
$inputFileType = 'csv';
$inputFileName = 'impo_1_1.xlsx';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$spreadsheet = $spreadsheet->getActiveSheet()->toArray();

//echo "<pre>";
//print_r($spreadsheet);
//exit;

/*function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
   $string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.
}*/

//$conn = mysqli_connect("localhost","root","m.VR1234","thenews") or die("Not connected");
$conn = mysqli_connect("pratibadikalam.c3nymi5miohr.ap-south-1.rds.amazonaws.com","pb24newsadmin","gxF6LjzWqd3OBh7UN9dC","pbdb") or die("Not connected");

$i = 0;
$rec = 0;
foreach($spreadsheet as $record){
	$rec++;
    if($i==0){
        $i++;
    }
    else{
        if($record[3]!="failed"){
            $payment_id = $record[0];
            $amount = $record[1];
            $email = $record[18];
            $mobile = $record[19];
            $created_at = $record[25];
            
            if($amount=="48.00"){
                $sub_plan_id = 1;
                $sub_end_date = date('Y-m-d', strtotime("+30 day"));
            }
            else{
                $sub_plan_id = 4;
                $sub_end_date = date('Y-m-d', strtotime("+365 day"));
            }
            
            
            $check_q = "SELECT * FROM users WHERE email='" . $email . "'";
            $check_res = mysqli_query($conn, $check_q);
            if(mysqli_num_rows($check_res)>0){
                //update
                $users = array();
                while($u = mysqli_fetch_assoc($check_res)){
                    $users[] = $u;
                }
                
                $op_q = "UPDATE users set email='". $email ."', phone='" . $mobile . "', subscribed_plan_id='" . $sub_plan_id . "', subscription_end_date='" . $sub_end_date . "', subscription_payment_id='Imported (" . $payment_id .")', date_created='".time()."' WHERE user_id=" . $users[0]['user_id'];
                echo $op_q;
                echo "<br>";
            }
            else{
                //insert
                $op_q = "INSERT INTO users set rand_id='" . generateRandomString(8) . "',user_role_id=2, password='$2y$10$2GhDJhUKW2pDhXeO4/5AZOC8YbsJuGB7WUh/Cg0SzrOEUAdbkE0x6', email='". $email ."', phone='" . $mobile . "', subscribed_plan_id='" . $sub_plan_id . "', subscription_end_date='" . $sub_end_date . "', subscription_payment_id='Imported (" . $payment_id .")', date_created='".time()."'";
                echo $rec . ". " . $op_q;
                echo "<br>";
            }
            mysqli_query($conn, $op_q);
        }
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
