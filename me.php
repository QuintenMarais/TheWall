<?php
session_start();
include('inc/config.conf');
include('inc/functions.php');

if (!isset($_SESSION['msatg'])) {
    header('Location: index.php'); // Redirect to the login page if not authenticated
    exit;
}

include('inc/header.html');
include('inc/navbar.php');
?>
<div class="container-lg custom-container">
<h1> My Details </h1>
<div class="container">
    <table width=500>
        <tr>
            <td>
<table class="table  table-auto table-striped">
        <tr>
            <th>Attribute</th>
            <th></th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Display Name</td>
            <th> : </th>
            <td><?php echo $_SESSION['displayName']; ?></td>
        </tr>
        <tr>
            <td>Given Name</td>
            <th> : </th>
            <td><?php echo $_SESSION['givenName']; ?></td>
        </tr>
        <tr>
            <td>Surname</td>
            <th> : </th>
            <td><?php echo $_SESSION['surname']; ?></td>
        </tr>
        <tr>
            <td>Job Title</td>
            <th> : </th>
            <td><?php echo $_SESSION['jobTitle']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <th> : </th>
            <td><?php echo $_SESSION['mail']; ?></td>
        </tr>
        <tr>
            <td>Mobile Phone</td>
            <th> : </th>
            <td><?php echo $_SESSION['mobilePhone']; ?></td>
        </tr>
        <tr>
            <td>Office Location</td>
            <th> : </th>
            <td><?php echo $_SESSION['officeLocation']; ?></td>
        </tr>
        <tr>
            <td>User Principal Name</td>
            <th> : </th>
            <td><?php echo $_SESSION['userPrincipalName']; ?></td>
        </tr>
    </table>
</td>
</tr>
</table>
</div>


</div>
<?php include('inc/footer.html');?>



