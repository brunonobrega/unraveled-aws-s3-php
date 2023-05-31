<?php

require 'vendor/autoload.php';

// load env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// The same options that can be provided to a specific client constructor can also be supplied to the Aws\Sdk class.
// Use the us-west-2 region and latest version of each client.
$sharedConfig = [
    'region' => $_ENV['S3_REGION'],
    'version' => 'latest',
    'credentials' => [
        'key'    => $_ENV['AWS_KEY'],
        'secret' => $_ENV['AWS_SECRET'],
        // 'token'  => $result['Credentials']['SessionToken']
    ]
];
// Create an SDK class used to share configuration across clients.
$sdk = new Aws\Sdk($sharedConfig);
// Create an Amazon S3 client using the shared configuration data.
$s3client = $sdk->createS3();

$bucket_name = $_ENV['S3_BUCKET'];

// List Objects
list_objects($s3client, $bucket_name);

// Get Object
$object_key = "Screenshot 2023-03-19 200802.png";
get_object($s3client, $bucket_name, $object_key);

// Put Objects
$file_path = 'images/rocket.png';
put_object($s3client, $bucket_name, $file_path);


function list_objects($s3client, $bucket_name) {
    try {
    
        $contents = $s3client->listObjects([
            'Bucket' => $bucket_name,
        ]);
    
        echo "The contents of your bucket are: \n";
        foreach ($contents['Contents'] as $content) {
            echo $content['Key'] . "\n";
        }
    
    } catch (Exception $exception) {
        echo "Failed to list objects in $bucket_name with error: " . $exception->getMessage();
        exit("Please fix error with listing objects before continuing.");
    }
} 

function get_object($s3client, $bucket_name, $object_key) {
    try {
    
        $contents = $s3client->getObject([
            'Bucket' => $bucket_name,
            'Key' => $object_key,
        ]);
    
        echo "Content Type: \n";
        echo $contents['ContentType'];

        echo "\n | \n";

        echo "Last Modified: \n";
        echo $contents['LastModified'];
        
    } catch (Exception $exception) {
        echo "Failed to list objects in $bucket_name with error: " . $exception->getMessage();
        exit("Please fix error with listing objects before continuing.");
    }
}

function put_object($s3client, $bucket_name, $file_path) {
    try {
    
        $contents = $s3client->putObject([
            'Bucket' => $bucket_name,
            'SourceFile' => $file_path,
            'Key'        => 'uploads/' . basename($file_path)
        ]);

        echo "Success on upload object";

    } catch (Exception $exception) {
        echo "Failed to list objects in $bucket_name with error: " . $exception->getMessage();
        exit("Please fix error with listing objects before continuing.");
    }
}