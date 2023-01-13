<?php
session_start();
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

require_once "../vendor/autoload.php"; 
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Blob\Models\Block;

$user = $_GET['user'];

$accountName = "cloudfiles346";
$accountKey = "s2AVwbX9uKNahDSY8mRWtXwEjD74aQ3MhFLburU3KNC04p6GlOVrijB2+TG4f+lMasfhXg1Y9mo5+ASt+g8L/w==";
$containerName = strtolower($user."blobcontainer");

$connectionString = "DefaultEndpointsProtocol=https;AccountName=$accountName;AccountKey=$accountKey";
$blobClient = BlobRestProxy::createBlobService($connectionString);

$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("");

function iconDecision($filetype) {
    global $fileIcon;
    switch($filetype) {
        case 'txt':
            $fileIcon = '../img/txt_OneDrive_icon.png';
            break;
        case 'exe':
            $fileIcon = '../img/exe-icon.png';
            break;
        case 'vss':
            $fileIcon = '../img/vss_icon.png';
            break;
        case 'png' || 'svg' || 'jpeg' || 'jpg' || 'gif':
            $fileIcon = '../img/image.png';
            break;
        default:
            $fileIcon = '../img/question_mark.png';
    }
}



/*function endsWith( $str, $sub ) {
    return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
}

foreach($list->getFiles() as &$file) {
    $fileName = $file->getName();
    if(endsWith($fileName, ".pdf")) {
        echo $fileName."\n";
    }
};*/
?>

<!doctype html>
    <title> Cloud-Storage - <?php echo $user; ?> </title>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/TextPlugin.min.js"></script>
        <style>
            footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                text-align: center;
            }

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

            .files{
                width: 1000px;
                margin: auto;
            }

            #time{
                margin: 80px    
            }

            .grid-container {
                display: inline-grid;
                grid-template-columns: auto auto auto;
                padding: 20px;
                text-align: center;
                word-wrap: break-word;
            }
            
            .grid-item{
                padding: 20px;
                height: 171px;
                width: 176px;
                transition: 0.25s;
            }

            .grid-item:hover{
                background-color: #f3f2f1;
                
            }

            .upload-container{
                text-align: center;
            }

            .upload-button-icon{
                width: 20px;
                margin-left: 10px
            }

            .deleteLink{
                background: red;
                width: 50px;
                height: 20px;
            }

            a{
                text-decoration:none;
            }

        </style>
    </head>
    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../admin.php?user=<?php $user ?>">Projekt Modul 346</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
    <form action='' method='post' enctype='multipart/form-data'>
                    <input type='submit' value='Delete' name='Delete_File' class='btn btn-danger'>
                </form>
        <br>
        <div class="upload-container">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="file" class="btn btn-primary">
                <input type="submit" value="Upload File" name="submit" class="btn btn-success">
            </form>
        </div>
        <div class="files">
            <div class='grid-container'>
        <?php
        do{
            $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob)
            {

                echo "<div class='grid-item'><a href='".$blob->getUrl()."'>";
                iconDecision(array_pop(explode('.', $blob->getName())));
                echo "<img src='".$fileIcon."' width=50px height=50px' class='justify-content-center'></img><br />";
                echo $blob->getName()."<br />";
                $blob = $blob->getName();
                echo "</a>
                <a class='btn btn-danger' href='delete_file.php?user=".$user."&blob=".$blob."'></a>
                </div>";
            }
            //echo "<input type='submit' href='delete_file.php?connectionString=".$connectionString."&container=".$container."&blob=".$blob."&' class='deleteLink'>";
            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());
        
        ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <?php
            if (isset($_POST['submit'])) {
                echo "yo";
                $uploadOk = 1;
                

                echo $_FILES["file"]["name"];
                
                define('KB', 1024);
                define('MB', 1048576);
                define('GB', 1073741824);
                define('TB', 1099511627776);
                // Check file size
                if ($_FILES["file"]["size"] > 500*MB) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } 

                //!AZURE UPLOAD!//
                // name of the uploaded file
                $azure_targetfile = $_FILES['file']['name'];
                // the physical file on a temporary uploads directory on the server
                $file = $_FILES['file']['tmp_name'];
                //echo $file;
                $size = $_FILES['file']['size'];
                $blobClient = BlobRestProxy::createBlobService($connectionString);
                $content = fopen($file, "r"); 
                //Upload blob
                $blobClient->createBlockBlob($containerName, $azure_targetfile, $content);
                if ($uploadOk == 1){
                    echo "File uploaded to Azure Blob successfully";
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                }
                ?>
        <footer>
            
                <?php
                    $i=0;
                    foreach ($result->getBlobs() as $blob){
                        $i++;
                    }
                    echo "Number of Files: ".$i;
                ?>
            
        </footer>
    </body>
</html>