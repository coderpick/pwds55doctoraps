<?php
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
                <h1><i class="bi bi-speedometer"></i> Welcome to admin panel</h1>
                <p>Start a beautiful journey here</p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">Create a beautiful dashboard</div>
                </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <?php
    include_once('layout/common_js.php');
    ?>
    <!-- Page specific javascripts-->

</body>

</html>