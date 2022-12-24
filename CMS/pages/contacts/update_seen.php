<?php
require "../../db/connection.php";

$pdo = pdo_connect_mysql();

// Check if the contactID and seen values were received via POST request
if (isset($_POST['contactID']) && isset($_POST['seen'])) {
    // Convert seen value to a boolean
    $seen = $_POST['seen'] == 'true' ? 1 : 0;
    if ($seen) {
        // Update the value of seen_at only if seen is true
        $seen_at = date('m/d/Y h:i:s a', time());
    } else {
        $seen_at = "not seen yet";
    }
    // Update the record
    $stmt = $pdo->prepare('UPDATE contact_request SET seen = ?, seen_at = ? WHERE contactID = ?');
    $stmt->execute([$seen, $seen_at, $_POST['contactID']]);
    echo 'Contact request updated';
} else {
    echo 'An error occurred';
}

?>