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

<div class="content update">
	<h2>Create New Experience</h2>
    <form action="create.php" method="post">
        <label for="experienceID">experienceID</label>
        <input type="text" name="experienceID" disabled placeholder="26" value="auto" id="experienceID">
        <label for="job_title">Job Title</label>
        <input type="text" name="job_title" placeholder="Job Title" id="job_title">
        <label for="company_title">Company Title</label>
        <input type="text" name="company_title" placeholder="Company Title" id="company_title">
        <label for="description">Descripton</label>
        <input type="text" name="description" placeholder="Description" id="description">
        <label for="date_start">Start Date</label>
        <input type="month" name="date_start" placeholder="Start Date" id="date_start">
        <label for="date_end">End Date</label>
        <input type="month" name="date_end" placeholder="End Date" id="date_end">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>