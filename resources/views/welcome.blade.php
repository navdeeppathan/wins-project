<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Project OverView (P.O.V.)</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        /* HERO BACKGROUND SLIDER */
        .hero {
        position: relative;
        overflow: hidden;
        }

        .hero-bg-slider {
        position: absolute;
        inset: 0;
        z-index: 1;
        }

        .hero-bg-slider .slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transform: scale(1.08);
        transition: opacity 1.5s ease-in-out, transform 6s ease;
        }

        .hero-bg-slider .slide.active {
        opacity: 1;
        transform: scale(1);
        }

        /* Dark elegant overlay */
        .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            120deg,
            rgba(0,0,0,0.85),
            rgba(0,0,0,0.65)
        );
        z-index: 2;
        }

        /* Keep content above slider */
        .hero .container {
        position: relative;
        z-index: 3;
        }

        /* Optional subtle grain for luxury feel */
        .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='60' height='60' fill='rgba(255,255,255,0.02)'/%3E%3C/svg%3E");
        opacity: 0.15;
        z-index: 2;
        pointer-events: none;
        }

    </style>

    <style>
        .security-section {
            padding: 60px 20px;
            background: #f9fafb;
        }
        .security-section h2 {
            margin-bottom: 15px;
        }
        .security-section ul {
            margin-top: 15px;
        }
        .security-section li {
            margin-bottom: 10px;
        }
    </style>

    <style>
        .security-section {
            padding: 80px 20px;
            background: #f4f6f9;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .section-subtitle {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 40px;
            color: #555;
        }

        .security-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 25px;
        }

        .security-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .security-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .security-card h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .security-card p {
            color: #555;
            line-height: 1.6;
        }
    </style>

    <style>
                    .brand-vertical {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        gap: 10px;
                        animation: fadeUp 1s ease forwards;
                        }

                        /* White circle */
                        .logo-circle {
                        width: 80px;
                        height: 80px;
                        background: #1c1b1b;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
                        animation: float 3.5s ease-in-out infinite;
                        }

                        /* Crown icon */
                        .logo-circle i {
                        font-size: 34px;
                        color: #dd3209; /* soft pink like image */
                        animation: crownPulse 2s infinite;
                        }

                        /* Brand name */
                        .brand-text {
                        font-size: 34px;
                        font-weight: 700;
                        color: #dd3209;
                        letter-spacing: 1px;
                        text-shadow: 0 6px 18px rgba(0,0,0,0.4);
                        }

                        /* Animations */
                        @keyframes float {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(-10px); }
                        }

                        @keyframes crownPulse {
                        0%, 100% { transform: scale(1); }
                        50% { transform: scale(1.15); }
                        }

                        @keyframes fadeUp {
                        from {
                            opacity: 0;
                            transform: translateY(15px);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                        }


    </style>

    <!-- header buttons -->
    <style>
      .header-buttons {
        display: flex;
        gap: 14px;
        align-items: center;
      }

      /* SIGN IN BUTTON */
      .btn-signin {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        background: #111827; /* dark gray */
        color: #ffffff;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 400;
        text-decoration: none;
        transition: background 0.25s ease, transform 0.25s ease;
      }

      .btn-signin i {
        font-size: 14px;
      }

      .btn-signin:hover {
        background: #1f2937;
        color: #ffffff;
        transform: translateY(-1px);
      }

      /* CONTACT US BUTTON */
      .btn-contact {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        background: #3b82f6; /* blue */
        color: #ffffff;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
      }

      .btn-contact i {
        font-size: 16px;
      }

      .btn-contact:hover {
        transform: translateY(-2px);
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.6);
      }
      /* ---------- RESPONSIVE BUTTONS ---------- */

      /* Tablet adjustments */
      @media (max-width: 991px) {
        .btn-signin,
        .btn-contact {
          padding: 8px 18px;
          font-size: 13.5px;
          margin-right: 35px;
        }
      }

      /* Mobile layout */
      @media (max-width: 576px) {
        .header-buttons {
          flex-direction: column;
          align-items: stretch;
          gap: 10px;
          margin-top: 40px;
          width: 100%;
        }

        .btn-signin,
        .btn-contact {
          width: 100%;
          justify-content: center;
          padding: 10px 16px;
          font-size: 14px;
        }
      }
    </style>

    {{-- whatsapp button --}}
    <style>
        .quick-connect {
            position: fixed;
            bottom: 12%;
            right: 0;
            z-index: 999999;
        }

        .quick-connect a {
        color: white;
        }

        .whatsapp a {
            color: var(--blue);
        }

        .whatsapp a {
            color: #fff;
        }
        .call {
            color: white;
            font-size: 30px;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            background-color: #34ABE3;
            /* border-radius: 0 10px 10px 0; */
            height: 51px;
            width: 52px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .whatsapp {
            background-color: #66df57;
            color: #fff;
            font-size: 30px;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            height: 51px;
            width: 52px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hidden-txt {
            display: none;
        }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="container-fluid container-xl position-relative">

      <div class="top-row d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <div class="brand-vertical">
                {{-- <div class="logo-circle">
                    <i class="fas fa-crown"></i>
                </div> --}}
                <div class="brand-text">Project OverView (P.O.V.)</div>


            </div>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#features">Features</a></li>

            <li><a href="#call-to-action">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="d-flex align-items-center">
          <div class="header-buttons">
              <a href="/login" class="btn-signin">
                Login <i class="bi bi-arrow-right"></i>
              </a>


            </div>
        </div>
      </div>

    </div>

    <div class="nav-wrap">
      <div class="container d-flex justify-content-center position-relative">

      </div>
    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        <!-- Background Slider -->
        <div class="hero-bg-slider">
            <div class="slide active" style="background-image:url('s1.jpg')"></div>
            <div class="slide" style="background-image:url('s2.jpg')"></div>
            <div class="slide" style="background-image:url('s3.jpg')"></div>
        </div>
        <!-- Overlay -->
        <div class="hero-overlay"></div>

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center gy-5">
            <div class="col-lg-7 ">
                <div class="hero-card shadow-sm" data-aos="fade-right" data-aos-delay="150">
                <div class="eyebrow d-inline-flex align-items-center mb-3">
                    <i class="bi bi-stars me-2"></i>
                    <span>Project OverView (P.O.V.): Elegance in Execution</span>
                </div>
                <div class="content">
                    <h2 class="display-5 fw-bold mb-3">
                      The Minimalistic Intelligence Hub for Business
                    Owners
                    </h2>
                    <p class="lead mb-4">In an era of digital complexity, Project OverView
                    (P.O.V.) offers a sophisticated alternative; a
                    streamlined, high-performance web solution
                    designed specifically for business owners
                    navigating the demanding landscapes of
                    Government, PSUs, Banking and the Private
                    Sector Units.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                    <a href="/register" class="btn btn-primary-ghost">
                        <span>Explore Now</span>
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-video d-inline-flex align-items-center">
                        <span class="play-icon d-inline-flex align-items-center justify-content-center me-2">
                        <i class="bi bi-play-fill"></i>
                        </span>
                        <span>Watch Overview</span>
                    </a> --}}
                    </div>
                    <div class="mini-stats d-flex flex-wrap gap-4 mt-4" data-aos="zoom-in" data-aos-delay="250">
                    <div class="stat d-flex align-items-center">
                        <i class="bi bi-lightning-charge me-2"></i>
                        <span>Business Connectivity</span>
                    </div>
                    <div class="stat d-flex align-items-center">
                        <i class="bi bi-shield-check me-2"></i>
                        <span>Project Monitoring</span>
                    </div>
                    <div class="stat d-flex align-items-center">
                        <i class="bi bi-people me-2"></i>
                        <span>Actionable Insights</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-lg-5 ">
                <div class="media-stack" data-aos="zoom-in" data-aos-delay="200">
                <figure class="media primary shadow-sm">
                    <p class="lead p-4">

                We are deeply grateful to Shri Sanjeev Kumar, Assistant Engineer (Civil), whose expert
                guidance and shared knowledge were instrumental in the successful completion of this
                project.
            </p>
                  {{-- <img src="assets/img/illustration/illustration-8.webp" class="img-fluid" alt="Hero visual"> --}}
                </figure>
                {{-- <figure class="media secondary shadow-sm">
                    <img src="assets/img/illustration/illustration-15.webp" class="img-fluid" alt="Supporting visual">
                </figure> --}}
                {{-- <div class="floating-badge d-flex align-items-center shadow-sm" data-aos="fade-down" data-aos-delay="300">
                    <i class="bi bi-award me-2"></i>
                    <span>Curabitur congue pretium</span>
                </div> --}}
                </div>
            </div>
            </div>
        </div>
        <script>
            const slides = document.querySelectorAll(".hero-bg-slider .slide");
            let current = 0;

            setInterval(() => {
                slides[current].classList.remove("active");
                current = (current + 1) % slides.length;
                slides[current].classList.add("active");
            }, 5000); // change every 5s
        </script>

    </section>
    <!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="container section-title" data-aos="fade-up">
            <h2>A Unified Intelligence Layer</h2>
            <p>Project OverView (P.O.V.) serves as your central command center, seamlessly integrating every facet of your operations into one cohesive ecosystem. </p>
        </div>

        <div class="row g-4">

          <!-- Card 1 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-stack"></i>
              </div>
              <h3>Business Connectivity</h3>
              <p> Align your team through a unified hub for productivity, billing, and attendance.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 2 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-shield-check"></i>
              </div>
              <h3>Project Monitoring</h3>
              <p>Gain real-time visibility into milestones, blockers, and material utilization with enterprise-grade precision.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item">
                    <div class="icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3>Actionable Insights</h3>
                    <p>Transform daily activity into "Work Intelligence," allowing you to make faster, data-driven decisions that safeguard your margins. </p>
                    <div class="card-links">
                        <a href="#" class="link-item">
                        Learn More
                        <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
          <!-- End Service Item -->
        </div>

      </div>

    </section>
    <!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>About</h2>
            <p>Project OverView (P.O.V.): Elegance in Execution </p>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-4 align-items-stretch">

            <div class="col-lg-5 order-lg-2" data-aos="fade-left" data-aos-delay="200">
                <aside class="showcase">
                <figure class="showcase-main">
                    <img src="{{ asset('s1.jpg') }}" alt="Our Journey" class="img-fluid">
                    {{-- <figcaption class="badge-note" data-aos="zoom-in" data-aos-delay="350">
                    <i class="bi bi-graph-up-arrow"></i>
                    <div>
                        <strong>Growing Strong</strong>
                        <small>Lorem ipsum dolor sit amet.</small>
                    </div>
                    </figcaption> --}}
                </figure>
                </aside>
            </div>

            <div class="col-lg-7 order-lg-1" data-aos="fade-right" data-aos-delay="200">
                <article class="intro-card">
                <div class="intro-head">
                    <span class="kicker"><i class="bi bi-stars me-1"></i>Our Story</span>
                    <h2>The Minimalistic Intelligence Hub for Business Owners</h2>
                </div>

                <div class="intro-body">
                    <p class="lead">In an era of digital complexity, Project OverView
                    (P.O.V.) offers a sophisticated alternative; a
                    streamlined, high-performance web solution
                    designed specifically for business owners
                    navigating the demanding landscapes of
                    Government, PSUs, Banking and the Private
                    Sector Units. 
                   </p>
                    <p>Project OverView (P.O.V.) eliminates the noise of traditional management tools. By focusing on essential functionalities and intuitive navigation, we deliver a smarter, non-confusing interface that transforms how you monitor projects and manage your workforce.</p>

                    <div class="feature-list row gy-3">
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <div class="text">
                            <h6>Reliable Delivery</h6>
                            {{-- <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis.</p> --}}
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-item">
                        <i class="bi bi-palette2"></i>
                        <div class="text">
                            <h6>Human-Centered Design</h6>
                            {{-- <p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus.</p> --}}
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="metric-band" data-aos="fade-up" data-aos-delay="350">
                    <div class="metric">
                        <span class="value">15+</span>
                        <span class="label">Years</span>
                    </div>
                    <div class="divider"></div>
                    <div class="metric">
                        <span class="value">520</span>
                        <span class="label">Projects</span>
                    </div>
                    <div class="divider"></div>
                    <div class="metric">
                        <span class="value">30</span>
                        <span class="label">Experts</span>
                    </div>
                    </div>

                    <div class="actions d-flex flex-wrap align-items-center gap-3" data-aos="fade-up" data-aos-delay="400">
                    <a href="#" class="btn btn-accent">
                        <i class="bi bi-rocket-takeoff me-1"></i> Explore Capabilities
                    </a>
                    <a href="#" class="link-more">
                        Learn about our culture <i class="bi bi-arrow-right-short"></i>
                    </a>
                    </div>
                </div>
                </article>
            </div>

            </div>

        </div>
    </section>
    <!-- /About Section -->



    <!-- Stats Section -->
    <section id="stats" class="stats section">


      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Measurable Impact by the Numbers </h2>
        <p>Our platform is engineered to deliver high-impact results that scale with your ambitions:</p>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-11">
            <div class="stats-board">
              <article class="stat-tile" data-aos="fade-up" data-aos-delay="150">
                <div class="tile-head">
                  <i class="bi bi-emoji-smile"></i>
                  <div class="label">
                    <h6 class="title">Material</h6>
                    <small class="hint">and Resource Utilization</small>
                  </div>
                </div>
                <div class="tile-metric">
                  <span class="metric-number purecounter" data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1"></span>
                  <span class="metric-suffix">%</span>
                </div>
              </article><!-- End Stat Tile -->

              <article class="stat-tile" data-aos="fade-up" data-aos-delay="200">
                <div class="tile-head">
                  <i class="bi bi-journal-richtext"></i>
                  <div class="label">
                    <h6 class="title">Activity </h6>
                    <small class="hint">Visibility</small>
                  </div>
                </div>
                <div class="tile-metric">
                  <span class="metric-number purecounter" data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1"></span>
                  <span class="metric-suffix">%</span>
                </div>
              </article><!-- End Stat Tile -->

              <article class="stat-tile" data-aos="fade-up" data-aos-delay="250">
                <div class="tile-head">
                  <i class="bi bi-headset"></i>
                  <div class="label">
                    <h6 class="title">Reduction</h6>
                    <small class="hint">in Manual Reporting</small>
                  </div>
                </div>
                <div class="tile-metric">
                  <span class="metric-number purecounter" data-purecounter-start="0" data-purecounter-end="80" data-purecounter-duration="1"></span>
                  <span class="metric-suffix">%</span>
                </div>
              </article><!-- End Stat Tile -->

              <article class="stat-tile" data-aos="fade-up" data-aos-delay="300">
                <div class="tile-head">
                  <i class="bi bi-people"></i>
                  <div class="label">
                    <h6 class="title">Increase </h6>
                    <small class="hint">in Operational Efficiency</small>
                  </div>
                </div>
                <div class="tile-metric">
                  <span class="metric-number purecounter" data-purecounter-start="0" data-purecounter-end="70" data-purecounter-duration="1"></span>
                  <span class="metric-suffix">%</span>
                </div>
              </article><!-- End Stat Tile -->
              <article class="stat-tile" data-aos="fade-up" data-aos-delay="300">
                <div class="tile-head">
                  <i class="bi bi-people"></i>
                  <div class="label">
                    <h6 class="title">Clearer</h6>
                    <small class="hint">Work Patterns</small>
                  </div>
                </div>
                <div class="tile-metric">
                  <span class="metric-number purecounter" data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="1"></span>
                  <span class="metric-suffix">x</span>
                </div>
              </article><!-- End Stat Tile -->
            </div>


          </div>
        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">

          <div class="col-lg-5">
            <div class="skills-header">
              <h3>Measurable Impact by the Numbers</h3>
              <p>
                Our platform is engineered to deliver high-impact results that scale with your ambitions:
              </p>
              <div class="certifications">
                <div class="cert-item" data-aos="fade-right" data-aos-delay="200">
                  <i class="bi bi-award-fill"></i>
                  <span>ISO Certified</span>
                </div>
                <div class="cert-item" data-aos="fade-right" data-aos-delay="250">
                  <i class="bi bi-shield-check"></i>
                  <span>Quality Assured</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="skills-grid skills-animation" data-aos="fade-left" data-aos-delay="200">

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Material and Resource Utilization </h4>
                  <span class="skill-value">100%</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                {{-- <p>Strategic planning and execution</p> --}}
              </div><!-- End Skills Item -->

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Activity Visibility </h4>
                  <span class="skill-value">100%</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                {{-- <p>Modern frameworks and technologies</p> --}}
              </div><!-- End Skills Item -->

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Reduction in Manual Reporting</h4>
                  <span class="skill-value">80%</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                {{-- <p>Business intelligence and insights</p> --}}
              </div><!-- End Skills Item -->

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Increase in Operational Efficiency</h4>
                  <span class="skill-value">70%</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                {{-- <p>Multi-channel campaign management</p> --}}
              </div><!-- End Skills Item -->

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Clearer Work Patterns </h4>
                  <span class="skill-value">3x</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p>Comprehensive testing protocols</p>
              </div><!-- End Skills Item -->

              <div class="skill-item">
                <div class="skill-header">
                  <h4>Client Relations</h4>
                  <span class="skill-value">96%</span>
                </div>
                <div class="skill-bar progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="96" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p>Long-term partnership building</p>
              </div><!-- End Skills Item -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Skills Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Start your Free Trial Today.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Services Grid -->
        <div class="row gy-5 d-flex align-items-center justify-content-center">


          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-card featured">
              <div class="service-number">01</div>
              <div class="service-icon-wrapper">
                <div class="service-icon">
                  <i class="bi bi-globe"></i>
                </div>
              </div>

               <div class="service-content">
                <h4>Project OverView (P.O.V.) Pricing</h4>
                <p>
                  We believe in the power of our platform Project
                  OverView (P.O.V.), which is why we invite you to
                  experience it firsthand - completely risk-free. No
                  hidden fees, No surprises, Annual price starting
                  at Rs.7,200/- plus GST for Basic Plan and
                  Rs.10,800/- plus GST for Advance Plan to ensure
                  Project OverView (P.O.V.) aligns with your needs.
                  We offer a FREE trial for first 3 months,
                  additionally, you can book a demo to get a
                  hands-on feel of its functionalities. Project
                  OverView (P.O.V.) prides itself on robust technical
                  support, whether you prefer email, chat or
                  phone, our team is ready to assist and ensuring a
                  seamless user experience.
                </p>

                <div class="service-pricing">

                  <span style="color: #fff; font-weight:500;">
                    Price Starting @ ₹ 7,200/- plus GST annually
                    <br>
                    Price Rs.8496/- GST Included</span>

                </div>

              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-card">
              <div class="service-number">02</div>
              <div class="service-icon-wrapper">
                <div class="service-icon">
                  <i class="bi bi-qr-code"></i>
                </div>
              </div>
              <div class="service-content">

                <img src="/QR2.jpg" alt="" width="100%" height="100%">
              </div>
            </div>
          </div>

          {{-- <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-card">
              <div class="service-number">04</div>
              <div class="service-icon-wrapper">
                <div class="service-icon">
                  <i class="bi bi-search"></i>
                </div>
              </div>
              <div class="service-content">
                <h4>SEO Optimization</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim.</p>
                <ul class="service-list">
                  <li>Keyword Research</li>
                  <li>On-page SEO</li>
                  <li>Technical SEO</li>
                  <li>Link Building</li>
                </ul>
                <div class="service-pricing">
                  <span class="price-tag">$899</span>
                  <a href="#" class="service-btn">
                    <span>Learn More</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-card">
              <div class="service-number">05</div>
              <div class="service-icon-wrapper">
                <div class="service-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
              <div class="service-content">
                <h4>Cybersecurity</h4>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat.</p>
                <ul class="service-list">
                  <li>Security Audits</li>
                  <li>Penetration Testing</li>
                  <li>Data Protection</li>
                  <li>Compliance Consulting</li>
                </ul>
                <div class="service-pricing">
                  <span class="price-tag">$1,999</span>
                  <a href="#" class="service-btn">
                    <span>Learn More</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-card">
              <div class="service-number">06</div>
              <div class="service-icon-wrapper">
                <div class="service-icon">
                  <i class="bi bi-cloud-arrow-up"></i>
                </div>
              </div>
              <div class="service-content">
                <h4>Cloud Solutions</h4>
                <p>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit in voluptate.</p>
                <ul class="service-list">
                  <li>Cloud Migration</li>
                  <li>Infrastructure Setup</li>
                  <li>DevOps Services</li>
                  <li>Monitoring &amp; Support</li>
                </ul>
                <div class="service-pricing">
                  <span class="price-tag">$1,599</span>
                  <a href="#" class="service-btn">
                    <span>Learn More</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div> --}}
        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- Features Section -->
    <section id="features" class="features section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Features</h2>
        <p>Tailored for Every Stakeholder</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5 align-items-center">

          <div class="col-lg-5">
            <article class="intro-panel" data-aos="fade-right" data-aos-delay="200">
              <figure class="preview-visual mb-4">
                <img src="assets/img/features/features-3.webp" alt="App preview" class="img-fluid rounded-4 shadow-sm">
              </figure>
              <div class="intro-content">
                <h3 class="intro-title">Tailored for Every Stakeholder</h3>
                {{-- <p class="intro-text">Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum.</p> --}}
                <ul class="intro-highlights list-unstyled mt-3">
                  <li><i class="bi bi-check-circle-fill"></i> For the Business Owner</li>
                  <li><i class="bi bi-check-circle-fill"></i> For Project Managers & Field Operations </li>
                  <li><i class="bi bi-check-circle-fill"></i> For Finance & Administration</li>
                </ul>
                <div class="mt-4">
                  <a href="#" class="btn cta-btn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Get Started
                  </a>
                  <a href="#" class="btn link-btn ms-2">
                    Learn More <i class="bi bi-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </article>
          </div>

          <div class="col-lg-7">
            <div class="feature-grid">
              <div class="feature-item" data-aos="zoom-in" data-aos-delay="200">
                <div class="f-icon badge-blue">
                  <i class="bi bi-cpu-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Centralized Command</h4>
                  <p class="f-text">A single dashboard for a unified view across all departments.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-speedometer2 me-1"></i>Up to 3x faster</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="250">
                <div class="f-icon badge-green">
                  <i class="bi bi-lock-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Privacy by Design</h4>
                  <p class="f-text"> Robust data protection with role-based access to ensure confidentiality.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-shield-lock-fill me-1"></i>AES-256</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
                <div class="f-icon badge-purple">
                  <i class="bi bi-diagram-3-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Predictive Analytics</h4>
                  <p class="f-text">Balance workloads and predict performance patterns to stay ahead of the curve.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-plug-fill me-1"></i>50+ apps</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="350">
                <div class="f-icon badge-orange">
                  <i class="bi bi-bar-chart-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Smarter Tracking</h4>
                  <p class="f-text">Monitor tasks, sprints, and milestones with early-warning systems for potential delays.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-graph-up-arrow me-1"></i>Realtime</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
                <div class="f-icon badge-cyan">
                  <i class="bi bi-cloud-arrow-down-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Verified Compliance</h4>
                  <p class="f-text">Accurate time and location records with compliance-ready logs for field-to-office transparency.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-cloud-check me-1"></i>99.9% uptime</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="450">
                <div class="f-icon badge-pink">
                  <i class="bi bi-people-fill"></i>
                </div>
                <div class="f-body">
                  <h4 class="f-title">Automated Precision</h4>
                  <p class="f-text">Transition to one-click tracking for billable hours, auto-filled payroll, and client-ready reporting.</p>
                  <div class="f-meta">
                    {{-- <span><i class="bi bi-chat-dots-fill me-1"></i>Team-ready</span> --}}
                  </div>
                </div>
              </div><!-- End Feature Item -->
            </div>

            <div class="assurance-banner" data-aos="fade-up" data-aos-delay="480">
              <div class="assurance-icon">
                <i class="bi bi-award-fill"></i>
              </div>
              <div class="assurance-content">
                <h5>Profitability Focus</h5>
                <p>Eliminate manual admin work and capture hidden time losses to ensure every project remains profitable.</p>
              </div>
              <a href="#" class="btn banner-btn">
                <i class="bi bi-arrow-right-circle me-1"></i> Explore
              </a>
            </div><!-- End Assurance Banner -->

          </div>

        </div>

      </div>

    </section><!-- /Features Section -->


    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="cta-wrapper">
          <div class="content-block">
            <div class="row align-items-center">
              <div class="col-lg-7">
                <div class="text-content" data-aos="fade-right" data-aos-delay="200">
                  <div class="section-label" data-aos="fade-up" data-aos-delay="250">
                    <span>Transform Your Vision</span>
                  </div>

                  <h2 data-aos="fade-up" data-aos-delay="300">
                    Begin Your Project OverView (P.O.V) Journey.
                    <span class="accent-text">No Pre-payment required</span>
                  </h2>

                  <p data-aos="fade-up" data-aos-delay="350">We believe in the power of our platform, which is why we invite you to experience it firsthand— completely risk-free.
                    <br>
                    Dedicated Support: Access our robust technical support via email, chat, or phone.
                  </p>


                  <div class="benefits-list" data-aos="fade-up" data-aos-delay="400">
                    <div class="benefit-row">
                      <div class="benefit-item">
                        <div class="check-icon">
                          <i class="bi bi-envelope-fill"></i>
                        </div>
                        <span>solutions1401@gmail.com</span>
                      </div>
                      <div class="benefit-item">
                        <div class="check-icon">
                         <i class="bi bi-telephone-fill"></i>
                        </div>
                        <span>9350350385</span>
                      </div>
                    </div>
                    <div class="benefit-row">
                      <div class="benefit-item">
                        <div class="check-icon">
                          <i class="bi bi-whatsapp"></i>
                        </div>
                       <a href="https://wa.me/919650650685" target="_blank" class="text-decoration-none">9650650685</a>
                      </div>
                      <div class="benefit-item">
                        <div class="check-icon">
                          <i class="bi bi-check2"></i>
                        </div>
                        <span>Continuous Support</span>
                      </div>
                    </div>
                  </div>

                  <div class="action-group" data-aos="fade-up" data-aos-delay="450">
                    <a href="/register" class="btn btn-primary-action">Start Your Journey</a>
                    {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-text-link glightbox">
                      <i class="bi bi-play-circle-fill"></i>
                      See How It Works
                    </a> --}}
                  </div>

                  {{-- <div class="trust-indicators" data-aos="fade-up" data-aos-delay="500">
                    <div class="indicator">
                      <div class="metric">12K+</div>
                      <div class="label">Projects Completed</div>
                    </div>
                    <div class="separator"></div>
                    <div class="indicator">
                      <div class="metric">98%</div>
                      <div class="label">Client Satisfaction</div>
                    </div>
                    <div class="separator"></div>
                    <div class="indicator">
                      <div class="metric">24/7</div>
                      <div class="label">Expert Support</div>
                    </div>
                  </div> --}}
                </div>
              </div>

              <div class="col-lg-5">
                <div class="visual-section" data-aos="fade-left" data-aos-delay="300">
                  <div class="image-container">
                    <img src="assets/img/cta/cta-4.webp" alt="Business Growth" class="main-visual">

                    <div class="floating-badge badge-1" data-aos="zoom-in" data-aos-delay="600">
                      <div class="badge-icon">
                        <i class="bi bi-award-fill"></i>
                      </div>
                      <div class="badge-text">
                        <div class="badge-title">Award Winner</div>
                        <div class="badge-subtitle">Best Solution 2024</div>
                      </div>
                    </div>

                    <div class="floating-badge badge-2" data-aos="zoom-in" data-aos-delay="700">
                      <div class="badge-icon">
                        <i class="bi bi-people-fill"></i>
                      </div>
                      <div class="badge-text">
                        <div class="badge-title">25K+</div>
                        <div class="badge-subtitle">Active Users</div>
                      </div>
                    </div>
                  </div>

                  <div class="decorative-elements">
                    <div class="element element-1"></div>
                    <div class="element element-2"></div>
                    <div class="element element-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

    <section class="security-section">
        <div class="container">
            <h2 class="section-title">Data Security & User Protection</h2>
            <p class="section-subtitle">
                Your data security is our top priority. We use industry-standard
                security protocols to protect user information from unauthorized access.
            </p>

            <div class="security-cards">

                <div class="security-card">
                    <h3> Secure Data Encryption</h3>
                    <p>
                        All data exchanged between users and the system is protected
                        using HTTPS encryption, ensuring privacy and data integrity.
                    </p>
                </div>

                <div class="security-card">
                    <h3> Authentication & Access Control</h3>
                    <p>
                        Secure login systems with role-based access ensure that users
                        can only access data they are authorized to view.
                    </p>
                </div>

                <div class="security-card">
                    <h3>Protection Against Cyber Attacks</h3>
                    <p>
                        Built-in safeguards protect the platform from common threats
                        such as unauthorized access, data manipulation, and misuse.
                    </p>
                </div>

                <div class="security-card">
                    <h3>Secure Data Storage</h3>
                    <p>
                        User information is securely stored in protected databases with
                        restricted access to prevent data leakage.
                    </p>
                </div>

                <div class="security-card">
                    <h3>Regular Security Updates</h3>
                    <p>
                        The system is regularly updated with the latest security patches
                        to ensure protection against new vulnerabilities.
                    </p>
                </div>

                <div class="security-card">
                    <h3>Continuous Monitoring</h3>
                    <p>
                        Ongoing system monitoring helps detect unusual activity early
                        and ensures the platform remains safe and reliable.
                    </p>
                </div>

            </div>
        </div>
    </section>

        <!-- /Call To Action Section -->

  </main>

  <div class="quick-connect">
        {{-- <div class="call">
            <a href="https://t.me/xtwebhostdesk"><i class="fab fa-telegram"></i></a>
        </div> --}}
        <div class="whatsapp">
            <a href="https://wa.me/919650650685" target="_blank" class="text-decoration-none"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>
  <footer id="footer" class="footer position-relative">

    <div class="container">
      <div class="row gy-5">

        <div class="col-lg-4">
          <div class="footer-brand">
            <a href="index.html" class="logo d-flex align-items-center mb-3">
           <div class="brand-vertical">
                {{-- <div class="logo-circle">
                    <i class="fas fa-crown"></i>
                </div> --}}
                <div class="brand-text">Project OverView (P.O.V.)</div>


            </div>

            </a>
            <p class="tagline">UPI : solut93503135@barodampay</p>


            <div class="mt-4">
            <h5>Follow US:</h5>
            <div class="social-links ">
              <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
              <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
              <a href="#" aria-label="Dribbble"><i class="bi bi-dribbble"></i></a>
            </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="footer-links-grid">
            <div class="row">
              <div class="col-12 col-md-12">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                  <li><a href="#">Terms & Use</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                  <li><a href="#">Refund & Cancellation Policy</a></li>
                  {{-- <li><a href="#">Newsroom</a></li> --}}
                </ul>
              </div>
              {{-- <div class="col-6 col-md-4">
                <h5>Services</h5>
                <ul class="list-unstyled">
                  <li><a href="#">Web Development</a></li>
                  <li><a href="#">UI/UX Design</a></li>
                  <li><a href="#">Digital Strategy</a></li>
                  <li><a href="#">Branding</a></li>
                </ul>
              </div>
              <div class="col-6 col-md-4">
                <h5>Support</h5>
                <ul class="list-unstyled">
                  <li><a href="#">Help Center</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                  <li><a href="#">Terms of Service</a></li>
                </ul>
              </div> --}}
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="footer-cta">
            <h5>About US</h5>
            {{-- <a href="contact.html" class="btn btn-outline">About US:</a> --}}
            <p>Central Delhi, New Delhi-110055</p>
            <p>+91 9350350385</p>
            <p>support@email.com</p>
          </div>
        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="footer-bottom-content">
              <p class="mb-0">© <span class="sitename">solution1401@gmail.com</span>. All rights reserved.</p>
              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://wa.me/919575370343" target="_blank" class="text-decoration-none"">infoharry</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
