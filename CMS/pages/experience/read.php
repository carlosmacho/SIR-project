<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM experience ORDER BY date_end DESC");
$stmt->execute();
// Fetch the records so we can display them in our template.
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Experience</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="create.php" class="create-language">Create Experience</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Experience ID</td>
                <td>Job Title</td>
                <td>Company Title</td>
                <td>Description</td>
                <td>Date Start</td>
                <td>Date End</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($experiences as $experience): ?>
            <tr>
                <td><?=$experience['userID']?></td>
                <td><?=$experience['experienceID']?></td>
                <td><?=$experience['job_title']?></td>
                <td><?=$experience['company_title']?></td>
                <td><?=$experience['description']?></td>
                <td><?=date('F Y', strtotime($experience['date_start']))?></td>
                <td><?=date('F Y', strtotime($experience['date_end']))?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="update.php?experienceID=<?=$experience['experienceID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?experienceID=<?=$experience['experienceID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>