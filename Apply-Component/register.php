<?php
include 'config.php';
session_start();

function generateSerialNumber() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $serialNumber = '';

    for ($i = 0; $i < 6; $i++) {
        $serialNumber .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $serialNumber;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    $check_user_sql = "SELECT * FROM application WHERE `name` = '$name' AND `password` = '$password'";
    $result = $conn->query($check_user_sql);

    if ($result->num_rows > 0) {
        $registrationMassage = '<div class ="massage error">Your password is not safe, Choose another!</div>';
    } else {
        $_SESSION['registration_data'] = ['name' => $name, 'password' => $password];
        header("Location: payment.php");
        exit();
    }

    $result->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="apply.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="../images/Logo.jpg" alt="Logo">
                <h2>OWASS APPLY</h2>
            </div>
            <h1>SERIAL NUMBER PURCHASE</h1>
            <a href="../index.html">Main Website</a>
        </header>

        <div id="login-form" class="form-group">
            <h2>How To Apply</h2>
            <label for="dis">Option 1</label>
            <li id="dis"><p>Enter your <span>Full name</span> as appears on your BECE results and choose a <span>Pin</span></p></li>

            <label for="dis">Option 2</label>
            <li id="dis"><p>NB<span> After Purchase, please ensure to memorize or write your serial number before leaving this Platform. And do not expose serial number to others.</span></p></li>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <?php
        if (isset($registrationMassage)) {
            echo $registrationMassage;
        }
        ?>
                <input type="text" id="fullName" name="name" placeholder="Full Name" required>
                <input type="password" id="loginPin" name="password" placeholder="Pin" required>
                <input type="submit" value="Purchase" id="button">
                <p>If You already have a Serial Number, start the application now</p>
                <a href="apply.php" id="button-2">Start Application</a>
            </form>
        </div>
    </div>
    <div class="copy">
        <span>&copy; 2023 - Ohenewaa Senior High School, Berekum</span>
    </div>
</body>
</html>
