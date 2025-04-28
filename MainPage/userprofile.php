<?php
include("profile_backend.php");
if (!isset($_SESSION['email'])) {
    // Redirect to login if not logged in
    header("Location: MainPage/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background-image: url();
        background-repeat: no-repeat;
        background-size: cover;
        font-family: "Roboto", sans-serif;
    }

    .shadow {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .profile-tab-nav {
        min-width: 250px;
    }

    .tab-content {
        flex: 1;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .nav-pills a.nav-link {
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
        border-radius: 0;
        color: #333;
    }

    .nav-pills a.nav-link i {
        width: 20px;
    }

    .img-circle img {
        height: 100px;
        width: 100px;
        border-radius: 100%;
        border: 5px solid #fff;
    }
</style>

<body>
    <section class="py-4 my-4">
        <div class="container">
            <h1 class="mb-5">Account Setting</h1>
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="profile-tab-naw border-right">
                    <div class="p-4">
                        <div class="img-circle text-center mb-3">
                            <img src="User_Img/default.png" alt="Image" class="shadow">
                        </div>
                        <h4 class="text-center"> </h4> <!-- Full Name -->

                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                            <i class="fa fa-home text-center mr-1"></i>
                            Account
                        </a>
                        <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                            <i class="fa fa-key text-center mr-1"></i>
                            Password
                        </a>
                        <!-- <a class="nav-link" id="wish-tab" data-toggle="pill" href="#wish" role="tab" aria-controls="wish" aria-selected="false">
                            <i class="fa fa-user text-center mr-1"></i>
                            Wishlist
                        </a> -->
                        <script>
                            function confirmLogout() {
                                // Create a custom confirmation box
                                const isConfirmed = window.confirm("Are you sure?");

                                if (isConfirmed) {
                                    // If "OK" is clicked, perform logout and redirect
                                    window.location.href = "?logout=true";
                                } else {
                                    // If "Cancel" is clicked, stay on the same page (reload or show run page)
                                    console.log("Logout canceled.");
                                }
                            }
                            document.querySelector('form').addEventListener('submit', function(e) {
                                e.preventDefault();

                                const formData = new FormData(this);
                                formData.append('update_profile', '1');

                                fetch('profile_backend.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.json()) // Changed to parse JSON response
                                    .then(data => {
                                        alert(data.message);
                                        if (data.status === 'success') {
                                            const firstname = formData.get('firstname');
                                            const lastname = formData.get('lastname');
                                            const fullName = `${firstname} ${lastname}`;
                                            document.querySelector('.user-profile span').textContent = fullName;
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Error updating profile');
                                    });
                            });
                        </script>
                        <a class="nav-link" button onclick="confirmLogout()">Logout</button></a>
                                        <a class="nav-link" href="home.php">
                                            <i class="fa fa-home text-center mr-1"></i>
                                            Back to Home
                                        </a>
                                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="account" role="tabpannel" aria-labelledby="account-tab">
                        <h3 class="mb-4">Profile</h3>
                        <form id="updateProfileForm" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" requierd>
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input type="text" class="form-control" name="profile_image" value="<?php echo $user['profile_image']; ?>">
                                    </div>
                                </div> -->
                            </div>
                            <div>
                                <button type="submit" class="btn btn-light" name="update_profile">Update</button>
                                <button class="btn btn-light" name="cancle">Cancel</button>
                            </div>

                    </div>
                    </form>
                    <div class="tab-pane fade" id="password" role="tabpannel" aria-labelledby="password-tab">
                        <form action="profile_backend.php" method="POST">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary" name="update_password">Update Password </button>
                                <button class="btn btn-light" name="pw_cancle">Cancel</button>
                            </div>
                    </div>

                    <div class="tab-pane fade" id="wish" role="tabpannel" aria-labelledby="wish-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Info</label>
                                    <textarea class="form-control" rows="4">starcity
                    </textarea>
                                </div>
                            </div>

                        </div>
                        <div>
                            <button class="btn btn-primary">Update</button>
                            <button class="btn btn-light">Cancel</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="logout" role="tabpannel" aria-labelledby="logout-tab">
                        <div class="row">

                        </div>

                        <!-- <div>
<button class="btn btn-primary">logout</button>
</div> -->
                    </div>
                    <script>
                        document.getElementById("updateProfileForm").addEventListener("submit", function(event) {
                            event.preventDefault();

                            let formData = new FormData(this);
                            formData.append('update_profile', '1');

                            fetch("profile_backend.php", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                    if (data.status === "success") {
                                        location.reload();
                                    }
                                })
                                .catch(error => console.error("Error:", error));
                        });
                    </script>

                </div>
            </div>
           

            </div>
        </div>
        </div>
        </div>
    </section>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>