<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /SIR-project/CMS/auth/login.php");
    exit;
}

function create_menu() {
    $userRole = $_SESSION["userType"];

    if ($userRole == "Admin") {
        // Create menu for admin
        echo '<a href="/SIR-project/CMS/pages/welcome.php">Home</a>';
        echo '<a href="/SIR-project/CMS/pages/aboutme/read.php">About me</a>';
        echo '<a href="/SIR-project/CMS/pages/experience/read.php">Experience</a>';
        echo '<a href="/SIR-project/CMS/pages/education/read.php">Education</a>';
        echo '<a href="/SIR-project/CMS/pages/languages/read.php">Skills</a>';
        echo '<a href="/SIR-project/CMS/pages/interests/read.php">Interests</a>';
        echo '<a href="/SIR-project/CMS/pages/contacts/read.php">Contacts</a>';

    } else if ($userRole == "Manager") {
        // Create menu for manager
        echo '<a href="/SIR-project/CMS/pages/welcome.php">Home</a>';
        echo '<a href="/SIR-project/CMS/pages/aboutme/read.php">About me</a>';
        echo '<a href="/SIR-project/CMS/pages/experience/read.php">Experience</a>';
        echo '<a href="/SIR-project/CMS/pages/education/read.php">Education</a>';
        echo '<a href="/SIR-project/CMS/pages/languages/read.php">Skills</a>';
        echo '<a href="/SIR-project/CMS/pages/interests/read.php">Interests</a>';
        echo '<a href="/SIR-project/CMS/pages/contacts/read.php">Contacts</a>';
    }
}

function template_header($title) {
	$username  = $_SESSION["username"];
	$userID  = $_SESSION["id"];
	$userRole = $_SESSION["userType"];

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="/SIR-project/utils/style.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link rel="stylesheet" href="/SIR-project/assets/css/styles.css">
	</head>
	<body>
	<nav class="navtop">
		<div>
			<h1>Hello, $username , id:$userID , role:$userRole</h1>
EOT;
create_menu();
echo <<<EOT
			<a href="/SIR-project/CMS/auth/logout.php">Logout</a>
		</div>
	</nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>