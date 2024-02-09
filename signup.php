<?php
$errorMessage = '';

include('db.php'); // Include db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $security_question = $_POST['security_question'];
    $answer = $_POST['answer'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    if (checkIfUsernameExists($username, $conn)) {
        $errorMessage = "Username already exists. Please choose a different one.";
    } else {
        // Perform the registration if the username is unique
        if (registerUser($username, $security_question, $answer, $password, $conn)) {
            // Redirect to login.php after successful registration
            header("Location: login.php");
            exit();
        } else {
            $errorMessage = "Error occurred during registration.";
        }
    }
}

function checkIfUsernameExists($username, $conn)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->num_rows > 0;
}

function registerUser($username, $security_question, $answer, $password, $conn)
{
    $stmt = $conn->prepare("INSERT INTO users (username, security_question, answer, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $security_question, $answer, $password);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function generateSecurityQuestion()
{
    $questions = array("What is your favorite color?", "Who was your favorite teacher?", "In which town were you born?");
    $randomIndex = array_rand($questions);
    return $questions[$randomIndex];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './include/cdn.php' ?>
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <div class="signup_all">
        <div class="signup_forms">
            <div class="title">
                <h2>HoSystem - Sign Up</h2>
            </div>
            <form method="post" action="signup.php">
                <?php if (!empty($errorMessage)) : ?>
                    <div id="error-message" class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <div class="forms">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="formss">
                    <input type="text" name="security_question" value="<?php echo generateSecurityQuestion(); ?>" readonly>
                </div>
                <div class="forms">
                    <label name="security_question" value="<?php echo generateSecurityQuestion(); ?>" readonly></label>
                    <input type="text" placeholder="Answer the question" name="answer" required>
                </div>
                <div class="forms">
                    <label>Password</label>
                    <input type="password" placeholder="Enter your password" name="password" required>
                </div>
                <div class="forms">
                    <button type="submit">Sign Up</button>
                </div>
                <div class="forms">
                    <a href="login.php">Already have an account? <span>Login</span></a>
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
</body>

</html>

