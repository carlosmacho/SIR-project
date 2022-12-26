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

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Social Media</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create Social Media Link</h5>
        </div>
        <div class="card-body">
        <form action="createLink.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="link">Link</label>
                <div class="col-sm-10">
                <input type="text" name="link" placeholder="Link" class="form-control" id="link" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="logo">Link Logotype</label>
                <div class="col-sm-10">
                <input type="file" name="profile" class="form-control" id="profile" />
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