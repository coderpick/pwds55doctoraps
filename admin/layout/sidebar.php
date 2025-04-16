  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
          <div>
              <p class="app-sidebar__user-name">John Doe</p>
              <p class="app-sidebar__user-designation">Frontend Developer</p>
          </div>
      </div>

      <ul class="app-menu">
          <li>
              <a class="app-menu__item <?php echo  $pageTitle  == 'Admin' ? 'active' : ''; ?>" href="dashboard.php"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span>
              </a>
          </li>

          <li>
              <a class="app-menu__item <?php echo  $pageTitle  == 'Doctors' ? 'active' : ''; ?>" href="doctor.php"><i class="app-menu__icon bi bi-file-earmark-person-fill"></i><span class="app-menu__label">Doctors</span>
              </a>
          </li>

          <li>
              <a class="app-menu__item <?php echo  $pageTitle  == 'Patients' ? 'active' : ''; ?>" href="patient.php"><i class="app-menu__icon bi bi-people"></i><span class="app-menu__label">Patients</span>
              </a>
          </li>

          <li>
              <a class="app-menu__item <?php echo  $pageTitle  == 'Schedule' ? 'active' : ''; ?>" href="schedule.php"><i class="app-menu__icon bi bi-calendar3"></i><span class="app-menu__label">Schedules</span>
              </a>
          </li>


      </ul>
  </aside>