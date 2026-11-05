<?php
// Agar kisi page par connect.php include nahi hai toh automatically include karein
if (!isset($conn)) {
    $connect_path = __DIR__ . '/../config/connect.php';
    if (file_exists($connect_path)) {
        require_once $connect_path;
    }
}

$current_page = basename($_SERVER['PHP_SELF']);

// 1. Base URL & Protocol Setup (No syntax errors)
$is_https = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);
$protocol = $is_https ? "https://" : "http://";
$raw_host = $_SERVER['HTTP_HOST'];

if (strpos($raw_host, 'localhost') !== false || strpos($raw_host, '127.0.0.1') !== false) {
    $base_path = '/office_php_project/akrbuild/';
    $base_url = isset($site) ? $site : ($protocol . $raw_host . $base_path);
    $canonical_base = $protocol . 'www.localhost' . $base_path;
} else {
    $base_path = '/';
    $clean_host = (strpos($raw_host, 'www.') === 0) ? $raw_host : 'www.' . $raw_host;
    $base_url = "https://" . $clean_host . $base_path;
    $canonical_base = $base_url;
}

// 2. Canonical URL Generator (Clean Slugs + www)
if ($current_page == 'index.php' || $current_page == '') {
    $canonical_url = $canonical_base;
} elseif ($current_page == 'category.php' && !empty($_GET['slug'])) {
    $canonical_url = $canonical_base . 'category/' . urlencode($_GET['slug']);
} elseif ($current_page == 'product-details.php' && !empty($_GET['slug'])) {
    $canonical_url = $canonical_base . 'product/' . urlencode($_GET['slug']);
} elseif ($current_page == 'products.php' && !empty($_GET['category'])) {
    $canonical_url = $canonical_base . 'products/category/' . urlencode($_GET['category']);
} elseif ($current_page == 'blog-details.php' && !empty($_GET['slug'])) {
    $canonical_url = $canonical_base . 'blog/' . urlencode($_GET['slug']);
} elseif ($current_page == 'page.php' && !empty($_GET['slug'])) {
    $canonical_url = $canonical_base . 'page/' . urlencode($_GET['slug']);
} else {
    $clean_page_name = preg_replace('/\.php$/', '', $current_page);
    $canonical_url = $canonical_base . $clean_page_name;
}

// 3. CSS Cache-Busting Function
if (!function_exists('asset_v')) {
    function asset_v($file) {
        $path = __DIR__ . '/../' . $file;
        return file_exists($path) ? filemtime($path) : 1;
    }
}

// 4. Default Meta Tags
if (!isset($pageTitle) || empty($pageTitle)) { 
    $pageTitle = "AKR Buildtech | Strength In Every Drops"; 
}
if (!isset($meta_description) || empty($meta_description)) { 
    $meta_description = "AKR Buildtech is a trusted supplier and exporter providing high-quality products across India."; 
}
if (!isset($meta_keywords) || empty($meta_keywords)) { 
    $meta_keywords = "AKR Buildtech, wholesale supplier Delhi, bulk supplier India"; 
}

$header_logo = "assets/images/logo/logo.png"; 
$favicon = "assets/images/logo/favicon.png"; 

$t_phone = "+91-9213519991";
$t_email = "akrbuildtech05@gmail.com";
$t_fb = "#"; $t_linkedin = "#"; $t_wp = "#"; $t_instagram = "#";
$cats_dropdown_query = false;

if (isset($conn)) {
    // Check if logos table exists before querying
    $logo_check = mysqli_query($conn, "SHOW TABLES LIKE 'logos'");
    if ($logo_check && mysqli_num_rows($logo_check) > 0) {
        $logo_query = mysqli_query($conn, "SELECT logo_path FROM logos WHERE location = 'header' AND is_active = 1 ORDER BY id DESC LIMIT 1");
        if ($logo_query && mysqli_num_rows($logo_query) > 0) {
            $logo_data = mysqli_fetch_assoc($logo_query);
            $header_logo = 'admin/uploads/' . $logo_data['logo_path'];
        }

        $fav_query = mysqli_query($conn, "SELECT logo_path FROM logos WHERE location = 'favicon' AND is_active = 1 ORDER BY id DESC LIMIT 1");
        if ($fav_query && mysqli_num_rows($fav_query) > 0) {
            $fav_data = mysqli_fetch_assoc($fav_query);
            $favicon = 'admin/uploads/' . $fav_data['logo_path'];
        }
    }

    $contact_query = mysqli_query($conn, "SELECT * FROM contacts ORDER BY id DESC LIMIT 1");
    if ($contact_query && mysqli_num_rows($contact_query) > 0) {
        $c_info = mysqli_fetch_assoc($contact_query);
        $t_phone = !empty($c_info['phone']) ? $c_info['phone'] : $t_phone;
        $t_email = !empty($c_info['contact_email']) ? $c_info['contact_email'] : (!empty($c_info['email']) ? $c_info['email'] : $t_email);
        $t_fb = !empty($c_info['facebook']) ? $c_info['facebook'] : $t_fb;
        $t_linkedin = !empty($c_info['linkdin']) ? $c_info['linkdin'] : $t_linkedin;
        $t_instagram = !empty($c_info['instagram']) ? $c_info['instagram'] : $t_instagram;
        $t_wp = !empty($c_info['wp_number']) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $c_info['wp_number']) : $t_wp;
    }

    $cats_dropdown_query = mysqli_query($conn, "SELECT * FROM categories WHERE status = 1 ORDER BY categories ASC");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?= htmlspecialchars($base_url); ?>">

    <title><?= htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords); ?>">

    <link rel="canonical" href="<?= htmlspecialchars($canonical_url); ?>" />

    <meta name="google-site-verification" content="eX_sXjETkL7O-emXnSDL6-LirHz1VsbiMIZMyFqgvIw" />
    <link rel="icon" href="<?= $base_url . htmlspecialchars($favicon); ?>" type="image/x-icon">

    <meta name="theme-color" content="#111111">

    <link rel="icon" href="<?= $base_url; ?>favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $base_url; ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $base_url; ?>favicon-16x16.png">
    <link rel="apple-touch-icon" href="<?= $base_url; ?>apple-touch-icon.png">
    <link rel="manifest" href="<?= $base_url; ?>site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/include.css?v=<?= asset_v('assets/style/include.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/style.css?v=<?= asset_v('assets/style/style.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/about.css?v=<?= asset_v('assets/style/about.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/blog.css?v=<?= asset_v('assets/style/blog.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/contact.css?v=<?= asset_v('assets/style/contact.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/gallery.css?v=<?= asset_v('assets/style/gallery.css'); ?>">
    <link rel="stylesheet" href="<?= $base_url; ?>assets/style/product.css?v=<?= asset_v('assets/style/product.css'); ?>">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3JGVQX47GN"></script>
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-PJCRLJB3');
    </script>

    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-3JGVQX47GN');
    </script>

    <?php if ($current_page == 'index.php' || $current_page == '') { ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "AKR Buildtech",
        "url": "<?= htmlspecialchars($canonical_base); ?>",
        "logo": "<?= $base_url . htmlspecialchars($header_logo); ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= htmlspecialchars($t_phone); ?>",
            "contactType": "customer service",
            "areaServed": "IN",
            "availableLanguage": ["en", "hi"]
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Office No-102, 1st Floor, Block C, Pocket-4, Azadpur",
            "addressLocality": "New Delhi",
            "postalCode": "110033",
            "addressCountry": "IN"
        }
    }
    </script>
    <?php } ?>

    <!-- Dynamic Schema Markup from Database -->
    <?php 
    if (isset($page_schema) && !empty(trim($page_schema))) {
        echo $page_schema;
    } 
    ?>
</head>

<body>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJCRLJB3" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div class="topbar d-none d-lg-block shadow-sm">
        <div class="container">
            <div class="row align-items-center py-2">
                <div class="col-md-7 topbar-left">
                    <a href="mailto:<?= htmlspecialchars($t_email); ?>"><i class="bi bi-envelope-fill me-1"></i>
                        <?= htmlspecialchars($t_email); ?></a>
                    <span class="mx-2 text-white-50">|</span>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $t_phone); ?>"><i
                            class="bi bi-telephone-fill me-1"></i> <?= htmlspecialchars($t_phone); ?></a>
                </div>
                <div class="col-md-5 text-end topbar-right">
                    <span class="me-2 text-white-50 small">Follow Us:</span>
                    <?php if ($t_fb != '#'): ?><a href="<?= htmlspecialchars($t_fb); ?>" target="_blank"
                        rel="noopener noreferrer" aria-label="Facebook"><i
                            class="bi bi-facebook"></i></a><?php endif; ?>
                    <?php if ($t_instagram != '#'): ?><a href="<?= htmlspecialchars($t_instagram); ?>" target="_blank"
                        rel="noopener noreferrer" aria-label="Instagram"><i
                            class="bi bi-instagram"></i></a><?php endif; ?>
                    <?php if ($t_linkedin != '#'): ?><a href="<?= htmlspecialchars($t_linkedin); ?>" target="_blank"
                        rel="noopener noreferrer" aria-label="LinkedIn"><i
                            class="bi bi-linkedin"></i></a><?php endif; ?>
                    <?php if ($t_wp != '#'): ?><a href="<?= htmlspecialchars($t_wp); ?>" target="_blank"
                        rel="noopener noreferrer" aria-label="WhatsApp"><i
                            class="bi bi-whatsapp"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="<?= $base_url; ?>" style="max-width: 70vw;">
                <img src="<?= $base_url . htmlspecialchars($header_logo); ?>" alt="AKR Buildtech Logo" class="site-logo"
                    onerror="this.onerror=null;this.src='<?= $base_url; ?>assets/images/logo/logo.png'">
            </a>

            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>"
                            href="<?= $base_url; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : ''; ?>"
                            href="<?= $base_url; ?>about">About Us</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($current_page == 'category.php') ? 'active' : ''; ?>"
                            href="javascript:void(0);" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg" aria-labelledby="categoriesDropdown">
                            <?php 
                            if ($cats_dropdown_query && mysqli_num_rows($cats_dropdown_query) > 0) {
                                while($cat = mysqli_fetch_assoc($cats_dropdown_query)) {
                                    $isActiveCat = ($current_page == 'category.php' && isset($_GET['slug']) && $_GET['slug'] == $cat['slug_url']) ? 'active-dropdown-item' : '';
                            ?>
                            <li>
                                <a class="dropdown-item <?= $isActiveCat; ?>"
                                    href="<?= $base_url; ?>category/<?= urlencode($cat['slug_url']); ?>">
                                    <?= htmlspecialchars($cat['categories']); ?>
                                </a>
                            </li>
                            <?php 
                                }
                            } 
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'blog.php' || $current_page == 'blog-details.php') ? 'active' : ''; ?>"
                            href="<?= $base_url; ?>blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : ''; ?>"
                            href="<?= $base_url; ?>contact">Contact Us</a>
                    </li>
                    <li class="nav-item ms-lg-4 mt-3 mt-lg-0 mb-3 mb-lg-0">
                        <a class="btn btn-quote" href="<?= $base_url; ?>contact">Get a Quote</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>