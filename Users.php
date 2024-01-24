<?php
session_start();
include('inc/config.conf');
include('inc/functions.php');

// Set this variable to true or false to toggle borders on or off
$showBorders = true;

if (!isset($_SESSION['msatg'])) {
    header('Location: index.php'); // Redirect to the login page if not authenticated
    exit;
}

include('inc/header.html');
include('inc/navbar.php');
?>
<div class="container-fluid custom-container custom-indent <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>Users</h1>
  <div class="container-fluid custom-container <?php echo $showBorders ? 'border border-primary' : ''; ?>">
<!-- Start -->
  




<!-- End -->
  </div>
</div>
<?php include('inc/footer.html'); ?>