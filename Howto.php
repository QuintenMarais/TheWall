<?php
session_start();
include('inc/config.conf');
include('inc/functions.php');

// Set this variable to true or false to toggle borders on or off
$showBorders = false;

if (!isset($_SESSION['msatg'])) {
    header('Location: index.php'); // Redirect to the login page if not authenticated
    exit;
}

include('inc/header.html');
include('inc/navbar.php');
?>
<div class="container-fluid custom-container custom-indent <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>How To</h1>
  <div class="container-fluid custom-container <?php echo $showBorders ? 'border border-primary' : ''; ?>">
<!-- Start -->
<style>
    .table td, .table th {
        border: none; /* Remove borders from table cells */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>The IP Blacklist File can be found at</td>
                        <td>:</td>
                        <td><?php echo $redirect_uri . $theipBlackfilePath; ?></td>
                    </tr>
                    <tr>
                        <td>The FQDN Blacklist File can be found at</td>
                        <td>:</td>
                        <td><?php echo $redirect_uri . $thefqdnBlackfilePath; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>The Username</td>
                        <td>:</td>
                        <td><?php echo $theBlackfileUser; ?></td>
                    </tr>
                    <tr>
                        <td>The Password</td>
                        <td>:</td>
                        <td><?php echo $theBlackfilePassword; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- End -->
  </div>
</div>


  
<?php include('inc/footer.html'); ?>