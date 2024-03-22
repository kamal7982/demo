<?php
/*====================================================
    Code for remove dublica record from 
    array and unique recorde by Client_email
======================================================*/
$uniqueEmails = array();
foreach ($all_client_data as $item) {
    $email = $item['Client_email'];
    if (!isset($uniqueEmails[$email])) {
        $uniqueEmails[$email] = $item;
    }
}
/*====================================================
    code for update inspection_reminder_date with qr_id
======================================================*/
foreach ($all_client_data as $key => $item) {
    if (empty($item['inspection_reminder_date'])) {
        foreach ($all_client_data as $otherItem) {
            if ($otherItem['qr_id'] === $item['qr_id'] && !empty($otherItem['inspection_reminder_date'])) {
                $all_client_data[$key]['inspection_reminder_date'] = $otherItem['inspection_reminder_date'];
                break;
            }
        }
    }
}
/*====================================================
    Sorting array in php
======================================================*/
usort($all_client_data, function ($a, $b) {
    return $a['qr_id'] - $b['qr_id'];
});

// Group by client email ID
foreach ($all_client_data as $item) {
    $email = $item['Client_email'];
    if (!isset($groupedArray[$email])) {
        $groupedArray[$email] = array();
    }
    $groupedArray[$email][] = $item;
}



