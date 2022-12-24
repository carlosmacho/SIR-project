<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['quoteID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM quotes WHERE quoteID = ?');
    $stmt->execute([$_GET['quoteID']]);
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$quote) {
        exit('Quote doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM quotes WHERE quoteID = ?');
            $stmt->execute([$_GET['quoteID']]);
            $msg = 'You have deleted the quote! You will be redirected to your account page in 2 seconds....';
            header("Refresh:2; url=read.php", true, 202);
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete quote #<?=$quote['quoteID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete quote #<?=$quote['quoteID']?>?</p>
    <div class="yesno">
        <a href="deleteQuote.php?quoteID=<?=$quote['quoteID']?>&confirm=yes">Yes</a>
        <a href="deleteQuote.php?quoteID=<?=$quote['quoteID']?>&confirm=no">No</a>
    </div>
    <h2>Preview</h2>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <?=$quote['quote_title']?>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                <p><?=$quote['quote_desc']?></p>
                <footer class="blockquote-footer"><?=$quote['quote_author']?> <cite title="Source Title"></cite></footer>
                </blockquote>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>