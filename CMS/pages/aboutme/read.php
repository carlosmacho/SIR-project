<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM about_me");
$stmt->execute();
// Fetch the records so we can display them in our template.
$about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt2 = $pdo->prepare("SELECT * FROM connect_links as cl, about_me as ab WHERE cl.aboutmeID = ab.aboutmeID ORDER BY connectlinksID");
$stmt2->execute();
// Fetch the records so we can display them in our template.
$connect_links= $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of links, this is so we can determine whether there should be a next and previous button
$num_connectlinks = $pdo->query('SELECT COUNT(*) FROM connect_links')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>About Me</h2>
    <!-- To hide the "Create About me" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $about_me variable is empty or not.-->
    <?php if (empty($about_me)): ?>
    <a href="create.php" class="create-language">Create About me</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>AboutMe ID</td>
                <td>User ID</td>
                <td>Title Name</td>
                <td>Title Description</td>
                <td>User Photo</td>
                <td>Section Description</td>
                <td>Phone Number</td>
                <td>Email</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($about_me as $aboutme): ?>
            <tr>
                <td><?=$aboutme['aboutmeID']?></td>
                <td><?=$aboutme['userID']?></td>
                <td><?=$aboutme['user_name']?></td>
                <td><?=$aboutme['title_desc']?></td>
                <td>
                <img witdh="100" height="100" src="<?php echo $aboutme['userPhoto']; ?>">
                </td>
                <td><?=$aboutme['section_desc']?></td>
                <td><?=$aboutme['phone_number']?></td>
                <td><?=$aboutme['email']?></td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="update.php?aboutmeID=<?=$aboutme['aboutmeID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?aboutmeID=<?=$aboutme['aboutmeID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="content read">
    <h2>Connect Links</h2>
    <?php if ($_SESSION["userType"] == "Admin"): ?>
    <a href="createLink.php" class="create-language">Create New Social Links</a>
    <?php endif; ?>
	<table>
        <thead>
            <tr>
                <td>AboutMe ID</td>
                <td>ConnectLinks ID</td>
                <td>Link</td>
                <td>Logotipo</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($connect_links as $connectlink): ?>
            <tr>
                <td><?=$connectlink['aboutmeID']?></td>
                <td><?=$connectlink['connectlinksID']?></td>
                <td><?=$connectlink['link']?></td>
                <td>
                <img witdh="30" height="30" src="<?php echo $connectlink['logo']; ?>">
                </td>
                <?php if ($_SESSION["userType"] == "Admin"): ?>
                <td class="actions">
                    <a href="updateLink.php?connectlinksID=<?=$connectlink['connectlinksID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteLink.php?connectlinksID=<?=$connectlink['connectlinksID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>