<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['experienceID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
        $company_title = isset($_POST['company_title']) ? $_POST['company_title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE experience SET job_title = ?, company_title = ?, description = ?, date_start = ?, date_end = ? WHERE experienceID = ?');
        $stmt->execute([$job_title, $company_title, $description, $date_start, $date_end, $_GET['experienceID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the experience table
    $stmt = $pdo->prepare('SELECT * FROM experience WHERE experienceID = ?');
    $stmt->execute([$_GET['experienceID']]);
    $experience = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$experience) {
        exit('experienceID doesn\'t exist with that ID!');
    }
} else {
    exit('No experienceID specified!');
}
?>

<?=template_header('Read')?>

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Experiences</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update a experience #<?=$experience['experienceID']?></h5>
        </div>
        <div class="card-body">
            <form action="update.php?experienceID=<?=$experience['experienceID']?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="job_title">Job Title</label>
                <div class="col-sm-10">
                <input type="text" name="job_title" placeholder="Job Title" value="<?=$experience['job_title']?>" class="form-control" id="job_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="company_title">Company Name</label>
                <div class="col-sm-10">
                <input type="text" name="company_title" placeholder="Company Name" value="<?=$experience['company_title']?>" class="form-control" id="company_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-10">
                <input type="text" name="description" placeholder="Description" value="<?=$experience['description']?>" class="form-control" id="description" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_start">Start Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_start" placeholder="Start Date" value="<?=$experience['date_start']?>" class="form-control" id="date_start" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_end">End Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_end" placeholder="End Date" value="<?=$experience['date_end']?>" class="form-control" id="date_end" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Experiences</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Experiences</h5>
        </div>
            <div class="card-body">
                <?php
                    $output="";
                    $stmt = $pdo->prepare("SELECT * FROM experience ORDER BY date_end DESC");
                    $stmt->execute();
                    // Fetch the records so we can display them in our template.
                    $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($experiences as $row) {
                        $job_title = $row['job_title'];
                        $company_name = $row['company_title'];
                        $description = $row['description'];
                        $date_start = date('F Y', strtotime($row['date_start']));
                        $date_end = date('F Y', strtotime($row['date_end']));
                        
                    $output .= "<div class='d-flex flex-column flex-md-row justify-content-between'>
                                <div class='flex-grow-1'>
                                    <h3 class='mb-0'>$job_title</h3>
                                    <div class='subheading mb-3'>$company_name</div>
                                    <p>$description</p>
                                </div>
                                <div class='flex-shrink-0'><span class='text-primary'>$date_start - $date_end</span></div>
                            </div>";     
                    }    
                    $output .="";
                    echo $output;
                ?>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<?=template_footer()?>