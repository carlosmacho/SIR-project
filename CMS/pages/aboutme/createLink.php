<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../assets/upload/logotypes/';
    $logotype = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $logotype);
    $newPath = '/SIR-project/assets/upload/logotypes/';
    $logotype = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $connectlinksID = isset($_POST['connectlinksID']) && !empty($_POST['connectlinksID']) && $_POST['connectlinksID'] != 'auto' ? $_POST['connectlinksID'] : NULL;
    $link = isset($_POST['link']) ? $_POST['link'] : '';
    // Insert new record into the about_me table
   
    $stmt = $pdo->prepare("SELECT aboutmeID FROM about_me");
    $stmt->execute();
    $aboutme = $stmt->fetch();

    if ($aboutme) {
        // The aboutmeID value exists in the about_me table, so we can insert it into the connect_links table
        $stmt = $pdo->prepare('INSERT INTO connect_links VALUES (?, ?, ?, ?)');
        $stmt->execute([$connectlinksID, $aboutme['aboutmeID'], $link, $logotype]);
        // Output message
        $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 203);
        #echo '<img width="250" height="250" src= "'.$logotype.'"/>';
    } else {
        // The aboutmeID value does not exist in the about_me table, so we cannot insert it into the connect_links table
        // You may want to add some error handling here
        
    }
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Social Media Link</h2>
    <form action="createLink.php" method="post" enctype="multipart/form-data">
        <label for="link">link</label>
        <input type="text" name="link" placeholder="social media link" id="link">
        <label for="logo">Link logotype</label>
        <input type="file" name="profile" value="" id=profile/>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>