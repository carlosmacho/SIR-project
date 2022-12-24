<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['languageID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/languages/';
        $language_icon = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $language_icon);
        $newPath = '/SIR-project/assets/upload/languages/';
        $language_icon = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $language_name = isset($_POST['language_name']) ? $_POST['language_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE languages SET language_name = ?, language_icon = ? WHERE languageID = ?');
        $stmt->execute([$language_name, $language_icon, $_GET['languageID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE languageID = ?');
    $stmt->execute([$_GET['languageID']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update language #<?=$language['languageID']?></h2>
    <form action="update.php?languageID=<?=$language['languageID']?>" method="post" enctype="multipart/form-data">

        <label for="language_name">Language Name</label>
        <input type="text" name="language_name" placeholder="Language Name" value="<?=$language['language_name']?>" id="language_name">
        <label for="language_icon">Language Icon</label>
        <input type="file" name="profile" value="<?=$language['language_icon']?>" id="profile">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>