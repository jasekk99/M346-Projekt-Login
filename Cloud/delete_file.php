<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location: ../login.php');
}
require_once "../vendor/autoload.php"; 
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Blob\Models\Block;



$user=$_SESSION['username'];
$blob=$_GET['blob'];
$accountName = "cloudfiles346";
$accountKey = "s2AVwbX9uKNahDSY8mRWtXwEjD74aQ3MhFLburU3KNC04p6GlOVrijB2+TG4f+lMasfhXg1Y9mo5+ASt+g8L/w==";
$connectionString = "DefaultEndpointsProtocol=https;AccountName=$accountName;AccountKey=$accountKey";
$blobClient = BlobRestProxy::createBlobService($connectionString);

$containerName = strtolower($user."blobcontainer");



//$connectionString = $_SESSION['connectionString'];
//$blobClient = BlobRestProxy::createBlobService($connectionString);
//$container = $_SESSION['containerName'];
//$blob = $_SESSION['blob'];

echo $connectionString;
echo " |||| ";
echo $containerName;
echo " |||| ";
echo $blob;

$cloudStorageHome="AzureBlobStorage.php?user=".$user;


//$result = $blobClient->acquireLease($containerName, $blob);
//$blobOptions = new DeleteBlobOptions();
//$blobOptions->setLeaseId($result->getLeaseId());
$blobClient->deleteBlob($containerName, $blob);
echo "code was run but nothing happened i guess???";
$run=true;
echo "!!!!!!!!OMG IT ACTUALLY RAN!!!!!!";
sleep(5);
header('Location: '.$cloudStorageHome);
?>