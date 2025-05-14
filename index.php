<?php
// This file replaces the existing index.html
// Load environment variables
foreach (parse_ini_file('.env') as $key => $value) {
    $_ENV[$key] = $value;
}

// Include database connection
require_once 'includes/database.php';

// Fetch data for displaying in admin view
$companyName = getSectionContent($conn, 'company_name');
$description = getSectionContent($conn, 'company_description');
$copyright = getSectionContent($conn, 'company_copyright');
$logo = getSectionContent($conn, 'logo');
$navLinks = getLinks($conn, 'nav');
$footerLinks = getLinks($conn, 'footer');
$socialLinks = getLinks($conn, 'social');

// Get articles from the database
$articles = getArticles($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .url-bar {
            border: 2px solid black;
            text-align: center;
            padding: 10px;
            margin: 10px 50px;
        }
        
        .container {
            border: 2px solid black;
            margin: 10px 50px;
        }
        
        .nav-box {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 2px solid black;
        }
        
        .logo-box {
            border: 2px solid black;
            padding: 10px 20px;
            margin-right: 30px;
            font-size: 24px;
            font-weight: bold;
        }
        
        .navbar {
            display: flex;
            gap: 40px;
            list-style: none;
            padding: 0;
        }
        
        .navbar a {
            text-decoration: none;
            color: blue;
            font-size: 18px;
        }
        
        .content-box {
            padding: 20px;
            border-bottom: 2px solid black;
        }
        
        .article {
            margin-bottom: 40px;
            border: 2px solid black;
            width: auto;
            min-width: 150px;
            padding: 10px 20px;
            height: auto;
            margin: 20px 0 0 30px;
        }
        
        .article h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .text-and-image {
            display: flex;
            gap: 20px;
        }
        
        .text-and-image p {
            flex: 1;
            margin: 0;
        }
        
        .text-and-image .image-placeholder {
            width: 300px;
            height: 200px;
            border: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .footer {
            display: flex;
            padding: 20px;
        }
        
        .footer-info {
            flex: 1;
        }
        
        .footer-links, .footer-social {
            width: 200px;
            display: flex;
            flex-direction: column;
        }
        
        .footer a {
            color: blue;
            text-decoration: none;
            margin-bottom: 10px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .admin-panel {
            position: fixed;
            top: 0;
            right: 0;
            background: #333;
            color: white;
            padding: 10px;
            border-bottom-left-radius: 10px;
            z-index: 1000;
        }
        
        .editable {
            position: relative;
            border: 2px dashed transparent;
            padding: 4px;
            min-height: 20px;
        }
        
        .editable:hover {
            border: 2px dashed #f00;
            cursor: pointer;
        }
        
        .image-upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            display: none;
        }
        
        .image-placeholder:hover .image-upload-btn {
            display: block;
        }
        
        .link-edit-btn {
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            padding: 2px 5px;
            cursor: pointer;
            margin-left: 5px;
            display: none;
            font-size: 10px;
            vertical-align: middle;
        }
        
        a:hover .link-edit-btn {
            display: inline-block;
        }
        
        .save-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .image-edit-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
        }
        
        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: space-between;
        }
        
        .modal-buttons button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .apply-btn {
            background: #4CAF50;
            color: white;
        }
        
        .cancel-btn {
            background: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-panel">
        <h3>Admin Mode</h3>
        <p>Click on any text to edit</p>
        <button class="save-btn" onclick="saveChanges()">Save Changes</button>
    </div>
    
    <div class="container">
        <nav class="nav-box">
            <div class="logo-box editable" id="logo-box" onclick="makeEditable(this)">
                <?php if($logo): ?>
                    <img src="<?= htmlspecialchars($logo) ?>" style="max-height: 50px; max-width: 100%;" alt="Logo">
                <?php else: ?>
                    LOGO
                <?php endif; ?>
            </div>

            <ul class="navbar">
                <?php foreach($navLinks as $link): ?>
                    <li><a href="<?= htmlspecialchars($link['url']) ?>" class="editable-link">
                        <?= htmlspecialchars($link['text']) ?>
                        <button class="link-edit-btn" onclick="editLink(this)">Edit Link</button>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        
        <div class="content-box">
            <?php foreach($articles as $article): ?>
                <div class="article">
                    <h2 class="editable" onclick="makeEditable(this)"><?= htmlspecialchars($article['title']) ?></h2>
                    <div class="text-and-image">
                        <p class="editable" onclick="makeEditable(this)"><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                        <div class="image-placeholder">
                            <img src="<?= htmlspecialchars($article['image_url']) ?>">
                            <button class="image-upload-btn" onclick="editImage(this)">Change Image</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="footer">
            <div class="footer-info">
                <h2 class="editable" id="company-name" onclick="makeEditable(this)"><?= htmlspecialchars($companyName) ?></h2>
                <p class="editable" id="company-description" onclick="makeEditable(this)"><?= nl2br(htmlspecialchars($description)) ?></p>
                <p class="editable" id="company-copyright" onclick="makeEditable(this)"><?= htmlspecialchars($copyright) ?></p>
            </div>
            
            <div class="footer-links">
                <?php foreach($footerLinks as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" class="editable-link">
                        <?= htmlspecialchars($link['text']) ?>
                        <button class="link-edit-btn" onclick="editLink(this)">Edit Link</button>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <div class="footer-social">
                <?php foreach($socialLinks as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" class="editable-link">
                        <?= htmlspecialchars($link['text']) ?>
                        <button class="link-edit-btn" onclick="editLink(this)">Edit Link</button>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Image editing modal -->
    <div class="image-edit-modal">
        <div class="modal-content">
            <h3>Change Image</h3>
            <input type="text" id="image-url-input" placeholder="Enter image URL">
            <div class="modal-buttons">
                <button class="cancel-btn" onclick="closeImageModal()">Cancel</button>
                <button class="apply-btn" onclick="applyImageChange()">Apply</button>
            </div>
        </div>
    </div>
    
    <!-- Link editing modal -->
    <div class="image-edit-modal" id="link-edit-modal">
        <div class="modal-content">
            <h3>Edit Link</h3>
            <input type="text" id="link-text-input" placeholder="Link Text">
            <input type="text" id="link-url-input" placeholder="Link URL">
            <div class="modal-buttons">
                <button class="cancel-btn" onclick="closeLinkModal()">Cancel</button>
                <button class="apply-btn" onclick="applyLinkChange()">Apply</button>
            </div>
        </div>
    </div>
    
    <!-- Logo upload modal -->
    <div class="image-edit-modal" id="logo-upload-modal">
        <div class="modal-content">
            <h3>Upload Logo</h3>
            <form id="logo-upload-form" enctype="multipart/form-data">
                <input type="file" id="logo-file-input" name="logo" accept="image/*">
                <div class="modal-buttons">
                    <button type="button" class="cancel-btn" onclick="closeLogoModal()">Cancel</button>
                    <button type="button" class="apply-btn" onclick="uploadLogo()">Upload</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Load all page data from server when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // No need to load data as we're fetching it directly in PHP
        });
        
        function makeEditable(element) {
            element.contentEditable = true;
            element.focus();
            
            // Special handling for logo
            if (element.id === 'logo-box') {
                openLogoModal();
                return;
            }
            
            element.onblur = function() {
                element.contentEditable = false;
            };
            
            element.onkeydown = function(e) {
                if (e.key === "Enter" && !e.shiftKey) {
                    e.preventDefault();
                    element.blur();
                }
            };
        }
        
        // Enhanced saveChanges function to save all content to database
        function saveChanges() {
            // Collect footer data
            const footerData = {
                companyName: document.getElementById('company-name').textContent,
                description: document.getElementById('company-description').textContent,
                copyright: document.getElementById('company-copyright').textContent
            };
            // Collect navigation links
            const navLinks = Array.from(document.querySelectorAll('.navbar .editable-link')).map(link => ({
                text: link.textContent.replace('Edit Link', '').trim(),
                url: link.href,
                type: 'nav'
            }));
            // Collect footer links
            const footerLinks = Array.from(document.querySelectorAll('.footer-links .editable-link')).map(link => ({
                text: link.textContent.replace('Edit Link', '').trim(),
                url: link.href,
                type: 'footer'
            }));
            // Collect social links
            const socialLinks = Array.from(document.querySelectorAll('.footer-social .editable-link')).map(link => ({
                text: link.textContent.replace('Edit Link', '').trim(),
                url: link.href,
                type: 'social'
            }));
            // Collect articles data
            const articles = Array.from(document.querySelectorAll('.article')).map((article, index) => {
                const title = article.querySelector('h2.editable').textContent;
                const content = article.querySelector('p.editable').textContent;
                const imageUrl = article.querySelector('.image-placeholder img').src;
                return { 
                    title, 
                    content, 
                    image_url: imageUrl,
                    name: `article_${index + 1}`
                };
            });
            // Get logo path
            const logoBox = document.getElementById('logo-box');
            const logoPath = logoBox.querySelector('img') ? logoBox.querySelector('img').src : '';
            // Combine all data
            const allData = {
                sections: [
                    { name: 'company_name', content: footerData.companyName },
                    { name: 'company_description', content: footerData.description },
                    { name: 'company_copyright', content: footerData.copyright },
                    { name: 'logo', content: logoPath }
                ],
                links: [...navLinks, ...footerLinks, ...socialLinks],
                articles: articles
            };
            
            // Send to server
            fetch('save_cms_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(allData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('All changes saved:', data);
                alert('All changes saved successfully!');
            })
            .catch(error => {
                console.error('Error saving data:', error);
                alert('Error saving changes. Please try again.');
            });
        }
        
        // Open logo upload modal
        function openLogoModal() {
            document.getElementById('logo-upload-modal').style.display = 'flex';
        }
        
        // Close logo upload modal
        function closeLogoModal() {
            document.getElementById('logo-upload-modal').style.display = 'none';
        }
        
        // Upload logo image
        function uploadLogo() {
            const fileInput = document.getElementById('logo-file-input');
            if (!fileInput.files.length) {
                alert('Please select a file first.');
                return;
            }
            
            const formData = new FormData();
            formData.append('logo', fileInput.files[0]);
            
            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update logo box with the new image
                    const logoBox = document.getElementById('logo-box');
                    logoBox.innerHTML = `<img src="${data.filePath}" style="max-height: 50px; max-width: 100%;" alt="Logo">`;
                    alert('Logo uploaded successfully!');
                } else {
                    alert(`Error: ${data.message}`);
                }
                closeLogoModal();
            })
            .catch(error => {
                console.error('Error uploading logo:', error);
                alert('Error uploading logo. Please try again.');
                closeLogoModal();
            });
        }
        
        let currentImageElement = null;
        
        function editImage(button) {
            currentImageElement = button.parentElement.querySelector('img');
            document.getElementById('image-url-input').value = currentImageElement.src;
            document.querySelector('.image-edit-modal').style.display = 'flex';
        }
        
        function closeImageModal() {
            document.querySelector('.image-edit-modal').style.display = 'none';
        }
        
        function applyImageChange() {
            if (currentImageElement) {
                const newUrl = document.getElementById('image-url-input').value;
                if (newUrl.trim() !== '') {
                    currentImageElement.src = newUrl;
                }
            }
            closeImageModal();
        }
        
        let currentLinkElement = null;
        
        function editLink(button) {
            event.preventDefault();
            event.stopPropagation();
            
            currentLinkElement = button.parentElement;
            document.getElementById('link-text-input').value = currentLinkElement.textContent.replace('Edit Link', '').trim();
            document.getElementById('link-url-input').value = currentLinkElement.href;
            document.getElementById('link-edit-modal').style.display = 'flex';
        }
        
        function closeLinkModal() {
            document.getElementById('link-edit-modal').style.display = 'none';
        }
        
        function applyLinkChange() {
            if (currentLinkElement) {
                const newText = document.getElementById('link-text-input').value;
                const newUrl = document.getElementById('link-url-input').value;
                
                if (newText.trim() !== '') {
                    const button = currentLinkElement.querySelector('.link-edit-btn');
                    currentLinkElement.textContent = newText;
                    currentLinkElement.appendChild(button);
                }
                
                if (newUrl.trim() !== '') {
                    currentLinkElement.href = newUrl;
                }
            }
            closeLinkModal();
        }
        
        window.onclick = function(event) {
            const imageModal = document.querySelector('.image-edit-modal');
            const linkModal = document.getElementById('link-edit-modal');
            const logoModal = document.getElementById('logo-upload-modal');
            
            if (event.target === imageModal) {
                closeImageModal();
            }
            
            if (event.target === linkModal) {
                closeLinkModal();
            }
            
            if (event.target === logoModal) {
                closeLogoModal();
            }
        };
    </script>
</body>
</html>