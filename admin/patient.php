<?php
$pageTitle = 'Doctors';
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
                <h1><i class="bi bi-table"></i> Patients</h1>
                <p>Doctor create,edit and delete</p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active"><a href="#">Patients</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="tile-title mb-0">Patients</h5>
                            </div>
                            <div class="col-md-6 text-end">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['success']);
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="doctorTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Degree</th>
                                        <th>Expertise</th>
                                        <th>Gender</th>
                                        <th>Dob</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT doctors.*,users.name,users.email,users.status FROM doctors INNER JOIN users ON doctors.user_id=users.id";
                                    $result = $conn->query($sql);
                                    if ($result->rowCount() > 0) {
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($rows as $key => $row) { ?>
                                            <tr>
                                                <td><?php echo $key + 1 ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img style="width: 60px;height: 60px;" class="rounded-circle" src="<?php echo $row->image ?>" alt="...">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6> <?php echo $row->name ?></h6>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td><?php echo $row->phone ?></td>
                                                <td><?php echo $row->degree ?></td>
                                                <td><?php echo $row->expert_in ?></td>
                                                <td><?php echo $row->gender ?></td>
                                                <td><?php echo $row->dob ?></td>
                                                <td><?php echo $row->status ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                    <a href="edit_doctor.php?id=<?php echo base64_encode($row->id) ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="delete_doctor.php?id=<?php echo base64_encode($row->id) ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
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

    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $('#doctorTable').DataTable();
    </script>

</body>

</html>