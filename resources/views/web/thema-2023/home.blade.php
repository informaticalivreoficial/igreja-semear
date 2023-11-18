@extends("web.{$configuracoes->template}.master.master")

@section('content')
{{--
<section id="hero" class="hero carousel  carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row justify-content-center gy-6">

                    <div class="col-lg-5 col-md-8">
                        <img src="assets/img/hero-carousel/hero-carousel-1.svg" alt="" class="img-fluid img">
                    </div>

                    <div class="col-lg-9 text-center">
                        <h2>Welcome to HeroBiz</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <a href="#featured-services" class="btn-get-started scrollto ">Get Started</a>
                    </div>

                </div>
            </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center gy-6">

                    <div class="col-lg-5 col-md-8">
                        <img src="assets/img/hero-carousel/hero-carousel-2.svg" alt="" class="img-fluid img">
                    </div>

                    <div class="col-lg-9 text-center">
                        <h2>At vero eos et accusamus</h2>
                        <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id
                            quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor
                            repellendus. Temporibus autem quibusdam et aut officiis debitis aut.</p>
                        <a href="#featured-services" class="btn-get-started scrollto ">Get Started</a>
                    </div>

                </div>
            </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
            <div class="container">
                <div class="row justify-content-center gy-6">

                    <div class="col-lg-5 col-md-8">
                        <img src="assets/img/hero-carousel/hero-carousel-3.svg" alt="" class="img-fluid img">
                    </div>

                    <div class="col-lg-9 text-center">
                        <h2>Temporibus autem quibusdam</h2>
                        <p>Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit
                            aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                            voluptatem sequi nesciunt omnis iste natus error sit voluptatem accusantium.</p>
                        <a href="#featured-services" class="btn-get-started scrollto ">Get Started</a>
                    </div>

                </div>
            </div>
        </div><!-- End Carousel Item -->
    </div>

    <a class="carousel-control-prev" href="#hero" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
    </a>

    <a class="carousel-control-next" href="#hero" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
    </a>

    <ol class="carousel-indicators"></ol>

</section>--}}

<main id="main">

    <!-- 
    <section id="featured-services" class="featured-services">
        <div class="container">

            <div class="row gy-4">

                <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-activity icon"></i></div>
                        <h4><a href="" class="stretched-link">Lorem Ipsum</a></h4>
                        <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                        <h4><a href="" class="stretched-link">Sed ut perspici</a></h4>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                        <h4><a href="" class="stretched-link">Magni Dolores</a></h4>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                        <h4><a href="" class="stretched-link">Nemo Enim</a></h4>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                    </div>
                </div>

            </div>

        </div>
    </section> -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>About Us</h2>
                <p>Architecto nobis eos vel nam quidem vitae temporibus voluptates qui hic deserunt iusto omnis nam
                    voluptas asperiores sequi tenetur dolores incidunt enim voluptatem magnam cumque fuga.</p>
            </div>

            <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">

                <div class="col-lg-5">
                    <div class="about-img">
                        <img src="assets/img/about.jpg" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-lg-7">
                    <h3 class="pt-0 pt-lg-5">Neque officiis dolore maiores et exercitationem quae est seda lidera
                        pat claero</h3>

                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-3">
                        <li><a class="nav-link active" data-bs-toggle="pill" href="#tab1">Saepe fuga</a></li>
                        <li><a class="nav-link" data-bs-toggle="pill" href="#tab2">Voluptates</a></li>
                        <li><a class="nav-link" data-bs-toggle="pill" href="#tab3">Corrupti</a></li>
                    </ul><!-- End Tabs -->

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="tab1">

                            <p class="fst-italic">Consequuntur inventore voluptates consequatur aut vel et. Eos
                                doloribus expedita. Sapiente atque consequatur minima nihil quae aspernatur quo
                                suscipit voluptatem.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                            </div>
                            <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                dolorum non eveniet magni quaerat nemo et.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Incidunt non veritatis illum ea ut nisi</h4>
                            </div>
                            <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                Dolorem quo tempora. Quia et perferendis.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Omnis ab quia nemo dignissimos rem eum quos..</h4>
                            </div>
                            <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam
                                officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam
                                odit enim quaerat. Vero error error voluptatem eum.</p>

                        </div><!-- End Tab 1 Content -->

                        <div class="tab-pane fade show" id="tab2">

                            <p class="fst-italic">Consequuntur inventore voluptates consequatur aut vel et. Eos
                                doloribus expedita. Sapiente atque consequatur minima nihil quae aspernatur quo
                                suscipit voluptatem.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                            </div>
                            <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                dolorum non eveniet magni quaerat nemo et.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Incidunt non veritatis illum ea ut nisi</h4>
                            </div>
                            <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                Dolorem quo tempora. Quia et perferendis.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Omnis ab quia nemo dignissimos rem eum quos..</h4>
                            </div>
                            <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam
                                officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam
                                odit enim quaerat. Vero error error voluptatem eum.</p>

                        </div><!-- End Tab 2 Content -->

                        <div class="tab-pane fade show" id="tab3">

                            <p class="fst-italic">Consequuntur inventore voluptates consequatur aut vel et. Eos
                                doloribus expedita. Sapiente atque consequatur minima nihil quae aspernatur quo
                                suscipit voluptatem.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                            </div>
                            <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                dolorum non eveniet magni quaerat nemo et.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Incidunt non veritatis illum ea ut nisi</h4>
                            </div>
                            <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                Dolorem quo tempora. Quia et perferendis.</p>

                            <div class="d-flex align-items-center mt-4">
                                <i class="bi bi-check2"></i>
                                <h4>Omnis ab quia nemo dignissimos rem eum quos..</h4>
                            </div>
                            <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam
                                officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam
                                odit enim quaerat. Vero error error voluptatem eum.</p>

                        </div><!-- End Tab 3 Content -->

                    </div>

                </div>

            </div>

        </div>
    </section><!-- End About Section -->

    <!-- 
    <section id="clients" class="clients">
        <div class="container" data-aos="zoom-out">

            <div class="clients-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid"
                            alt=""></div>
                    <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid"
                            alt=""></div>
                </div>
            </div>

        </div>
    </section> -->

    <!-- 
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-out">

            <div class="row g-5">

                <div
                    class="col-lg-8 col-md-6 content d-flex flex-column justify-content-center order-last order-md-first">
                    <h3>Alias sunt quas <em>Cupiditate</em> oluptas hic minima</h3>
                    <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                        mollit anim id est laborum.</p>
                    <a class="cta-btn align-self-start" href="#">Call To Action</a>
                </div>

                <div class="col-lg-4 col-md-6 order-first order-md-last d-flex align-items-center">
                    <div class="img">
                        <img src="assets/img/cta.jpg" alt="" class="img-fluid">
                    </div>
                </div>

            </div>

        </div>
    </section> -->

    <!-- 
    <section id="onfocus" class="onfocus">
        <div class="container-fluid p-0" data-aos="fade-up">

            <div class="row g-0">
                <div class="col-lg-6 video-play position-relative">
                    <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                </div>
                <div class="col-lg-6">
                    <div class="content d-flex flex-column justify-content-center h-100">
                        <h3>Voluptatem dignissimos provident quasi corporis</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore
                            magna aliqua.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                                consequat.</li>
                            <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in
                                voluptate velit.</li>
                            <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                        </ul>
                        <a href="#" class="read-more align-self-start"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section> -->

    <!-- 
    <section id="features" class="features">
        <div class="container" data-aos="fade-up">

            <ul class="nav nav-tabs row gy-4 d-flex">

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                        <i class="bi bi-binoculars color-cyan"></i>
                        <h4>Modinest</h4>
                    </a>
                </li>

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-2">
                        <i class="bi bi-box-seam color-indigo"></i>
                        <h4>Undaesenti</h4>
                    </a>
                </li>

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-3">
                        <i class="bi bi-brightness-high color-teal"></i>
                        <h4>Pariatur</h4>
                    </a>
                </li>

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-4">
                        <i class="bi bi-command color-red"></i>
                        <h4>Nostrum</h4>
                    </a>
                </li>

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-5">
                        <i class="bi bi-easel color-blue"></i>
                        <h4>Adipiscing</h4>
                    </a>
                </li>

                <li class="nav-item col-6 col-md-4 col-lg-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-6">
                        <i class="bi bi-map color-orange"></i>
                        <h4>Reprehit</h4>
                    </a>
                </li>

            </ul>

            <div class="tab-content">

                <div class="tab-pane active show" id="tab-1">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                            <h3>Modinest</h3>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center" data-aos="fade-up" data-aos-delay="200">
                            <img src="assets/img/features-1.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-2">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <h3>Undaesenti</h3>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Provident mollitia neque rerum
                                    asperiores dolores quos qui a. Ipsum neque dolor voluptate nisi sed.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center">
                            <img src="assets/img/features-2.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-3">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <h3>Pariatur</h3>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Provident mollitia neque rerum
                                    asperiores dolores quos qui a. Ipsum neque dolor voluptate nisi sed.</li>
                            </ul>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center">
                            <img src="assets/img/features-3.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-4">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <h3>Nostrum</h3>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center">
                            <img src="assets/img/features-4.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-5">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <h3>Adipiscing</h3>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center">
                            <img src="assets/img/features-5.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-6">
                    <div class="row gy-4">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <h3>Reprehit</h3>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit
                                    in voluptate velit.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea
                                    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 text-center">
                            <img src="assets/img/features-6.svg" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section> -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Our Services</h2>
                <p>Ea vitae aspernatur deserunt voluptatem impedit deserunt magnam occaecati dssumenda quas ut ad
                    dolores adipisci aliquam.</p>
            </div>

            <div class="row gy-5">

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Nesciunt Mete</h3>
                            </a>
                            <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus
                                dolores iure perferendis.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-2.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Eosle Commodi</h3>
                            </a>
                            <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque
                                eum hic non ut nesciunt dolorem.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-3.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-easel"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Ledo Markt</h3>
                            </a>
                            <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id
                                voluptas adipisci eos earum corrupti.</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-4.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-bounding-box-circles"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Asperiores Commodit</h3>
                            </a>
                            <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea
                                fuga sit provident adipisci neque.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-5.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Velit Doloremque</h3>
                            </a>
                            <p>Cumque et suscipit saepe. Est maiores autem enim facilis ut aut ipsam corporis aut.
                                Sed animi at autem alias eius labore.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="700">
                    <div class="service-item">
                        <div class="img">
                            <img src="assets/img/services-6.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-chat-square-text"></i>
                            </div>
                            <a href="#" class="stretched-link">
                                <h3>Dolori Architecto</h3>
                            </a>
                            <p>Hic molestias ea quibusdam eos. Fugiat enim doloremque aut neque non et debitis iure.
                                Corrupti recusandae ducimus enim.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>
    </section><!-- End Services Section -->

    
    <!-- 
    <section id="team" class="team">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Our Team</h2>
                <p>Architecto nobis eos vel nam quidem vitae temporibus voluptates qui hic deserunt iusto omnis nam
                    voluptas asperiores sequi tenetur dolores incidunt enim voluptatem magnam cumque fuga.</p>
            </div>

            <div class="row gy-5">

                <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="member-info">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="member-info">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="member-info">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section> -->

    <!-- 
    <section id="recent-blog-posts" class="recent-blog-posts">

        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Blog</h2>
                <p>Recent posts form our Blog</p>
            </div>

            <div class="row">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="post-box">
                        <div class="post-img"><img src="assets/img/blog/blog-1.jpg" class="img-fluid"
                                alt=""></div>
                        <div class="meta">
                            <span class="post-date">Tue, December 12</span>
                            <span class="post-author"> / Julia Parker</span>
                        </div>
                        <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur
                            sit</h3>
                        <p>Illum voluptas ab enim placeat. Adipisci enim velit nulla. Vel omnis laudantium.
                            Asperiores eum ipsa est officiis. Modi cupiditate exercitationem qui magni est...</p>
                        <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="post-box">
                        <div class="post-img"><img src="assets/img/blog/blog-2.jpg" class="img-fluid"
                                alt=""></div>
                        <div class="meta">
                            <span class="post-date">Fri, September 05</span>
                            <span class="post-author"> / Mario Douglas</span>
                        </div>
                        <h3 class="post-title">Et repellendus molestiae qui est sed omnis voluptates magnam</h3>
                        <p>Voluptatem nesciunt omnis libero autem tempora enim ut ipsam id. Odit quia ab eum
                            assumenda. Quisquam omnis aliquid necessitatibus tempora consectetur doloribus...</p>
                        <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="post-box">
                        <div class="post-img"><img src="assets/img/blog/blog-3.jpg" class="img-fluid"
                                alt=""></div>
                        <div class="meta">
                            <span class="post-date">Tue, July 27</span>
                            <span class="post-author"> / Lisa Hunter</span>
                        </div>
                        <h3 class="post-title">Quia assumenda est et veritatis aut quae</h3>
                        <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis
                            repellat sed quae consectetur magnam veritatis dicta nihil...</p>
                        <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

            </div>

        </div>

    </section> -->

    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Nossa Localização</h2>
            </div>
        </div>

        <div class="map">{!! $configuracoes->mapa_google !!}</div>

        <div class="container">
            <div class="row gy-5 gx-lg-5">
                <div class="col-lg-12">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Seu Nome" >
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Seu Email" >
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" placeholder="Message" ></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Enviar Mensagem</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection

@section('css')
@endsection

@section('js')
@endsection
