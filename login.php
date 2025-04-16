<?php
include "layout/head.php";
?>

<?php
include "layout/navbar.php";
?>

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
            $sql = "SELECT * FROM users WHERE email = :email AND type = 'patient'";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $user = $stmt->fetch();
                    if ($user != null) {
                        if (password_verify($data['password'], $user['password'])) {

                            $_SESSION['username'] = $user['name'];
                            $_SESSION['is_login'] = true;

                            header("Location: index.php");
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
<!-- main content area start -->
<div class="container my-5">
    <div class="row justify-content-center">
        <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        unset($_SESSION['success']);

        ?>
        <div class="col-md-6">
            <!-- login form -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="<?php $data['email'] ?? ''; ?>">
                            <span class="text-danger"><?php echo $error['email'] ?? ''; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                            <span class="text-danger"><?php echo $error['password'] ?? ''; ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="#">Forgot Password?</a>
                            <a href="register.php">Don't have an account?</a>

                        </div>
                        <div class="text-center my-3">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content area end -->
<!-- footer -->
<?php
include "layout/footer.php";
?>