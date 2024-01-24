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
  <h1>Add New Entry</h1>
  <div class="container-fluid custom-container <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <form class="form-horizontal" action="actions.php" method="POST">
    <fieldset>
        <!-- Text input -->
        <div class="form-group">
            <div class="col-md-4">
                <input id="textinput" name="textinput" type="text" class="form-control input-md">
            </div>
        </div>
        <br>
        <!-- Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
        <input type="hidden" name="action" value="add">

    </fieldset>
</form>

    <!-- End -->
  </div>
</div>

<div class="container-fluid custom-container custom-indent text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>Current Contents</h1>
  <div class="container-fluid custom-container text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <?php

    // Read the file and store each line in an array
    $blacklistData = file($theBlackfilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Check if there is data in the file
    if (!empty($blacklistData)) {
      // Output Bootstrap 5 table structure with an additional "Action" column
      echo '<table border=0><tr><td>';
      echo '<div class="row">';
      echo '<div class="col-md-8">'; // Adjust the column size based on your preference
      echo '<table class="table table-bordered custom-large-table table-striped">';
      echo '<thead class="thead-dark">';
      echo '<tr><th>IP Address</th><th>Action</th></tr>';
      echo '</thead>';
      echo '<tbody>';

      // Iterate through each line and output as a table row
      foreach ($blacklistData as $ipAddress) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($ipAddress) . '</td>';
        echo '<td class="text-center">';
        echo '<form action="actions.php" method="POST">';
        echo '<input type="hidden" name="action" value="delete">';
        echo '<input type="hidden" name="ip" value="' . urlencode($ipAddress) . '">';
        echo '<button type="submit" class="btn btn-danger">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        
      }
      echo '</tbody>';
      echo '</table>';
      echo '</div>';
      echo '</div>';
      echo '</td></tr></table>';
    } else {
      // Output a message if the file is empty
      echo '<p>No data in the blacklist file.</p>';
    }

    ?>
    <!-- End -->
  </div>
</div>
<?php include('inc/footer.html'); ?>
