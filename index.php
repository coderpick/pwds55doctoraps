<?php
include "layout/head.php";
?>

<?php
include "layout/navbar.php";
?>

<!-- main content area start -->
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Doctor Schedules</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="doctorTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doctor Name</th>
                                <th>Schedule Date</th>
                                <th>Schedule Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Consulting Time</th>
                                <th>Max Appointment</th>
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
                                            <?php echo $row->maximum_appointment;   ?> Person
                                        </td>
                                        <td>

                                            <?php
                                            if (isset($_SESSION['is_login']) != true) { ?>
                                                <a href="login.php" class="btn btn-primary btn-sm">
                                                    Get Appointment
                                                </a>
                                            <?php } else { ?>
                                                <a href="book_appointment.php?schedule_id=<?php echo $row->id; ?>" class="btn btn-primary btn-sm">
                                                    Get Appointment
                                                </a>
                                            <?php   } ?>
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
<!-- main content area end -->
<!-- footer -->
<?php
include "layout/footer.php";
?>