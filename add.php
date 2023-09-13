<?php
	session_start();
	include_once('connection.php');

	if(isset($_POST['add'])){
		$item_name = $_POST['item_name'];
		$own_price = $_POST['own_price'];
		$comp_price1 = $_POST['comp_price1'];
		$comp_price2 = $_POST['comp_price2'];
		$comp_price3 = $_POST['comp_price3'];
		$comp_price4 = $_POST['comp_price4'];
		$sql = "INSERT INTO items (item_name, own_price, comp_price1, comp_price2, comp_price3, comp_price4) VALUES ('$item_name', '$own_price', '$comp_price1', '$comp_price2', '$comp_price3', '$comp_price4')";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Items added successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member added successfully';
		// }
		//////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong while adding items';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: index.php');
?>