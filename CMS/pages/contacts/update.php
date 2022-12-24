<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['contactID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $contactID = isset($_POST['contactID']) ? $_POST['contactID'] : NULL;
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        // Change the line below to your timezone!
        date_default_timezone_set('Europe/London');
        $created = date('m/d/Y h:i:s a', time());
        // Update the record
        $stmt = $pdo->prepare('UPDATE contact_request SET firstname = ?, lastname = ?, email = ?, message = ?, created = ? WHERE contactID = ?');
        $stmt->execute([$firstname, $lastname, $email, $message, $created, $_GET['contactID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM contact_request WHERE contactID = ?');
    $stmt->execute([$_GET['contactID']]);
    $contact_request = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact_request) {
        exit('contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update contact request #<?=$contact_request['contactID']?></h2>
    <form action="update.php?contactID=<?=$contact_request['contactID']?>" method="post">

        <label for="firstname">First Name</label>
        <input type="text" name="firstname" placeholder="First Name" value="<?=$contact_request['firstname']?>" id="firstname">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" placeholder="subtitulo descricao" value="<?=$contact_request['lastname']?>" id="lastname">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" value="<?=$contact_request['email']?>" id="email">
        <label for="message">Message</label>
        <input type="text" name="message" placeholder="Message" value="<?=$contact_request['message']?>" id="message">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>