<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {
    $path = '../../../assets/upload/images/';
    $location = $path . $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], $location);
    $newPath = '/SIR-project/assets/upload/images/';
    $location = $newPath . $_FILES['profile']['name'];
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $aboutmeID = isset($_POST['aboutmeID']) && !empty($_POST['aboutmeID']) && $_POST['aboutmeID'] != 'auto' ? $_POST['aboutmeID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $title_desc = isset($_POST['title_desc']) ? $_POST['title_desc'] : '';
    #$userPhoto = isset($_POST['userPhoto']) ? $_POST['userPhoto'] : '';
    $section_desc = isset($_POST['section_desc']) ? $_POST['section_desc'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $connect_links = isset($_POST['connect_links']) ? $_POST['connect_links'] : '';
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO about_me VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$aboutmeID, $_SESSION["id"], $user_name, $title_desc, $location, $section_desc, $phone_number, $email]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);
    #echo '<img width="250" height="250" src= "'.$location.'"/>';

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create About Me</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="aboutmeID">aboutmeID</label>
        <input type="text" name="aboutmeID" disabled placeholder="26" value="auto" id="aboutmeID">
        <label for="user_name">Title Name</label>
        <input type="text" name="user_name" placeholder="Titulo principal" id="user_name">
        <label for="title_desc">Title Descripton</label>
        <input type="text" name="title_desc" placeholder="subtitulo descricao" id="title_desc">
        <label for="userPhoto">User Photo</label>
        <input type="file" name="profile" value="" id=profile/>
        <label for="section_desc">section Descripton</label>
        <input type="text" name="section_desc" placeholder="section description" id="section_desc">
        <label for="phone_number">phone number</label>
        <input type="text" name="phone_number" placeholder="phone number" id="phone_number">
        <label for="email">email</label>
        <input type="text" name="email" placeholder="email here" id="email">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>