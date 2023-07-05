<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: ./dashboard/index.php");
    exit();
}

// Periksa apakah form dikirimkan
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi dan membersihkan data (opsional)

    // Buat koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistempakar";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Persiapkan dan jalankan query SQL untuk memvalidasi kredensial login
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah pengguna ada dan kata sandi benar
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Simpan data pengguna ke dalam sesi
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            // Tutup statement dan koneksi database
            $stmt->close();
            $conn->close();

            // Alihkan ke dashboard/index.php
            header("Location: http://localhost/FP-KCB/dashboard/index.php");
exit();

        }
    }

    // Tampilkan pesan kesalahan jika login gagal
    $error_message = "Email atau kata sandi tidak valid.";

    // Tutup statement dan koneksi database
    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hope UI | Responsive Bootstrap 5 Admin Dashboard Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="../../assets/css/core/libs.min.css" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="../../assets/css/hope-ui.min.css?v=2.0.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="../../assets/css/custom.min.css?v=2.0.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="../../assets/css/dark.min.css" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="../../assets/css/customizer.min.css" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="../../assets/css/rtl.min.css" />


</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="../../dashboard/index.html"
                                        class="navbar-brand d-flex align-items-center mb-3">
                                        <!--Logo start-->
                                        <!--logo End-->

                                        <!--Logo start-->
                                        <div class="logo-main">
                                            <div class="logo-normal">
                                                <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                                        transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                                    <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                                        transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                                    <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                                        transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                                    <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                                        transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                                                </svg>
                                            </div>
                                            <div class="logo-mini">
                                                <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                                        transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                                    <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                                        transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                                    <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                                        transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                                    <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                                        transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!--logo End-->




                                        <h4 class="logo-title ms-3">Sistem Pakar</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center">Login to stay connected.</p>
                                    <?php if (isset($error_message)) { ?>
                                    <p><?php echo $error_message; ?></p>
                                    <?php } ?>
                                    <form method="POST" action="sign-in.php">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        aria-describedby="email" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" aria-describedby="password" placeholder=" ">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">Remember
                                                        Me</label>
                                                </div>
                                                <a href="recoverpw.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                    transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="../../assets/images/auth/01.png" class="img-fluid gradient-main animated-scaleX"
                        alt="images">
                </div>
            </div>
        </section>
    </div>

    <!-- Library Bundle Script -->
    <script src="../../assets/js/core/libs.min.js"></script>

    <!-- External Library Bundle Script -->
    <script src="../../assets/js/core/external.min.js"></script>

    <!-- Widgetchart Script -->
    <script src="../../assets/js/charts/widgetcharts.js"></script>

    <!-- mapchart Script -->
    <script src="../../assets/js/charts/vectore-chart.js"></script>
    <script src="../../assets/js/charts/dashboard.js"></script>

    <!-- fslightbox Script -->
    <script src="../../assets/js/plugins/fslightbox.js"></script>

    <!-- Settings Script -->
    <script src="../../assets/js/plugins/setting.js"></script>

    <!-- Slider-tab Script -->
    <script src="../../assets/js/plugins/slider-tabs.js"></script>

    <!-- Form Wizard Script -->
    <script src="../../assets/js/plugins/form-wizard.js"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="../../assets/js/hope-ui.js" defer></script>

</body>

</html>