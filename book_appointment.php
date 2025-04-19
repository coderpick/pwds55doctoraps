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
                    <h5 class="card-title mb-0">Book Appointment</h5>
                </div>
                <div class="card-body">
                    <?php
                    $error = array();
                    $data  = array();
                    if (isset($_POST['book_appointment'])) {
                        $appointment_reason = $_POST['appointment_reason'];
                        $schedule_id = $_POST['schedule_id'];
                        $doctor_id = $_POST['doctor_id'];
                        $patientUserId = $_SESSION['patientUserId'];

                        /* check schedule if already booked or not */
                        $sql = "SELECT * FROM appointments WHERE schedule_id = :schedule_id AND user_id = :user_id";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
                            $stmt->bindParam(':user_id', $patientUserId, PDO::PARAM_INT);
                            if ($stmt->execute()) {
                                $result = $stmt->fetch();
                                if ($result != null) {
                                    $_SESSION['schedule_already_booked'] = "You have already booked this schedule";
                                    echo "<script>window.location.href='my_appointment.php';</script>";
                                    exit();
                                }
                            }
                        }

                        if (empty($appointment_reason)) {
                            $error['appointment_reason'] = "Appointment reason is required";
                        } else {
                            $data['appointment_reason'] = $appointment_reason;
                        }
                        if (empty($error)) {

                            $sql = "INSERT INTO appointments (doctor_id, user_id, schedule_id,appointment_number, appointment_reason,created_at) VALUES (:doctor_id, :user_id, :schedule_id, :appointment_number,:appointment_reason,:created_at)";
                            $appointment_number = rand(100000, 999999);
                            $currentDateTime = date('Y-m-d H:i:s');
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
                                $stmt->bindParam(':user_id',  $patientUserId, PDO::PARAM_INT);
                                $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
                                $stmt->bindParam(':appointment_number',  $appointment_number, PDO::PARAM_STR);
                                $stmt->bindParam(':appointment_reason', $data['appointment_reason'], PDO::PARAM_STR);
                                $stmt->bindParam(':created_at', $currentDateTime, PDO::PARAM_STR);
                                $stmt->execute();
                                $_SESSION['message'] = "Appointment Booked Successfully";
                                echo "<script>window.location.href='my_appointment.php';</script>";
                            }
                        }
                    }
                    ?>


                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Doctor Details</h4>
                                <!-- get url param id -->
                                <?php
                                if (isset($_GET['schedule_id'])) {
                                    $id = base64_decode($_GET['schedule_id']);
                                    $sql = "SELECT schedules.*, doctors.name as doctorName FROM schedules
                        INNER JOIN doctors ON schedules.doctor_id = doctors.id WHERE schedules.id = :id";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':id', $id);
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_OBJ);
                                }
                                ?>
                                <table class="table">
                                    <tr>
                                        <th>Doctor Name</th>
                                        <td> <?php echo $row->doctorName; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Schedule Date</th>
                                        <td> <?php echo $row->schedule_date; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Time Slot</th>
                                        <td> <?php echo $row->start_time; ?> - <?php echo $row->end_time; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Day</th>
                                        <td> <?php echo $row->schedule_day; ?></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="schedule_id" value="<?php echo $row->id; ?>">
                                <input type="hidden" name="doctor_id" value="<?php echo $row->doctor_id; ?>">

                            </div>
                            <div class="col-md-6">
                                <h4>Patient Details</h4>
                                <?php
                                $patientUserId = $_SESSION['patientUserId'];
                                $sql = "SELECT * FROM patients WHERE user_id = :user_id";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':user_id', $patientUserId, PDO::PARAM_INT);
                                $stmt->execute();
                                $patient = $stmt->fetch(PDO::FETCH_OBJ);
                                ?>
                                <table class="table">
                                    <tr>
                                        <th>Doctor Name</th>
                                        <td> <?php echo $patient->name; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td> <?php echo $patient->phone; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td> <?php echo $patient->address; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Marital status</th>
                                        <td> <?php echo $patient->marital_status; ?></td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-12">
                                <h5 class="mt-2">Resion of Appointment</h5>
                                <div class="mb-3">
                                    <label for="name" class="form-label d-none">Resion of Appointment</label>
                                    <textarea name="appointment_reason" id="name" rows="5" class="form-control" required></textarea>
                                    <span class="text-danger"><?php echo $error['appointment_reason'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <button type="submit" name="book_appointment" class="btn btn-primary">Book Appointment</button>
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