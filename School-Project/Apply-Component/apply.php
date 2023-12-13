<?php
// Include or require your database connection file here
include 'config.php';

// Start the session
session_start();

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $serial = $_POST["login-serial-number"];
    $password = $_POST["login-password"];

    // Check if the user exists and the password is correct
    $login_sql = "SELECT * FROM application WHERE `serial-number` = '$serial' AND password = '$password'";
    $result = $conn->query($login_sql);
    // $id = $result->fetch_assoc();
    // $_SESSION['id'] = $id;

    if ($result->num_rows > 0) {
        // User found, store user information in a session variable
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        if($user["usertype"]=="Student"){
            header("Location: home.php");
            // exit();
        }

        elseif($user["usertype"]=="admin"){
            header("Location: admin.php");
            // exit();
        }

        // User found, redirect to the new page
    } else {
        // Invalid credentials, display an error message
        $registrationMassage = '<div class ="massage error">Invalid serial number or password!</div>';
    }

    $result->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="apply.css">
</head>

<body>
    <div class="container">
        <!-- Header Starts -->
        <header>
            <div class="logo">
                <img src="../images/Logo.jpg" alt="Logo">
                <h2>OWASS LOGIN</h2>
            </div>

            <h1>ADMISSION LOGIN</h1>
            <a href="../index.html">Main Website</a>
        </header>
        <!-- Header Ends -->
                
               
        <main>
            <div class="title">
                <span>📂</span>
                <h2>ONLINE GENERATED</h2>
            </div>
            <div class="welcome">
            <h1>Welcome To The School Admission Portal</h1>
            </div>

            <div id="login-form" class="form-group">
                <p>Provide Your Serial Number and Pin To Access The Admission Forms.</p>
                

                <!-- Login Form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php
        if (isset($registrationMassage)) {
            echo $registrationMassage;
        }
        ?>
            <input type="text" id="loginSerialNumber" name="login-serial-number" placeholder="Serial Number" required>

            <input type="password" id="loginPin" name="login-password" placeholder="Pin" required>

            <input type="submit" value="Login" name="login" id="button"> <br>
            <a href="register.php">Don't have serial number?</a>
        </form>
</div>
        </main>

        <div class="copy">
            <span>&copy; 2023 - Ohenewaa Senior High School, Berekum</span>
        </div>
    </div>
</body>

</html>
