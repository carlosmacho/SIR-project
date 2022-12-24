<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 10;

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM contact_request ORDER BY contactID LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contact_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of ..., this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contact_request')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Contact Requests</h2>
    <!-- To hide the "Create About me" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $about_me variable is empty or not.-->
    <?php if (empty($contact_requests)): ?>
    <a href="create.php" class="create-language">Create New Contact Request</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>Contact ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Message</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contact_requests as $contact): ?>
            <tr>
                <td><?=$contact['contactID']?></td>
                <td><?=$contact['firstname']?></td>
                <td><?=$contact['lastname']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['message']?></td>
                <td><?=date('d-m-Y h:i:s a', strtotime($contact['created']))?></td>
                <td class="actions">
                    <a href="update.php?contactID=<?=$contact['contactID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <?php if ($_SESSION["userType"] == "Admin"): ?>
                    <a href="delete.php?contactID=<?=$contact['contactID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>