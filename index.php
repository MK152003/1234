<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
   .modal .modal-dialog {
      margin-top: 20vh;
    }

    nav {
      padding: 10px;
    }
    iframe{
      overflow: hidden;
    }
    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: flex-start; 
    }

    nav ul li {
      margin-right: 10px;
      justify-content: center;
    }

    nav ul li:first-child {
      margin-right: 10px;
    }

    nav ul li:last-child {
      margin-left: 10px; 
    }

    nav ul li a {
      text-decoration: none;
      padding: 5px;
      color: black;
      text-align: center;
      font-weight: bold;
    }
    
    nav ul li a:hover,
    nav ul li a:focus,
    nav ul li a:active {
      color: black;
      text-decoration: none;
    }

    .content {
      padding: 20px;
      padding-top: 70px; 
    }

    iframe {
      border: none;
      width: 100%;
      height: calc(100vh - 50px);
    }

    h1 {
      margin: 0;
      padding: 10px;
    }
  </style>
</head>
<body>
  <nav class="fixed-top">
    <ul>
      
            <div class="container-alpha">
                <div class="row">
                    <div class="col-1">
                        <image src="Logo.png" alt="Logo" id="logo" class="logo"></image>
                    </div>
                    <div class="col-5">
                        <h1>VIYAGULA SECURITY SERVICES</h1>
                        <p>15/456 NO.2, ANNAI KAMATCHI NAGAR MALAIPATTY ROAD, THOTTANATHU POST, DINDIGUL 624003, TAMIL NADU</p>
                    </div>
                </div>
                    
            </div>
      <li><a href="#" class="active">Enter Details</a></li>
      <li><a href="#">Generate Invoice</a></li>
    </li>
    </ul>
  </nav>

  <div class="content">
    <iframe src="home.php"></iframe>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
      link.addEventListener('click', function(event) {
        event.preventDefault();

        navLinks.forEach(link => link.classList.remove('active'));

        this.classList.add('active');

        if (this.textContent === 'Enter Details') {
          document.querySelector('iframe').src = 'home.php';
        } else if (this.textContent === 'Generate Invoice') {
          document.querySelector('iframe').src = 'invoice.php';
        } 
      });
    });
  </script>
</body>
</html>
