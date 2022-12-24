<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../assets/upload/languages/';
    $language_icon = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $language_icon);
    $newPath = '/SIR-project/assets/upload/languages/';
    $language_icon = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $languageID = isset($_POST['languageID']) && !empty($_POST['languageID']) && $_POST['languageID'] != 'auto' ? $_POST['languageID'] : NULL;
    $language_name = isset($_POST['language_name']) ? $_POST['language_name'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO languages VALUES (?, ?, ?, ?)');
    $stmt->execute([$languageID, $_SESSION["id"], $language_name, $language_icon]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Language</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="language_name">Language Name</label>
        <input type="text" name="language_name" placeholder="Language Name" id="language_name">
        <label for="language_icon">Language Icon</label>
        <input type="file" name="profile" value="" id=profile/>
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>