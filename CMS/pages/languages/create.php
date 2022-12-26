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

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Languages</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create Language</h5>
        </div>
        <div class="card-body">
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="language_name">Language</label>
                <div class="col-sm-10">
                <input type="text" name="language_name" placeholder="Language Name" class="form-control" id="language_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="language_icon">Language Icon</label>
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