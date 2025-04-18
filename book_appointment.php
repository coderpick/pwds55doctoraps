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

                    <!-- get url param id -->
                    <?php
                    if (isset($_GET['schedule_id'])) {
                        $id = $_GET['schedule_id'];
                        $sql = "SELECT schedules.*,doctors.name as doctorName FROM schedules INNER JOIN doctors ON schedules.doctor_id =doctors.id;
                            WHERE schedules.id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_OBJ);
                        print_r($row);
                    }
                    ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Doctor Details</h4>
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
                            </div>
                            <div class="col-md-6">
                                <h4 class="mt-2">Resion of Appointment</h4>
                                <div class="mb-3">
                                    <label for="name" class="form-label d-none">Resion of Appointment</label>
                                    <textarea name="name" id="name" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <button type="submit" class="btn btn-primary">Book Appointment</button>
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