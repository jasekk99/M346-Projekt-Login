<?php
require_once "../vendor/autoload.php"; 
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Blob\Models\Block;

$connectionString=$_GET['connectionString'];
$blobClient = BlobRestProxy::createBlobService($connectionString);
$containerName=$_GET['containerName'];
$blob=$_GET['blob'];
$filename=$_GET['filename'];

//$connectionString = $_SESSION['connectionString'];
//$blobClient = BlobRestProxy::createBlobService($connectionString);
//$container = $_SESSION['containerName'];
//$blob = $_SESSION['blob'];

echo $connectionString;
echo " |||| ";
echo $containerName;
echo " |||| ";
echo $blob;

$cloudStorageHome="AzureBlobStorage.php";


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