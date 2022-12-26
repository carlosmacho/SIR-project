<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['connectlinksID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/logotypes/';
        $logotype = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $logotype);
        $newPath = '/SIR-project/assets/upload/logotypes/';
        $logotype = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $link = isset($_POST['link']) ? $_POST['link'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE connect_links SET link = ?, logo = ? WHERE connectlinksID = ?');
        $stmt->execute([$link, $logotype, $_GET['connectlinksID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the table
    $stmt = $pdo->prepare('SELECT * FROM connect_links WHERE connectlinksID = ?');
    $stmt->execute([$_GET['connectlinksID']]);
    $connect_links = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$connect_links) {
        exit('connect_links doesn\'t exist with that ID!');
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Social Media</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update Social Media Link #<?=$connect_links['connectlinksID']?></h5>
        </div>
        <div class="card-body">
        <form action="updateLink.php?connectlinksID=<?=$connect_links['connectlinksID']?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="link">Link</label>
                <div class="col-sm-10">
                <input type="text" name="link" placeholder="Link" value="<?=$connect_links['link']?>"  class="form-control" id="link" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="logo">Link Logotype</label>
                <div class="col-sm-10">
                <input type="file" name="profile" value="<?=$connect_links['logo']?>" class="form-control" id="profile" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Social Media Links</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Connect with me</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <ul>
                                    <div class="social-icons">
                                        <?php
                                            $output="";
                                            $stmt = $pdo->prepare("SELECT * FROM connect_links as cl, about_me as ab WHERE cl.aboutmeID = ab.aboutmeID ORDER BY connectlinksID");
                                            $stmt->execute();
                                            // Fetch the records so we can display them in our template.
                                            $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($links as $row) {
                                                $link = $row['link'];
                                                $logo = $row['logo'];

                                            $output .= "<a class='social-icon' href='$link' target='blank'><img width='25' height='25' src='$logo'></a>";     
                                            }    
                                            $output .="";
                                            echo $output;
                                        ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<?=template_footer()?>