<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {

    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $experienceID = isset($_POST['experienceID']) && !empty($_POST['experienceID']) && $_POST['experienceID'] != 'auto' ? $_POST['experienceID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $company_title = isset($_POST['company_title']) ? $_POST['company_title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO experience VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$experienceID, $_SESSION["id"], $job_title, $company_title, $description, $date_start, $date_end]);
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Experiences</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create a experience</h5>
        </div>
        <div class="card-body">
            <form action="create.php" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="experienceID">Experience ID</label>
                <div class="col-sm-10">
                <input type="text" name="experienceID" disabled placeholder="Experience ID" value="auto" class="form-control" id="experienceID" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="job_title">Job Title</label>
                <div class="col-sm-10">
                <input type="text" name="job_title" placeholder="Job Title" class="form-control" id="job_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="company_title">Company Name</label>
                <div class="col-sm-10">
                <input type="text" name="company_title" placeholder="Company Name" class="form-control" id="company_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-10">
                <input type="text" name="description" placeholder="Description" class="form-control" id="description" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_start">Start Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_start" placeholder="Start Date" class="form-control" id="date_start" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_end">End Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_end" placeholder="End Date" class="form-control" id="date_end" />
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