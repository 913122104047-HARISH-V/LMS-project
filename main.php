<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velammal Library Management System</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
     body {
    background-image: url("photos/bg.jpg");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
   }
    </style>
</head>

<body>
    <header>
        <h1>Velammal Library Management System</h1>
    </header>

<nav>
    <ul>
         <li><a href="details.php">Dash board</a></li>
        <li><a href='display_books.php'>Books</a></li>
        <li><a href='display_publisher.php'>Publishers</a></li>
        <li><a href='display_readers.php'>Readers</a></li>
        <li>
        <div class="dropdown">
           <button class="dropbtn">Transactions <i class="fa fa-caret-down"></i> </button>
              <div class="dropdown-content">
               <a href="borrow.php">Lending</a>
               <a href="fineborrphpow.">Fines for Book Delay</a>
               <a href="dis_borrowed_books.php">View Returned Books</a>
             </div>
         </div>
        </li>
        <li><a href='display_lib_staffs.php'>Library Staffs</a></li>
        <li><a href="logout.php"> <i class="fas fa-sign-out-alt"></i>Logout</a></li>  
    </ul>
</nav>

<script src="js/display.js"></script>
</body>



