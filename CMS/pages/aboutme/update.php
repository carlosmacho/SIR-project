<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['aboutmeID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/images/';
        $location = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $location);
        $newPath = '/SIR-project/assets/upload/images/';
        $userPhoto = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $title_desc = isset($_POST['title_desc']) ? $_POST['title_desc'] : '';
        $section_desc = isset($_POST['section_desc']) ? $_POST['section_desc'] : '';
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $connect_links = isset($_POST['connect_links']) ? $_POST['connect_links'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE about_me SET user_name = ?, title_desc = ?, userPhoto = ?, section_desc = ?, phone_number = ?,
         email = ? WHERE aboutmeID = ?');
        #$stmt->bind_param('s', $image);
        $stmt->execute([$user_name, $title_desc, $userPhoto, $section_desc, $phone_number, $email, $_GET['aboutmeID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM about_me WHERE aboutmeID = ?');
    $stmt->execute([$_GET['aboutmeID']]);
    $about_me = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$about_me) {
        exit('user doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update about me #<?=$about_me['aboutmeID']?></h2>
    <form action="update.php?aboutmeID=<?=$about_me['aboutmeID']?>" method="post" enctype="multipart/form-data">

        <label for="user_name">Title Name</label>
        <input type="text" name="user_name" placeholder="Titulo principal" value="<?=$about_me['user_name']?>" id="user_name">
        <label for="title_desc">Title Descripton</label>
        <input type="text" name="title_desc" placeholder="subtitulo descricao" value="<?=$about_me['title_desc']?>" id="title_desc">
        <label for="userPhoto">User Photo</label>
        <input type="file" name="profile" value="<?=$about_me['userPhoto']?>" id="profile">
        <label for="section_desc">section Descripton</label>
        <input type="text" name="section_desc" placeholder="section description" value="<?=$about_me['section_desc']?>" id="section_desc">
        <label for="phone_number">phone number</label>
        <input type="text" name="phone_number" placeholder="phone number" value="<?=$about_me['phone_number']?>" id="phone_number">
        <label for="email">email</label>
        <input type="text" name="email" placeholder="email here" value="<?=$about_me['email']?>" id="email">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>