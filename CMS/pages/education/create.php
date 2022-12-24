<?php

require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';


// Check if POST data is not empty
if (!empty($_POST)) {

    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $experienceID = isset($_POST['educationID']) && !empty($_POST['educationID']) && $_POST['educationID'] != 'auto' ? $_POST['educationID'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $school_title = isset($_POST['school_title']) ? $_POST['school_title'] : '';
    $course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
    $gpa = isset($_POST['gpa']) ? $_POST['gpa'] : '';
    // Insert new record into the about_me table
    $stmt = $pdo->prepare('INSERT INTO education VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$experienceID, $_SESSION["id"], $school_title, $course_name, $description, $date_start, $date_end, $gpa]);
    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=read.php", true, 203);

}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create New Education</h2>
    <form action="create.php" method="post">
        <label for="educationID">Education ID</label>
        <input type="text" name="educationID" disabled placeholder="26" value="auto" id="educationID">
        <label for="school_title">School Title</label>
        <input type="text" name="school_title" placeholder="School Title" id="school_title">
        <label for="course_name">Course Title</label>
        <input type="text" name="course_name" placeholder="Course Name" id="course_name">
        <label for="description">Descripton</label>
        <input type="text" name="description" placeholder="Description" id="description">
        <label for="date_start">Start Date</label>
        <input type="month" name="date_start" placeholder="Start Date" id="date_start">
        <label for="date_end">End Date</label>
        <input type="month" name="date_end" placeholder="End Date" id="date_end">
        <label for="gpa">GPA</label>
        <input type="text" name="gpa" placeholder="Average Grade" id="gpa">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>