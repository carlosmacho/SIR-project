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

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Interest Cards</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create Interest Card</h5>
        </div>
        <div class="card-body">
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="card_img">Card Image</label>
                <div class="col-sm-10">
                <input type="file" name="profile" placeholder="Card Image" class="form-control" id="profile" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="card_desc">Card Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="card_desc" id="card_desc" rows="3"></textarea>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-10">
                <button type="submit" value="Create" class="btn btn-primary">Create</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- / Content -->
<?php if ($msg): ?>
    <p><?=$msg?></p>
<?php endif; ?>

<?=template_footer()?>