<?php
$pageTitle = "404 - Page Not Found | AKR Buildtech";
// Include header
include 'includes/header.php'; // Ya jo bhi aapke header ka path hai
?>

<style>
/* Premium 404 Page Design */
.error-page-wrap {
    background-color: #1a1a1a;
    background-image: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
    color: #ffffff;
    padding: 120px 20px;
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.error-page-wrap::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('https://via.placeholder.com/1920x1080/1a1a1a/222222') center/cover;
    opacity: 0.2;
    z-index: 1;
}

.error-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
    margin: 0 auto;
}

.error-heading {
    font-size: clamp(6rem, 15vw, 12rem);
    font-weight: 900;
    line-height: 1;
    margin-bottom: 0;
    color: transparent;
    -webkit-text-stroke: 2px #7bc243;
    text-shadow: 0 10px 30px rgba(123, 194, 67, 0.3);
}

.error-subheading {
    font-size: 2rem;
    font-weight: 700;
    margin-top: -20px;
    margin-bottom: 20px;
    color: #ffffff;
}

.error-desc {
    color: #bbbbbb;
    font-size: 1.1rem;
    margin-bottom: 40px;
    line-height: 1.6;
}

.btn-primary-green {
    background-color: #7bc243;
    color: #ffffff !important;
    padding: 14px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 2px solid #7bc243;
}

.btn-primary-green:hover {
    background-color: transparent;
    color: #7bc243 !important;
    box-shadow: 0 5px 20px rgba(123, 194, 67, 0.4);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>

<div class="error-page-wrap">
    <div class="error-content animate-fade-up">
        <h1 class="error-heading">404</h1>
        <h2 class="error-subheading">Page Not Found</h2>
        <p class="error-desc">Oops! The page you are looking for might have been removed, had its name changed, or is
            temporarily unavailable.</p>

        <a href="index.php" class="btn-primary-green">
            <i class="fa-solid fa-arrow-left"></i> Back to Homepage
        </a>
    </div>
</div>

<?php 
// Include footer
include 'includes/footer.php'; 
?>