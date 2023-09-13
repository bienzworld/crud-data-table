<?php
	session_start();
	include_once('connection.php');

	if(isset($_GET['item_id'])){
		$sql = "DELETE FROM items WHERE item_id = '".$_GET['item_id']."'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Item deleted successfully';
		}
		////////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member deleted successfully';
		// }
		/////////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in deleting item';
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: index.php');
?>