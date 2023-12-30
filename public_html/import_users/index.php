<?php
echo "Import finished";exit;
$conn = mysqli_connect("pratibadikalam.c3nymi5miohr.ap-south-1.rds.amazonaws.com","pb24newsadmin","gxF6LjzWqd3OBh7UN9dC","pbdb") or die("Not connected");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
$inputFileType = 'csv';
$inputFileName = 'impo_1_2.xlsx';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$spreadsheet = $spreadsheet->getActiveSheet()->toArray();

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
   $string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.
}

//$conn = mysqli_connect("localhost","root","m.VR1234","thenews") or die("Not connected");


$i = 0;
foreach($spreadsheet as $record){
    if($i==0){
        $i++;
    }
    else{
        $i++;
        
        if($record[3]!="failed"){
            $payment_id = $record[0];
            $amount = $record[1];
            $email = $record[18];
            $mobile = $record[19];
            $created_at = $record[25];
            $created_at = date("Y-m-d", strtotime($created_at));
            
            if($amount=="48.00"){
                $sub_plan_id = 1;
                $sub_end_date = date('Y-m-d', strtotime("+30 day"));
            }
            else{
                $sub_plan_id = 4;
                $sub_end_date = date('Y-m-d', strtotime("+365 day"));
            }
            
            
            $check_q = "SELECT * FROM users WHERE email='" . $email . "'";
            $check_res = mysqli_query($conn, $check_q) or die(mysqli_error($conn));
            if(mysqli_num_rows($check_res)>0){
                //update
                $users = array();
                while($u = mysqli_fetch_assoc($check_res)){
                    $users[] = $u;
                }
                
                if($users[0]['subscription_end_date']<$sub_end_date){
                        echo "Old subscription date : " . $users[0]['subscription_end_date'] . " => " . "New subscription date: " . $sub_end_date;
                        echo "<br>";
                	$op_q = "UPDATE users set email='". $email ."', phone='" . $mobile . "', subscribed_plan_id='" . $sub_plan_id . "', subscription_end_date='" . $sub_end_date . "', subscription_payment_id='Imported (" . $payment_id .")', date_created='".time()."' WHERE user_id=" . $users[0]['user_id'];
	                echo $i . " => " . $op_q;
	                echo "<br>";
	                echo "<br>";
                }

            }
            else{
                //insert
                $op_q = "INSERT INTO users set rand_id='" . generateRandomString(8) . "', email='". $email ."', phone='" . $mobile . "', subscribed_plan_id='" . $sub_plan_id . "', subscription_end_date='" . $sub_end_date . "', subscription_payment_id='Imported (" . $payment_id .")', date_created='".time()."'";
                echo $i . " => " . $op_q;
                echo "<br>";
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

