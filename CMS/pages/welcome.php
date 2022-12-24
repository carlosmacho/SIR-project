<?php 
    require "../../utils/header.php";
    require "../db/connection.php";
    $username = $_SESSION["username"];
    $userRole = $_SESSION["userType"];

    $pdo = pdo_connect_mysql();
    $msg = '';


    // Check if POST data is not empty
if (!empty($_POST)) {    
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variables exists, if not default the value to blank, basically the same for all variables
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $userType = isset($_POST['userType']) ? $_POST['userType'] : '';
    // Change the line below to your timezone!
    date_default_timezone_set('Europe/London');
    // Insert new record into the about_me table
    $sql = "INSERT INTO users (id, userType, username, password) VALUES (UUID(), :userType, :username, :password)";

    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":userType", $param_userType, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        
        $param_username = $username;
        $param_userType= $userType;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
        if($stmt->execute()){
            header("location: login.php");
        } 
        else{
            echo "Ups! Try again please.";
        }

        unset($stmt);
    }

    // Output message
    $msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
    header("Refresh:2; url=welcome.php", true, 203);

}
?>
<?=template_header('Create')?>
<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Create Users</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Create a user</h5>
        </div>
        <div class="card-body">
            <form action="welcome.php" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="id">User ID</label>
                <div class="col-sm-10">
                <input type="text" name="id" disabled placeholder="26" value="auto" class="form-control" id="id" placeholder="User ID" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Select a role</label>
                <div class="col-sm-10">
                <select class="form-select form-select-lg mb-3" for="userType" name="userType">
                    <option selected>Select a role</option>
                        <?php
                            $output="";
                            $stmt = $pdo->prepare("SELECT * FROM roles");
                            $stmt->execute();
                            // Fetch the records so we can display them in our template.
                            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($roles as $row) {
                                $role = $row['userRole'];
                            
                            $output .= "<option value='$role'>$role</option>";     
                            }    
                            $output .="";
                            echo $output;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="username">Username</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <input
                    type="text"
                    id="username"
                    class="form-control"
                    placeholder="username or email"
                    aria-label="username"
                    aria-describedby="basic-default-email2"
                    name="username"
                    required="required" 
                    data-error="Please enter your username *"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                </div>
                <div class="form-text">You can use letters, numbers & periods</div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="password">Password</label>
                <div class="col-sm-10">
                <input
                    type="password"
                    id="password"
                    class="form-control phone-mask"
                    placeholder="password"
                    aria-label="password"
                    aria-describedby="basic-default-phone"
                    name="password"
                    required="required" 
                    data-error="Please enter your password *"
                />
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- / Content -->
<?php
$msg = 'Created Successfully! You will be redirected to your account page in 2 seconds....';
?>
<?=template_footer()?>