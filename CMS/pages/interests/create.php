<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../assets/upload/interests/';
    $card_img = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $card_img);
    $newPath = '/SIR-project/assets/upload/interests/';
    $card_img = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $cardID = isset($_POST['cardID']) && !empty($_POST['cardID']) && $_POST['cardID'] != 'auto' ? $_POST['cardID'] : NULL;
    $card_desc = isset($_POST['card_desc']) ? $_POST['card_desc'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO interests VALUES (?, ?, ?, ?)');
    $stmt->execute([$cardID, $_SESSION["id"], $card_img, $card_desc]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Interest Card</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="card_img">Card Image</label>
        <input type="file" name="profile" value="" id=profile/>
        <label for="card_desc">Card Description</label>
        <input type="text" name="card_desc" placeholder="Card Description" id="card_desc">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>