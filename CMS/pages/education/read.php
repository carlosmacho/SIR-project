<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM education ORDER BY date_end DESC LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$educations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_educations = $pdo->query('SELECT COUNT(*) FROM education')->fetchColumn();

?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Education</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="create.php" class="create-language">Create Education</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Education ID</td>
                <td>School Title</td>
                <td>Course Name</td>
                <td>Description</td>
                <td>Date Start</td>
                <td>Date End</td>
                <td>GPA</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($educations as $education): ?>
            <tr>
                <td><?=$education['userID']?></td>
                <td><?=$education['educationID']?></td>
                <td><?=$education['school_title']?></td>
                <td><?=$education['course_name']?></td>
                <td><?=$education['description']?></td>
                <td><?=date('F Y', strtotime($education['date_start']))?></td>
                <td><?=date('F Y', strtotime($education['date_end']))?></td>
                <td><?=$education['gpa']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="update.php?educationID=<?=$education['educationID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?educationID=<?=$education['educationID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_educations): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>