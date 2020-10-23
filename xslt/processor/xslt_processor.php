<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dir = dirname(__DIR__) . '/notices';

$files = scandir($dir, SCANDIR_SORT_ASCENDING);

$xslDoc = new DOMDocument();
$xslDoc->load(dirname(__DIR__) . '/xslt_notices.xsl');

$xslProcessor = new XSLTProcessor();
$xslProcessor->importStylesheet($xslDoc);

foreach(array_slice($files, 2) as $file) {
    $domDoc = new DOMDocument();
    $domDoc->load($dir.'/'.$file);
    
    $fileHandle = fopen(dirname(__DIR__) . '/refined_output/'.$file, 'w+');
    fwrite($fileHandle, $xslProcessor->transformToXml($domDoc));
    fclose($fileHandle);
}