<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['connectlinksID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/logotypes/';
        $logotype = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $logotype);
        $newPath = '/SIR-project/assets/upload/logotypes/';
        $logotype = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $link = isset($_POST['link']) ? $_POST['link'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE connect_links SET link = ?, logo = ? WHERE connectlinksID = ?');
        $stmt->execute([$link, $logotype, $_GET['connectlinksID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the table
    $stmt = $pdo->prepare('SELECT * FROM connect_links WHERE connectlinksID = ?');
    $stmt->execute([$_GET['connectlinksID']]);
    $connect_links = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$connect_links) {
        exit('connect_links doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update link #<?=$connect_links['connectlinksID']?></h2>
    <form action="updateLink.php?connectlinksID=<?=$connect_links['connectlinksID']?>" method="post" enctype="multipart/form-data">

        <label for="link">Link URL</label>
        <input type="text" name="link" placeholder="Social Media Link" value="<?=$connect_links['link']?>" id="link">
        <label for="logotype">Logotype</label>
        <input type="file" name="profile" value="<?=$connect_links['logo']?>" id="profile">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>