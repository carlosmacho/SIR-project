<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['cardID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/interests/';
        $card_img = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $card_img);
        $newPath = '/SIR-project/assets/upload/interests/';
        $card_img = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $card_desc = isset($_POST['card_desc']) ? $_POST['card_desc'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE interests SET card_img = ?, card_desc = ? WHERE cardID = ?');
        $stmt->execute([$card_img, $card_desc, $_GET['cardID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM interests WHERE cardID = ?');
    $stmt->execute([$_GET['cardID']]);
    $interest = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$interest) {
        exit('Interest card doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Interest Card #<?=$interest['cardID']?></h2>
    <form action="update.php?cardID=<?=$interest['cardID']?>" method="post" enctype="multipart/form-data">

        <label for="card_img">Card Image</label>
        <input type="file" name="profile" value="<?=$interest['card_img']?>" id="profile">
        <label for="card_desc">Card Description</label>
        <input type="text" name="card_desc" placeholder="Card Description" value="<?=$interest['card_desc']?>" id="card_desc">

        <input type="submit" value="Update">
    </form>
    
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>

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
</div>

<?=template_footer()?>