<?php
include("func.php");
session_start();
conn();

if (!isset($_SESSION["ID"])) {
    header("location:login.php");
}
$name = $_SESSION["NAME"];
$lname = $_SESSION["LNAME"];
$pos = $_SESSION['POS'];

$row1 = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-001'"));
$permis1 = $row1['permis'];
$row2 = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-002'"));
$permis2 = $row2['permis'];
$row3 = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-003'"));
$permis3 = $row3['permis'];
$row4 = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-004'"));
$permis4 = $row4['permis'];
$row5 = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' and pp_perid='PER-005'"));
$permis5 = $row5['permis'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">MANAGE</h2><br>
            <div class=" text-center text-uppercase ">
                <?php echo $name . " " . $lname ?>
            </div>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Item 1-->
                <?php if ($permis1) : ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal1">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/jobs.png" alt="..." />
                            <div style="text-align: center">Position&Permis</div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6 col-lg-4 mb-5" style="pointer-events: none; opacity: 0.5;">
                        <div class="portfolio-item mx-auto">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/jobs.png" alt="..." />
                            <div style="text-align: center">Position&Permis</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Item 2-->
                <?php if ($permis2) : ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal2">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/people.png" alt="..." />
                            <div style="text-align: center">Admin&Customers</div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6 col-lg-4 mb-5" style="pointer-events: none; opacity: 0.5;">
                        <div class="portfolio-item mx-auto">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/people.png" alt="..." />
                            <div style="text-align: center">Admin&Customers</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Item 3-->
                <?php if ($permis3) : ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal3">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/books.png" alt="..." />
                            <div style="text-align: center">Type Book&Book</div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6 col-lg-4 mb-5" style="pointer-events: none; opacity: 0.5;">
                        <div class="portfolio-item mx-auto">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/books.png" alt="..." />
                            <div style="text-align: center">Type Book&Book</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Item 4-->
                <?php if ($permis4) : ?>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal4">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/dollar.png" alt="..." />
                            <div style="text-align: center">Set Date&Payment</div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" style="pointer-events: none; opacity: 0.5;">
                        <div class="portfolio-item mx-auto">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/dollar.png" alt="..." />
                            <div style="text-align: center">Set Date&Payment</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Item 5-->
                <?php if ($permis5) : ?>
                    <div class="col-md-6 col-lg-4 mb-5 mb-md-0">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal5">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/report.png" alt="..." />
                            <div style="text-align: center">Report</div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-6 col-lg-4 mb-5 mb-md-0" style="pointer-events: none; opacity: 0.5;">
                        <div class="portfolio-item mx-auto">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/report.png" alt="..." />
                            <div style="text-align: center">Report</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Item 6-->
                <div class="col-md-6 col-lg-4">
                    <div class="portfolio-item mx-auto" data-bs-target="#portfolioModal6">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center ">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <a href="logout.php"><img class="img-fluid" src="assets/img/portfolio/logout.png" /></a>
                        <div style="text-align: center">Logout</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Your Website 2023</small></div>
    </div>
    <!-- Portfolio Modal 1-->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" aria-labelledby="portfolioModal1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Position&Permis
                                </h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center me-4">
                                        <a href="position/position.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/jobs.png" alt="Jobs" height="200" width="200" />
                                        </a>
                                        <p>Position</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="permis/permis.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/permis.png" alt="Permis" height="200" width="200" />
                                        </a>
                                        <p>Permis</p>
                                    </div>
                                </div>


                                <!-- Portfolio Modal - Text-->
                                <div>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-xmark fa-fw"></i>
                                        Close Window
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 2-->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" aria-labelledby="portfolioModal2" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Admin&Customer</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center me-4">
                                        <a href="admin/admin.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/admin.png" alt="Admin" height="200" width="200" />
                                        </a>
                                        <p>Admin</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="cus/cus.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/customer.png" alt="Customer" height="200" width="200" />
                                        </a>
                                        <p>Customer</p>
                                    </div>
                                </div>

                                <!-- Portfolio Modal - Text-->
                                <div>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-xmark fa-fw"></i>
                                        Close Window
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 3-->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" aria-labelledby="portfolioModal3" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">TYPE BOOK&BOOK</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center me-4">
                                        <a href="book/typebook.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/typebook.png" alt="Type Book" height="200" width="200" />
                                        </a>
                                        <p>Type Book</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="book/book.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/book2.png" alt="Book" height="200" width="200" />
                                        </a>
                                        <p>Book</p>
                                    </div>
                                </div>



                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 4-->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" aria-labelledby="portfolioModal4" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">SET DATE&PAYMENT</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center me-4">
                                        <a href="finance/finance.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/date.png" alt="Finance" height="200" width="200" />
                                        </a>
                                        <p>Finance</p>
                                    </div>
                                    <div class="text-center me-4">
                                        <a href="finance/coin.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/coins.png" alt="Coins" height="200" width="200" />
                                        </a>
                                        <p>Coins</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="finance/bank.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/bank.png" alt="Bank" height="200" width="200" />
                                        </a>
                                        <p>Bank</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="finance/payment.php?rou=ROU-001">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/payment.png" alt="Bank" height="200" width="200" />
                                        </a>
                                        <p>Payment</p>
                                    </div>
                                </div>

                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal 5-->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" aria-labelledby="portfolioModal5" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Title-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Report</h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - Image-->
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center me-4">
                                        <a href="./report/rpt_income_expense.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/increase.png" alt="Finance" height="200" width="200" />
                                        </a>
                                        <p>Income and Expense</p>
                                    </div>

                                    <div class="text-center me-4">
                                        <a href="./report/rpt_toppublisher.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/top.png" alt="Coins" height="200" width="200" />
                                        </a>
                                        <p>Top Publisher</p>
                                    </div>


                                    <div class="text-center me-4">
                                        <a href="./report/rpt_dashboard.php">
                                            <img class="img-fluid rounded mb-2" src="assets/img/portfolio/dashboard.png" alt="Coins" height="200" width="200" />
                                        </a>
                                        <p>Dashboard</p>
                                    </div>

                                </div>

                                <button class="btn btn-primary" data-bs-dismiss="modal">
                                    <i class="fas fa-xmark fa-fw"></i>
                                    Close Window
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>