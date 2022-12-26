<?php
include "CMS/db/connection.php";
$pdo = pdo_connect_mysql();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Professional Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="assets/imgs/favicon-macho.png" />

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body id="page-top">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="navMenu">
            <a class="navbar-brand" href="#page-top">
                <span class="d-block d-lg-none">Carlos Macho</span>
                <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="assets/imgs/profile.jpg" alt="imagem de perfil" /></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mt-2">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#experience">Experience</a></li>
                <li class="nav-item"><a class="nav-link" href="#education">Education</a></li>
                <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
                <li class="nav-item"><a class="nav-link" href="#interests">Interests</a></li>
                <li class="nav-item"><a class="nav-link" href="#stats">Statistics</a></li>
                <li class="nav-item"><a class="nav-link" href="#footer">Contact Me</a></li>
            </ul>
            </div>
          </nav>
    </header>
    <main>
        <!-- Back to top button -->
        <button
            type="button"
            class="btn btn-secondary btn-floating btn-lg"
            id="btn-back-to-top"
            >
        <i class="fas fa-arrow-up"></i>
        </button>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section" id="about">
                <div class="container">
                    <?php
                        $output="";
                        $stmt = $pdo->prepare("SELECT * FROM about_me");
                        $stmt->execute();
                        // Fetch the records so we can display them in our template.
                        $about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($about_me as $row) {
                            $user_name = $row['user_name'];
                            list($firstName, $lastName) = explode(' ', $user_name);
                            $title_desc = $row['title_desc'];
                            $userPhoto = $row['userPhoto'];
                            $section_desc = $row['section_desc'];

                        $output .= "<div class='row'>
                                        <div class='col-lg-9'>
                                            <div class='resume-section-content'>
                                                <h1 class='mb-0'>
                                                    $firstName
                                                    <span class='text-primary'>$lastName</span>
                                                </h1>
                                                <div class='subheading mb-5'>
                                                    $title_desc
                                                </div>
                                                <p class='mb-5'>$section_desc</p>
                                            </div>
                                        </div>
                                        <div class='col-lg-3'>
                                            <div class='resume-section-content'>
                                                <span class='d-lg-block'><img class='img-fluid img-profile2 rounded-circle mx-auto mt-4 mb-4' src='$userPhoto' alt='profile picture' /></span>
                                            </div>
                                        </div>
                                    </div>";     
                        }    
                        $output .="";
                        echo $output;
                        ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <h2>
                                    Connect with me
                                </h2>

                                <ul>
                                    <?php
                                        $output="";
                                        $stmt = $pdo->prepare("SELECT * FROM about_me");
                                        $stmt->execute();
                                        // Fetch the records so we can display them in our template.
                                        $about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($about_me as $row) {
                                            $phone_number = $row['phone_number'];
                                            $email = $row['email'];

                                        $output .= "<li>
                                                        <strong>Number:</strong>  <a href='tel:$phone_number'> $phone_number</a>
                                                    </li>
                                                    <li class='mb-3'>
                                                        <strong>Email:</strong> <a href='mailto:$email'> $email</a>
                                                    </li>";     
                                        }    
                                        $output .="";
                                        echo $output;
                                    ?>
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
            </section>
            <hr class="m-0" />
            <!-- Experience-->
            <section class="resume-section" id="experience">
                <div class="resume-section-content">
                    <h2 class="mb-5">Experience</h2>
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
            </section>
            <hr class="m-0" />
            <!-- Education-->
            <section class="resume-section" id="education">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <h2 class="mb-5">Education</h2>
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
            </section>
            <hr class="m-0" />
            <!-- Skills-->
            <section class="resume-section" id="skills">
                <div class="resume-section-content">
                    <h2 class="mb-5">Skills</h2>
                    <div class="subheading mb-3">Programming Languages & Tools</div>
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
                    <div class="subheading mb-3">Soft Skills</div>
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
            </section>
            <hr class="m-0" />
            <!-- Interests-->
            <section class="resume-section" id="interests">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="resume-section-content">
                            <h2 class="mb-5">Interests</h2>
                            <p>Here you can see some of my interests and what i like to do in my freetime</p>
                        </div>
                    </div>
                </div>
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
            </section>
            <hr class="m-0" />
            <!-- Stats-->
            <section class="resume-section" id="stats">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <h2 class="mb-5">Statistical Data</h2>
                            </div>
                        </div>
                      </div>
                    <div class="row">
                        <div class="col-lg-6">
                            &nbsp;<img src="https://github-readme-stats.vercel.app/api?username=carlosmacho&theme=vue-dark&show_icons=true"
                            alt="carlosmacho" />
                          </div>
                          <div class="col-lg-6 d-flex">
                            <img src="https://streak-stats.demolab.com?user=carlosmacho&theme=vue-dark" alt="carlosmacho" />
                          </div>
                      </div>
                      <div class="row mt-2">
                        <!-- <div class="col-lg-12 d-flex">
                            <img src="https://github-readme-activity-graph.cyclic.app/graph?username=carlosmacho&theme=vue" alt="carlosmacho" />
                          </div>                          -->
                      </div>
                  </div>
            </section>
        </div>
    </main>
    <hr class="m-0" />
    <!-- Contact Form-->
    <div class="container">
        <div class=" text-center mt-5 ">
            <h1 >Contact Form</h1>
        </div>
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <form id="contact-form" role="form" action="/SIR-Project/CMS/pages/contacts/createForm.php" method="post">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">Firstname *</label>
                                        <input id="firstname" type="text" name="firstname" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Lastname *</label>
                                        <input id="lastname" type="text" name="lastname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input id="email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Message *</label>
                                        <textarea id="message" name="message" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea
                                            >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success btn-send  pt-2 btn-block
                                        " value="Send Message" >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.8 -->
        </div>
        <!-- /.row-->
    </div>
     <!-- place footer here -->
    <footer id="footer">
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>Carlos Macho © 2022-23, All Rights Reserved</span>
                    </div>
                    <!-- End Col -->
                    <div class="col-md-6">
                        <div class="copyright-menu">
                            <ul>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#">Terms</a>
                                </li>
                                <li>
                                    <a href="#">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Copyright Container -->
    </footer>
    
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <!-- My JavaScript scripts -->
    <script src="assets/js/js-functions.js">
    </script>
</body>
</html>