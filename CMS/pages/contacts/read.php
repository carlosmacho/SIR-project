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

// Check if form was submitted
if (isset($_POST['save_contact'])) {
    // Sanitize POST array
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // Get checkbox value
    $seen = isset($_POST['seen']) ? 1 : 0;
    // Update contact request
    $stmt = $pdo->prepare('UPDATE contact_request SET seen = ? WHERE contactID = ?');
    $stmt->execute([$seen, $_POST['contactID']]);
    // Set the text of the seen field based on the value of the $seen variable
    if ($seen) {
        $seenText = "seen";
        } else {
        $seenText = "not seen";
        }
    
        echo $seenText;
    header('Location: read.php');
    exit;
}

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
                <td>Seen</td>
                <td>Seen At</td>
                <td>Created</td>
                <td>Options</td>
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
                <td>
                <!-- Toggle switch -->
                <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" onchange="updateContactRequest(<?=$contact['contactID']?>, this.checked)" <?php echo $contact['seen'] == 1 ? 'checked' : ''; ?>>
                <label class="form-check-label" id="flexSwitchLabel" for="flexSwitchCheckDefault"><?php echo $contact['seen'] == 1 ? 'seen' : 'not seen'; ?></label>
                </div>
                </td>
                <td>
                    <?php
                        if ($contact['seen']) {
                            // Display the seen_at value from the database if seen is true
                            echo date('d-m-Y h:i:s a', strtotime($contact['seen_at']));
                        } else {
                            // Display "not seen" if seen is false
                            echo "not seen yet";
                        }
                    ?>
                </td>
                <td><?=date('d-m-Y h:i:s a', strtotime($contact['created']))?></td>
                <td class="actions">
                    <button class="btn btn-primary" onclick="openMailClient('<?=$contact['firstname']?>', '<?=$contact['lastname']?>', '<?=$contact['email']?>')">Reply</button>
                </td>
                <td>
                    <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                        <div class="dropdown-menu">
                            <!-- <a class="dropdown-item" href="mailto:<?=$contact['email']?>?subject=<?=$contact['firstname']?><?=$contact['lastname']?>">
                                <i class="bx bx-edit-alt me-1"></i>Reply</a> -->
                            <?php if ($_SESSION["userType"] == "Admin"): ?>
                            <a class="dropdown-item" href="delete.php?contactID=<?=$contact['contactID']?>">
                                <i class="bx bx-trash me-1"></i> Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
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

<!-- JavaScript function to send an AJAX request to update contact request seen status -->
<script>
function updateContactRequest(contactID, seen) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_seen.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Contact request updated');
        }
        else {
            console.error('An error occurred');
        }
    };
    xhr.send(`contactID=${contactID}&seen=${seen}`);
}

function openMailClient(firstname, lastname, email) {
    // Set the email subject and body
    let subject = `Re: Contact request from ${firstname} ${lastname}`;
    let body = `Dear ${firstname} ${lastname},\n\nThank you for your contact request.\n\nSincerely,\nCarlos Macho`;

    // Encode the subject and body for use in the mailto: URI
    let encodedSubject = encodeURIComponent(subject);
    let encodedBody = encodeURIComponent(body);

    // Construct the mailto: URI
    let mailtoURI = `mailto:${email}?subject=${encodedSubject}&body=${encodedBody}`;

    // Open the default mail client with the mailto: URI
    window.location.href = mailtoURI;
  }

</script>
<?=template_footer()?>