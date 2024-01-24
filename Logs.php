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
  <h1>Logs</h1>
  <div class="container-fluid custom-container <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
  

    <?php

// Read the log file and store each line in an array
$logData = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Check if there is data in the file
if (!empty($logData)) {
    // Output Bootstrap 5 table structure with an additional "Action" column
    echo '<table class="table table-bordered custom-Log-table table-striped">';
    echo '<thead class="thead-dark">';
    echo '<tr><th>Date & Time</th><th>Username</th><th>Action</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    // Iterate through each line and output as a table row
    foreach ($logData as $logEntry) {
        // Explode the log entry into an array
        $logFields = explode(';', $logEntry);

        // Check if the log entry has the expected number of fields
        if (count($logFields) >= 3) {
            // Combine the first two fields as "Date & Time"
            $dateTime = $logFields[0];
            $username = $logFields[1];
            $action   = $logFields[2];

            echo '<tr>';
            echo '<td>' . htmlspecialchars($dateTime) . '</td>';
            echo '<td>' . htmlspecialchars($username) . '</td>';
            echo '<td>' . htmlspecialchars($action) . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '</table>';
} else {
    // Output a message if the file is empty
    echo '<p>No data in the log file.</p>';
}

?>



    <!-- End -->
  </div>
</div>
<?php include('inc/footer.html'); ?>


