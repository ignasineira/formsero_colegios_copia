<?php

function endsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}

$files = scandir('CSVs');

$zip = new ZipArchive();
$zip_name = "data.zip"; // Zip name
$zip->open($zip_name,  ZipArchive::CREATE);
foreach ($files as $file) {
    if (endsWith($file,'All.csv')){
        $path = "CSVs/".$file;
        if(file_exists($path)){
            $zip->addFromString(basename($path),  file_get_contents($path));
        }
    }
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zip_name);
header('Content-Length: ' . filesize($zip_name));
readfile($zip_name);

?>