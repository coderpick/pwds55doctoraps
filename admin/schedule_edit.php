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
                                <h5 class="tile-title mb-0">Edit Doctor Schedule</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <!-- Button trigger modal -->
                                <a href="schedule.php" class="btn btn-warning">
                                    <i class="bi bi-reply me-2"></i> Back to Schedule
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">

                                <?php
                                $error = [];
                                $data = [];
                                if (isset($_POST['submit'])) {

                                    $data['doctor'] = $_POST['doctor'];
                                    $data['schedule_date'] = $_POST['schedule_date'];
                                    $data['start_time'] = $_POST['start_time'];
                                    $data['end_time'] = $_POST['end_time'];
                                    $data['average_consulting_time'] = $_POST['average_consulting_time'];
                                    $data['maximum_appointment'] = $_POST['maximum_appointment'];
                                    $date =  $_POST['schedule_date'];
                                    $dayName = date('l', strtotime($date));
                                    $schedule_id = $_POST['schedule_id'];

                                    if (empty($data['doctor'])) {
                                        $error['doctor'] = 'Please select a doctor';
                                    } else {
                                        $data['doctor'] = $_POST['doctor'];
                                    }
                                    if (empty($data['schedule_date'])) {
                                        $error['schedule_date'] = 'Please select a schedule date';
                                    } else {
                                        $data['schedule_date'] = $_POST['schedule_date'];
                                    }
                                    if (empty($data['start_time'])) {
                                        $error['start_time'] = 'Please select a start time';
                                    } else {
                                        $data['start_time'] = $_POST['start_time'];
                                    }
                                    if (empty($data['end_time'])) {
                                        $error['end_time'] = 'Please select a end time';
                                    } else {
                                        $data['end_time'] = $_POST['end_time'];
                                    }
                                    if (empty($data['average_consulting_time'])) {
                                        $error['average_consulting_time'] = 'Please select a average consulting time';
                                    } else {
                                        $data['average_consulting_time'] = $_POST['average_consulting_time'];
                                    }
                                    if (empty($data['maximum_appointment'])) {
                                        $error['maximum_appointment'] = 'Please select a maximum appointment';
                                    } else {
                                        $data['maximum_appointment'] = $_POST['maximum_appointment'];
                                    }

                                    if (count($error) == 0) {
                                        $currentDateTime = date('Y-m-d H:i:s');
                                        try {
                                            //update schedule
                                            /* `doctor_id`, `schedule_date`, `schedule_day`, `start_time`, `end_time`, `consulting_time`, */
                                            $sql = "UPDATE schedules SET doctor_id=:doctor, schedule_date=:schedule_date, schedule_day=:schedule_day,start_time=:start_time, end_time=:end_time, consulting_time=:average_consulting_time, maximum_appointment=:maximum_appointment WHERE id=:schedule_id";
                                            if ($stmt = $conn->prepare($sql)) {
                                                $stmt->bindParam(':doctor', $data['doctor'], PDO::PARAM_INT);
                                                $stmt->bindParam(':schedule_date', $data['schedule_date'], PDO::PARAM_STR);
                                                $stmt->bindParam(':schedule_day', $dayName, PDO::PARAM_STR);
                                                $stmt->bindParam(':start_time', $data['start_time'], PDO::PARAM_STR);
                                                $stmt->bindParam(':end_time', $data['end_time'], PDO::PARAM_STR);
                                                $stmt->bindParam(':average_consulting_time', $data['average_consulting_time'], PDO::PARAM_INT);
                                                $stmt->bindParam(':maximum_appointment', $data['maximum_appointment'], PDO::PARAM_INT);
                                                $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
                                                if ($stmt->execute()) {
                                                    $_SESSION['success'] = 'Schedule updated successfully';
                                                    echo "<script>window.location.href='schedule.php';</script>";
                                                }
                                            }
                                        } catch (\PDOException $e) {
                                            die("Error: " . $e->getMessage());
                                        }
                                    }
                                }

                                /* get url param id */
                                if (isset($_GET['id'])) {
                                    $id = base64_decode($_GET['id']);
                                    $sql = "SELECT * FROM schedules WHERE id=:id";
                                    try {
                                        if ($stmt = $conn->prepare($sql)) {
                                            $stmt->bindParam(':id', $id);
                                            if ($stmt->execute()) {
                                                $row = $stmt->fetch(PDO::FETCH_OBJ);
                                                $data['doctor'] = $row->doctor_id;
                                                $data['schedule_date'] = $row->schedule_date;
                                                $data['start_time'] = $row->start_time;
                                                $data['end_time'] = $row->end_time;
                                                $data['average_consulting_time'] = $row->consulting_time;
                                                $data['maximum_appointment'] = $row->maximum_appointment;
                                                $data['schedule_id'] = $row->id;
                                            }
                                        }
                                    } catch (\PDOException $e) {
                                        die("Error: " . $e->getMessage());
                                    }
                                }
                                ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" id="doctor_schedule_form" autocomplete="off">
                                    <input type="hidden" name="schedule_id" value="<?php echo  $data['schedule_id'] ?? ''; ?>">
                                    <div class="mb-3">
                                        <label class="control-label">Select Doctor</label>
                                        <select name="doctor" id="doctor" class="form-control" required>
                                            <option value="" selected disabled>Select Doctor</option>
                                            <?php
                                            $sql = "SELECT * FROM doctors";
                                            $result = $conn->query($sql);
                                            if ($result->rowCount() > 0) {
                                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($rows as $row) {
                                            ?>
                                                    <option
                                                        <?php if ($data['doctor'] == $row->id) echo 'selected'; ?>

                                                        value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo $error['doctor'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="control-label" for="schedule_date">Schedule Date</label>
                                        <input type="text" class="form-control" name="schedule_date"
                                            value="<?php echo $data['schedule_date'] ?? ''; ?>"
                                            id="schedule_date" required>
                                        <span class="text-danger"><?php echo $error['schedule_date'] ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="control-label" for="start_time">Start Time</label>
                                        <input type="text" class="form-control" name="start_time"
                                            value="<?php echo $data['start_time'] ?? ''; ?>"
                                            id="start_time" required>
                                        <span class="text-danger"><?php echo $error['start_time'] ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="control-label" for="end_time">End Time</label>
                                        <input type="text" class="form-control" name="end_time"
                                            value="<?php echo $data['end_time'] ?? ''; ?>"
                                            id="end_time" required>
                                        <span class="text-danger"><?php echo $error['end_time'] ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="control-label" for="average_consulting_time">Average Consulting Time</label>
                                        <select name="average_consulting_time" id="average_consulting_time" class="form-select" required>
                                            <option value="" disabled selected>Select Consulting Duration</option>
                                            <?php
                                            for ($i = 5; $i <= 60; $i += 5) {
                                                echo '<option
                                                ' . ($data['average_consulting_time'] == $i ? 'selected' : '') . '
                                                value="' . $i . '">' . $i . ' Minute</option>';
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo $error['average_consulting_time'] ?? ''; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <!-- max appointment -->
                                        <label for="maximum_appointment">Max Appointment</label>
                                        <input type="number" min="1" name="maximum_appointment" class="form-control"
                                            value="<?php echo $data['maximum_appointment'] ?? ''; ?>"
                                            id="maximum_appointment">
                                        <span class="text-danger"><?php echo $error['maximum_appointment'] ?? ''; ?></span>
                                    </div>

                                    <div class="text-center pt-3 pb-5">
                                        <button type="submit" name="submit" id="submit_button" class="btn btn-primary">Update Schedule</button>
                                    </div>
                                </form>
                            </div>
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
    <script src="js/plugins/datepicker/bootstrap-datepicker.min.js"></script>
    <script src="js/plugins/timepicker/jquery.timepicker.min.js"></script>
    <script src="js/parsley.min.js"></script>


    <script type="text/javascript">
        $('#doctorTable').DataTable();


        var date = new Date();
        date.setDate(date.getDate());

        $('#schedule_date').datepicker({
            startDate: date,
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            backday: false
        });

        $('#start_time').timepicker({
            'minTime': '06:00am',
            'maxTime': '11:30pm',
            'timeFormat': 'h:i A',
            'step': '15'
        });

        $('#end_time').timepicker({
            'minTime': '06:00am',
            'maxTime': '11:30pm',
            'timeFormat': 'h:i A',
            'step': '15'
        });

        $('#doctor_schedule_form').parsley();
    </script>
</body>

</html>