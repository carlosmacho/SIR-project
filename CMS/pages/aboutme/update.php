<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['aboutmeID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/images/';
        $location = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $location);
        $newPath = '/SIR-project/assets/upload/images/';
        $userPhoto = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $title_desc = isset($_POST['title_desc']) ? $_POST['title_desc'] : '';
        $section_desc = isset($_POST['section_desc']) ? $_POST['section_desc'] : '';
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $connect_links = isset($_POST['connect_links']) ? $_POST['connect_links'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE about_me SET user_name = ?, title_desc = ?, userPhoto = ?, section_desc = ?, phone_number = ?,
         email = ? WHERE aboutmeID = ?');
        #$stmt->bind_param('s', $image);
        $stmt->execute([$user_name, $title_desc, $userPhoto, $section_desc, $phone_number, $email, $_GET['aboutmeID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM about_me WHERE aboutmeID = ?');
    $stmt->execute([$_GET['aboutmeID']]);
    $about_me = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$about_me) {
        exit('user doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> About Me</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update about me #<?=$about_me['aboutmeID']?></h5>
        </div>
        <div class="card-body">
        <form action="update.php?aboutmeID=<?=$about_me['aboutmeID']?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="user_name">User Name</label>
                <div class="col-sm-10">
                <input type="text" name="user_name" placeholder="User Name" value="<?=$about_me['user_name']?>" class="form-control" id="user_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="title_desc">Title Description</label>
                <div class="col-sm-10">
                <input type="text" name="title_desc" placeholder="Title Description" value="<?=$about_me['title_desc']?>" class="form-control" id="title_desc" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="profile">User Photo</label>
                <div class="col-sm-10">
                <input type="file" name="profile" placeholder="User Photo" value="<?=$about_me['userPhoto']?>" class="form-control" id="profile" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="section_desc">Section Description</label>
                <div class="col-sm-10">
                <!-- <input type="text" name="section_desc" placeholder="Section Description" value="<?=$about_me['section_desc']?>" class="form-control" id="section_desc" /> -->
                <textarea class="form-control" name="section_desc" id="section_desc" rows="3"><?=$about_me['section_desc']?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="phone_number">Phone Number</label>
                <div class="col-sm-10">
                <input type="text" name="phone_number" placeholder="Phone Number" value="<?=$about_me['phone_number']?>" class="form-control" id="phone_number" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="email">Email</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <input
                    type="text"
                    id="email"
                    class="form-control"
                    placeholder="Email"
                    aria-label="username"
                    aria-describedby="basic-default-email2"
                    name="email"
                    required="required" 
                    data-error="Please enter your email *"
                    value="<?=$about_me['email']?>"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-10">
                <button type="submit" value="Update" class="btn btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- / Content -->
<?php if ($msg): ?>
    <p><?=$msg?></p>
<?php endif; ?>


<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> About Me</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">About Me Section</h5>
        </div>
        <div class="card-body">
            <?php
                $output="";
                $stmt = $pdo->prepare("SELECT * FROM about_me");
                $stmt->execute();
                // Fetch the records so we can display them in our template.
                $about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($about_me as $row) {
                    $user_name = $row['user_name'];
                    list($firstName, $lastName) = explode(' ', $user_name);
                    $title_desc = $row['title_desc'];
                    $userPhoto = $row['userPhoto'];
                    $section_desc = $row['section_desc'];

                $output .= "<div class='row'>
                                <div class='col-lg-9'>
                                    <div class='resume-section-content'>
                                        <h1 class='mb-0'>
                                            $firstName
                                            <span class='text-primary'>$lastName</span>
                                        </h1>
                                        <div class='subheading mb-5'>
                                            $title_desc
                                        </div>
                                        <p class='mb-5'>$section_desc</p>
                                    </div>
                                </div>
                                <div class='col-lg-3'>
                                    <div class='resume-section-content'>
                                        <span class='d-lg-block'><img class='img-fluid img-profile2 rounded-circle mx-auto mt-4 mb-4' src='$userPhoto' alt='profile picture' /></span>
                                    </div>
                                </div>
                            </div>";     
                }    
                    $output .="";
                    echo $output;
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <h2>
                                    Connect with me
                                </h2>
                            <ul>
                                <?php
                                    $output="";
                                    $stmt = $pdo->prepare("SELECT * FROM about_me");
                                    $stmt->execute();
                                    // Fetch the records so we can display them in our template.
                                    $about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($about_me as $row) {
                                        $phone_number = $row['phone_number'];
                                        $email = $row['email'];

                                    $output .= "<li>
                                                    <strong>Number:</strong>  <a href='tel:$phone_number'> $phone_number</a>
                                                </li>
                                                <li class='mb-3'>
                                                    <strong>Email:</strong> <a href='mailto:$email'> $email</a>
                                                </li>";     
                                    }    
                                    $output .="";
                                    echo $output;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<?php if ($msg): ?>
    <p><?=$msg?></p>
<?php endif; ?>
<?=template_footer()?>