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
  <h1>Settings</h1>
  <div class="container-fluid custom-container <?php echo $showBorders ? 'border border-primary' : ''; ?>">
<!-- Start -->
    <?php
    // Output Bootstrap 5 table structure for settings
    echo '<table class="table table-bordered custom-Settings-table table-striped">';
    echo '<thead class="thead-dark">';
    echo '<tr><th>Setting</th><th>Value</th></tr>';
    echo '</thead>';
    echo '<tbody>';

      // Read the settings file and store each line in an array
      $settingsData = file('inc/config.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Iterate through each line and output as a table row
    foreach ($settingsData as $settingEntry) {
      // Explode the setting entry into an array
      $settingFields = explode('=', $settingEntry, 2);


      // Check if the setting entry has the expected number of fields
      if (count($settingFields) === 2) {
          $settingName = trim($settingFields[0]);
          $settingValue = trim(str_replace(['"', ';'], '', $settingFields[1]));

          echo '<tr>';
          echo '<td>' . htmlspecialchars($settingName) . '</td>';
          echo '<td>' . (strpos($settingName, 'secret') !== false ? '********' : htmlspecialchars($settingValue)) . '</td>';
          echo '</tr>';
      }
  }

    echo '</tbody>';
    echo '</table>';
    ?>

<!-- End -->
  </div>
</div>
<?php include('inc/footer.html'); ?>