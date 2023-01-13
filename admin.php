<?php
session_start();
include "dbconnector.inc.php";

// Check user login or not
if(!isset($_SESSION[$_GET['user']])){
    header('Location: login.php?fromFail=true');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: login.php');
}

$user = $_GET['user'];
$error = '';

if(isset($_POST['DeleteAccount'])){
    // query
    $query = "DELETE FROM users WHERE username = ?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if($stmt===false){
        $error .= 'prepare() failed '. $mysqli->error . '<br />';
    }
    if(!$stmt->bind_param("s", $user)){
		$error .= 'bind_param() failed '. $mysqli->error . '<br />';
    }
    // query ausführen
    if(!$stmt->execute()){
        $error .= 'execute() failed '. $mysqli->error . '<br />';
    }
    if(empty($error)){
        $mysqli->close();
    }
    session_destroy();
    header('Location: login.php');
}
    
echo $error;
?>
<!doctype html>
    <title> Adminbereich - <?php echo $user; ?> </title>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/TextPlugin.min.js"></script>
        <style>
            .profilePicture{
                width: 50px;
            }
            .profilePictureNav{
                width: 40px;
                height: 40px;
            }
            .adminACCinf::before{
                content:'Admin';
                color: red;
            }
            #time{
                margin: 80px    
            }
        </style>
    </head>
    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Projekt Modul 346</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="./Cloud/AzureBlobStorage.php?user=<?php echo $user ?>">Cloud-Storage</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item active" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="./LoggedIn/editProfile.php?user=<?php echo $user ?>">Edit</a></li>
                            </ul>
                        </li>
                        <a href="#">
                            <img class="profilePictureNav" src=
                                <?php
                                    if(file_exists("./img/".$user.".jpg")){
                                        echo "./img/".$user.".jpg"; 
                                    }
                                    else{
                                        echo "./img/default.jpg";
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
            <?php 
            error_reporting(0);
            if ($_GET['fromLogin'] == "true"){
                echo "<div class='alert alert-info alert-dismissible fade show' role='alert' style='margin-left: 300px; margin-right: 300px;'>
                        Welcome back <strong> ".$user."!</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
            }
            error_reporting(1);
            ?>
            <h1 class="h1">
                Logged in as <?php echo $user; ?>
                <img class="profilePicture" src=
                <?php
                    if(file_exists("./img/".$user.".jpg")){
                        echo "./img/".$user.".jpg"; 
                    }
                    else{
                        echo "./img/default.jpg";
                    }
                ?>>
                </img>
            </h1>
            <?php
                if($user == "Jasekk"){
                    echo "  <div>
                                <h2 class='adminACCinf'>
                                    account
                                </h2>
                            </div>";
                }
            ?>
            <div class="container">
                <div class="btn-group">
                    <form method='post' action="">
                        <button type="submit" value="Logout" name="but_logout" class="btn btn-warning">Log out</button>
                        <button type="submit" name="DeleteAccount" class="btn btn-danger DeleteAccount">Delete account &#128465;</button>
                        <?php if ($user == "Jasekk"){echo '
                        <button class="btn btn-primary dropdown-toggle AdminAccButton" data-bs-toggle="dropdown" aria-expanded="false">Admin controls &#128295;</button>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./LoggedIn/editProfile.php?user='.$user.'">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item localFolderBtn" href="#">Open local folder</a></li>
                        <li><a class="dropdown-item" href="#">Control panel</a></li>
                        </ul>
                        ';} ?>
                    </form>
                </div>
                <h1 id="time"></h1>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script>
            setInterval(function(){
            document.getElementById("time").innerHTML = (new Date()).toLocaleTimeString();
            }, 1000);
        </script>
    </body>
</html>