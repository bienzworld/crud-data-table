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
		$images = $_POST['images'];
		$sql = "INSERT INTO items (item_name, own_price, comp_price1, comp_price2, comp_price3, comp_price4, images) VALUES ('$item_name', '$own_price', '$comp_price1', '$comp_price2', '$comp_price3', '$comp_price4', '$images')";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Items added successfully';
		}
		else{
			$_SESSION['error'] = 'Something went wrong while adding items';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: index.php');
?>