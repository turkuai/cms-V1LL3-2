<?php
require_once 'includes/database.php';

// Hae tietokannasta
$companyName = getSectionContent($conn, 'company_name');
$description = getSectionContent($conn, 'company_description');
$copyright = getSectionContent($conn, 'company_copyright');
$logo = getSectionContent($conn, 'logo');
$navLinks = getLinks($conn, 'nav');
$footerLinks = getLinks($conn, 'footer');
$socialLinks = getLinks($conn, 'social');
?>
<!DOCTYPE html>
<html>
<head>
    <title>User View</title>
    <style>
        /* ... (pidä nykyinen tyyli ennallaan) ... */
    </style>
</head>
<body>
    <div class="container">
        <nav class="nav-box">
            <div class="logo-box">
                <?php if($logo): ?>
                    <img src="<?= htmlspecialchars($logo) ?>" style="max-height: 50px">
                <?php else: ?>
                    LOGO
                <?php endif; ?>
            </div>
            <ul class="navbar">
                <?php foreach($navLinks as $link): ?>
                    <li><a href="<?= htmlspecialchars($link['url']) ?>"><?= htmlspecialchars($link['text']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        
        <div class="content-box">
            <?php
            $articles = db_query($conn, 
                "SELECT * FROM sections WHERE name LIKE 'article_%'"
            )->get_result()->fetch_all(MYSQLI_ASSOC);
            
            foreach($articles as $article): ?>
                <div class="article">
                    <h2><?= htmlspecialchars($article['title']) ?></h2>
                    <div class="text-and-image">
                        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                        <?php if(!empty($article['image_url'])): ?>
                            <div class="image-placeholder">
                                <img src="<?= htmlspecialchars($article['image_url']) ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="footer">
            <div class="footer-info">
                <h2><?= htmlspecialchars($companyName) ?></h2>
                <p><?= nl2br(htmlspecialchars($description)) ?></p>
                <p><?= htmlspecialchars($copyright) ?></p>
            </div>
            
            <div class="footer-links">
                <?php foreach($footerLinks as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>"><?= htmlspecialchars($link['text']) ?></a>
                <?php endforeach; ?>
            </div>
            
            <div class="footer-social">
                <?php foreach($socialLinks as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>"><?= htmlspecialchars($link['text']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>