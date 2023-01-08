<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /SIR-project/CMS/auth/login.php");
    exit;
}

function create_menu() {
    $userRole = $_SESSION["userType"];

    if ($userRole == "Admin") {
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/aboutme/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>About me</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/experience/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Experience</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/education/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Education</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/languages/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Skills</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/interests/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Interests</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/contacts/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Contacts</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/net-salary/calculate-net-salary.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Net Salary</div>
                </a>
            </li>';
    } else if ($userRole == "Manager") {
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/aboutme/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>About me</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/experience/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Experience</div>
                </a>
            </li>';
        echo '<li class="menu-item">
                <a href="/SIR-project/CMS/pages/education/read.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div>Education</div>
                </a>
            </li>';
        echo '<li class="menu-item">
            <a href="/SIR-project/CMS/pages/languages/read.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Skills</div>
            </a>
        </li>';
        echo '<li class="menu-item">
            <a href="/SIR-project/CMS/pages/interests/read.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Interests</div>
            </a>
        </li>';
        echo '<li class="menu-item">
            <a href="/SIR-project/CMS/pages/contacts/read.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Contacts</div>
            </a>
        </li>';
        echo '<li class="menu-item">
            <a href="/SIR-project/CMS/pages/net-salary/calculate-net-salary.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Net Salary</div>
            </a>
        </li>';
    }
}

function template_header($title) {
	$username  = $_SESSION["username"];
	$userID  = $_SESSION["id"];
	$userRole = $_SESSION["userType"];
    $userPhoto = "/SIR-project/assets/imgs/default_profile.png";

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="/SIR-project/utils/style.css" rel="stylesheet" type="text/css">
        
        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="/SIR-project/assets/css/styles.css">

        <!-- Icons. required icon fonts -->
        <link rel="stylesheet" href="/SIR-project/assets/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="/SIR-project/assets/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="/SIR-project/assets/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="/SIR-project/assets/css/demo.css" />

	</head>
	<body>
    
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
              <span class="app-brand-text demo menu-text fw-bolder ms-2">backoffice</span>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
            <a href="/SIR-project/CMS/pages/welcome.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
             </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Pages</span>
            </li>
            
EOT;
create_menu();
echo <<<EOT
            
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="https://github.com/carlosmacho/SIR-project/issues"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://github.com/carlosmacho/SIR-project/wiki"
                target="_blank"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item lh-1 me-3">$username</li>
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="$userPhoto" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="$userPhoto" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">$username</span>
                            <small class="text-muted">$userRole</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/SIR-project/CMS/pages/aboutme/read.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/SIR-project/CMS/auth/logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
          <!-- / Navbar -->
          
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-fluid flex-grow-1 container-p-y">

    
EOT;
}
function template_footer() {
echo <<<EOT
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    </div>
    <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <!-- Core JS -->
    <script src="/SIR-project/assets/js/bootstrap.js"></script>
    </body>
</html>
EOT;
}
?>