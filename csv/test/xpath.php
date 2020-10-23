<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$domDoc = new DOMDocument();

$domDoc->load(dirname(dirname(__DIR__)) . '/xslt/refined_output/notices_2011_01.xml');

$xPath = new DOMXpath($domDoc);

$nodeList = $xPath->evaluate('/notices/contract');

print $nodeList->item(0)->nodeName;