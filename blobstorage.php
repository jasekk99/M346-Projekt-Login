<?php
# Setup a specific instance of an Azure::Storage::Client
$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('account_name').";AccountKey=".getenv('account_key');

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

# Create the BlobService that represents the Blob service for the storage account
$createContainerOptions = new CreateContainerOptions();

$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Set container metadata.
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");

$containerName = "blockblobs".generateRandomString();

try {
    // Create container.
    $blobClient->createContainer($containerName, $createContainerOptions);
}
catch (Exception $e){
    echo "idk something went wrong";
}

$myfile = fopen("HelloWorld.txt", "w") or die("Unable to open file!");
fclose($myfile);

# Upload file as a block blob
echo "Uploading BlockBlob: ".PHP_EOL;
echo $fileToUpload;
echo "<br />";

$content = fopen($fileToUpload, "r");

//Upload blob
$blobClient->createBlockBlob($containerName, $fileToUpload, $content);

$listBlobsOptions = new ListBlobsOptions();
$listBlobsOptions->setPrefix("HelloWorld");

echo "These are the blobs present in the container: ";

do{
    $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
    foreach ($result->getBlobs() as $blob)
    {
        echo $blob->getName().": ".$blob->getUrl()."<br />";
    }

    $listBlobsOptions->setContinuationToken($result->getContinuationToken());
} while($result->getContinuationToken());

$blob = $blobClient->getBlob($containerName, $fileToUpload);
    fpassthru($blob->getContentStream());


function delete_blob(){
        // Delete blob.
        echo "Deleting Blob".PHP_EOL;
        echo $fileToUpload;
        echo "<br />";
        $blobClient->deleteBlob($_GET["containerName"], $fileToUpload);
    
        // Delete container.
        echo "Deleting Container".PHP_EOL;
        echo $_GET["containerName"].PHP_EOL;
        echo "<br />";
        $blobClient->deleteContainer($_GET["containerName"]);
    
        //Deleting local file
        echo "Deleting file".PHP_EOL;
        echo "<br />";
        unlink($fileToUpload);   
}

if(array_key_exists('button2', $_POST)) {
    delete_blob();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="submit" name="button2" class="button" value="Clean up" />
    </form>
</body>
</html>