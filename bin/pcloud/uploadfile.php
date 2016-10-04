<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \GlauberPortella\pCloud\Json\DigestAuth;
use \GlauberPortella\pCloud\Json\UploadFile;

if (PHP_SAPI != "cli") {
    exit;
}

if ($argc < 5) {
    die("\nUse: php uploadfile.php --email=<user email> --pass=<user password> --folder=<folder path> file\n");
}

// input params from commandline
$email = preg_replace('/--email=/i', '', $args[1]);
$pass = preg_replace('/--pass=/i', '', $args[2]);
$folder = preg_replace('/--folder=/i', '', $args[3]);
$filePath = $args[4];

try {
    // digest auth
    $digestAuth = new DigestAuth($email, $pass);
    $token = $digestAuth->getToken();

    $upload = new UploadFile($token);
    $upload->put($filePath, array(
        'path' => $folder
    ));
} catch (\Exception $e) {
    fwrite(STDERR, $e->getMessage());
    exit(1);
}
