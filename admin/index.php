<?php
$realpath = realpath(dirname(__FILE__));
require_once($realpath . "/../db/db_connection.php");
require_once($realpath . "/../helper/helpers.php");
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <title>Login - Admin</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>Admin Login</h1>
    </div>
    <?php
    $error = [];
    $data  = [];

    if (isset($_POST['login'])) {

      $email  = inputValidation($_POST['email']);
      $password = $_POST['password'];

      // email validation
      if (empty($email)) {
        $error['email'] = "Email is required";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format";
      } else {
        $data['email'] = $email;
      }
      // password validation
      if (empty($password)) {
        $error['password'] = "Password is required";
      } else {
        $data['password'] = $password;
      }

      if (empty($error)) {

        try {
          $sql = "SELECT * FROM users WHERE email = :email AND type = 'admin'";
          if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);

            if ($stmt->execute()) {
              $user = $stmt->fetch();
              if ($user != null) {
                if (password_verify($data['password'], $user['password'])) {

                  $_SESSION['username'] = $user['name'];
                  $_SESSION['is_admin'] = true;

                  header("Location: dashboard.php");
                } else {
                  $error['password'] = "Password is incorrect";
                }
              } else {
                $error['email'] = "Email not found";
              }
            }
          }
        } catch (\PDOException $e) {
          echo $e->getMessage();
        }
      }
    };
    ?>

    <div class="login-box">
      <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" type="text" value="admin@gmail.com" placeholder="Email" autofocus>
          <span class="text-danger"><?php echo $error['email'] ?? ''; ?></span>
        </div>
        <div class="mb-3">
          <label class="form-label">PASSWORD</label>
          <input class="form-control" name="password" type="password" value="123456" placeholder="Password">
          <span class="text-danger"><?php echo $error['password'] ?? ''; ?></span>
        </div>
        <div class="mb-3">
          <div class="utility">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"><span class="label-text">Stay Signed in</span>
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
          </div>
        </div>
        <div class="mb-3 btn-container d-grid">
          <button type="submit" name="login" class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN</button>
        </div>
      </form>

      <!-- Forgot Password Form -->
      <form class="forget-form" action="index.html">
        <h3 class="login-head"><i class="bi bi-person-lock me-2"></i>Forgot Password ?</h3>
        <div class="mb-3">
          <label class="form-label">EMAIL</label>
          <input class="form-control" type="text" placeholder="Email">
        </div>
        <div class="mb-3 btn-container d-grid">
          <button class="btn btn-primary btn-block"><i class="bi bi-unlock me-2 fs-5"></i>RESET</button>
        </div>
        <div class="mb-3 mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="bi bi-chevron-left me-1"></i> Back to Login</a></p>
        </div>
      </form>

    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
      $('.login-box').toggleClass('flipped');
      return false;
    });
  </script>
</body>

</html>