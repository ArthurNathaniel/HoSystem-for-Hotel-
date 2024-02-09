<?php
session_start();

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set the session variable
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $errorMessage = "Invalid password!";
        }
    } else {
        $errorMessage = "User not found!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include './include/cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>

    <div class="signup_all">
        <div class="signup_forms">
            <div class="title">
                <h2>HoSystem - Login</h2>
            </div>
            <form method="post" action="login.php">
                <?php if (!empty($errorMessage)) : ?>
                    <div id="error-message" class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <div class="forms">
                    <label>Username: </label>
                    <input type="text" placeholder="Enter your username" name="username" required>
                </div>
                <div class="forms">
                    <label>Password: </label>
                    <input type="password" placeholder="Enter your password" name="password" required>
                </div>
                <div class="forms">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
        <div class="signup_swiper">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">Slide 1</div>
                    <div class="swiper-slide">Slide 2</div>
                    <div class="swiper-slide">Slide 3</div>
                    <div class="swiper-slide">Slide 4</div>
                    <div class="swiper-slide">Slide 5</div>
                    <div class="swiper-slide">Slide 6</div>
                    <div class="swiper-slide">Slide 7</div>
                    <div class="swiper-slide">Slide 8</div>
                    <div class="swiper-slide">Slide 9</div>
                </div>
                <div class="box-swipper">
                    <button class="fa-solid fa-arrow-left next "></button>
                    <button class="fa-solid fa-arrow-right prev "></button>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/signup.js"></script>

</html>



<style>
    .signup_all {
        height: 100vh;
    }
</style>