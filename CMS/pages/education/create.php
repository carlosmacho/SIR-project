<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {

    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $educationID = isset($_POST['educationID']) && !empty($_POST['educationID']) && $_POST['educationID'] != 'auto' ? $_POST['educationID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $school_title = isset($_POST['school_title']) ? $_POST['school_title'] : '';
    $course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
    $gpa = isset($_POST['gpa']) ? $_POST['gpa'] : '';
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO education VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$educationID, $_SESSION["id"], $school_title, $course_name, $description, $date_start, $date_end, $gpa]);
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Educations</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create a education</h5>
        </div>
        <div class="card-body">
        <form action="create.php" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="school_title">School Title</label>
                <div class="col-sm-10">
                <input type="text" name="school_title" placeholder="School Title" class="form-control" id="school_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="course_name">Course Name</label>
                <div class="col-sm-10">
                <input type="text" name="course_name" placeholder="Course Name" class="form-control" id="course_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" placeholder="Description" name="description" id="description" rows="3"></textarea>
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
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="gpa">GPA</label>
                <div class="col-sm-10">
                <input type="text" name="gpa" placeholder="GPA" class="form-control" id="gpa" />
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