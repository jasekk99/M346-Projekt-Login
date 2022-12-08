<?php
session_start();
include "../dbconnector.inc.php";

// Check user login or not
if(!isset($_SESSION[$_GET['user']])){
    header('Location: ../login.php');
}

$user = $_GET['user'];
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['clickbutton'])){
            $query = "UPDATE users SET clicks = clicks + 1 WHERE username = ?";
            $stmt = $mysqli->prepare($query);
                // query vorbereiten
                if($stmt===false){
                    $error .= 'prepare() failed '. $mysqli->error . '<br />';
                }
                // parameter an query binden
                if(!$stmt->bind_param("s", $user)){
                    $error .= 'bind_param() failed '. $mysqli->error . '<br />';
                }
                // query ausführen
                if(!$stmt->execute()){
                    $error .= 'execute() failed '. $mysqli->error . '<br />';
                }
        }
}
?>
<!doctype html>
    <title> Control Panel - <?php echo $user ?> </title>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/TextPlugin.min.js"></script>
            <style>
                .profilePictureNav{
                    width: 40px;
                    height: 40px;
                }
            </style>
        </head>
    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">jackgreen.ch</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Clicker</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Projekte</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../admin.php?user=<?php echo $user ?>">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item active" href="#">Edit</a></li>
                            </ul>
                        </li>
                    <a href="../admin.php?user=<?php echo $user; ?>">
                            <img class="profilePictureNav" src=
                                <?php
                                    if(file_exists("../img/".$user.".jpg")){
                                        echo "../img/".$user.".jpg";
                                    }
                                    else{
                                        echo "../img/default.jpg";
                                    }
                                ?>>
                            </img>
                        </a>
                    </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
        </nav>
    <!-- Navbar End -->
    </header>
    <body>
        <div class="text-center" style="margin: 50px;">
            <h1 class="h1">Click Counter</h1>
            <form action="" method="post">
                <button type="submit" name="clickbutton" value="click" class="btn btn-success" style="padding: 30px 80px; font-size:20px; margin: 15px;">Click!</button>
            </form>
            <p>Clicks: <?php
                    $stmt = $mysqli->prepare("SELECT clicks FROM users WHERE username = ?");
                    $stmt->bind_param('s', $user);
                    $stmt->execute();
                    $stmt->bind_result($clicks);
                    $stmt->fetch();
                    $stmt->close();
                    echo $clicks;
            ?></p>
        </div>
    </body>