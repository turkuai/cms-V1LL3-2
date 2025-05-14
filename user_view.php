<?php
// This file is the user-facing view (non-admin)
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
    </style>
</head>
<body>
    <div class="container">
        <nav class="nav-box">
            <div class="logo-box" id="logo-box"></div>
            <ul class="navbar">
                <!-- Navigation links loaded dynamically -->
            </ul>
        </nav>
        
        <div class="content-box">
            <!-- Articles loaded dynamically -->
        </div>
        
        <div class="footer">
            <div class="footer-info">
                <h2 id="company-name"></h2>
                <p id="company-description"></p>
                <p id="company-copyright"></p>
            </div>
            
            <div class="footer-links">
                <!-- Footer links loaded dynamically -->
            </div>
            
            <div class="footer-social">
                <!-- Social links loaded dynamically -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadSiteData();
        });

        function loadSiteData() {
            fetch('footer_api.php')
                .then(response => response.json())
                .then(data => {
                    // Load company info
                    document.getElementById('company-name').textContent = data.companyName;
                    document.getElementById('company-description').textContent = data.description;
                    document.getElementById('company-copyright').textContent = data.copyright;

                    // Load logo
                    const logoBox = document.getElementById('logo-box');
                    if (data.logoPath) {
                        logoBox.innerHTML = `<img src="${data.logoPath}" style="max-height: 50px; max-width: 100%;" alt="Logo">`;
                    } else {
                        logoBox.textContent = 'LOGO';
                    }

                    // Load navigation
                    const navContainer = document.querySelector('.navbar');
                    navContainer.innerHTML = data.navLinks.map(link => `
                        <li><a href="${link.url}">${link.text}</a></li>
                    `).join('');

                    // Load articles
                    const contentBox = document.querySelector('.content-box');
                    contentBox.innerHTML = data.articles.map(article => `
                        <div class="article">
                            <h2>${article.title}</h2>
                            <div class="text-and-image">
                                <p>${article.content}</p>
                                <div class="image-placeholder">
                                    <img src="${article.imageUrl}">
                                </div>
                            </div>
                        </div>
                    `).join('');

                    // Load footer links
                    document.querySelector('.footer-links').innerHTML = data.footerLinks.map(link => `
                        <a href="${link.url}">${link.text}</a>
                    `).join('');

                    // Load social links
                    document.querySelector('.footer-social').innerHTML = data.socialLinks.map(link => `
                        <a href="${link.url}">${link.text}</a>
                    `).join('');
                })
                .catch(error => {
                    console.error('Error loading site data:', error);
                });
        }
    </script>
</body>