<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text-shadow: .3rem .3rem 0 rgba(0, 0, 0, .2);
            --black: #000;
            --blue: #42586e;
            --light-color: rgb(145, 156, 163);
        }

        * {
            font-family: Nunito;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-transform: capitalize;
        }

        html {
            font-size: 62.5%;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scroll-padding-top: 7rem;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--black);
            line-height: 1.8;
            text-shadow: var(--text-shadow);
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            font-size: 2em;
            margin-bottom: 10px;
            text-align: left;
        }

        p {
            text-align: center;
            font-size: 2em;
            color: #666;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #222222;
            height: 15%;
            padding: 10px 40px;
        }

        .header .logo {
            font-size: 2.5rem;
            color: #E67E22;
            /* color:#FFA500; */
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .header .logo i {
            color: var(--blue);
            margin-right: .5rem;
        }

        .header .navbar {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .header .navbar a {
            font-size: 1.7rem;
            color: var(--light-color);
            margin-left: 2rem;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #FFA500;
            border-bottom: .2rem solid #FFA500;
        }

        /* Add Properties Button */
        .add-properties {
            padding: 5px 15px;
            background-color: darkorange;
            color: white !important;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Toggler Icon (Mobile) */
        .menu-toggle {
            color: white;
            display: none;
            cursor: pointer;
            font-size: 24px;
        }

        /* Responsive Navbar */
        @media screen and (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .navbar {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background: #222222;
                padding: 10px 0;
                text-align: center;
                transition: all 0.3s ease-in-out;
            }

            .navbar.active {
                display: flex;
            }

            .navbar a {
                padding: 10px;
                display: block;
            }
        }
    </style>
    <script>
        function toggleAdvanced() {
            const advancedContent = document.querySelector('.advanced-content');
            advancedContent.classList.toggle('active');
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Select all wish buttons
            const wishButtons = document.querySelectorAll('.wish');

            wishButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const icon = button.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                });
            });
        });
    </script>
</head>

<body>
    <!--Header Section Starts-->
    <header class="header">
        <a href="home.php" class="logo"><i class="fas fa-door-open"></i>&nbsp;NextDoor</a>

        <!-- Navbar Toggler Icon -->
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>

        <nav class="navbar" id="navbar">
            <a href="home.php">Home</a>
            <a href="properties.php">All Properties</a>
            <a href="aboutus.php">About Us</a>
            <a href="contactus.php">Contact Us</a>

            <!-- In the navbar section, add this line after the wishlist link -->
            <?php
            if (isset($_SESSION['email'])) {
                $userEmail = $_SESSION['email']; // Get logged-in user email
                $userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
            
                echo '<a href="wishlist.php">Wishlist</a>';
                echo '<a href="myproperties.php">My Properties</a>'; // Add this line
                echo '<a href="addproperties.php" class="add-properties">+ Add Properties</a>';
                echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>';
            
                // Check if the logged-in user is the admin
                if ($userEmail == "nextdoor101r@gmail.com") {
                    echo '<a href="/Real%20Estate/panel/admin/" class="user-profile" style="text-decoration:none"><i class="fas fa-user"></i> <span>' . $userName . '</span></a>';
                } else {
                    echo '<a href="userprofile.php" class="user-profile"><i class="fas fa-user"></i> <span>' . $userName . '</span></a>';
                }
            } else {
                echo '<a href="login.php">Login</a>';
                echo '<a href="wishlist.php">Wishlist</a>';
                echo '<a href="login.php" class="add-properties">+ Add Properties</a>';
            }
            ?>
        </nav>
    </header>
    <!-- Responsive Navbar Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuToggle = document.getElementById("menuToggle");
            const navbar = document.getElementById("navbar");

            menuToggle.addEventListener("click", function() {
                navbar.classList.toggle("active");
            });
        });
    </script>
    <!--Header Section Ends-->
</body>

</html>