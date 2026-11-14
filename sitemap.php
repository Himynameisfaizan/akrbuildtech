<?php
header("Content-Type: application/xml; charset=utf-8");
include 'config/connect.php';

global $site;
$baseUrl = !empty($site) ? $site : "https://akrbuildtech.com/";

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    $staticPages = [
    ["url" => "", "priority" => "1.0", "changefreq" => "daily"],
    ["url" => "about", "priority" => "0.8", "changefreq" => "monthly"],
    ["url" => "products", "priority" => "0.9", "changefreq" => "daily"],
    ["url" => "blog", "priority" => "0.8", "changefreq" => "weekly"],
    ["url" => "contact", "priority" => "0.7", "changefreq" => "monthly"],
    ["url" => "terms-condition", "priority" => "0.3", "changefreq" => "yearly"],
    ["url" => "privacy-policy", "priority" => "0.3", "changefreq" => "yearly"],
    ["url" => "shipping-return", "priority" => "0.3", "changefreq" => "yearly"],
    ["url" => "refund-policy", "priority" => "0.3", "changefreq" => "yearly"]
    ];

    foreach ($staticPages as $page) {
    echo '<url>';
        echo '<loc>' . $baseUrl . $page['url'] . '</loc>';
        echo '<changefreq>' . $page['changefreq'] . '</changefreq>';
        echo '<priority>' . $page['priority'] . '</priority>';
        echo '</url>';
    }

    if (isset($conn)) {
    $catQuery = mysqli_query($conn, "SELECT cate_id, slug_url FROM categories WHERE status = 1");
    if ($catQuery && mysqli_num_rows($catQuery) > 0) {
    while ($row = mysqli_fetch_assoc($catQuery)) {
    $catVal = !empty($row['slug_url']) ? $row['slug_url'] : $row['cate_id'];
    echo '<url>';
        echo '<loc>' . $baseUrl. 'category/' . urlencode($catVal) . '</loc>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
    }

    $prodQuery = mysqli_query($conn, "SELECT id, slug_url FROM products WHERE status = 1");
    if ($prodQuery && mysqli_num_rows($prodQuery) > 0) {
    while ($row = mysqli_fetch_assoc($prodQuery)) {
    $prodVal = !empty($row['slug_url']) ? $row['slug_url'] : $row['id'];
    echo '<url>';
        echo '<loc>' . $baseUrl . 'product/' . $prodVal . '</loc>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
    }

    $blogQuery = mysqli_query($conn, "SELECT slug FROM blogs WHERE status = 1");
    if ($blogQuery && mysqli_num_rows($blogQuery) > 0) {
    while ($row = mysqli_fetch_assoc($blogQuery)) {
    if (!empty($row['slug'])) {
    echo '<url>';
        echo '<loc>' . $baseUrl . 'blog/' . htmlspecialchars($row['slug']) . '</loc>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }
    }
    }

    $customPageQuery = mysqli_query(
    $conn,
    "SELECT slug_url FROM custom_pages WHERE status = 1"
    );

    if ($customPageQuery && mysqli_num_rows($customPageQuery) > 0) {
    while ($row = mysqli_fetch_assoc($customPageQuery)) {

    if (!empty($row['slug_url'])) {
    echo '<url>';
        echo '<loc>' . htmlspecialchars(
            rtrim($baseUrl, '/') . '/page/' .
            rawurlencode($row['slug_url']),
            ENT_XML1,
            'UTF-8'
            ) . '</loc>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }
    }
    }
    }

    echo '</urlset>';
?>