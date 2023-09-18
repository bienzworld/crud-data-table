<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <?php 
             
              include_once("php/connection.php");
              if(isset($_POST['submit'])){
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];

                $sql = "SELECT * FROM users WHERE user_name='$user_name' AND password='$password'";
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if(is_array($row) && !empty($row)){
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['user_type'] = $row['user_type'];
                        $_SESSION['user_id'] = $row['user_id'];
                    } else {
                        echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                         </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button>";
                    }
                } else {
                    echo "<div class='message'>
                    <p>Wrong Username or Password</p>
                     </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button>";
                }
                if (isset($_SESSION['user_name']) && $_SESSION['user_type']  == 1) {
                    header("Location: admin_view.php");
                } else {
                    header("Location: user_view.php");
                }                
              }else{
            
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="user_name">Username</label>
                    <input type="text" name="user_name" id="user_name" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>