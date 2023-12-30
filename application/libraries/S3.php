<?php
//require_once  'aws/aws-autoloader.php';
require_once  (APPPATH . 'vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

     
    // Instantiate an Amazon S3 client.
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'ap-south-1',
        'credentials' => [
            'key'    => 'AKIAJGEECF7VBXN3PWUA',
            'secret' => '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'
        ]
    ]);
     
    
         
        $bucketName = 'jigarstudio.in';
        $file_Path = '/public_html/images/gp1.jpg';
        $key = basename($file_Path);

        // Upload a publicly accessible file. The file size and type are determined by the SDK.
        try {
            $result = $s3->putObject([
                'Bucket' => $bucketName,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read',
            ]);
            echo $result->get('ObjectURL');
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
            echo $e->getMessage();
        }
    