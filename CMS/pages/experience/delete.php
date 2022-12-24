<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['experienceID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM experience WHERE experienceID = ?');
    $stmt->execute([$_GET['experienceID']]);
    $experience = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$experience) {
        exit('experience doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM experience WHERE experienceID = ?');
            $stmt->execute([$_GET['experienceID']]);
            $msg = 'You have deleted the experience! You will be redirected to your account page in 2 seconds....';
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
	<h2>Delete experience #<?=$experience['experienceID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete experience #<?=$experience['experienceID']?>?</p>
    <div class="yesno">
        <a href="delete.php?experienceID=<?=$experience['experienceID']?>&confirm=yes">Yes</a>
        <a href="delete.php?experienceID=<?=$experience['experienceID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>