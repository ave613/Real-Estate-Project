<nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <ul class="navbar-nav">
     <li class="nav-item">
       <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
       <a href="/Real%20Estate/MainPage/home.php" class="nav-link">Home</a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
       <a href="/Real%20Estate/MainPage/contactus.php" class="nav-link">Contact</a>
     </li>
   </ul>

   <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

   <ul class="navbar-nav ml-auto">

     <li class="nav-item d-none d-sm-inline-block">
       <div class="user-panel mt-1 pb-1 mb-1 d-flex">
         <div class="image">
           <img src="assets/dist/img/eeyore.jpg" class="img-circle elevation-2" alt="User Image">
         </div>
         <?php
          include 'connect.php'; 
          $adminName = "NextDoor Admin"; // Default fallback name

          $query = "SELECT firstname, lastname FROM registered_users WHERE email = 'nextdoor101r@gmail.com' LIMIT 1";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $adminName = $row['firstname'] . ' ' . $row['lastname'];
          }
          ?>

     <li class="nav-item d-none d-sm-inline-block">
       <a href="admin.php" class="nav-link" id="adminNameLink"><?= htmlspecialchars($adminName); ?></a>
     </li>

     </div>
     </li>
   </ul>
 </nav>