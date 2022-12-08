<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: profile.php");
  exit();
}

if (isset($_POST['submit'])) {
  include_once('db.php');

  $username = $_POST['name'];
  $email = $_POST['email'];
  $img_profile = $_POST['img_profile'];
  $password = $_POST['password'];
  $data_account = $_POST['data_account'];

  $errors = [];

  if (strlen($username) < 3) {
    $errors[] = "You Need Write > 3 Char In Username";
  }
  if (empty($email)) {
    $errors[] = "You Need Write Email";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "You Need Write Good Email";
  }
  if (strlen($password) < 6) {
    $errors[] = "You Need Write Password >= 6 chars";
  } elseif (strlen($password) > 12) {
    $errors[] = "You Need Write Password <= 12 chars";
  }


  if (empty($errors)) {
    $stm = "SELECT * FROM usertable WHERE email ='$email'";
    $res = mysqli_query($db, $stm);
    $rows = mysqli_num_rows($res);
    if ($rows === 1) {
      $errors[] = "You Need Write Other Email";
    } else {
      $_SESSION['user'] = [
        'name' => $username,
        'email' => $email,
        'image' => $img_profile
      ];
      $stm = "INSERT INTO usertable (id, image, username, email, password, data_account) VALUES ('NULL', '$img_profile', '$username', '$email', '$password', '$data_account')";
      $res = mysqli_query($db, $stm);
      header("Location: profile.php");
      exit();
    }
  }
}

if (isset($_SESSION['user'])) {
  header("Location: profile.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Account</title>
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <div class="parent">
    <form action="" method="POST">
      <h2 class="title">New Account</h2>
      <input type="text" name="name" placeholder="User Name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>">
      <input type="text" name="email" placeholder="Your Email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
      <input type="password" name="password" placeholder="Your Password">
      <input type="file" name="img_profile">
      <input type="hidden" name="data_account" value="<?php date_default_timezone_set("Africa/Cairo");
                                                      echo date("Y-m-d H:i:s"); ?>">
      <input type="submit" name="submit" value="Send">
      <a href="Login.php" class="trans_page">Login</a>
    </form>
    <?php
    if (isset($errors)) {
      foreach ($errors as $err) {
        echo "<p class='error'>" . $err . "</p>";
      }
    }
    ?>
  </div>

</body>

</html>