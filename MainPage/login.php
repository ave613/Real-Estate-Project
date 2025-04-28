<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        #phoneError {
            color: red;
            font-size: 0.9rem;
            display: none;
        }


        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #ffece0);
        }

        .container {
            background: #fff;
            width: 450px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 1, 0.5);
        }

        form {
            margin: 0 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1.3rem;
            margin-bottom: 0.4rem;
        }

        input {
            color: inherit;
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #757575;
            padding-left: 1.5rem;
            font-size: 15px;
        }

        .input-group {
            padding: 1% 0;
            position: relative;
        }

        .input-group i {
            position: absolute;
            color: black;
        }

        input:focus {
            background-color: transparent;
            outline: transparent;
            border-bottom: 2px solid hsl(327, 90%, 28%);
        }

        input::placeholder {
            color: transparent;
        }

        label {
            color: #757575;
            position: relative;
            left: 1.2em;
            top: -1.3em;
            cursor: auto;
            transition: 0.3s ease all;
        }

        input:focus~label,
        input:not(:placeholder-shown)~label {
            top: -3em;
            color: hsl(327, 90%, 28%);
            font-size: 15px;
        }

        .btn {
            font-size: 1.1rem;
            padding: 8px 0;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: #e67e22;
            color: white;
            cursor: pointer;
            transition: 0.9s;
        }

        .btn:hover {
            background: orange;
        }

        .or {
            font-size: 1.1rem;
            margin-top: 0.5rem;
            text-align: center;
        }

        .links {
            display: flex;
            justify-content: space-around;
            padding: 0 4rem;
            margin-top: 0.9rem;
            font-weight: bold;
        }

        button {
            color: #3498DB;
            border: none;
            background-color: transparent;
            font-size: 1rem;
            font-weight: bold;
        }

        button:hover {
            text-decoration: underline;
            color: blue;
        }

        #passwordError {
            color: red;
            font-size: 0.9rem;
            display: none;
        }
    </style>
</head>

<body>

    <div class="container" id="signup" style="display: none;">
        <h1 class="form-title">Register</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" required maxlength="11">
                <label for="phone">Phone</label>
                <p id="phoneError" style="display: none; color: red;">Invalid phone number (must be 09 + 7-9 digits)</p>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <p id="passwordError">Passwords don't match</p>
            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <p class="or">
            ----------or--------
        </p>
        <div class="links">
            <p>Already Have an Account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="login_handler.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
            <div class="forgot-password" style="text-align: right; margin-top: 10px;">
                <a href="forgot_password.php" style="color: #3498DB; text-decoration: none;">Forgot Password?</a>
            </div>
        </form>
        <p class="or">
            ----------or--------
        </p>
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUpButton');
        const signInButton = document.getElementById('signInButton');
        const signInForm = document.getElementById('signIn');
        const signUpForm = document.getElementById('signup');

        signUpButton.addEventListener('click', function() {
            signInForm.style.display = "none";
            signUpForm.style.display = "block";
        });
        signInButton.addEventListener('click', function() {
            signInForm.style.display = "block";
            signUpForm.style.display = "none";
        });

        // Phone number validation
        document.addEventListener("DOMContentLoaded", function() {
            const phoneInput = document.getElementById("phone");
            const phoneError = document.getElementById("phoneError");


            phoneInput.addEventListener("focus", function() {
                if (!phoneInput.value.startsWith("09")) {
                    phoneInput.value = "09";
                }
                phoneError.style.display = "none";
            });

            // Ensure "09" is always at the beginning
            phoneInput.addEventListener("input", function() {
                if (!phoneInput.value.startsWith("09")) {
                    phoneInput.value = "09";
                }
                phoneInput.value = phoneInput.value.replace(/\D/g, '');

                if (phoneInput.value.length > 11) {
                    phoneInput.value = phoneInput.value.slice(0, 11);
                }
            });

            // Validate on blur (when user leaves the field)
            phoneInput.addEventListener("blur", function() {
                const length = phoneInput.value.length;
                if (length < 9 || length > 11) {
                    phoneError.style.display = "block";
                } else {
                    phoneError.style.display = "none";
                }
            });
        });

        // Password validation
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById("password");
            const confirmPasswordInput = document.getElementById("confirm_password");
            const errorText = document.getElementById("passwordError");

            function validatePassword() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    errorText.style.display = "block";
                } else {
                    errorText.style.display = "none";
                }
            }

            confirmPasswordInput.addEventListener("input", validatePassword);

            confirmPasswordInput.addEventListener("blur", validatePassword);

            confirmPasswordInput.addEventListener("focus", function() {
                errorText.style.display = "none";
            });
        });
    </script>

</body>

</html>