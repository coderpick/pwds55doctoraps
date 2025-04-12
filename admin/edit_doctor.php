<?php
$pageTitle = 'Add Doctor';
include_once('layout/head.php');
?>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <?php
    include_once('layout/header.php');
    ?>
    <!-- Sidebar menu-->
    <?php
    include_once('layout/sidebar.php');
    ?>


    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Doctors</h1>
                <p>Doctor create,edit and delete</p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active"><a href="#">Doctor Registration</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="tile-title mb-0">Doctor Registration</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-warning" href="doctor.php">Back to Doctor</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        $data = [];
                        $error = [];
                        if (isset($_POST['submit'])) {
                            $name  = inputValidation($_POST['name']);
                            $phone = inputValidation($_POST['phone']);
                            $gender = @$_POST['gender'];
                            $dob    = $_POST['dob'];
                            $expert_in = $_POST['expert_in'];
                            $degree = $_POST['degree'];
                            $address = $_POST['address'];

                            $id = inputValidation($_POST['id']);
                            $user_id = inputValidation($_POST['user_id']);
                            $oldImage = $_POST['odlImage'];

                            $fileName    = $_FILES['image']['name'];
                            $fileTmpName = $_FILES['image']['tmp_name'];
                            $fileSize    = $_FILES['image']['size'];

                            if ($fileName) {
                                // Image validation
                                $allowItems = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                                $file_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                $fileUniqueName = time() . uniqid() . '.' . $file_ext;
                                $uploadDirPath = 'uploads/' . $fileUniqueName;
                                if (empty($fileName)) {
                                    $errors['image'] = "Image is required";
                                } elseif ($fileSize > 1048576) {
                                    // 1048576 =1mb ( 1024*1024)
                                    $errors['image'] = "Image size must be less then 1mb";
                                } elseif (!in_array($file_ext, $allowItems)) {
                                    $errors['image'] = "You can upload only:" . implode(',', $allowItems);
                                } else {
                                    unlink($oldImage);
                                    $data['image'] =  $uploadDirPath;
                                    move_uploaded_file($fileTmpName, $uploadDirPath);
                                }
                            } else {
                                $data['image'] = $oldImage;
                            }

                            // Validate name
                            if (empty($name)) {
                                $error['name'] = "Name is required";
                            } elseif (strlen($name) < 4) {
                                $error['name'] = "Name must be at least 4 characters";
                            } elseif (!preg_match('/[^a-zA-Z]/', $name)) {
                                $error['name'] = "Name must be only characters";
                            } else {
                                $data['name'] = $name;
                            }
                            //validate phone
                            if (empty($phone)) {
                                $error['phone'] = "Phone is required";
                            } elseif (!preg_match('/^\d{11}$/', $phone)) {
                                $error['phone'] = "Invalid phone number format";
                            } else {
                                $data['phone'] = $phone;
                            }

                            //gender validation
                            if (empty($gender)) {
                                $error['gender'] = "Gender is required";
                            } else {
                                $data['gender'] = $gender;
                            }
                            //dob validation
                            if (empty($dob)) {
                                $error['dob'] = "Date of Birth is required";
                            } else {
                                $data['dob'] = $dob;
                            }
                            //expert_in validation
                            if (empty($expert_in)) {
                                $error['expert_in'] = "Expert in is required";
                            } else {
                                $data['expert_in'] = $expert_in;
                            }
                            //degree validation
                            if (empty($degree)) {
                                $error['degree'] = "Degree is required";
                            } else {
                                $data['degree'] = $degree;
                            }
                            //address validation
                            if (empty($address)) {
                                $error['address'] = "Address is required";
                            } else {
                                $data['address'] = $address;
                            }

                            if (empty($error)) {
                                try {
                                    /* update user table */
                                    $sql = "UPDATE users SET name=:name WHERE id=:id";
                                    if ($stmt = $conn->prepare($sql)) {
                                        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                                        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                                        $stmt->execute();
                                    }
                                    /* update doctor */
                                    $sql = "UPDATE doctors SET name=:name, phone=:phone, image=:image, address=:address, dob=:dob, expert_in=:expert_in, degree=:degree, gender=:gender WHERE id=:id";

                                    if ($stmt = $conn->prepare($sql)) {
                                        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                                        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
                                        $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
                                        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
                                        $stmt->bindParam(':dob', $data['dob'], PDO::PARAM_STR);
                                        $stmt->bindParam(':expert_in', $data['expert_in'], PDO::PARAM_STR);
                                        $stmt->bindParam(':degree', $data['degree'], PDO::PARAM_STR);
                                        $stmt->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
                                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $_SESSION['success'] = "Doctor update successfully";
                                        // header("location:doctor.php");
                                        echo "<script>window.location.href='doctor.php';</script>";
                                    }
                                } catch (\Exception $e) {
                                    die($e->getMessage());
                                }
                            }
                        }
                        ?>

                        <!-- get url param id -->
                        <?php
                        if (isset($_GET['id'])) {
                            $id = base64_decode($_GET['id']);
                            $sql = "SELECT * FROM doctors WHERE id = :id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_OBJ);
                            // print_r($row);
                            $data = [
                                'name' => $row->name,
                                'phone' => $row->phone,
                                'image' => $row->image,
                                'address' => $row->address,
                                'dob' => $row->dob,
                                'expert_in' => $row->expert_in,
                                'degree' => $row->degree,
                                'gender' => $row->gender,
                                'user_id' => $row->user_id
                            ];
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <input type="hidden" name="id" value="<?php echo $id ?? ''; ?>">
                                <input type="hidden" name="odlImage" value="<?php echo $data['image'] ?? ''; ?>" ?>
                                <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?? ''; ?>">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="<?php echo $data['name'] ?? ''; ?>" class="form-control">
                                        <span class="text-danger"><?php echo $error['name'] ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="<?php echo $data['phone'] ?? ''; ?>" class="form-control">
                                        <span class="text-danger"><?php echo $error['phone'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option <?php echo $data['gender'] == 'Male' ? 'selected' : '' ?> value="Male">Male</option>
                                            <option <?php echo $data['gender'] == 'Female' ? 'selected' : '' ?> value="Female">Female</option>
                                            <option <?php echo $data['gender'] == 'Other' ? 'selected' : '' ?> value="Other">Other</option>
                                        </select>
                                        <span class="text-danger"><?php echo $error['gender'] ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" name="dob" id="dob" value="<?php echo $data['dob'] ?? ''; ?>" class="form-control datepicker">
                                        <span class="text-danger"><?php echo $error['dob'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control"><?php echo $data['address'] ?? ''; ?></textarea>
                                        <span class="text-danger"><?php echo $error['address'] ?? ''; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control dropify" data-default-file="<?php echo $data['image'] ?? ''; ?>">
                                        <span class="text-danger"><?php echo $error['image'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expert_in">Expert In</label>
                                        <textarea name="expert_in" id="expert_in" rows="3" class="form-control"><?php echo $data['expert_in'] ?? ''; ?></textarea>
                                        <span class="text-danger"><?php echo $error['expert_in'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="degree">Degree</label>
                                        <input type="text" name="degree" id="degree" value="<?php echo $data['degree'] ?? ''; ?>" class="form-control">
                                        <span class="text-danger"><?php echo $error['degree'] ?? ''; ?></span>
                                    </div>


                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <?php
    include_once('layout/common_js.php');
    ?>
    <!-- Page specific javascripts-->
    <script src="js/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="js/plugins/datepicker/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                height: 120
            });

            /* datepicker active */
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</body>

</html>