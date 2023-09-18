<?php
session_start();
include_once('connection.php');

if(isset($_GET['item_id'])){
    // Fetch the filename of the image associated with the item
    $sql = "SELECT images FROM items WHERE item_id = '".$_GET['item_id']."'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $images = $row['images'];

        // Delete the record from the database
        $deleteSQL = "DELETE FROM items WHERE item_id = '".$_GET['item_id']."'";
        if($conn->query($deleteSQL)){
            // Delete the image file from the uploads folder
            $imagePath = $images;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $_SESSION['success'] = 'Item deleted successfully';
        }
        else{
            $_SESSION['error'] = 'Something went wrong in deleting item';
        }
    } else {
        $_SESSION['error'] = 'Item not found';
    }
}
else{
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: index.php');
?>
