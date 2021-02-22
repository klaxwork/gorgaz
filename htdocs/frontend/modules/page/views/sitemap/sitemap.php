<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?php
$x1 = 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
$x2 = 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
$x3 = 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9';
$x4 = 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"';
?>
<urlset
    <?= $x1 ?>
    <?= $x2 ?>
    <?= $x3 ?>
    <?= $x4 ?>>
    <?php foreach ($sitemap as $row): ?>
        <url>
            <loc><?= $row['loc'] ?></loc>
            <lastmod><?= $row['lastmod'] ?></lastmod>
            <changefreq><?= $row['frequency'] ?></changefreq>
            <priority><?= $row['priority']; ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>
