
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Velammal Library Management System</title>
    <link rel="stylesheet" href="css/loginsec.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header>
        <h1>Velammal Library Management System</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#" onclick="toggleLoginForm()"><i class="fa fa-fw fa-user"></i>Login</a></li>
        </ul>
    </nav>
    <?php
    $passerr = $stafferr = "";
    $pass = $staffid = $suberr = "";

    function inputdata($data) {
        return stripslashes(htmlspecialchars(trim($data)));
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['staffid'])) {
            $stafferr = "Staff ID is required";
        } else {
            $staffid = inputdata($_POST['staffid']);
        }

        if (empty($_POST['password'])) {
            $passerr = "Password is required";
        } else {
            $pass = inputdata($_POST['password']);
        }

        if (empty($passerr) && empty($stafferr)) {
            include('dbcon.php');
            $sql = "SELECT * FROM authentication_system WHERE staff_ID= ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $staffid, $pass);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                header("Location: details.php");
                exit();
            } else {
                $suberr = "*ID or password is wrong";
            }
        }
    }
    ?>
    <div class="login-box" style="display: none;">
        <button class="btn-close" onclick="closeLoginForm()">&times;</button>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h2>Staff Login</h2>
            <table>
                <tr>
                    <td><label for="staff">Enter Staff ID: </label></td>
                    <td><input type="number" id="staff" name="staffid" placeholder="Staff ID" required></td>
                    <td><span><?php echo $stafferr; ?></span></td>
                </tr>
                <tr>
                    <td><label for="patpass">Enter Password: </label></td>
                    <td><input type="password" id="patpass" name="password" placeholder="Password" required></td>
                    <td><span><?php echo $passerr; ?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span style="color:red"><?php echo $suberr; ?></span></td>
                </tr>
            </table>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
    <main>
        <section id="welcome-section">
            <div class="contentimg">
                <div>
                    <h2>Welcome to the Velammal Library Management System!</h2>
                    <p>At Velammal, we understand the pivotal role libraries play in nurturing a culture of learning and intellectual curiosity. With a rich collection of resources spanning various disciplines, our library serves as a gateway to knowledge for students, faculty, and researchers alike.</p>

                    <p>Our Library Management System is designed to streamline the process of accessing and managing library resources, making it easier for our patrons to explore, discover, and engage with the wealth of information available to them. From traditional print materials to digital resources and multimedia content, our system ensures that users can conveniently access a diverse range of materials to support their academic and research endeavors.</p>

                    <ul>
                        <li>Working Days: 8.00 AM to 6.00 PM</li>
                        <li>All Holidays: 8.00 AM to 5.00 PM (Except Govt. Holidays)</li>
                        <li>Vacation Period: 8:00 AM to 5:00 PM</li>
                    </ul>
                </div>
                <div>
                    <img src="photos/humanlib.png" alt="Library Image">
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Velammal Library Management Sytem. All rights reserved.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var showError = <?php echo !empty($suberr) ? 'true' : 'false'; ?>;
            if (showError) {
                $('.login-box').show();
            }
        });
        function toggleLoginForm() {
            var loginBox = document.querySelector('.login-box');
            loginBox.style.display = 'block';
        }

        function closeLoginForm() {
            $('.login-box').hide();
            var form = document.querySelector('.login-box form');
            if (form) {
                form.reset();
            }
        }
    </script>
</body>
</html>
