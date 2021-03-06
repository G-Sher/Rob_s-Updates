<?php

//Functions
require_once('scFunctions.php');
require 'scDB.php';

function submitForm()
{

	if(isset($_POST['submit']))
	{
	
		notify('Hello I am '.$_POST['name'], 'positive');
	
	}

}

function notify($message, $karma = 2)
{
	
	//Function used to create a notification that lasts for one page refresh
	if($karma == 1)
	{
		
		$class = "positive-notification";
		
	}
	elseif($karma == 0)
	{
		
		$class = "negative-notification";
		
	}
	elseif($karma == 2)
	{
		
		$class = "neutral-notification";
		
	}
	
	$notification = array('message' => $message, 'class' => $class);
	
	$_SESSION['notification'] = serialize($notification);
	
}

function notification()
{
	
	//Prints the notification set with notify() then deletes it from session
	if(isset($_SESSION['notification']))
	{
		
		$notification = unserialize($_SESSION['notification']);
		extract($notification);
		
		$notification = '<div class="notify '.$class.'">'.$message.'</div>';
		
		echo $notification;
		
		unset($_SESSION['notification']);
		
	}
		
}

function getUsers()
{

	$db = new Connection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$result = $db->query('SELECT name FROM users');
	
	while($row = mysql_fetch_assoc($result))
	{
	
		echo $row['name'].'<br>';
	
	}

}

function check_txnid($tnxid){
    
    return true;
//    $valid_txnid = true;
    //get result set
//    $sql = mysqi_query($mysqli,"SELECT * FROM `payments` WHERE txnid = '$tnxid'");
//   if ($row = mysqli_fetch_array($sql)) {
//        $valid_txnid = false;
//    }
//    return $valid_txnid;
}

function check_price($price, $id){
    $valid_price = false;
    //you could use the below to check whether the correct price has been paid for the product

    /*
    $sql = mysqli_query("SELECT amount FROM `products` WHERE id = '$id'");
    if (mysqli_num_rows($sql) != 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $num = (float)$row['amount'];
            if($num == $price){
                $valid_price = true;
            }
        }
    }
    return $valid_price;
    */
    return true;
}

function updatePayments($data){
	require 'scDB.php';

    if (is_array($data)) {
        $sql = mysqli_query($mysqli, "INSERT INTO payments (txnid, payment_amount, payment_status, itemid, createdtime) VALUES ('$data[txn_id]' ,'$data[payment_amount]' ,'$data[payment_status]' ,'$data[item_number]', 0)");
        return mysqli_insert_id($mysqli);
    }
}
?>