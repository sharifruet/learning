<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // Default SEO values
    $siteName = 'Bandhanhara Learning';
    $siteDescription = 'Free online learning platform with interactive lessons and courses. Learn Python, JavaScript, and other programming languages at your own pace.';
    $siteUrl = base_url();
    
    // Get SEO data from view data
    $pageTitle = $seo['title'] ?? $title ?? $siteName;
    $pageDescription = $seo['description'] ?? $siteDescription;
    $pageKeywords = $seo['keywords'] ?? 'online learning, free courses, programming, Python, JavaScript, web development, coding tutorials';
    $pageImage = $seo['image'] ?? base_url('logo.png');
    $pageUrl = $seo['url'] ?? current_url();
    $pageType = $seo['type'] ?? 'website';
    
    // Construct full title
    $fullTitle = $pageTitle === $siteName ? $siteName : $pageTitle . ' | ' . $siteName;
    ?>
    
    <!-- Primary Meta Tags -->
    <title><?= esc($fullTitle) ?></title>
    <meta name="title" content="<?= esc($fullTitle) ?>">
    <meta name="description" content="<?= esc($pageDescription) ?>">
    <meta name="keywords" content="<?= esc($pageKeywords) ?>">
    <meta name="author" content="<?= esc($siteName) ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= esc($pageType) ?>">
    <meta property="og:url" content="<?= esc($pageUrl) ?>">
    <meta property="og:title" content="<?= esc($fullTitle) ?>">
    <meta property="og:description" content="<?= esc($pageDescription) ?>">
    <meta property="og:image" content="<?= esc($pageImage) ?>">
    <meta property="og:site_name" content="<?= esc($siteName) ?>">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($pageUrl) ?>">
    <meta name="twitter:title" content="<?= esc($fullTitle) ?>">
    <meta name="twitter:description" content="<?= esc($pageDescription) ?>">
    <meta name="twitter:image" content="<?= esc($pageImage) ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= esc($pageUrl) ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('logo.png') ?>">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        html, body, * {
            font-family: Verdana, Tahoma, Arial, sans-serif !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('logo.png') ?>" alt="Bandhanhara Learning" class="navbar-logo" style="height: 40px; width: auto;">
                <span class="ms-2">Bandhanhara Learning</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('courses') ?>">
                            <i class="bi bi-book"></i> Courses
                        </a>
                    </li>
                    <?php if (session()->has('user_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <?php if (in_array(session()->get('role'), ['admin', 'instructor'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear"></i> 
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        Admin
                                    <?php else: ?>
                                        Instructor
                                    <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <li><a class="dropdown-item" href="<?= base_url('admin') ?>"><i class="bi bi-speedometer2"></i> Admin Dashboard</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('admin/users') ?>"><i class="bi bi-people"></i> Manage Users</a></li>
                                    <?php endif; ?>
                                    <?php if (session()->get('role') === 'instructor'): ?>
                                        <li><a class="dropdown-item" href="<?= base_url('instructor') ?>"><i class="bi bi-speedometer2"></i> Instructor Dashboard</a></li>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses') ?>"><i class="bi bi-book"></i> Manage Courses</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses/create') ?>"><i class="bi bi-plus-circle"></i> Create Course</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (session()->has('user_id')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?= esc(session()->get('first_name') ?: session()->get('username')) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/login') ?>">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-dark ms-2" href="<?= base_url('auth/register') ?>">
                                <i class="bi bi-person-plus"></i> Sign Up
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show fade-in-up" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show fade-in-up" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show fade-in-up" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($content)): ?>
            <?= $content ?>
        <?php endif; ?>
    </main>

    <footer class="bg-dark text-light">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= base_url('logo.png') ?>" alt="Bandhanhara Learning" class="footer-logo" style="height: 50px; width: auto;">
                        <span class="ms-2 text-white" style="font-size: 1.25rem; font-weight: 600;">Bandhanhara Learning</span>
                    </div>
                    <p class="text-muted">Free online learning platform with interactive courses and lessons. Learn any subject - from programming to any topic you want to master.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('courses') ?>" class="text-muted text-decoration-none">Courses</a></li>
                        <?php if (session()->has('user_id')): ?>
                            <li><a href="<?= base_url('dashboard') ?>" class="text-muted text-decoration-none">Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('auth/login') ?>" class="text-muted text-decoration-none">Login</a></li>
                            <li><a href="<?= base_url('auth/register') ?>" class="text-muted text-decoration-none">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; <?= date('Y') ?> bandhanhara learning. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
