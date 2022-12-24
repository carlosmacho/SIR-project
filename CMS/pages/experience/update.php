<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['experienceID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
        $company_title = isset($_POST['company_title']) ? $_POST['company_title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE experience SET job_title = ?, company_title = ?, description = ?, date_start = ?, date_end = ? WHERE experienceID = ?');
        $stmt->execute([$job_title, $company_title, $description, $date_start, $date_end, $_GET['experienceID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM experience WHERE experienceID = ?');
    $stmt->execute([$_GET['experienceID']]);
    $about_me = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$about_me) {
        exit('experienceID doesn\'t exist with that ID!');
    }
} else {
    exit('No experienceID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update about me #<?=$about_me['experienceID']?></h2>
    <form action="update.php?experienceID=<?=$about_me['experienceID']?>" method="post">

        <label for="job_title">Job Title</label>
        <input type="text" name="job_title" placeholder="Job Tittle" value="<?=$about_me['job_title']?>" id="job_title">
        <label for="company_title">Company Name</label>
        <input type="text" name="company_title" placeholder="Company Name" value="<?=$about_me['company_title']?>" id="company_title">
        <label for="description">Descripton</label>
        <input type="text" name="description" placeholder="Description" value="<?=$about_me['description']?>" id="description">
        <label for="date_start">Start Date</label>
        <input type="month" name="date_start" placeholder="Start Date" value="<?=$about_me['date_start']?>" id="date_start">
        <label for="date_end">End Date</label>
        <input type="month" name="date_end" placeholder="End Date" value="<?=$about_me['date_end']?>" id="date_end">
    
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>