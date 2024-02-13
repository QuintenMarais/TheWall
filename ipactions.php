<?php
session_start();

// Include necessary files and configurations
include('inc/config.conf');
include('inc/functions.php');

// Check if the user is authenticated
if (!isset($_SESSION['msatg'])) {
    header('Location: index.php'); // Redirect to the login page if not authenticated
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the action
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Check if the textinput field is set
            if (isset($_POST['textinput'])) {
                $newEntry = trim($_POST['textinput']);
        
                // Check if the entry is not empty
                if (!empty($newEntry)) {
                    // Append the new entry to the file with a newline character
                    file_put_contents($theipBlackfilePath, PHP_EOL . $newEntry, FILE_APPEND | LOCK_EX);
                }
                logUserAction($logFilePath, $_SESSION['userPrincipalName'], "Added record : $newEntry");
            }
        } elseif ($_POST['action'] === 'delete') {
            // Handle the delete action
            if (isset($_POST['ip'])) {
                $ipToDelete = urldecode($_POST['ip']);
        
                // Read the file and store each line in an array
                $blacklistData = file($theipBlackfilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
                // Find the index of the IP address in the array
                $indexToDelete = array_search($ipToDelete, $blacklistData);
        
                // If the IP address is found, remove it from the array
                if ($indexToDelete !== false) {
                    // Log the deleted IP address
                    logUserAction($logFilePath,$_SESSION['userPrincipalName'], "Deleted record: $ipToDelete");
        
                    unset($blacklistData[$indexToDelete]);
        
                    // Save the modified array back to the file
                    file_put_contents($theipBlackfilePath, implode("\n", $blacklistData));
                }
            }
        }
    }
}

// Redirect back to the dashboard.php page after completing the action
header('Location: dashboard.php');
exit;
?>

