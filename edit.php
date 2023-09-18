<?php
session_start();
include("php/connection.php");
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
}

if (isset($_POST['edit'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $own_price = $_POST['own_price'];
    $comp_price1 = $_POST['comp_price1'];
    $comp_price2 = $_POST['comp_price2'];
    $comp_price3 = $_POST['comp_price3'];
    $comp_price4 = $_POST['comp_price4'];

    // Initialize image update variable
    $imageUpdate = "";

    // Check if a new image was uploaded
    if ($_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/";

        // Ensure the directory exists
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $dateFormat = "YmdHis";
        $currentDate = date($dateFormat);
        $targetFile = $targetDirectory . $currentDate . "_" . $_FILES['images']['name'];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['images']['tmp_name'], $targetFile)) {
            // File upload successful, update the image path in the database
            $imageUpdate = ", images = '$targetFile'";
        } else {
            // Handle the case where the file upload failed
            $_SESSION['error'] = 'Failed to upload image.';
            header('Location: index.php');
            exit;
        }
    }

    // Get the current image path to delete the old image
    $sql = "SELECT images FROM items WHERE item_id = '$item_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $imagePath = $row['images'];

        // Check if the image file exists before deleting
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the old image file
        }
    }

    // Update the item in the database with or without the new image path
    $sql = "UPDATE items SET 
            item_name = '$item_name', 
            own_price = '$own_price', 
            comp_price1 = '$comp_price1', 
            comp_price2 = '$comp_price2',
            comp_price3 = '$comp_price3',
            comp_price4 = '$comp_price4' $imageUpdate
            WHERE item_id = '$item_id'";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Item updated successfully';
		header('Location: admin_view.php'); 
        exit;
    } else {
        $_SESSION['error'] = 'Something went wrong in updating items';
		header('Location: admin_view.php'); 
        exit;
    }
} else {
    $_SESSION['error'] = 'Select item to edit first';
	header('Location: admin_view.php'); 
	exit;
}

header('Location: index.php');
exit;
?>
