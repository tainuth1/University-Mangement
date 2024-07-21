<?php
include 'link/link.php';
include '../connection/db.php';
session_start();
function logout()
{
    if (isset($_POST['logout'])) {
        unset($_SESSION['id']);
    }
}
logout();
if (!$_SESSION['id']) {
    header('location:../login.php');
}

$userID = $_SESSION['id'];
$stmt = connection()->prepare("SELECT * FROM admin WHERE admin_id = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch();


$current_page = basename($_SERVER['PHP_SELF']);
include 'function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head id="body-pd">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/alert.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="sidebar"><!-- addClass .close if you want to close sidebar at the begin-->
        <div class="logo-details">
            <!-- <i class='bx bxl-c-plus-plus'></i> -->
            <div class="logo-wrapper">
                <img src="images/logo.png" alt="">
            </div>
            <span class="logo_name">University</span>
        </div>
        <ul class="nav-links" id="menu">
            <li class="nav-menu <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Category</a></li>
                </ul>
            </li>
            <li class="nav-menu <?php echo ($current_page == 'createDepartment.php') ? 'active' : ''; ?>">
                <div class="iocn-link">
                    <a>
                        <i class="fa-solid fa-school-flag"></i>
                        <span class="link_name">Department</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Category</a></li>
                    <li><a href="createDepartment.php">Create & Views</a></li>
                </ul>
            </li>
            <li class="nav-menu <?php echo ($current_page == 'createClass.php') ? 'active' : ''; ?>">
                <div class="iocn-link">
                    <a>
                        <i class="fa-solid fa-book"></i>
                        <span class="link_name">Class</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Classes</a></li>
                    <li><a href="createClass.php">Create & Views</a></li>
                </ul>
            </li>
            <li class="nav-menu <?php echo ($current_page == 'createTeacher.php') ? 'active' : ''; ?>">
                <div class="iocn-link">
                    <a>
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span class="link_name">Teachers</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Teachers</a></li>
                    <li><a href="createTeacher.php">Add & Views</a></li>
                </ul>
            </li>
            <li
                class="nav-menu <?php echo ($current_page == 'createStudent.php' || $current_page == 'studentPayment.php') ? 'active' : ''; ?>">
                <div class="iocn-link">
                    <a>
                        <i class='bx bx-male-female'></i>
                        <span class="link_name">Students</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Students</a></li>
                    <li><a href="createStudent.php">Add & Views</a></li>
                    <li><a href="studentPayment.php">Payments</a></li>
                </ul>
            </li>
            <li class="nav-menu">
                <a href="createEvent.php">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="link_name">Event</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="createEvent.php">Event</a></li>
                </ul>
            </li>
            <li class="nav-menu <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
                <a href="profile.php?id=<?= $_SESSION['id'] ?>">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">Profile</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Profile</a></li>
                </ul>
            </li>
            <!--<li class="nav-menu">
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Setting</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Setting</a></li>
                </ul>
            </li> -->
            <li class="nav-menu">
                <form action="" method="post" class="logout-form">
                    <button type="submit" class="logout-btn" name="logout">
                        <a>
                            <i class='bx bx-log-out'></i>
                            <span class="link_name">Logout</span>
                        </a>
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="home-nav">
            <div class="">
                <i class='bx bx-menu'></i>
            </div>
            <div class="left-nav">
                <div class="icon-background" id="notification">
                    <i class='bx bx-bell'></i>
                    <div class="notification-wrapper">

                    </div>
                </div>
                <div class="profile-section">
                    <a href="profile.php?id=<?= $_SESSION['id'] ?>">
                        <div class="pro-img">
                            <img src="profile/<?= $user['profile'] ?>" alt="<?= $user['profile'] ?>">
                        </div>
                        <div class="name-job">
                            <h5><?php echo $user['firstName'] . ' ' . $user['lastName'] ?></h5>
                            <p><?php echo $user['role'] ?></p>
                        </div>
                    </a>
                    <i class='showDropProfile bx bxs-chevron-down arrow'></i>
                    <div class="menu">
                        <ul>
                            <li>
                                <i class='bx bx-user'></i><a href="profile.php?id=<?= $_SESSION['id'] ?>">My profile</a>
                            </li>
                            <li>
                                <i class='bx bxs-edit'></i><a href="edit-profile-admin.php?adminID=<?= $_SESSION['id'] ?>">Edit profile</a>
                            </li>
                            <li>
                                <i class='bx bx-envelope'></i><a href="#">Inbox</a>
                            </li>
                            <li>
                                <i class='bx bx-cog'></i><a href="#">Setting</a>
                            </li>
                            <li>
                                <i class='bx bx-help-circle'></i><a href="#">Help</a>
                            </li>
                            <li>
                                <form action="" method="post">
                                    <button type="submit" class="drop-logoutBtn logout-btn" name="logout">
                                        <i class='bx bx-log-out'></i><a>Logout</a>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>