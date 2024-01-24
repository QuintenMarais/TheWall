<?php

// Start a session
session_start();
include('inc/config.conf');
include('inc/functions.php');

// Check if the user is authenticated
if (isset($_SESSION['msatg'])) {

    // Redirect to the dashboard if the user is authenticated
    header('Location: dashboard.php');
    exit;
} else {
    include('inc/header.html');
    ?>
    
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-5">
                            <img src="./img/Logicalis_Datatec_logo_CMYK.jpg" alt="Your Logo" class="img-fluid">
                        </div>
                        <form>
                            <div class="d-grid">
                                <a href="?action=login" class="btn btn-primary btn-login text-uppercase fw-bold">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
include('inc/footer.html'); 
}

// Handle the login action
if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $params = [
        'client_id' => $appid,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'token',
        'scope' => 'https://graph.microsoft.com/User.Read',
        'state' => $_SESSION['state']
    ];

    // Redirect the user to Microsoft login
    header('Location: ' . $login_url . '?' . http_build_query($params));
}

// JavaScript to handle URL hash fragment
echo '
<script>
    url = window.location.href;
    i = url.indexOf("#");
    if (i > 0) {
        url = url.replace("#", "?");
        window.location.href = url;
    }
</script>
';

// Check if an access token is in the URL
if (isset($_GET['access_token'])) {
    $_SESSION['t'] = $_GET['access_token'];
    $t = $_SESSION['t'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $t, 'Content-type: application/json']);
    curl_setopt($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch), true);

    if (array_key_exists('error', $response)) {
        var_dump($response['error']);
        die();
    } else {
        $_SESSION['msatg'] = 1;  // Authenticated and verified
        $_SESSION['id'] = $response["id"];

        $user_info = fetchUserInfo($_SESSION['t']); // Fetch all the users details and store in Session 

        $_SESSION['displayName']  = $user_info['displayName'];
        $_SESSION['givenName']  = $user_info['givenName'];
        $_SESSION['jobTitle']  = $user_info['jobTitle'];
        $_SESSION['mail']  = $user_info['mail'];
        $_SESSION['mobilePhone']  = $user_info['mobilePhone'];
        $_SESSION['officeLocation']  = $user_info['officeLocation'];
        $_SESSION['surname']  = $user_info['surname'];
        $_SESSION['userPrincipalName']  = $user_info['userPrincipalName'];

        $user_groups = fetchUserGroups($_SESSION['t']);
        $_SESSION['user_groups'] = $user_groups;

        //fetchUserProfilePicture($access_token); // Fetches image and stores it as  $_SESSION['profile_picture']

    }

    curl_close($ch);
    // Log the Login
    logUserAction($logFilePath, $_SESSION['userPrincipalName'], "Login Succesfull");
    // Redirect to the dashboard after successful login
    header("Location: $SuccessRedirect");
}

// Handle the logout action
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Log the Logoff
    logUserAction($logFilePath, $_SESSION['userPrincipalName'], "Logout Succesfull");
    unset($_SESSION['msatg']);
    // Redirect to the logout page
    header("Location: $Logout_uri");
    exit();
}
?>
