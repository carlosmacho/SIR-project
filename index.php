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
    <link rel="stylesheet" href="css/styles.css">
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
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section" id="about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="resume-section-content">
                                <h1 class="mb-0">
                                    Carlos
                                    <span class="text-primary">Macho</span>
                                </h1>
                                <div class="subheading mb-5">
                                    Computer Science Student at IPVC, Viana do Castelo.
                                </div>
                                <p class="mb-5">From Póvoa de Varzim, always willing to brainstorm to solve any problem. I'm quick to adjust to new environments and i always try to be very helpful overall. Can awalys count on me!</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="resume-section-content">
                                <span class="d-lg-block"><img class="img-fluid img-profile2 rounded-circle mx-auto mt-4 mb-4" src="assets/imgs/profile.jpg" alt="imagem de perfil" /></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="resume-section-content">
                                <h2>
                                    Connect with me
                                </h2>
                                <ul>
                                    <li>
                                        <strong>Number:</strong>  <a href="tel:+35191XXXXXXX"> 91X-XXX-XXX</a>
                                    </li>
                                    <li class="mb-3">
                                        <strong>Email:</strong> <a href="mailto:carlosmacho@ipvc.pt"> carlosmacho@ipvc.pt</a>
                                    </li>
                                    <div class="social-icons">
                                        <a class="social-icon" href="https://www.linkedin.com/in/carlos-macho-599860152/" target="blank"><i class="fab fa-linkedin-in"></i></a>
                                        <a class="social-icon" href="https://github.com/carlosmacho" target="blank"><i class="fab fa-github"></i></a>
                                        <a class="social-icon" href="https://instagram.com/machof1" target="blank"><i class="fab fa-instagram"></i></a>
                                        <a class="social-icon" href="https://www.facebook.com/carlos.macho3" target="blank"><i class="fab fa-facebook-f"></i></a>
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
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">PC Repair Intern</h3>
                            <div class="subheading mb-3">Chip7</div>
                            <p>Internship at a local chip7 shop. Learned and helped fixing computer hardware problems.</p>
                        </div>
                        <div class="flex-shrink-0"><span class="text-primary">April 2018 - July 2018</span></div>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">Software Intern</h3>
                            <div class="subheading mb-3">Moldart</div>
                            <p>C# Software Intern at MoldartPovoa. Helped to implement a tablet to be placed at every worker machine to register their hours and functions.</p>
                        </div>
                        <div class="flex-shrink-0"><span class="text-primary">May 2017 - July 2017</span></div>
                    </div>
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
                            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                                <div class="flex-grow-1">
                                    <h3 class="mb-0">Polytechnic Institute of Viana do Castelo</h3>
                                    <div class="subheading mb-3">Bachelor of Science</div>
                                    <div>Computer Science</div>
                                    <p>GPA: 12.79</p>
                                </div>
                                <div class="flex-shrink-0"><span class="text-primary">September 2018 - June 2023</span></div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div class="flex-grow-1">
                                    <h3 class="mb-0">Rocha Peixoto High School</h3>
                                    <div class="subheading mb-3">Professional Course in Management Informatics</div>
                                    <p>GPA: 16</p>
                                </div>
                                <div class="flex-shrink-0"><span class="text-primary">September 2015 - June 2018</span></div>
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
                        <li class="list-inline-item"><i class="fab fa-html5"></i></li>
                        <li class="list-inline-item"><i class="fab fa-css3-alt"></i></li>
                        <li class="list-inline-item"><i class="fab fa-js-square"></i></li>
                        <li class="list-inline-item"><i class="fab fa-angular"></i></li>
                        <li class="list-inline-item"><i class="fab fa-java"></i></li>
                        <li class="list-inline-item"><i class="fab fa-react"></i></li>
                        <li class="list-inline-item"><i class="fab fa-node-js"></i></li>
                        <li class="list-inline-item"><i class="fab fa-sass"></i></li>
                        <li class="list-inline-item"><i class="fab fa-php"></i></li>
                        <li class="list-inline-item"><i class="fab fa-python"></i></li>
                        <li class="list-inline-item"><i class="fab fa-vuejs"></i></li>
                        <li class="list-inline-item"><i class="fab fa-docker"></i></li>
                        <li class="list-inline-item"><i class="fab fa-npm"></i></li>
                    </ul>
                    <div class="subheading mb-3">Soft Skills</div>
                    <ul class="fa-ul mb-0">
                        <li>
                            <span class="fa-li"><i class="fas fa-check"></i></span>
                            Teamplayer
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-check"></i></span>
                            Problem-Solver
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-check"></i></span>
                            Adaptable to work environments
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-check"></i></span>
                            Great Communication
                        </li>
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
                  <div class="col-lg-4 mb-5">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="assets/imgs/travel.webp" alt="Traveling">
                        <div class="card-body">
                          <p class="card-text">As much as i love staying in my confortable home, i also love going out to explore new places!</p>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-4 mb-5">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="assets/imgs/gaming.webp" alt="Gaming">
                        <div class="card-body">
                          <p class="card-text">Gaming is in one of my top go-to's in my hobbies!</p>
                          <p class="card-text">Some of my favourites are:</p>
                          <ul>
                            <li>
                                Valorant
                            </li>
                            <li>
                                Phasmophobia
                            </li>
                            <li>
                                Metin2
                            </li>
                            <li>
                                Apex Legends
                            </li>
                            <li>
                                Call Of Duty
                            </li>
                            <li>
                                Grounded
                            </li>
                          </ul>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="assets/imgs/music.jpg" alt="Music">
                        <div class="card-body">
                          <p class="card-text">Can´t live without music. Music is present in my life everywhere i go. Not to mention i also play an instrument!</p>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                My favourite quote in Tech
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                <p>Developer is an organism that turns coffee into code.</p>
                                <footer class="blockquote-footer">Anonymous <cite title="Source Title"></cite></footer>
                                </blockquote>
                            </div>
                        </div>
                  </div>
              </div>
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
                        <div class="col-lg-12">
                            <img src="https://activity-graph.herokuapp.com/graph?username=carlosmacho&theme=vue" alt="carlosmacho" />
                          </div>                         
                      </div>
                  </div>
            </section>
        </div>
    </main>
    <hr class="m-0" />
     <!-- place footer here -->
    <footer id="footer">
        <div class="container">
            <div class=" text-center mt-5 ">
                <h1 >Contact Form</h1>
            </div>
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-4 bg-light">
                    <div class="card-body bg-light">
                        <form id="contact-form" role="form">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_name">Firstname *</label>
                                            <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_lastname">Lastname *</label>
                                            <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_email">Email *</label>
                                            <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_need">Please specify your need *</label>
                                            <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                                                <option value="" selected disabled>--Select Your Reason--</option>
                                                <option >Request for CV details</option>
                                                <option >Request for Interview schedule</option>
                                                <option >Request for contact info</option>
                                                <option >Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_message">Message *</label>
                                            <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea
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
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>
</html>