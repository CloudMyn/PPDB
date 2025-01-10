<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="PPDB SMP Negeri 2 Towuti">
    <meta name="author" content="SMP Negeri 2 Towuti">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <title>PPDB SMP Negeri 2 Towuti</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/templatemo-art-factory.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl-carousel.css">

    <style>
        body div.container nav.main-nav>a.logo {
            font-size: 22px;
        }

        @media (min-width: 768px) {

            body div.container nav.main-nav>a.logo {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">SMP Negeri 2 Towuti</a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#welcome" class="active">Beranda</a></li>
                            <li class="scroll-to-section"><a href="#about">Profil Sekolah</a></li>
                            <li class="scroll-to-section"><a href="#services">PPDB</a></li>
                            <li class="scroll-to-section"><a href="#frequently-question">Fasilitas</a></li>
                            <li class="scroll-to-section"><a href="#contact-us">Kontak</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Welcome Area Start ***** -->
    <div class="welcome-area" id="welcome">
        <div class="header-text">
            <div class="container">
                <div class="row">
                    <div class="left-text col-lg-6 col-md-6 col-sm-12 col-xs-12"
                        data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                        <h1>Selamat Datang di <strong>SMP Negeri 2 Towuti</strong></h1>
                        <p>Sekolah yang berkomitmen untuk memberikan pendidikan terbaik bagi generasi muda Indonesia.
                            Daftarkan diri Anda sekarang melalui PPDB Online.</p>

                        @if (auth()->check())
                            <a href="/siswa" class="main-button-slider">Dashboard</a>
                        @else
                            <a href="/siswa/login" class="main-button-slider">Daftar Sekarang</a>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"
                        data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                        <img src="/smp.png" class="rounded img-fluid d-block mx-auto" style="max-width: 250px"
                            alt="Sekolah">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Welcome Area End ***** -->

    <!-- ***** Profil Sekolah Start ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12"
                    data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <img src="/sekolah.webp" class="rounded img-fluid d-block mx-auto" alt="Gedung Sekolah">
                </div>
                <div class="right-text col-lg-5 col-md-12 col-sm-12 mobile-top-fix">
                    <div class="left-heading">
                        <h5>Profil SMP Negeri 2 Towuti</h5>
                    </div>
                    <div class="left-text">
                        <p>SMP Negeri 2 Towuti adalah sekolah menengah pertama yang terletak di Kabupaten Luwu Timur,
                            Sulawesi Selatan. Kami memiliki fasilitas yang lengkap dan tenaga pengajar yang berkualitas
                            untuk mendukung proses belajar mengajar.</p>
                        {{-- <a href="#about2" class="main-button">Selengkapnya</a> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Profil Sekolah End ***** -->

    <!-- ***** Informasi PPDB Start ***** -->
    <section class="section" id="services">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme">
                    <div class="item service-item">
                        <div class="icon">
                            <i><img src="assets/images/ppdb-icon.png" alt=""></i>
                        </div>
                        <h5 class="service-title">Pendaftaran Online</h5>
                        <p>Daftarkan diri Anda secara online melalui website resmi SMP Negeri 2 Towuti. Proses
                            pendaftaran mudah dan cepat.</p>
                        {{-- <a href="#" class="main-button">Daftar Sekarang</a> --}}
                    </div>
                    <div class="item service-item">
                        <div class="icon">
                            <i><img src="assets/images/calendar-icon.png" alt=""></i>
                        </div>
                        <h5 class="service-title">Jadwal PPDB</h5>
                        <p>Lihat jadwal lengkap PPDB SMP Negeri 2 Towuti untuk tahun ajaran baru. Pastikan Anda tidak
                            melewatkan tanggal penting.</p>
                        {{-- <a href="#" class="main-button">Lihat Jadwal</a> --}}
                    </div>
                    <div class="item service-item">
                        <div class="icon">
                            <i><img src="assets/images/document-icon.png" alt=""></i>
                        </div>
                        <h5 class="service-title">Persyaratan</h5>
                        <p>Persiapkan dokumen yang diperlukan untuk pendaftaran PPDB. Pastikan semua dokumen lengkap dan
                            valid.</p>
                        {{-- <a href="#" class="main-button">Lihat Persyaratan</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Informasi PPDB End ***** -->

    <!-- ***** FAQ Start ***** -->
    <section class="section" id="frequently-question">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Pertanyaan yang Sering Diajukan</h2>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-6">
                    <div class="section-heading">
                        <p>Berikut adalah beberapa pertanyaan yang sering diajukan oleh calon peserta didik dan orang
                            tua.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="left-text col-lg-6 col-md-6 col-sm-12">
                    <h5>Informasi Umum PPDB</h5>
                    <div class="accordion-text">
                        <p>Proses PPDB SMP Negeri 2 Towuti dilakukan secara online. Pastikan Anda mengikuti semua
                            tahapan dengan benar.</p>
                        <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami melalui kontak yang tersedia
                            di website ini.</p>
                        <span>Email: <a href="#">ppdb@smpn2towuti.sch.id</a><br></span>
                        <a href="#contact-us" class="main-button">Hubungi Kami</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="accordions is-first-expanded">
                        <article class="accordion">
                            <div class="accordion-head">
                                <span>Bagaimana cara mendaftar PPDB?</span>
                                <span class="icon">
                                    <i class="icon fa fa-chevron-right"></i>
                                </span>
                            </div>
                            <div class="accordion-body">
                                <div class="content">
                                    <p>Anda dapat mendaftar melalui website resmi SMP Negeri 2 Towuti. Ikuti
                                        langkah-langkah yang tertera di halaman pendaftaran.</p>
                                </div>
                            </div>
                        </article>
                        <article class="accordion">
                            <div class="accordion-head">
                                <span>Apa saja persyaratan yang diperlukan?</span>
                                <span class="icon">
                                    <i class="icon fa fa-chevron-right"></i>
                                </span>
                            </div>
                            <div class="accordion-body">
                                <div class="content">
                                    <p>Persyaratan umum meliputi fotokopi rapor, akta kelahiran, dan kartu keluarga.
                                        Silakan lihat halaman persyaratan untuk informasi lengkap.</p>
                                </div>
                            </div>
                        </article>
                        <!-- Tambahkan pertanyaan lain sesuai kebutuhan -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** FAQ End ***** -->

    <!-- ***** Kontak Start ***** -->
    <section class="section" id="contact-us">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div id="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.1234567890123!2d121.12345678901234!3d-2.1234567890123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwMDcnMjQuNCJTIDEyMcKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" height="500px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="contact-form">
                        <form id="contact" action="" method="post">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name"
                                            placeholder="Nama Lengkap" required="" class="contact-field">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" id="email" placeholder="Email"
                                            required="" class="contact-field">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Pesan Anda" required=""
                                            class="contact-field"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button">Kirim
                                            Pesan</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Kontak End ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <p class="copyright">Copyright &copy; 2023 SMP Negeri 2 Towuti. All Rights Reserved.</p>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- ***** Footer End ***** -->

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script>

    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

</body>

</html>
