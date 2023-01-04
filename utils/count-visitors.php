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
    $query = $pdo->prepare("INSERT INTO visitors (ip_address, visit_time) VALUES (?, ?)");
    $query->execute([$ip_address, $visit_time]);
}
?>