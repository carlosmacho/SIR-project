<?php

require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

if (isset($_POST['email']) && isset($_POST['message'])) {
  // Get form data
  $contactID = $_GET['contactID'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Send email
  $to = $email;
  $subject = 'Reply to Contact Request';
  $headers = 'From: my@email.com' . "\r\n" .
             'Reply-To: my@email.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);

  // Update contact request
  $stmt = $pdo->prepare('UPDATE contact_request SET reply = ? WHERE contactID = ?');
  $stmt->execute([$message, $contactID]);
  header('Location: read.php');
  exit;
}

// Get contact request data
$stmt = $pdo->prepare('SELECT * FROM contact_request WHERE contactID = ?');
$stmt->execute([$_GET['contactID']]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Set variables for form values
$email = $contact['email'];
$message = $contact['message'];
?>

<?=template_header('Read')?>

<div class="content reply">
  <h2>Reply to Contact Request</h2>
  <form action="reply.php?contactID=<?=$contact['contactID']?>" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" value="<?=$email?>" required>
    <label for="message">Message</label>
    <textarea name="message" required><?=$message?></textarea>
    <input type="submit" value="Send Reply">
  </form>
</div>

<?=template_footer()?>



