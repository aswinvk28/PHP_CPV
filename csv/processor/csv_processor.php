<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$noticesDIR = dirname(dirname(__DIR__)) . '/xslt/refined_output';
$outputDIR = dirname(__DIR__) . '/output_test';

$files = scandir($noticesDIR, SCANDIR_SORT_ASCENDING);

$xmlDoc = new DOMDocument();

// Build the Header Array
// Create Array
// Load the File
// Map the XML elements for each file
// Build CSV array

$header = array('id', 'contract_type', 'cpv_main', 'cpv_add', 'budget_min', 'budget_max', 'estimate', 'contract_award_date', 'date_start', 'date_end', 
    'duration', 'deadline', 'delivery_location', 'notice_id', 'parent_notice_id', 'root_notice_id', 'notice_group', 'notice_type', 'notice_type_friendly_name',
    'notice_state', 'system_notice_state', 'published_date', 'changed_date', 'buyer_group_id', 'buyer_group_name');

$header_short = array('id', 'contract_type', 'cpv_main', 'cpv_add', 'budget_min', 'budget_max', 'estimate', 'contract_award_date', 'date_start', 'date_end', 
    'duration', 'deadline', 'notice_id', 'parent_notice_id', 'root_notice_id', 'buyer_group_id', 'buyer_group_name');

function main_code($xPath, &$body, $contractNode) {
    $maincode = $xPath->evaluate('maincode/code', $contractNode);
    $main = array('NULL');
    if(!empty($maincode->length)) {
        for($j = 0; $j < $maincode->length; $j++) {
            $main[$j] = $maincode->item($j)->nodeValue;
        }
    }
    array_push($body, implode('|', $main));
}

function add_code($xPath, &$body, $contractNode) {
    $addcode = $xPath->evaluate('addcode/code', $contractNode);
    $add = array('NULL');
    if(!empty($addcode->length)) {
        for($j = 0; $j < $addcode->length; $j++) {
            $add[$j] = $addcode->item($j)->nodeValue;
        }
    }
    array_push($body, implode('|', $add));
}

function budget_min($xPath, &$body, $contractNode) {
    $budget_min = $xPath->evaluate('budget/min', $contractNode);
    $min_budget = !empty($budget_min->length) ? $budget_min->item(0)->nodeValue: 'NULL';
    array_push($body, $min_budget);
}

function budget_max($xPath, &$body, $contractNode) {
    $budget_max = $xPath->evaluate('budget/max', $contractNode);
    $max_budget = !empty($budget_max->length) ? $budget_max->item(0)->nodeValue: 'NULL';
    array_push($body, $max_budget);
}

function estimate($xPath, &$body, $contractNode) {
    $estimate = $xPath->evaluate('estimate', $contractNode);
    $tender_estimate = array('NULL');
    if(!empty($estimate->length)) {
        for($j = 0; $j < $estimate->length; $j++) {
            $tender_estimate[$j] = $estimate->item($j)->nodeValue;
        }
    }
    array_push($body, implode('|', $tender_estimate));
}

function contract_award_date($xPath, &$body, $contractNode) {
    $contract_date = $xPath->evaluate('contract_award_date', $contractNode);
    if(!empty($contract_date->length)) {
        $contract_date_award = !empty($contract_date->item(0)->nodeValue) ? $contract_date->item(0)->nodeValue : 'NULL';
        array_push($body, $contract_date_award);
    } else {
        array_push($body, 'NULL');
    }
}

function date_start($xPath, &$body, $contractNode) {
    $date_start = $xPath->evaluate('date/start', $contractNode);
    if(!empty($date_start->length)) {
        $date_start_date = !empty($date_start->item(0)->nodeValue) ? $date_start->item(0)->nodeValue : 'NULL';
        array_push($body, $date_start_date);
    } else {
        array_push($body, 'NULL');
    }
}

function date_end($xPath, &$body, $contractNode) {
    $date_start = $xPath->evaluate('date/end', $contractNode);
    if(!empty($date_start->length)) {
        $date_start_date = !empty($date_start->item(0)->nodeValue) ? $date_start->item(0)->nodeValue : 'NULL';
        array_push($body, $date_start_date);
    } else {
        array_push($body, 'NULL');
    }
}

function duration($xPath, &$body, $contractNode) {
    $duration_year = $xPath->evaluate('duration/year', $contractNode);
    $duration_months = $xPath->evaluate('duration/months', $contractNode);
    $duration_days = $xPath->evaluate('duration/days', $contractNode);
    $sum = 'NULL';
    if(!empty($duration_year->length) && !empty($duration_months->length) && !empty($duration_days->length)) {
        $sum = (int) $duration_year->item(0)->nodeValue;
    }
    if(!empty($duration_months->length)) {
        $sum += (int) $duration_months->item(0)->nodeValue;
    }
    if(!empty($duration_days->length)) {
        $sum += (int) $duration_days->item(0)->nodeValue;
    }
    array_push($body, $sum);
}

function deadline($xPath, &$body, $contractNode) {
    $deadline = $xPath->evaluate('deadline', $contractNode);
    
    if(!empty($deadline->length)) {
        $deadline_date = !empty($deadline->item(0)->nodeValue) ? $deadline->item(0)->nodeValue : 'NULL';
        array_push($body, $deadline_date);
    } else {
        array_push($body, 'NULL');
    }
}

function buyer_group_id($xPath, &$body, $contractNode) {
    $buyer_group_id = $xPath->evaluate('system/buyer_group_id', $contractNode);
    
    if(!empty($buyer_group_id->length)) {
        $buyer_group = !empty($buyer_group_id->item(0)->nodeValue) ? $buyer_group_id->item(0)->nodeValue : 'NULL';
        array_push($body, $buyer_group);
    } else {
        array_push($body, 'NULL');
    }
}

function buyer_group_name($xPath, &$body, $contractNode) {
    $buyer_group_name = $xPath->evaluate('system/buyer_group_name', $contractNode);
    
    if(!empty($buyer_group_name->length)) {
        $buyer_group = !empty($buyer_group_name->item(0)->nodeValue) ? $buyer_group_name->item(0)->nodeValue : 'NULL';
        array_push($body, $buyer_group);
    } else {
        array_push($body, 'NULL');
    }
}

function notice_id($xPath, &$body, $contractNode) {
    $notice_id = $xPath->evaluate('system/notice_id', $contractNode);
    
    if(!empty($notice_id->length)) {
        $notice = !empty($notice_id->item(0)->nodeValue) ? $notice_id->item(0)->nodeValue : 'NULL';
        array_push($body, $notice);
    } else {
        array_push($body, 'NULL');
    }
}

function parent_notice_id($xPath, &$body, $contractNode) {
    $parent_notice_id = $xPath->evaluate('system/parent_notice_id', $contractNode);
    
    if(!empty($parent_notice_id->length)) {
        $notice = !empty($parent_notice_id->item(0)->nodeValue) ? $parent_notice_id->item(0)->nodeValue : 'NULL';
        array_push($body, $notice);
    } else {
        array_push($body, 'NULL');
    }
}

function root_notice_id($xPath, &$body, $contractNode) {
    $root_notice_id = $xPath->evaluate('system/root_notice_id', $contractNode);
    
    if(!empty($root_notice_id->length)) {
        $notice = !empty($root_notice_id->item(0)->nodeValue) ? $root_notice_id->item(0)->nodeValue : 'NULL';
        array_push($body, $notice);
    } else {
        array_push($body, 'NULL');
    }
}

function persist_csv($file, $body, $header) {
    $fileHandle = fopen($file, 'w+');
    fwrite($fileHandle, implode("~~~", $header)."\n");
    foreach($body as $i => $item) {
        fwrite($fileHandle, $i."~~~".implode("~~~", $item)."\n");
    }
    fclose($fileHandle);
}

function call_function_contract(&$body, $xPath, $contract_type) {
    $contract = $xPath->evaluate('/notices/'.$contract_type);
    
    print "\n".$contract->length."\n";
    
    $i = 0;
    $length = count($body);
    while($i < $contract->length) {
        $body[$length + $i] = array();
        $contractNode = $contract->item($i);
        $node = $xPath->evaluate('@type', $contractNode);
        array_push($body[$length + $i], $node->item(0)->nodeValue);
        
        main_code($xPath, $body[$length + $i], $contractNode);
        add_code($xPath, $body[$length + $i], $contractNode);
        budget_min($xPath, $body[$length + $i], $contractNode);
        budget_max($xPath, $body[$length + $i], $contractNode);
        estimate($xPath, $body[$length + $i], $contractNode);
        contract_award_date($xPath, $body[$length + $i], $contractNode);
        date_start($xPath, $body[$length + $i], $contractNode);
        date_end($xPath, $body[$length + $i], $contractNode);
        duration($xPath, $body[$length + $i], $contractNode);
        deadline($xPath, $body[$length + $i], $contractNode);
        notice_id($xPath, $body[$length + $i], $contractNode);
        parent_notice_id($xPath, $body[$length + $i], $contractNode);
        root_notice_id($xPath, $body[$length + $i], $contractNode);
        buyer_group_id($xPath, $body[$length + $i], $contractNode);
        buyer_group_name($xPath, $body[$length + $i], $contractNode);
        
        $i++;
    }
}

$body = array();

foreach(array_slice($files, 2) as $file) {
    
    $xmlDoc->load($noticesDIR . '/' . $file);
    
    $xPath = new DOMXpath($xmlDoc);
    
    call_function_contract($body, $xPath, 'contract');
    
    persist_csv($outputDIR.'/'.str_replace('xml', 'csv', $file), $body, $header_short);
    break;
}