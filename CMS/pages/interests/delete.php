<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['cardID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM interests WHERE cardID = ?');
    $stmt->execute([$_GET['cardID']]);
    $interest = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$interest) {
        exit('interest doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM interests WHERE cardID = ?');
            $stmt->execute([$_GET['cardID']]);
            $msg = 'You have deleted the interest card! You will be redirected to your account page in 2 seconds....';
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
	<h2>Delete interest card #<?=$interest['cardID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete interest cade #<?=$interest['cardID']?>?</p>
    <div class="yesno">
        <a href="delete.php?cardID=<?=$interest['cardID']?>&confirm=yes">Yes</a>
        <a href="delete.php?cardID=<?=$interest['cardID']?>&confirm=no">No</a>
    </div>
    <div>
    <h2>Preview</h2>
    <div class="row mb-5 mt-5">
        <div class="col-lg-4 mb-5">
            <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo $interest['card_img']; ?>">
                <div class="card-body">
                    <p class="card-text"><?=$interest['card_desc']?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
