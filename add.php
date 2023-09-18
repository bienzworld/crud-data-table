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

    // Handle image upload
    $targetDirectory = "uploads/"; 
	if (!file_exists($targetDirectory)) {
		mkdir($targetDirectory, 0777, true);
	}
    $dateFormat = "YmdHis"; 
    $currentDate = date($dateFormat);
    $targetFile = $targetDirectory . $currentDate . "_" . basename($_FILES['images']['name']);
    
    // Check if the file is an actual image
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    
    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES['images']['tmp_name'], $targetFile)) {
            // Image uploaded successfully, now insert into the database
            $sql = "INSERT INTO items (item_name, own_price, comp_price1, comp_price2, comp_price3, comp_price4, images) 
                    VALUES ('$item_name', '$own_price', '$comp_price1', '$comp_price2', '$comp_price3', '$comp_price4', '$targetFile')";
            
            if($conn->query($sql)){
                $_SESSION['success'] = 'Item added successfully';
            }
            else{
                $_SESSION['error'] = 'Something went wrong while adding the item';
            }
        } else {
            $_SESSION['error'] = 'Failed to upload image';
        }
    } else {
		echo in_array($imageFileType, $allowedExtensions);
        $_SESSION['error'] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF';
    }
} else {
    $_SESSION['error'] = 'Fill up the add form first';
}

header('location: index.php');
?>
