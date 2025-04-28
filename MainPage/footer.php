<style>
    .text {
        font-size: medium;
        text-align: left;
        text-transform: none;
        color: whitesmoke;
    }

    .h {
        color: #e67e22;
    }

    footer {
        background: #222;
        color: #fff;
        padding: 40px 20px;
    }

    ul a:hover {
        text-decoration: underline;
    }

    .footer-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        text-align: left;
    }

    .footer-section {
        flex: 1 1 250px;
        margin-bottom: 20px;
    }

    .footer-section h3 {
        margin-bottom: 15px;
    }

    .footer-section p,
    .footer-section ul {
        margin: 0;
        padding: 0;
        line-height: 1.8;
    }

    .footer-section a {
        color: #fff;
        text-decoration: none;
    }

    .footer-section ul {
        list-style: none;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .logo {
        font-size: 24px;
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: left;
    }

    .logo i {
        margin-right: 8px;
    }
</style>

<footer>
    <div class="footer-container">
        <!-- Follow Us -->
        <div class="footer-section">
            <h3 class="h">Follow Us</h3><br>
            <p class="text"><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></p>
            <p class="text"><a href="#"><i class="fab fa-instagram"></i> Instagram</a></p>
            <p class="text"><a href="#"><i class="fab fa-x-twitter"></i> X</a></p>
            <p class="text"><a href="#"><i class="fab fa-telegram-plane"></i> Telegram</a></p>
        </div>
        <!-- Quick Links -->
        <div class="footer-section">
            <h3 class="h">Quick Links</h3><br>
            <ul>
                <li class="text"><a href="properties.php">Properties</a></li>
                <li class="text"><a href="contactus.php">Contact</a></li>
                <li class="text"><a href="aboutus.php">About</a></li>
                <li class="text"><a href="wishlist.php">Wishlist</a></li>
            </ul>
        </div>
        <!-- Contact Info -->
        <div class="footer-section">
            <h3 class="h">Contact Info</h3><br>
            <p class="text"><i class="fas fa-phone"></i> +959-697922356</p>
            <p class="text"><i class="fa-brands fa-viber"></i> +959-880223456</p>
            <p class="text"><i class="fas fa-envelope"></i> nextdoor101r@gmail.com</p>
            <p class="text"><i class="fas fa-map-marker-alt"></i> Yangon, Myanmar</p>
        </div>
        <!-- Logo and Tagline -->
        <div class="footer-section">
            <a href="home.php" class="logo" style="color:#e67e22"><i class="fas fa-door-open"></i> <strong>&nbsp;NextDoor</strong></a>
            <br>
            <p class="text">Your Trusted Partner In</p>
            <p class="text">Finding Perfect Homes</p>
        </div>
    </div>
</footer>

<!-- FontAwesome for Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>