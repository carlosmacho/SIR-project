<?php 
    require "../../utils/header.php";
    require "../db/connection.php";
    $username = $_SESSION["username"];
    $userRole = $_SESSION["userType"];
?>

<?=template_header('Read')?>

<h2> Hello, <?php echo $username ?></h2>
<p>My first paragraph.</p>


<?=template_footer()?>