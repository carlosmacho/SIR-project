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


<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> About Me</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create about me</h5>
        </div>
        <div class="card-body">
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="aboutmeID">About Me ID</label>
                <div class="col-sm-10">
                <input type="text" name="aboutmeID" disabled value="auto" placeholder="26" class="form-control" id="aboutmeID" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="user_name">Title Name</label>
                <div class="col-sm-10">
                <input type="text" name="user_name" placeholder="Title Name" class="form-control" id="user_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="title_desc">Title Description</label>
                <div class="col-sm-10">
                <input type="text" name="title_desc" placeholder="Title Description" class="form-control" id="title_desc" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="profile">User Photo</label>
                <div class="col-sm-10">
                <input type="file" name="profile" placeholder="User Photo" class="form-control" id="profile" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="section_desc">Section Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="section_desc" id="section_desc" rows="3"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="phone_number">Phone Number</label>
                <div class="col-sm-10">
                <input type="text" name="phone_number" placeholder="Phone Number" class="form-control" id="phone_number" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="email">Email</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <input
                    type="text"
                    id="email"
                    class="form-control"
                    placeholder="Email"
                    aria-label="username"
                    aria-describedby="basic-default-email2"
                    name="email"
                    required="required" 
                    data-error="Please enter your email *"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                </div>
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