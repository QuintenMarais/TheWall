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

<div class="container-fluid <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <div class="row">
        <div class="col-md-6">

<!-- Start Left Container -->
<div class="container-fluid <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>IP Addresses</h1>
  <div class="container-fluid  <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <form class="form-horizontal" action="ipactions.php" method="POST">
    <fieldset>
        <!-- Text input -->
        <div class="form-group">
            <div class="col-md-8">
                <input id="textinput" name="textinput" type="text" class="form-control input-md" placeholder="Enter an IP Address Address">
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

<div class="container-fluid text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>Current Contents</h1>
  <div class="container-fluid text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <?php

    // Read the file and store each line in an array
    $blacklistData = file($theipBlackfilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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
        echo '<form action="ipactions.php" method="POST">';
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

<!-- End Left Container -->

</div>
<div class="col-md-6">

<!-- Start Right Container -->
<div class="container-fluid <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>FQDN</h1>
  <div class="container-fluid <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <form class="form-horizontal" action="fqdnactions.php" method="POST">
    <fieldset>
        <!-- Text input -->
        <div class="form-group">
            <div class="col-md-8">
                <input id="textinput" name="textinput" type="text" class="form-control input-md" placeholder="Enter an FQDN">
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

<div class="container-fluid  text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
  <h1>Current Contents</h1>
  <div class="container-fluid  text-left <?php echo $showBorders ? 'border border-primary' : ''; ?>">
    <!-- Start -->
    <?php

    // Read the file and store each line in an array
    $blacklistData = file($thefqdnBlackfilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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
      foreach ($blacklistData as $fqdnAddress) {
        // Perform DNS lookup
        $ipAddress = gethostbyname($fqdnAddress);
    
        echo '<tr>';
        echo '<td class="ip-address" data-toggle="tooltip" data-placement="top" title="' . ($ipAddress !== $fqdnAddress ? 'IP Address: ' . htmlspecialchars($ipAddress) : 'No IP address found') . '">' . htmlspecialchars($fqdnAddress) . '</td>';

        echo '<td class="text-center">';
        echo '<form action="fqdnactions.php" method="POST">';
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
<!-- End RIGHT Container -->
</div>
    </div>
</div>
<script>
    // Get the domain cell and IP cell
    const domainCell = document.getElementById('domain');
    const ipCell = document.getElementById('ip');

    // Function to perform NSlookup and display IP address
    function performNslookup(domain) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `https://dns.google/resolve?name=${domain}&type=A`);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.Answer && response.Answer.length > 0) {
                        resolve(response.Answer[0].data);
                    } else {
                        reject('No IP address found');
                    }
                } else {
                    reject('Failed to fetch IP address');
                }
            };

            xhr.onerror = function() {
                reject('Failed to fetch IP address');
            };

            xhr.send();
        });
    }

    // Add event listener to perform NSlookup when hovering over the domain
    domainCell.addEventListener('mouseover', async function() {
        try {
            const ipAddress = await performNslookup(domainCell.textContent);
            ipCell.textContent = ipAddress;
        } catch (error) {
            console.error(error);
            ipCell.textContent = 'Failed to fetch IP';
        }
    });
</script>
<?php include('inc/footer.html'); ?>


