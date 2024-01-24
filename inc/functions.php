<?php
include('inc/config.conf');
function fetchUserInfo($access_token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token, 'Content-type: application/json']);
    curl_setopt($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    // You can fetch additional user information here
    // Example: $user_info['jobTitle'] = $response['jobTitle'];

    return $response;
}

function fetchUserGroups($access_token) {
    $url = 'https://graph.microsoft.com/beta/me/memberOf?$select=id';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token, 'Content-type: application/json']);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (array_key_exists('value', $response)) {
        $groups = array();
        foreach ($response['value'] as $group) {
            // Add group information to the $groups array
            $groups[] = array(
                'id' => $group['id'],
            );
        }

        return $groups;
    }

    return array(); // No groups found
}

function fetchUserProfilePicture($access_token) {
    // To Use the image <img src="data:image/jpeg;base64,<?= base64_encode($_SESSION['profile_picture']); 

    $url = 'https://graph.microsoft.com/v1.0/me/photo/$value';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token, 'Content-type: application/json']);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $profilePicture = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        // Profile picture found, store it in the session variable
        $_SESSION['profile_picture'] = $profilePicture;
    } else {
        // Profile picture not found, use a default picture
        $_SESSION['profile_picture'] = file_get_contents('./img/nobody.png');
    }
}

function connectToDatabase($sqlitedbname) {
    $db = new SQLite3($sqlitedbname);
    if (!$db) {
        die("Database connection failed.");
    }
    return $db;
}


function logUserAction($logFilePath, $username, $action) {

    // Get the current date and time
    $dateTime = date('Y-m-d H:i:s');

    // Create the log entry in the specified format
    $logEntry = "$dateTime;$username;$action" . PHP_EOL;

    // Append the log entry to the file
    file_put_contents($logFilePath, $logEntry, FILE_APPEND | LOCK_EX);
}


?>