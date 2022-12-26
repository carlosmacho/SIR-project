<?php

#require "../../../utils/header.php";
require "../../db/connection.php";
#$username = $_SESSION["username"];
#$userRole = $_SESSION["userType"];

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $contactID = isset($_POST['contactID']) && !empty($_POST['contactID']) && $_POST['contactID'] != 'auto' ? $_POST['contactID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $seen = isset($_POST['seen']) == 'true' ? 1 : 0;
    if ($seen) {
        // Update the value of seen_at only if seen is true
        $seen_at = date('m/d/Y h:i:s a', time());
    } else {
        $seen_at = "not seen yet";
    }
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    $created = date('m/d/Y h:i:s a', time());
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO contact_request VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$contactID, $firstname, $lastname, $email, $message, $seen, $seen_at, $created, 0]);
    // Output message
    $msg = 'Your message was sent successfully! You will be redirected to the home page in 1 second.';
    header("Refresh:1; url=../../../index.php", true, 203);
}
?>

<div class="message">
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

