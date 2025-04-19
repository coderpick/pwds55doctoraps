 <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
     <div class="container">
         <a class="navbar-brand" href="index.php">Doctor Appointment</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                 <?php
                    if (isset($_SESSION['is_login']) &&  $_SESSION['is_login'] == true) { ?>
                     <li class="nav-item">
                         <a class="nav-link" aria-current="page" href="my_appointment.php">My Appointments</a>
                     </li>

                     <li class="nav-item dropdown">
                         <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                             <?= $_SESSION['username'] ?? '' ?>
                         </button>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="#">Profile</a></li>
                             <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                         </ul>
                     </li>
                 <?php     } else { ?>
                     <li class="nav-item">
                         <a class=" btn btn-primary" href="login.php">Login</a>
                     </li>

                 <?php }
                    ?>
             </ul>

         </div>
     </div>
 </nav>