<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['languageID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/languages/';
        $language_icon = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $language_icon);
        $newPath = '/SIR-project/assets/upload/languages/';
        $language_icon = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $language_name = isset($_POST['language_name']) ? $_POST['language_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE languages SET language_name = ?, language_icon = ? WHERE languageID = ?');
        $stmt->execute([$language_name, $language_icon, $_GET['languageID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE languageID = ?');
    $stmt->execute([$_GET['languageID']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('Language doesn\'t exist with that ID!');
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Languages</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update Language #<?=$language['languageID']?></h5>
        </div>
        <div class="card-body">
        <form action="update.php?languageID=<?=$language['languageID']?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="language_name">Language</label>
                <div class="col-sm-10">
                <input type="text" name="language_name" placeholder="language_name" value="<?=$language['language_name']?>"  class="form-control" id="language_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="language_icon">Language Icon</label>
                <div class="col-sm-10">
                <input type="file" name="profile" value="<?=$language['language_icon']?>" class="form-control" id="profile" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Languages</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Languages</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <ul class="list-inline dev-icons">
                                    <?php
                                        $output="";
                                        $stmt = $pdo->prepare("SELECT * FROM languages ORDER BY languageID");
                                        $stmt->execute();
                                        // Fetch the records so we can display them in our template.
                                        $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($languages as $row) {
                                            $language_icon = $row['language_icon'];

                                            $output .= "<li class='list-inline-item'><img with='50' height='50'src='$language_icon'></li>";     
                                        }    
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
</div>
<!-- / Content -->

<?=template_footer()?>