<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['cardID'])) {
    if (!empty($_POST)) {
        $path = '../../../assets/upload/interests/';
        $card_img = $path . $_FILES['profile']['name'];
        move_uploaded_file($_FILES['profile']['tmp_name'], $card_img);
        $newPath = '/SIR-project/assets/upload/interests/';
        $card_img = $newPath . $_FILES['profile']['name'];
        // This part is similar to the create.php, but instead we update a record and not insert
        $card_desc = isset($_POST['card_desc']) ? $_POST['card_desc'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE interests SET card_img = ?, card_desc = ? WHERE cardID = ?');
        $stmt->execute([$card_img, $card_desc, $_GET['cardID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM interests WHERE cardID = ?');
    $stmt->execute([$_GET['cardID']]);
    $interest = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$interest) {
        exit('Interest card doesn\'t exist with that ID!');
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Interest Cards</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update Interest Card #<?=$interest['cardID']?></h5>
        </div>
        <div class="card-body">
        <form action="update.php?cardID=<?=$interest['cardID']?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="card_img">Card Image</label>
                <div class="col-sm-10">
                <input type="file" name="profile" placeholder="Card Image" value="<?=$interest['card_img']?>"  class="form-control" id="profile" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="card_desc">Card Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="card_desc" id="card_desc" rows="3"><?=$interest['card_desc']?></textarea>
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Interest Cards</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Interest Cards</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <div class="row mb-5 mt-5">
                                    <?php
                                        $output="";
                                        $stmt = $pdo->prepare("SELECT * FROM interests ORDER BY cardID");
                                        $stmt->execute();
                                        // Fetch the records so we can display them in our template.
                                        $interests = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($interests as $row) {
                                            $card_img = $row['card_img'];
                                            $card_desc = $row['card_desc'];

                                            $output .= "<div class='col-lg-4 mb-5'>
                                            <div class='card' style='width: 18rem;''>
                                                <img class='card-img-top' src='$card_img'>
                                                <div class='card-body'>
                                                    <p class='card-text'>$card_desc</p>
                                                </div>
                                            </div>
                                        </div>";     
                                        }    
                                        echo $output;  
                                    ?>
                                </div>
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