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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Doctor Schedules</h5>
                        <a href="index.php" class="btn btn-primary">Back to Schedules</a>
                    </div>

                </div>
                <div class="card-body">
                    <!-- schedule success message -->
                    <?php
                    if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo $_SESSION['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['message']);
                    }
                    ?>
                    <?php
                    // schedule check message
                    if (isset($_SESSION['schedule_already_booked'])) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Whoops!</strong> <?php echo $_SESSION['schedule_already_booked'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    <?php
                        unset($_SESSION['schedule_already_booked']);
                    }
                    ?>
                    <table class="table table-striped" id="doctorTable">
                        <thead>
                            <tr>
                                <th width="8%">Serial</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT appointments.*, doctors.name as doctorName, schedules.schedule_date,schedules.schedule_day,schedules.start_time,schedules.end_time FROM appointments
                            INNER JOIN doctors ON appointments.doctor_id=doctors.id 
                            INNER JOIN schedules ON appointments.schedule_id=schedules.id 
                            WHERE appointments.user_id = :user_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':user_id', $_SESSION['patientUserId'], PDO::PARAM_INT);
                            $stmt->execute();
                            $schedules = $stmt->fetchAll(PDO::FETCH_OBJ);

                            if ($schedules != null) {
                                foreach ($schedules as $key => $schedule) { ?>
                                    <tr>
                                        <td><?php echo $schedule->appointment_number; ?></td>
                                        <td><?php echo $schedule->doctorName; ?></td>
                                        <td><?php echo $schedule->schedule_date; ?></td>
                                        <td><?php echo $schedule->schedule_day; ?></td>
                                        <td><?php echo $schedule->start_time; ?> - <?php echo $schedule->end_time; ?></td>
                                        <td>
                                            <?php
                                            if ($schedule->status == "Pending") {
                                                echo "<span class='badge bg-secondary'>Pending</span>";
                                            } elseif ($schedule->status == "Booked") {
                                                echo "<span class='badge bg-primary'>Booked</span>";
                                            } elseif ($schedule->status == "In_Process") {
                                                echo "<span class='badge bg-info'>In Process</span>";
                                            } elseif ($schedule->status == "Completed") {
                                                echo "<span class='badge bg-success'>Completed</span>";
                                            } else {
                                                echo "<span class='badge bg-danger'>Cancelled</span>";
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                            <?php   }
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