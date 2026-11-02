<?php
$pageTitle = 'Locations & Custom Pages | AKR Buildtech';
$meta_title = 'Locations & Custom Pages | AKR Buildtech';
$meta_desc = 'Explore location and information pages published by AKR Buildtech.';
$meta_key = 'AKR Buildtech, locations, custom pages, premium quality';
$breadcrumb_title = 'Locations';

// Adjust this path if your database connection file is in a different folder.
include 'config/connect.php';

// Fetch active custom pages using the schema in custom_pages.sql.
$customPages = [];
$sql = "SELECT page_title, breadcrumb_title, slug_url, meta_title, meta_desc
        FROM custom_pages
        WHERE status = 1 AND slug_url <> ''
        ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $customPages[] = $row;
    }
}

function locationPageText($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Use the existing shared site header
include 'includes/header.php';
?>

<style>
/* ================= PREMIUM THEME (AKR BUILDTECH) ================= */
:root {
    --primary-green: #7bc243;
    --dark-bg: #1a1a1a;
    --card-bg: #ffffff;
    --text-muted: #666666;
    --body-bg: #f9f9f9;
}

body.location-page {
    margin: 0;
    background: var(--body-bg);
    font-family: 'Poppins', sans-serif;
}

/* Animations */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Premium Hero Section */
.location-hero {
    background-color: var(--dark-bg);
    background-image: url('https://via.placeholder.com/1920x400/1a1a1a/333333');
    /* Add real BG image here */
    background-size: cover;
    background-position: center;
    position: relative;
    padding: 100px 0;
    color: #ffffff;
    text-align: center;
}

.location-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    /* Dark Overlay */
}

.location-hero .container {
    position: relative;
    z-index: 2;
}

.location-hero h1 {
    font-size: clamp(2.5rem, 4vw, 3.5rem);
    font-weight: 700;
    margin-bottom: 15px;
}

.location-hero p {
    color: #cccccc;
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto;
}

/* Premium Card Layout */
.location-section {
    padding: 80px 0;
}

.premium-card {
    background: var(--card-bg);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.02);
}

.premium-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.card-img-wrapper {
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
}

.card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.premium-card:hover .card-img-wrapper img {
    transform: scale(1.08);
    /* Zoom effect */
}

.card-content {
    padding: 25px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.premium-card h3 {
    color: var(--dark-bg);
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.premium-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
    display: -webkit-box;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-btn {
    display: inline-block;
    color: var(--dark-bg);
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

.premium-card:hover .card-btn {
    color: var(--primary-green);
}

.card-btn i {
    margin-left: 5px;
    transition: transform 0.3s ease;
}

.premium-card:hover .card-btn i {
    transform: translateX(5px);
}
</style>

<header class="location-hero">
    <div class="container animate-fade-up">
        <h1>Explore Our Pages</h1>
        <p>Discover our location-focused pages, premium services, and useful information tailored for commercial
            requirements.</p>
    </div>
</header>

<main class="bg-light">
    <section class="location-section">
        <div class="container">
            <?php if (!empty($customPages)): ?>
            <div class="row g-4 justify-content-center">
                <?php 
                $delay = 0.1;
                foreach ($customPages as $customPage):
                    $cardTitle = trim((string)($customPage['breadcrumb_title'] ?? ''));
                    if ($cardTitle === '') { $cardTitle = trim((string)($customPage['page_title'] ?? '')); }
                    if ($cardTitle === '') { $cardTitle = 'Explore Page'; }

                    $description = trim(strip_tags((string)($customPage['meta_desc'] ?? '')));
                    if ($description === '') { $description = 'Explore premium quality details and information.'; }

                    $slug = trim((string)($customPage['slug_url'] ?? ''));
                    // Note: Update this link structure if using .htaccess URL rewriting (e.g., '/page/' . $slug)
                    $pageUrl = 'page.php?slug=' . rawurlencode($slug); 
                ?>
                <div class="col-12 col-md-6 col-lg-4 animate-fade-up" style="animation-delay: <?= $delay; ?>s;">
                    <a href="<?= locationPageText($pageUrl); ?>" class="premium-card">
                        <div class="card-img-wrapper">
                            <!-- Placeholder image, map real image from DB if available -->
                            <img src="https://via.placeholder.com/400x250/222/fff?text=<?= urlencode(substr($cardTitle, 0, 10)) ?>..."
                                alt="<?= locationPageText($cardTitle); ?>">
                        </div>
                        <div class="card-content">
                            <h3><?= locationPageText($cardTitle); ?></h3>
                            <p><?= locationPageText($description); ?></p>
                            <div class="card-btn">View Details <i class="fa-solid fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
                <?php 
                $delay += 0.1;
                endforeach; 
                ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-break display-4 text-muted mb-3 d-block"></i>
                <h3>No pages available yet</h3>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>