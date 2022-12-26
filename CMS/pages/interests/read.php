<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 3;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare("SELECT * FROM interests ORDER BY cardID LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$interests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement and get records from table, and only show the one that belongs to the user logged in
$stmt2 = $pdo->prepare("SELECT * FROM quotes ORDER BY quoteID LIMIT :current_page, :record_per_page");
$stmt2->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt2->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt2->execute();
// Fetch the records so we can display them in our template.
$quotes= $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_interests = $pdo->query('SELECT COUNT(*) FROM interests')->fetchColumn();
$num_quotes = $pdo->query('SELECT COUNT(*) FROM quotes')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Interests Cards</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
	<a href="create.php" class="create-language">Create Interest Card</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Card ID</td>
                <td>Card Image</td>
                <td>Card Description</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interests as $interest): ?>
            <tr>
                <td><?=$interest['userID']?></td>
                <td><?=$interest['cardID']?></td>
                <td>
                <img witdh="100" height="100" src="<?php echo $interest['card_img']; ?>">
                </td>
                <td><?=$interest['card_desc']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="update.php?cardID=<?=$interest['cardID']?>">
                                <i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="delete.php?cardID=<?=$interest['cardID']?>">
                                <i class="bx bx-trash me-1"></i> Delete</a>
                        </div>
                    </div>
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
		<?php if ($page*$records_per_page < $num_interests): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<div class="content read">
    <h2>Quotes</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="createQuote.php" class="create-language">Create New Quote</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>Quote ID</td>
                <td>Quote Title</td>
                <td>Quote Description</td>
                <td>Quote Author</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quotes as $quote): ?>
            <tr>
                <td><?=$quote['userID']?></td>
                <td><?=$quote['quoteID']?></td>
                <td><?=$quote['quote_title']?></td>
                <td><?=$quote['quote_desc']?></td>
                <td><?=$quote['quote_author']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="updateQuote.php?quoteID=<?=$quote['quoteID']?>">
                                <i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="deleteQuote.php?quoteID=<?=$quote['quoteID']?>">
                                <i class="bx bx-trash me-1"></i> Delete</a>
                        </div>
                    </div>
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
		<?php if ($page*$records_per_page < $num_quotes): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>