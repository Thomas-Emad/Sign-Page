<?php
/* 2022-8-12 */
session_start();
if (isset($_SESSION['user'])) {
  header("Location: profile.php");
  exit();
}

if (isset($_POST['submit'])) {
  include_once('db.php');

  $email = $_POST['email'];
  $password = $_POST['password'];

  $errors = [];

  if (empty($email)) {
    $errors[] = "You Need Write Email";
  }

  if (empty($errors)) {
    $stm = "SELECT * FROM usertable WHERE email ='$email' AND password='$password'";
    $res = mysqli_query($db, $stm);
    $row = mysqli_fetch_assoc($res);

    if (isset($row)) {
      if ($row['email'] === $email && $row['password'] === $password) {
        $_SESSION['user'] = [
          'name' => $row['username'],
          'email' => $email,
          'image' => $row['image'],
          'data_account' => $row['data_account']
        ];
        header("Location: profile.php");
        exit();
      }
    } else {
      $errors[] = "Failed In Login";
    }
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <div class="parent">
    <form action="" method="POST">
      <h2 class="title">Login</h2>
      <input type="email" name="email" placeholder="Your Email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
      <input type="password" name="password" placeholder="Your Password">
      <input type="submit" name="submit" value="Send">
      <a href="register.php" class="trans_page">New Account</a>
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