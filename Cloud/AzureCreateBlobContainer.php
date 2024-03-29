<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location: ../login.php?fromFail=true');
}
/**----------------------------------------------------------------------------------
* Microsoft Developer & Platform Evangelism
*
* Copyright (c) Microsoft Corporation. All rights reserved.
*
* THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND, 
* EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES 
* OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
*----------------------------------------------------------------------------------
* The example companies, organizations, products, domain names,
* e-mail addresses, logos, people, places, and events depicted
* herein are fictitious.  No association with any real company,
* organization, product, domain name, email address, logo, person,
* places, or events is intended or should be inferred.
*----------------------------------------------------------------------------------
**/

/** -------------------------------------------------------------
 *Azure Storage Blob Sample - Demonstrate how to use the Blob Storage service. 
 *Blob storage stores unstructured data such as text, binary data, documents or media files. 
 *Blobs can be accessed from anywhere in the world via HTTP or HTTPS. 

 *Documentation References: 
  *- Associated Article - https://docs.microsoft.com/en-us/azure/storage/blobs/storage-quickstart-blobs-php 
  *- What is a Storage Account - http://azure.microsoft.com/en-us/documentation/articles/storage-whatis-account/ 
  *- Getting Started with Blobs - https://azure.microsoft.com/en-us/documentation/articles/storage-php-how-to-use-blobs/
  *- Blob Service Concepts - http://msdn.microsoft.com/en-us/library/dd179376.aspx 
  *- Blob Service REST API - http://msdn.microsoft.com/en-us/library/dd135733.aspx 
  *- Blob Service PHP API - https://github.com/Azure/azure-storage-php

  *- Storage Emulator - http://azure.microsoft.com/en-us/documentation/articles/storage-use-emulator/ 

**/

require_once '../vendor/autoload.php';
/*require_once "./random_string.php";*/

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

/*$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');*/
$connectionString = "DefaultEndpointsProtocol=https;AccountName=cloudfiles346;AccountKey=s2AVwbX9uKNahDSY8mRWtXwEjD74aQ3MhFLburU3KNC04p6GlOVrijB2+TG4f+lMasfhXg1Y9mo5+ASt+g8L/w==";

//Get user from URL
$user = $_SESSION['username'];

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

    // Create container options object.
    $createContainerOptions = new CreateContainerOptions();

    // Set public access policy. Possible values are
    // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
    // CONTAINER_AND_BLOBS:
    // Specifies full public read access for container and blob data.
    // proxys can enumerate blobs within the container via anonymous
    // request, but cannot enumerate containers within the storage account.
    //
    // BLOBS_ONLY:
    // Specifies public read access for blobs. Blob data within this
    // container can be read via anonymous request, but container data is not
    // available. proxys cannot enumerate blobs within the container via
    // anonymous request.
    // If this value is not specified in the request, container data is
    // private to the account owner.
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

    // Set container metadata.
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");

      $containerName = strtolower($user."blobcontainer");

        // Create container.
        $blobClient->createContainer($containerName, $createContainerOptions);
        $_SESSION['ContainerCreated'] = "true";
        echo "Please wait... Creating storage container... (10 seconds)";
        sleep(10);
        // Getting local file so that we can upload it to Azure
        header('Location: AzureBlobStorage.php');