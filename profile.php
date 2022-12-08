<?php
include_once("db.php");
// Check If Here Cookies ?
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: Login.php");
  exit();
} else {
  $email = $_SESSION['user']['email'];
  $username = $_SESSION['user']['name'];
  $data_account = $_SESSION['user']['data_account'];
}

// Send Message To DataBase
if (isset($_POST['send_message'])) {
  $title = filter_var($_POST['title_mess'], FILTER_SANITIZE_STRING);
  $mess = filter_var($_POST['mess'], FILTER_SANITIZE_STRING);
  $message = ("Title Message: " . $title . "\n" . "Message:" . "\n" . $mess);

  date_default_timezone_set("Africa/Cairo");
  $time_send = date("Y-m-d H-i-s");

  $stm = "INSERT INTO message (id, email, username, Message, time_send) VALUES ('NULL', '$email', '$username', '$message', '$time_send')";
  $res = mysqli_query($db, $stm);
  echo "Good";
}

// If I Click Here LogOut Account...
if (isset($_POST['log_out'])) {
  session_unset();
  header("Location: Login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="css/profile.css">
</head>

<body>
  <div class="box">
    <div class="info_account">
      <p>Hello: <?php echo $username; ?></p>
      <p>Your Email: <?php echo $email; ?></p>
      <p>Your Data Make This Account: <?php echo $data_account; ?></p>

    </div>
    <div class="message">
      <div class="show_message">Do You Want Send Me Message?</div>
      <form action="" method="POST">
        <input type="text" name="title_mess" placeholder="Write Title Message">
        <textarea name="mess" placeholder="Your Message"></textarea>
        <input type="submit" value="Send Message" name="send_message">
      </form>
    </div>
    <form method="post">
      <input type="submit" name="log_out" value="Logout" class="logout" />
    </form>
  </div>
  <script>
    let show_form = document.getElementsByClassName("show_message")[0];
    let form = document.querySelectorAll("form")[0];
    let status = false;
    show_form.onclick = function() {
      if (status === false) {
        form.style = `display:flex;`;
        status = true;
      } else if (status === true) {
        form.style = `display:none;`;
        status = false;
      }
    }
  </script>
</body>

</html>