<?php
// This file replaces the existing index.html
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
            <div class="logo-box editable" id="logo-box" onclick="makeEditable(this)">LOGO</div>

            <ul class="navbar">
                <li><a href="#" class="editable-link">Home<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a></li>
                <li><a href="#" class="editable-link">About<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a></li>
                <li><a href="#" class="editable-link">Blog<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a></li>
            </ul>
        </nav>
        
        <div class="content-box">
            <div class="article">
                <h2 class="editable" onclick="makeEditable(this)">A title for your first article</h2>
                <div class="text-and-image">
                    <p class="editable" onclick="makeEditable(this)">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                    <div class="image-placeholder">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFUuOtK7W_UNjvXDx3Z9tCD14xTfWPFs3Wbw&s">
                        <button class="image-upload-btn" onclick="editImage(this)">Change Image</button>
                    </div>
                </div>
            </div>
            
            <div class="article">
                <h2 class="editable" onclick="makeEditable(this)">A title for your first article</h2>
                <div class="text-and-image">
                    <p class="editable" onclick="makeEditable(this)">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                    <div class="image-placeholder">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFUuOtK7W_UNjvXDx3Z9tCD14xTfWPFs3Wbw&s">
                        <button class="image-upload-btn" onclick="editImage(this)">Change Image</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-info">
                <h2 class="editable" id="company-name" onclick="makeEditable(this)">Your company's name</h2>
                <p class="editable" id="company-description" onclick="makeEditable(this)">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <p class="editable" id="company-copyright" onclick="makeEditable(this)">© 2024, Company's name, All rights reserved.</p>
            </div>
            
            <div class="footer-links">
                <a href="#" class="editable-link">Home<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
                <a href="#" class="editable-link">About<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
                <a href="#" class="editable-link">Blog<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
            </div>
            
            <div class="footer-social">
                <a href="#" class="editable-link">Facebook<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
                <a href="#" class="editable-link">LinkedIn<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
                <a href="#" class="editable-link">GitHub<button class="link-edit-btn" onclick="editLink(this)">Edit Link</button></a>
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
            loadAllPageData();
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
        
        // Load all page data from server
        function loadAllPageData() {
            fetch('footer_api.php')
                .then(response => response.json())
                .then(data => {
                    // Load footer data
                    if (data.companyName) document.getElementById('company-name').textContent = data.companyName;
                    if (data.description) document.getElementById('company-description').textContent = data.description;
                    if (data.copyright) document.getElementById('company-copyright').textContent = data.copyright;
                    
                    // Load navigation links
                    if (data.navLinks && data.navLinks.length > 0) {
                        const navLinks = document.querySelectorAll('.navbar .editable-link');
                        data.navLinks.forEach((link, index) => {
                            if (index < navLinks.length) {
                                const linkElement = navLinks[index];
                                const button = linkElement.querySelector('.link-edit-btn');
                                linkElement.textContent = link.text;
                                linkElement.href = link.url;
                                if (button) linkElement.appendChild(button);
                            }
                        });
                    }
                    
                    // Load footer links
                    if (data.footerLinks && data.footerLinks.length > 0) {
                        const footerLinks = document.querySelectorAll('.footer-links .editable-link');
                        data.footerLinks.forEach((link, index) => {
                            if (index < footerLinks.length) {
                                const linkElement = footerLinks[index];
                                const button = linkElement.querySelector('.link-edit-btn');
                                linkElement.textContent = link.text;
                                linkElement.href = link.url;
                                if (button) linkElement.appendChild(button);
                            }
                        });
                    }
                    
                    // Load social links
                    if (data.socialLinks && data.socialLinks.length > 0) {
                        const socialLinks = document.querySelectorAll('.footer-social .editable-link');
                        data.socialLinks.forEach((link, index) => {
                            if (index < socialLinks.length) {
                                const linkElement = socialLinks[index];
                                const button = linkElement.querySelector('.link-edit-btn');
                                linkElement.textContent = link.text;
                                linkElement.href = link.url;
                                if (button) linkElement.appendChild(button);
                            }
                        });
                    }
                    
                    // Load articles
                    if (data.articles && data.articles.length > 0) {
                        const articles = document.querySelectorAll('.article');
                        data.articles.forEach((article, index) => {
                            if (index < articles.length) {
                                const articleElement = articles[index];
                                if (article.title) articleElement.querySelector('h2.editable').textContent = article.title;
                                if (article.content) articleElement.querySelector('p.editable').textContent = article.content;
                                if (article.imageUrl) articleElement.querySelector('.image-placeholder img').src = article.imageUrl;
                            }
                        });
                    }
                    
                    // Load logo
                    if (data.logoPath && data.logoPath.length > 0) {
                        const logoBox = document.getElementById('logo-box');
                        logoBox.innerHTML = `<img src="${data.logoPath}" style="max-height: 50px; max-width: 100%;" alt="Logo">`;
                    }
                })
                .catch(error => {
                    console.error('Error loading page data:', error);
                });
        }
        
        // Enhanced saveChanges function to save all content
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
                url: link.href
            }));
            // Collect footer links
            const footerLinks = Array.from(document.querySelectorAll('.footer-links .editable-link')).map(link => ({
                text: link.textContent.replace('Edit Link', '').trim(),
                url: link.href
            }));
            // Collect social links
            const socialLinks = Array.from(document.querySelectorAll('.footer-social .editable-link')).map(link => ({
                text: link.textContent.replace('Edit Link', '').trim(),
                url: link.href
            }));
            // Collect articles data
            const articles = Array.from(document.querySelectorAll('.article')).map(article => {
                const title = article.querySelector('h2.editable').textContent;
                const content = article.querySelector('p.editable').textContent;
                const imageUrl = article.querySelector('.image-placeholder img').src;
                return { title, content, imageUrl };
            });
            // Get logo path
            const logoBox = document.getElementById('logo-box');
            const logoPath = logoBox.querySelector('img') ? logoBox.querySelector('img').src : '';
            // Combine all data
            const allData = {
                ...footerData,
                navLinks,
                footerLinks,
                socialLinks,
                articles,
                logoPath
            };
            // Send to server
            fetch('footer_api.php', {
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