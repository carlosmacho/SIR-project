<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $softskillID = isset($_POST['softskillID']) && !empty($_POST['softskillID']) && $_POST['softskillID'] != 'auto' ? $_POST['softskillID'] : NULL;
    $softskill_name = isset($_POST['softskill_name']) ? $_POST['softskill_name'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO soft_skills VALUES (?, ?, ?)');
    $stmt->execute([$softskillID, $_SESSION["id"], $softskill_name]);
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Soft Skills</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create Soft Skills</h5>
        </div>
        <div class="card-body">
        <form action="createSoftSkill.php" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="softskill_name">Soft Skill Name</label>
                <div class="col-sm-10">
                <input type="text" name="softskill_name" placeholder="Soft Skill Name" class="form-control" id="softskill_name" />
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