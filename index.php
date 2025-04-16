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
                                <th>Name</th>
                                <th>Education</th>
                                <th>Specialty</th>
                                <th>Appointment Date</th>
                                <th>Time Slot</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

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