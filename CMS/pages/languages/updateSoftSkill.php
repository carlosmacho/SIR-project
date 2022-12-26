<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the id exists, for example update.php?id=1 will get the softskill with the id of 1
if (isset($_GET['softskillID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $softskill_name = isset($_POST['softskill_name']) ? $_POST['softskill_name'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE soft_skills SET softskill_name = ? WHERE softskillID = ?');
        $stmt->execute([$softskill_name, $_GET['softskillID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the softskill from the softskills table
    $stmt = $pdo->prepare('SELECT * FROM soft_skills WHERE softskillID = ?');
    $stmt->execute([$_GET['softskillID']]);
    $softskill = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$softskill) {
        exit('soft skill doesn\'t exist with that ID!');
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Soft Skills</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update Soft Skills #<?=$softskill['softskillID']?></h5>
        </div>
        <div class="card-body">
        <form action="updateSoftSkill.php?softskillID=<?=$softskill['softskillID']?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="softskill_name">softskill</label>
                <div class="col-sm-10">
                <input type="text" name="softskill_name" placeholder="softskill_name" value="<?=$softskill['softskill_name']?>"  class="form-control" id="softskill_name" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Soft Skills</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Soft Skills</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <ul class="fa-ul mb-0">
                                    <?php
                                        $output="";
                                        $stmt = $pdo->prepare("SELECT * FROM soft_skills ORDER BY softskillID");
                                        $stmt->execute();
                                        // Fetch the records so we can display them in our template.
                                        $softskills = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($softskills as $row) {
                                            $softskill_name = $row['softskill_name'];

                                            $output .= "<li>
                                            <span class='fa-li'><i class='fas fa-check'></i></span>
                                            $softskill_name
                                        </li>";     
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