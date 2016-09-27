<?php
$url = $_SERVER['REQUEST_URI'];
if (strpos($url,'upload/')) {
    $filename = substr($url,strpos($url,'upload/')+7);
    echo $filename;
    echo '<hr>';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file = $_FILES['sample'];
        include './Upload.class.php';
        $res = Upload::singleUpload($file);
        var_dump( $res );
    }
}
