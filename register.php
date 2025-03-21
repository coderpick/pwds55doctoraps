<?php
include "layout/head.php";
?>

<?php
include "layout/navbar.php";
?>

<?php
$error = [];
$data = [];
if (isset($_POST['register'])) {
    $name   = inputValidation($_POST['name']);
    $email  = inputValidation($_POST['email']);
    $password = $_POST['password'];

    // name validation
    if (empty($name)) {
        $error['name'] = "Name is required";
    } else {
        $data['name'] = $name;
    }
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
    } elseif (strlen($password) < 6) {
        $error['password'] = "Password must be at least 6 characters";
    } else {
        $data['password'] = $password;
    }

    if (empty($error)) {
        try {
            /* input password hashed */
            $hasPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $userType = 'patient';
            $sql = "INSERT INTO users (name, email, password,type) VALUES (:name, :email, :password,:type)";

            if ($stmt = $conn->prepare($sql)) {

                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $hasPassword, PDO::PARAM_STR);
                $stmt->bindParam(':type',  $userType, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Registration successful";
                    header("Location: login.php");
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
        <div class="col-md-6">
            <!-- login form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Registration</h5>
                </div>
                <div class="card-body">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $data['name'] ?? ''; ?>">
                            <span class="text-danger"><?php echo $error['name'] ?? ''; ?></span>
                        </div>

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

                            <a href="login.php">You have an account? login</a>
                            <div class="">
                                <button type="submit" name="register" class="btn btn-primary">Registration</button>
                            </div>
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