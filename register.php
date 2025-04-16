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
    $name             = inputValidation($_POST['name']);
    $email            = inputValidation($_POST['email']);
    $phone            = inputValidation($_POST['phone']);
    $dob              = inputValidation($_POST['dob']);
    $gender           = @$_POST['gender'];
    $marital_status   = @$_POST['marital_status'];
    $address          = inputValidation($_POST['address']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

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
    // phone validation
    if (empty($phone)) {
        $error['phone'] = "Phone is required";
    } else {
        $data['phone'] = $phone;
    }
    //dob validation
    if (empty($dob)) {
        $error['dob'] = "Date of birth is required";
    } else {
        $dateCreate = date('Y-m-d', strtotime($dob));
        $data['dob'] =  $dateCreate;
    }
    //gender validation
    if (empty($gender)) {
        $error['gender'] = "Gender is required";
    } else {
        $data['gender'] = $gender;
    }
    //address validation
    if (empty($address)) {
        $error['address'] = "Address is required";
    } else {
        $data['address'] = $address;
    }
    //marital status validation
    if (empty($marital_status)) {
        $error['marital_status'] = "Marital status is required";
    } else {
        $data['marital_status'] = $marital_status;
    }
    // password validation
    if (empty($password)) {
        $error['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $error['password'] = "Password must be at least 6 characters";
    } else {
        $data['password'] = $password;
    }

    // confirm password validation
    if (empty($confirm_password)) {
        $error['confirm_password'] = "Confirm password is required";
    } elseif ($password !== $confirm_password) {
        $error['confirm_password'] = "Password and confirm password do not match";
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
                $stmt->execute();
                $last_id = $conn->lastInsertId();
                /* insert patient */
                $insert = "INSERT INTO patients (user_id,name,phone, address, gender, dob, marital_status, created_at) VALUES (:user_id,:name, :phone, :address, :gender, :dob, :marital_status,:created_at)";
                if ($stmt = $conn->prepare($insert)) {
                    $stmt->bindParam(':user_id', $last_id, PDO::PARAM_INT);
                    $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
                    $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                    $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
                    $stmt->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
                    $stmt->bindParam(':dob', $data['dob'], PDO::PARAM_STR);
                    $stmt->bindParam(':marital_status', $data['marital_status'], PDO::PARAM_STR);
                    $stmt->bindParam(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->execute();
                    $_SESSION['success'] = "Patient registered successfully";
                    header("location:login.php");
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
        <div class="col-md-8">
            <!-- login form -->
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Patient Registration</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $data['name'] ?? ''; ?>">
                                    <span class="text-danger"><?php echo $error['name'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" name="phone" class="form-control" id="phone" value="<?php $data['phone'] ?? ''; ?>">
                                    <span class="text-danger"><?php echo $error['phone'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label d-block">Gender :</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="Other">
                                        <label class="form-check-label" for="inlineRadio3">Other</label>
                                    </div>
                                    <span class="text-danger d-block"><?php echo $error['gender'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control" rows="4"><?php $data['address'] ?? ''; ?></textarea>
                                    <span class="text-danger"><?php echo $error['address'] ?? ''; ?></span>
                                </div>
                            </div><!-- end col-6 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="<?php $data['email'] ?? ''; ?>">
                                    <span class="text-danger"><?php echo $error['email'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" id="dob" value="<?php $data['dob'] ?? ''; ?>">
                                    <span class="text-danger"><?php echo $error['dob'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="marital_status" class="form-label">Marital Status: &nbsp</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="marital_status" id="Single" value="Single">
                                        <label class="form-check-label" for="Single">Single</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="marital_status" id="Married" value="Married">
                                        <label class="form-check-label" for="Married">Married</label>
                                    </div>
                                    <span class="text-danger d-block"><?php echo $error['marital_status'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                    <span class="text-danger"><?php echo $error['password'] ?? ''; ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                                    <span class="text-danger"><?php echo $error['confirm_password'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div><!-- end row -->
                        <div class="text-center mt-4">
                            <button type="submit" name="register" class="btn btn-primary">Registration</button>
                        </div>
                        <div class="text-end">
                            <a href="login.php">You have an account? login</a>
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