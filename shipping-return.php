<?php
include('config/connect.php');

$pageTitle = "Shipping and Delivery Policy | AKR Build Tech";
$meta_description = "Learn about domestic and international shipping options for premium construction materials and infrastructure products by AKR Build Tech.";
$meta_key = "shipping policy, delivery policy, akr build tech, infrastructure export";

include 'includes/header.php';
include 'includes/breadcrumb.php';
?>

<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row g-5">
            
            <!-- LEFT COLUMN: Content -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm border">
                    <h1 class="mb-4" style="color: #2b5e2c; font-weight: 700;">Shipping and Delivery Policy</h1>
                    <p class="text-muted mb-5"><strong>Last Updated:</strong> <?= date('F d, Y'); ?></p>
                    
                    <h3 class="mt-5 mb-3" style="color: #e65c00; font-size: 1.3rem;">Shipping Policy</h3>
                    
                    <h4 class="mt-4" style="font-size: 1.1rem; color: #2b5e2c; font-weight: 600;">1. Order Processing & Dispatch</h4>
                    <p>Standard retail orders of construction materials are processed and dispatched within <strong>3 to 5 business days</strong>. Bulk wholesale and international container exports follow custom schedules based on documentation and transport processing.</p>

                    <h4 class="mt-4" style="font-size: 1.1rem; color: #2b5e2c; font-weight: 600;">2. Domestic Delivery (Within India)</h4>
                    <p>Standard delivery across India takes approximately <strong>5 to 7 business days</strong> depending on the delivery location and the volume of the shipment.</p>

                    <h4 class="mt-4" style="font-size: 1.1rem; color: #2b5e2c; font-weight: 600;">3. International Shipping & Exports</h4>
                    <p>International shipments are handled via sea freight or appropriate logistics channels. <strong>Note:</strong> The buyer is fully responsible for destination country customs duties, import clearance, and local taxes. AKR Build Tech provides all mandatory Indian export compliance documentation.</p>

                    <hr class="my-5">

                    <h3 class="mb-3" style="color: #e65c00; font-size: 1.3rem;">Returns Policy</h3>
                    
                    <h4 class="mt-4" style="font-size: 1.1rem; color: #2b5e2c; font-weight: 600;">1. Non-Returnable Goods</h4>
                    <p>Due to stringent industrial standards and the logistics involved in moving heavy infrastructure materials, <strong>we do not accept standard returns</strong> on consumable construction items once shipped.</p>

                    <h4 class="mt-4" style="font-size: 1.1rem; color: #2b5e2c; font-weight: 600;">2. Damaged or Incorrect Shipments</h4>
                    <p>Exceptions apply strictly if you receive wrong or severely transit-damaged items affecting their utility. Claims must be filed within <strong>48 hours of receipt</strong> along with an unboxing video/photos.</p>
                </div>
            </div>

            <!-- RIGHT COLUMN: Sidebar Widgets -->
            <div class="col-lg-4">
                <div class="sidebar-widgets position-sticky" style="top: 20px;">
                    <div class="widget-box bg-white p-4 rounded shadow-sm border mb-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Search Products</h5>
                        <form action="products.php" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search..." required style="font-size: 0.9rem;">
                            <button type="submit" class="btn text-white px-3" style="background: var(--primary-green, #2b5e2c);"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    <div class="widget-box bg-white p-4 rounded shadow-sm border mb-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Categories</h5>
                        <ul class="list-unstyled mb-0 category-list">
                            <?php
                            $catQuery = mysqli_query($conn, "SELECT * FROM categories WHERE status = 1");
                            if ($catQuery && mysqli_num_rows($catQuery) > 0) {
                                while($catRow = mysqli_fetch_assoc($catQuery)) {
                            ?>
                            <li class="mb-2 pb-2 border-bottom">
                                <a href="category.php?slug=<?= htmlspecialchars($catRow['slug_url']) ?>" class="text-decoration-none d-flex justify-content-between align-items-center text-muted" style="font-size: 0.95rem;">
                                    <span><i class="fa-solid fa-angle-right me-2" style="font-size: 0.75rem;"></i> <?= htmlspecialchars($catRow['categories']) ?></span>
                                </a>
                            </li>
                            <?php 
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="widget-box rounded shadow-sm text-center p-4 text-white" style="background: linear-gradient(135deg, var(--primary-green, #2b5e2c) 0%, #1a3f1b 100%);">
                        <div class="icon-wrap mb-3"><i class="fa-solid fa-headset fs-1 text-white opacity-75"></i></div>
                        <h4 class="fw-bold mb-2 text-white">Bulk Export Inquiry?</h4>
                        <p class="small mb-4 opacity-75">Get reliable global shipping for wholesale construction commodities.</p>
                        <a href="contact.php" class="btn bg-white w-100 fw-bold shadow-sm mb-3" style="color: var(--primary-green, #2b5e2c);">Request Quote</a>
                        <a href="tel:+918448211202" class="text-white text-decoration-none small fw-bold"><i class="fa-solid fa-phone me-1"></i> +91-8448211202</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php 
include ('includes/inquiry-form.php');
include 'includes/footer.php'; 
?>