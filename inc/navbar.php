<table border="0" align="center" width="80%" style="background-color: white; border-radius: 20px; box-shadow: 0px 0px 5px  rgba(0, 0, 0, 0.5);"> 
    <tr>
    <td style="padding: 5px;">  
      <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="index.php">
                    <img
                    src="./img/lsa.png"
                    height="80"
                    alt="LSA Logo"
                    loading="lazy"
                    />
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="Logs.php">Logs</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="HowTo.php">How To</a>
                    </li>
                <!--         <li class="nav-item">
                    <a class="nav-link disabled" href="#">Logs</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" href="#">Manage</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="testpage.php">TestPage</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="sessioncreds.php">Session Creds</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="allusers.php">All Users</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="adminsonly.php">Admin Only</a>
                    </li> -->
                </ul>
                <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">
                <!-- Icon -->
                <a href="me.php">
                <?php 
                    echo $_SESSION['displayName'];
                ?>
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <form action="inc/logout.php" method="POST">
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>

                </div>
            </div>
            <!-- Container wrapper -->
            </nav>
            <hr>