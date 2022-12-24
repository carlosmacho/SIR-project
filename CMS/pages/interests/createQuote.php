<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $quoteID = isset($_POST['quoteID']) && !empty($_POST['quoteID']) && $_POST['quoteID'] != 'auto' ? $_POST['quoteID'] : NULL;
    $quote_title = isset($_POST['quote_title']) ? $_POST['quote_title'] : '';
    $quote_desc = isset($_POST['quote_desc']) ? $_POST['quote_desc'] : '';
    $quote_author = isset($_POST['quote_author']) ? $_POST['quote_author'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO quotes VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$quoteID, $_SESSION["id"], $quote_title, $quote_desc, $quote_author]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Quote</h2>
    <form action="createQuote.php" method="post">

        <label for="quote_title">Quote Title</label>
        <input type="text" name="quote_title" placeholder="Quote Title" id="quote_title">
        <label for="quote_desc">Quote Description</label>
        <input type="text" name="quote_desc" placeholder="Quote Description" id="quote_desc">
        <label for="quote_author">Quote Author</label>
        <input type="text" name="quote_author" placeholder="Quote Auhtor" id="quote_author">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>