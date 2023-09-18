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
	
    	// Handle image upload
    	$targetDirectory = "uploads/"; 
		if (!file_exists($targetDirectory)) {
			mkdir($targetDirectory, 0777, true);
		}
    	$dateFormat = "YmdHis"; 
    	$currentDate = date($dateFormat);
    	$targetFile = $targetDirectory . $currentDate . "_" . $_FILES['images']['name']; // Use $_FILES to access the uploaded file information

		// Check if the file was successfully uploaded
		if (move_uploaded_file($_FILES['images']['tmp_name'], $targetFile)) {
			// The file was successfully moved, now you can include it in the SQL query
			$imageUpdate = ", images = '$targetFile'";

			$sql = "SELECT images FROM items WHERE item_id = '$item_id'";
			$result = $conn->query($sql);
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$images = $row['images'];
				$imagePath = $images;
				if (file_exists($imagePath)) {
					unlink($imagePath);
				}
			}
		} else {
			// Handle the case where the file upload failed
			$imageUpdate = ""; // Do not include images in the query
			$_SESSION['error'] = 'Failed to upload image.';
		}

		$sql = "UPDATE items SET item_name = '$item_name', own_price = '$own_price', comp_price1 = '$comp_price1', comp_price2 = '$comp_price2',comp_price3 = '$comp_price3',comp_price4 = '$comp_price4' $imageUpdate WHERE item_id = '$item_id'";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Item updated successfully';
		}
		else{
			$_SESSION['error'] = 'Something went wrong in updating items';
		}
	}
	else{
		$_SESSION['error'] = 'Select item to edit first';
	}

	header('location: index.php');
?>
