<?php

require "../../../utils/header.php";
require "../../db/connection.php";

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
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    $created = date('m/d/Y h:i:s a', time());
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO contact_request VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$contactID, $_SESSION["id"], $firstname, $lastname, $email, $message, $created]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact Request</h2>
    <form action="create.php" method="post">

        <label for="contactID">Contact ID</label>
        <input type="text" name="contactID" disabled placeholder="26" value="auto" id="contactID">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" placeholder="First Name" id="firstname">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" placeholder="Last Name" id="lastname">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" id="email">
        <label for="message">Message</label>
        <input type="text" name="message" placeholder="Message" id="message">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>