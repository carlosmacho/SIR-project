<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['quoteID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $quote_title = isset($_POST['quote_title']) ? $_POST['quote_title'] : '';
        $quote_desc = isset($_POST['quote_desc']) ? $_POST['quote_desc'] : '';
        $quote_author = isset($_POST['quote_author']) ? $_POST['quote_author'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE quotes SET quote_title = ?, quote_desc = ?, quote_author = ? WHERE quoteID = ?');
        $stmt->execute([$quote_title, $quote_desc, $quote_author, $_GET['quoteID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM quotes WHERE quoteID = ?');
    $stmt->execute([$_GET['quoteID']]);
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$quote) {
        exit('quote doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update quote #<?=$quote['quoteID']?></h2>
    <form action="updateQuote.php?quoteID=<?=$quote['quoteID']?>" method="post">

        <label for="quote_title">Quote Title</label>
        <input type="text" name="quote_title" placeholder="Quote Title" value="<?=$quote['quote_title']?>" id="quote_title">
        <label for="quote_desc">Quote Description</label>
        <input type="text" name="quote_desc" placeholder="Quote Description" value="<?=$quote['quote_desc']?>" id="quote_desc">
        <label for="quote_author">Quote Author</label>
        <input type="text" name="quote_author" placeholder="Quote Author" value="<?=$quote['quote_author']?>" id="quote_author">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
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
</div>


<?=template_footer()?>