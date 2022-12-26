<?php
require "../../../utils/header.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['quoteID'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $quote_title = isset($_POST['quote_title']) ? $_POST['quote_title'] : '';
        $quote_desc = isset($_POST['quote_desc']) ? $_POST['quote_desc'] : '';
        $quote_author = isset($_POST['quote_author']) ? $_POST['quote_author'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE quotes SET quote_title = ?, quote_desc = ?, quote_author = ? WHERE quoteID = ?');
        $stmt->execute([$quote_title, $quote_desc, $quote_author, $_GET['quoteID']]);
        $msg = 'Updated Successfully! You will be redirected to your account page in 2 seconds....';
        header("Refresh:2; url=read.php", true, 202);
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM quotes WHERE quoteID = ?');
    $stmt->execute([$_GET['quoteID']]);
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$quote) {
        exit('quote doesn\'t exist with that ID!');
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Quotes</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Update Quote #<?=$quote['quoteID']?></h5>
        </div>
        <div class="card-body">
        <form action="updateQuote.php?quoteID=<?=$quote['quoteID']?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="quote_title">Quote Title</label>
                <div class="col-sm-10">
                <input type="text" name="quote_title" placeholder="Quote Title" value="<?=$quote['quote_title']?>"  class="form-control" id="quote_title" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="quote_desc">Quote Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="quote_desc" id="quote_desc" rows="3"><?=$quote['quote_desc']?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="quote_author">Quote Author</label>
                <div class="col-sm-10">
                <input type="text" name="quote_author" placeholder="Quote Author" value="<?=$quote['quote_author']?>"  class="form-control" id="quote_author" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Preview/</span> Quote Cards</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Quote Cards</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <?php
                                    $output="";
                                    $stmt = $pdo->prepare("SELECT * FROM quotes ORDER BY quoteID");
                                    $stmt->execute();
                                    // Fetch the records so we can display them in our template.
                                    $quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    $output="<h2>My favourite quotes</h2>
                                                <div class='row'>";
                                    foreach($quotes as $row) {
                                        $quote_title = $row['quote_title'];
                                        $quote_desc = $row['quote_desc'];
                                        $quote_author = $row['quote_author'];

                                        $output .= "<div class='col-lg-6 mt-2 mb-2'>
                                                        <div class='card'>
                                                            <div class='card-header'>
                                                                $quote_title
                                                            </div>
                                                            <div class='card-body'>
                                                                <blockquote class='blockquote mb-0'>
                                                                    <p>$quote_desc</p>
                                                                    <footer class='blockquote-footer'>$quote_author <cite title='Source Title'></cite></footer>
                                                                </blockquote>
                                                            </div>
                                                        </div>
                                                    </div>";     
                                    }    
                                    $output .= "</div>";
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
<!-- / Content -->

<?=template_footer()?>