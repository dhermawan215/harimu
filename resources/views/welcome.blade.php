<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Harimu') }} — Undangan Pernikahan Digital & Buku Tamu Online</title>
    <meta name="description" content="Buat undangan pernikahan digital yang elegan dalam hitungan menit. Pilih template, custom foto, ucapan & kado, lalu bagikan ke tamu via WhatsApp. Lengkap dengan buku tamu online.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @include('partials.brand-styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand navbar-brand-name fs-4" href="/">
                <i class="bi bi-heart-fill me-1"></i>Harimu
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-lg-4 text-center mt-3 mt-lg-0">
                    <li class="nav-item"><a class="nav-link fw-medium" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#cara-kerja">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#template">Template</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#harga">Harga</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#faq">FAQ</a></li>
                </ul>
                <div class="d-flex gap-2 justify-content-center mt-3 mt-lg-0">
                    <a href="/login" class="btn btn-outline-brand rounded-pill px-4">Masuk</a>
                    <a href="/register" class="btn btn-brand rounded-pill px-4">Daftar Gratis</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section py-5 py-lg-6">
        <div class="hero-decor bg-warning" style="width:220px;height:220px;top:-60px;right:-60px;"></div>
        <div class="hero-decor bg-brand" style="width:160px;height:160px;bottom:20px;left:-60px;opacity:.15;"></div>
        <div class="container py-5 position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="section-eyebrow">Undangan Pernikahan Digital</span>
                    <h1 class="display-5 fw-bold mt-3 mb-3">Rayakan Hari Bahagiamu dengan Undangan yang Elegan &amp; Berkesan</h1>
                    <p class="fs-5 text-secondary mb-4">
                        Pilih template pilihan, custom foto, ucapan, dan kado pengantin sendiri, lalu bagikan langsung ke tamu via WhatsApp. Lengkap dengan buku tamu digital untuk mencatat kehadiran dan ucapan.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="/register" class="btn btn-brand btn-lg rounded-pill px-4">
                            Mulai Buat Undangan <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <a href="#template" class="btn btn-outline-brand btn-lg rounded-pill px-4">
                            Lihat Contoh Template
                        </a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 text-secondary small">
                        <span><i class="bi bi-check-circle-fill text-brand me-1"></i>Tanpa install aplikasi</span>
                        <span><i class="bi bi-check-circle-fill text-brand me-1"></i>Siap dibagikan hari ini</span>
                        <span><i class="bi bi-check-circle-fill text-brand me-1"></i>Buku tamu otomatis</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="invite-mockup">
                        <div class="text-center">
                            <div class="ornament mb-2"><i class="bi bi-flower1"></i></div>
                            <p class="text-uppercase small mb-1" style="letter-spacing:3px; opacity:.8;">The Wedding Of</p>
                            <h3 class="fw-bold mb-1" style="font-size:1.9rem;">Andra &amp; Kirana</h3>
                            <p class="small opacity-75 mb-4">Sabtu, 20 Desember 2026</p>
                            <hr style="border-color: rgba(255,255,255,.25);">
                            <p class="fst-italic small opacity-90 mb-4">
                                "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan..."<br>
                                <span class="opacity-75">— QS. Ar-Rum: 21</span>
                            </p>
                            <a href="#" class="btn btn-light btn-sm rounded-pill px-4 text-brand fw-semibold">
                                <i class="bi bi-envelope-heart me-1"></i> Buka Undangan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <h3 class="fw-bold text-brand mb-0">1.000+</h3>
                    <small class="text-secondary">Pasangan Bahagia</small>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bold text-brand mb-0">30+</h3>
                    <small class="text-secondary">Pilihan Template</small>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bold text-brand mb-0">50.000+</h3>
                    <small class="text-secondary">Tamu Terundang</small>
                </div>
                <div class="col-6 col-md-3">
                    <h3 class="fw-bold text-brand mb-0">4.9/5</h3>
                    <small class="text-secondary">Rating Pengguna</small>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-5 py-lg-6">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">Semua yang Kamu Butuhkan</span>
                <h2 class="fw-bold mt-2">Satu Platform untuk Undangan &amp; Buku Tamu</h2>
                <p class="text-secondary col-lg-6 mx-auto">Dari pemilihan template sampai tamu mengisi ucapan, semua bisa diatur sendiri lewat menu custom yang mudah dipakai.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-images"></i></div>
                        <h5 class="fw-bold">Section Foto</h5>
                        <p class="text-secondary mb-0">Unggah foto cover, foto pasangan, hingga galeri momen kalian berdua dan atur urutannya sesuka hati.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-gift"></i></div>
                        <h5 class="fw-bold">Kado Pengantin</h5>
                        <p class="text-secondary mb-0">Cantumkan rekening bank, e-wallet, atau alamat pengiriman kado tanpa perlu disebut langsung ke tamu.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-chat-heart"></i></div>
                        <h5 class="fw-bold">Ucapan &amp; Doa</h5>
                        <p class="text-secondary mb-0">Tamu bisa mengirim ucapan dan doa langsung dari halaman undangan, tersimpan rapi di buku tamu digital.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-whatsapp"></i></div>
                        <h5 class="fw-bold">Bagikan via WhatsApp</h5>
                        <p class="text-secondary mb-0">Cukup satu klik, pesan undangan personal untuk tiap tamu langsung siap dikirim lewat WhatsApp kamu sendiri.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <h5 class="fw-bold">Buku Tamu Digital</h5>
                        <p class="text-secondary mb-0">Pantau siapa saja yang konfirmasi hadir, tidak hadir, beserta jumlah orang yang datang secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-circle mb-3"><i class="bi bi-quote"></i></div>
                        <h5 class="fw-bold">Kata &amp; Ayat Pilihan</h5>
                        <p class="text-secondary mb-0">Pilih dari kumpulan ayat suci &amp; kata-kata indah, atau tambahkan versi kalian sendiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-5 py-lg-6 bg-brand-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">Mudah &amp; Cepat</span>
                <h2 class="fw-bold mt-2">Buat Undangan dalam 4 Langkah</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-number mx-auto mb-3">1</div>
                    <h6 class="fw-bold">Daftar &amp; Pilih Paket</h6>
                    <p class="text-secondary small">Buat akun dan pilih paket sesuai kebutuhan acaramu.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-number mx-auto mb-3">2</div>
                    <h6 class="fw-bold">Pilih Template</h6>
                    <p class="text-secondary small">Telusuri koleksi template yang disediakan admin.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-number mx-auto mb-3">3</div>
                    <h6 class="fw-bold">Custom Undangan</h6>
                    <p class="text-secondary small">Isi nama pasangan, foto, ucapan, kado, dan detail acara.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-number mx-auto mb-3">4</div>
                    <h6 class="fw-bold">Bagikan ke Tamu</h6>
                    <p class="text-secondary small">Kirim link undangan via WhatsApp dan pantau buku tamu.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="template" class="py-5 py-lg-6">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">Koleksi Template</span>
                <h2 class="fw-bold mt-2">Pilih Gaya yang Paling Mewakili Kalian</h2>
                <p class="text-secondary col-lg-6 mx-auto">Template terus ditambah oleh tim kami, dari yang minimalis sampai yang mewah.</p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="template-card overflow-hidden">
                        <div class="template-thumb" style="background: linear-gradient(160deg,#8a3b5e,#c8a04d);"></div>
                        <div class="p-3">
                            <span class="badge bg-brand-soft text-brand mb-2">Basic</span>
                            <h6 class="fw-bold mb-0">Rosea</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="template-card overflow-hidden">
                        <div class="template-thumb" style="background: linear-gradient(160deg,#2c2230,#8a3b5e);"></div>
                        <div class="p-3">
                            <span class="badge bg-warning-subtle text-warning-emphasis mb-2">Premium</span>
                            <h6 class="fw-bold mb-0">Noira</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="template-card overflow-hidden">
                        <div class="template-thumb" style="background: linear-gradient(160deg,#c8a04d,#fbeef2);"></div>
                        <div class="p-3">
                            <span class="badge bg-brand-soft text-brand mb-2">Basic</span>
                            <h6 class="fw-bold mb-0">Aurum</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="template-card overflow-hidden">
                        <div class="template-thumb" style="background: linear-gradient(160deg,#5c2740,#c8a04d);"></div>
                        <div class="p-3">
                            <span class="badge bg-danger-subtle text-danger-emphasis mb-2">Exclusive</span>
                            <h6 class="fw-bold mb-0">Velora</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="/register" class="btn btn-outline-brand rounded-pill px-4">Lihat Semua Template</a>
            </div>
        </div>
    </section>

    <section id="harga" class="py-5 py-lg-6 bg-brand-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">Paket Harga</span>
                <h2 class="fw-bold mt-2">Pilih Paket Sesuai Kebutuhanmu</h2>
                <p class="text-secondary col-lg-6 mx-auto">Semua paket sudah termasuk custom undangan, buku tamu, dan fitur bagikan via WhatsApp.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100 d-flex flex-column">
                        <h5 class="fw-bold">Silver</h5>
                        <p class="text-secondary small">Cocok untuk acara sederhana</p>
                        <h2 class="fw-bold my-3">Rp99rb<span class="fs-6 text-secondary"> /acara</span></h2>
                        <ul class="list-unstyled flex-grow-1 mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>1 Undangan</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Hingga 100 Tamu</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Akses Template Basic</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Buku Tamu Digital</li>
                        </ul>
                        <a href="/register" class="btn btn-outline-brand rounded-pill">Pilih Paket</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="price-card popular p-4 h-100 d-flex flex-column position-relative">
                        <span class="badge bg-brand position-absolute top-0 start-50 translate-middle rounded-pill px-3 py-2">Paling Populer</span>
                        <h5 class="fw-bold mt-2">Gold</h5>
                        <p class="text-secondary small">Untuk resepsi dengan banyak tamu</p>
                        <h2 class="fw-bold my-3">Rp199rb<span class="fs-6 text-secondary"> /acara</span></h2>
                        <ul class="list-unstyled flex-grow-1 mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>3 Undangan</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Hingga 500 Tamu</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Akses Template Basic &amp; Premium</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Buku Tamu Digital</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Template Pesan WhatsApp</li>
                        </ul>
                        <a href="/register" class="btn btn-brand rounded-pill">Pilih Paket</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="price-card p-4 h-100 d-flex flex-column">
                        <h5 class="fw-bold">Platinum</h5>
                        <p class="text-secondary small">Pengalaman tanpa batas</p>
                        <h2 class="fw-bold my-3">Rp349rb<span class="fs-6 text-secondary"> /acara</span></h2>
                        <ul class="list-unstyled flex-grow-1 mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Undangan Tanpa Batas</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Tamu Tanpa Batas</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Semua Template Termasuk Exclusive</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Buku Tamu Digital</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-brand me-2"></i>Prioritas Dukungan</li>
                        </ul>
                        <a href="/register" class="btn btn-outline-brand rounded-pill">Pilih Paket</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">Testimoni</span>
                <h2 class="fw-bold mt-2">Apa Kata Mereka</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-secondary fst-italic">"Prosesnya cepat banget, tinggal pilih template terus isi data. Tamu-tamu juga gampang isi ucapan."</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar-circle">DA</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Dinda &amp; Arka</h6>
                                <small class="text-secondary">Menikah Agustus 2026</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-secondary fst-italic">"Fitur kado pengantinnya membantu banget, jadi tidak perlu jelasin rekening satu-satu ke tamu."</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar-circle">RS</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Rian &amp; Sinta</h6>
                                <small class="text-secondary">Menikah Oktober 2026</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 h-100">
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-secondary fst-italic">"Bagikan undangan ke grup keluarga besar jadi lebih rapi, semua ucapan tersimpan di satu tempat."</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar-circle">FH</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Fajar &amp; Hana</h6>
                                <small class="text-secondary">Menikah November 2026</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-5 py-lg-6 bg-brand-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">FAQ</span>
                <h2 class="fw-bold mt-2">Pertanyaan yang Sering Diajukan</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apakah saya perlu instal aplikasi untuk buat undangan?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary">Tidak perlu. Semua proses pembuatan undangan dilakukan langsung lewat browser, baik di HP maupun laptop.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana cara mengirim undangan ke banyak tamu?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary">Setelah daftar tamu ditambahkan, sistem akan membuatkan link undangan personal untuk tiap tamu yang bisa langsung kamu kirim lewat WhatsApp masing-masing dengan satu klik.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apakah ayat atau kata-kata di undangan bisa diganti sendiri?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary">Bisa. Kamu bisa memilih dari kumpulan ayat dan kata-kata yang sudah kami sediakan, atau menambahkan versimu sendiri.</div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Apakah data buku tamu bisa diunduh?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary">Bisa. Semua data kehadiran dan ucapan tamu tersimpan rapi dan dapat kamu lihat kapan saja dari halaman kelola undangan.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-banner py-5">
        <div class="container text-center text-white py-4">
            <h2 class="fw-bold mb-3">Wujudkan Undangan Impianmu Sekarang</h2>
            <p class="col-lg-6 mx-auto mb-4 opacity-75">Daftar hari ini dan buat undangan pernikahan digital pertamamu hanya dalam hitungan menit.</p>
            <a href="/register" class="btn btn-light btn-lg rounded-pill px-5 text-brand fw-semibold">Daftar Sekarang</a>
        </div>
    </section>

    <footer class="footer-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="navbar-brand-name text-white fs-3 mb-3"><i class="bi bi-heart-fill me-1 text-gold"></i>Harimu</h4>
                    <p class="text-white-50">Platform undangan pernikahan digital dan buku tamu online untuk hari bahagiamu.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Produk</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#fitur" class="text-white-50 text-decoration-none">Fitur</a></li>
                        <li class="mb-2"><a href="#template" class="text-white-50 text-decoration-none">Template</a></li>
                        <li class="mb-2"><a href="#harga" class="text-white-50 text-decoration-none">Harga</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Bantuan</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#faq" class="text-white-50 text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3 fs-5">
                        <a href="#" class="text-white-50"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white-50"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="text-white-50"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <p class="text-center text-white-50 small mb-0">&copy; {{ date('Y') }} Harimu. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
