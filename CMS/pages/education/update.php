<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the aboutme id exists, for example update.php?id=1 will get the aboutme with the id of 1
if (isset($_GET['educationID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $school_title = isset($_POST['school_title']) ? $_POST['school_title'] : '';
        $course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
        $gpa = isset($_POST['gpa']) ? $_POST['gpa'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE education SET school_title = ?, course_name = ?, description = ?, date_start = ?, date_end = ?, gpa = ? WHERE educationID = ?');
        $stmt->execute([$school_title, $course_name, $description, $date_start, $date_end, $gpa, $_GET['educationID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the fields from the about_me table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE educationID = ?');
    $stmt->execute([$_GET['educationID']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
        exit('education doesn\'t exist with that ID!');
    }
} else {
    exit('No educationID specified!');
}
?>

<?=template_header('Read')?>

<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Educations</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update a education #<?=$education['educationID']?></h5>
        </div>
        <div class="card-body">
        <form action="update.php?educationID=<?=$education['educationID']?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="school_title">School Title</label>
                <div class="col-sm-10">
                <input type="text" name="school_title" placeholder="School Title" value="<?=$education['school_title']?>" class="form-control" id="school_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="course_name">Course Name</label>
                <div class="col-sm-10">
                <input type="text" name="course_name" placeholder="Company Name" value="<?=$education['course_name']?>" class="form-control" id="course_name" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" placeholder="Description" name="description" id="description" rows="3"><?=$education['description']?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_start">Start Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_start" placeholder="Start Date" value="<?=$education['date_start']?>" class="form-control" id="date_start" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="date_end">End Date</label>
                <div class="col-sm-10">
                <input type="month" name="date_end" placeholder="End Date" value="<?=$education['date_end']?>" class="form-control" id="date_end" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="gpa">GPA</label>
                <div class="col-sm-10">
                <input type="text" name="gpa" placeholder="GPA" value="<?=$education['gpa']?>" class="form-control" id="gpa" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Educations</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Educations</h5>
        </div>
            <div class="card-body">
                <?php
                    $output="";
                    $stmt = $pdo->prepare("SELECT * FROM education ORDER BY date_end DESC");
                    $stmt->execute();
                    // Fetch the records so we can display them in our template.
                    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($educations as $row) {
                        $school_title = $row['school_title'];
                        $course_name = $row['course_name'];
                        $description = $row['description'];
                        $date_start = date('F Y', strtotime($row['date_start']));
                        $date_end = date('F Y', strtotime($row['date_end']));
                        $gpa = $row['gpa'];
                        
                    $output .= "<div class='row'>
                        <div class='col-lg-12'>
                            <div class='d-flex flex-column flex-md-row justify-content-between'>
                                <div class='flex-grow-1'>
                                    <h3 class='mb-0'>$school_title</h3>
                                    <div class='subheading mb-3'>$course_name</div>
                                    <p>GPA: $gpa</p>
                                </div>
                                <div class='flex-shrink-0'><span class='text-primary'>$date_start - $date_end</span></div>
                            </div>
                        </div>
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