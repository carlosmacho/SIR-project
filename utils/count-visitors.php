<?php

// Check if the current visitor is new
$ip_address = $_SERVER['REMOTE_ADDR'];
$query = $pdo->prepare("SELECT COUNT(*) FROM visitors WHERE ip_address = ?");
$query->execute([$ip_address]);
$count = $query->fetchColumn();
// Change the line below to your timezone!
date_default_timezone_set('Europe/London');
$visit_time = date('m/d/Y h:i:s a', time());
if ($count == 0) {
    // The visitor is new, add them to the database
    $device = get_device();  // Call the function to get the visitor's device
    $query = $pdo->prepare("INSERT INTO visitors (ip_address, device, visit_time) VALUES (?, ?, ?)");
    $query->execute([$ip_address, $device, $visit_time]);
}


/**
 * Function to get the visitor's device (e.g. desktop, mobile, tablet)
 *
 * @return string The device type (desktop, mobile, tablet)
 */
function get_device() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $device = 'desktop';

    if (preg_match('/mobile/i', $user_agent)) {
        $device = 'mobile';
    } elseif (preg_match('/tablet/i', $user_agent)) {
        $device = 'tablet';
    }

    return $device;
}
?>