<?php
// Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

require_once __DIR__ . '/../../vendor/autoload.php';

use \GlauberPortella\pCloud\Json\DigestAuth;
use \GlauberPortella\pCloud\Json\UploadFile;

if (PHP_SAPI != "cli") {
    fwrite(STDERR, "\nThis script must be run from command line.\n");
    exit(1);
}

if ($argc < 5) {
    die("\nUse: php uploadfile.php --email=<user email> --pass=<user password> --folder=<folder path> file\n");
}

// input params from commandline
$email = preg_replace('/--email=/i', '', $argv[1]);
$pass = preg_replace('/--pass=/i', '', $argv[2]);
$folder = preg_replace('/--folder=/i', '', $argv[3]);
$filePath = $argv[4];

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

echo "\nFile: '$filePath' uploaded.\n";
exit(0);
