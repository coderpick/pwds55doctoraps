<?php
$pageTitle = 'Schedule';
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
                <h1><i class="bi bi-table"></i> Doctor Schedules</h1>
                <p>Doctor Schedules create,edit and delete</p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active"><a href="#">Doctor Schedules</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="tile-title mb-0">Doctor Schedules</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <!-- Button trigger modal -->
                                <a href="schedule_add.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Add Schedule
                                </a>
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
                                        <th>Doctor Name</th>
                                        <th>Schedule Date</th>
                                        <th>Schedule Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Consulting Time</th>
                                        <th>Max Visitor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT schedules.*, doctors.name as doctorName FROM schedules INNER JOIN doctors ON schedules.doctor_id=doctors.id ORDER BY schedules.created_at DESC;";
                                    $result = $conn->query($sql);
                                    if ($result->rowCount() > 0) {
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($rows as $key => $row) { ?>
                                            <tr>
                                                <td><?php echo $key + 1 ?></td>
                                                <td><?php echo $row->doctorName; ?></td>
                                                <td><?php echo $row->schedule_date; ?></td>
                                                <td><?php echo $row->schedule_day; ?></td>
                                                <td><?php echo $row->start_time; ?></td>
                                                <td><?php echo $row->end_time; ?></td>
                                                <td><?php echo $row->consulting_time; ?> Minutes</td>
                                                <td>
                                                    <?php echo $row->maximum_appointment;  ?>
                                                </td>
                                                <td>
                                                    <a href="schedule_edit.php?id=<?php echo base64_encode($row->id) ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                    <?php
                                                    if ($row->status !== 'Booked') { ?>
                                                        <a href="schedule_delete.php?id=<?php echo base64_encode($row->id) ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php }
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