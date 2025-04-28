<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us </title>
  <style>
    body {
      font-family: Nunito;
      color: black;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background: url('Img/aboutus.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    background-position: center;

    }
    .about-us {
      padding: 20px;
      max-width: 800px;
      margin: auto;
      background:rgba(230, 234, 219, 0.69);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    .about-us h1 {
      color:black;
      text-align: center;
    }
    .about-us h2 {
      color:black;
      margin-top: 20px;
    }
    .about-us ul {
      list-style: none;
      padding: 0;
    }
    .about-us ul li {
      margin: 10px 0;
    }
  
    .btn {
      display: inline-block;
      background:White;
      color: black;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
      text-align: center;
    }
    .btn:hover {
      background:rgb(100, 197, 239);
    }
    @media (max-width: 600px) {
      .about-us {
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <section class="about-us">
    <h1><strong>About Us</strong></h1>
    <p>Welcome to <strong>NEXT DOOR</strong>, where dreams of homeownership and real estate success come to life.</p>
    
    <h2>Who We Are</h2>
    <p>We are a team of passionate real estate professionals dedicated to understanding your unique needs and exceeding your expectations. Whether you're buying, selling, renting, or investing, our expertise spans across residential, commercial, and luxury properties.</p>
    
    <h2>Our Mission</h2>
    <p>Our mission is to simplify the real estate journey for our clients while delivering exceptional results. We strive to build long-term relationships based on trust, transparency, and mutual success.</p>
    
    <h2>Why Choose Us?</h2>
    <ul>
      <li><strong>Local Expertise:</strong> We have in-depth knowledge of the neighborhoods, market trends, and property values in your area.</li>
      <li><strong>Tailored Service:</strong> Every client is unique, and we provide customized solutions to meet your goals.</li>
      <li><strong>Innovative Tools:</strong> We use cutting-edge technology and marketing strategies to ensure you get the best results.</li>
      <li><strong>Committed to You:</strong> Your satisfaction is our top priority, and we work tirelessly to turn your vision into reality.</li>
    </ul>
    
    <h2>Let’s Connect</h2>
    <p>Whether you're a first-time buyer, a seasoned investor, or looking for your dream home, we’re here to guide you every step of the way. Explore our listings, schedule a consultation, or contact today to start your real estate journey!</p>
    <a href="contactus.php" class="btn">Contact Us</a>
    <a href="home.php"  class ="btn btn=danger back-btn">Home</a>
  </section>
</body>
</html>