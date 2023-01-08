<?php
require "../../utils/header.php";
require "../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from users table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$stmt2 = $pdo->prepare("SELECT * FROM visitors ORDER BY visit_time DESC LIMIT :current_page, :record_per_page");
$stmt2->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt2->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt2->execute();

// Get the total number of ..., this is so we can determine whether there should be a next and previous button
$num_visitors = $pdo->query('SELECT COUNT(DISTINCT ip_address) FROM visitors')->fetchColumn();

// Fetch the records so we can display them in our template.
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$visitors = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>
<div class="content read">
    <h2>Visitor Count: <?=$num_visitors?></h2>
    <!-- To hide the "Create User" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $users variable is empty or not.-->
    <table>
        <thead>
            <tr>
                <td>Visitor ID</td>
                <td>IP Address</td>
                <td>Device Accessed</td>
                <td>Time Of Visit</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitors as $visitor): ?>
            <tr>
                <td><?=$visitor['id']?></td>
                <td><?=$visitor['ip_address']?></td>
                <td><?=$visitor['device']?></td>
                <td><?=date('d-m-Y h:i:s a', strtotime($visitor['visit_time']))?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="welcome.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_visitors): ?>
		<a href="welcome.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<div class="content read">
    <h2>Users</h2>
    <!-- To hide the "Create User" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $users variable is empty or not.-->
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="users/create.php" class="create-language">Create users</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Username</td>
                <td>User Type</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['userType']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="users/update.php?id=<?=$user['id']?>">
                                <i class="bx bx-edit-alt me-1"></i> Edit</a>
                <?php if ($_SESSION["userType"] == "Admin" && $_SESSION["id"] != $user["id"]): ?>
                            <a class="dropdown-item" href="users/delete.php?id=<?=$user['id']?>">
                                <i class="bx bx-trash me-1"></i> Delete</a>
                <?php endif; ?>
                        </div>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>