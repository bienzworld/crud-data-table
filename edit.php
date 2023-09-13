<?php
	session_start();
	include_once('connection.php');

	if(isset($_POST['edit'])){
		$item_id = $_POST['item_id'];
		$item_name = $_POST['item_name'];
		$own_price = $_POST['own_price'];
		$comp_price1 = $_POST['comp_price1'];
		$comp_price2 = $_POST['comp_price2'];
		$comp_price3 = $_POST['comp_price3'];
		$comp_price4 = $_POST['comp_price4'];
		$sql = "UPDATE items SET item_name = '$item_name', own_price = '$own_price', comp_price1 = '$comp_price1', comp_price2 = '$comp_price2',comp_price3 = '$comp_price3',comp_price4 = '$comp_price4' WHERE item_id = '$item_id'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Item updated successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member updated successfully';
		// }
		///////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in updating items';
		}
	}
	else{
		$_SESSION['error'] = 'Select item to edit first';
	}

	header('location: index.php');

?>