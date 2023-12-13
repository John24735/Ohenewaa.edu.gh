<?php
// Include or require your database connection file here
include 'config.php';

// Start the session
session_start();


// Retrieve user information from the session
$user = $_SESSION['user'];
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: apply.php");
    exit();
}

if($user["status"]=="Pendding" OR $user["status"]=="Approved"){
    $link = '<a href="#">My Application</a>';
    // exit();
}

if($user["status"]=="Not started"){
    $link = '<a href="forms.php">Fill Application</a>';
    // exit();
}


// Display user information
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="top">
        <div class="logo">
            <img src="../images/Logo.jpg" alt="logo">
            <h3>OWASS</h3>
        </div>
        <h2>ADMISSION PORTAL</h2>
        
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <header>
            <h2>Home</h2>
            <h3>Welcome, <?php echo htmlspecialchars($user['name']); ?></h3>
        </header>

        <div class="field">
            <div class="card">
                <span>20th may, 2023</span>
                <h3>Welcome to OWASS</h3>
                <div class="image">
                 Serial Number: <?php echo htmlspecialchars($user['serial-number']); ?>
                </div>
                <h5>Academic Year</h5>
                <h5>Form Type</h5>

                <?php echo $link;?>
                
                

            </div>
            <div class="card">
                <h4>For More Info</h4>
                <p>For more queries, please contact Admission Office Main Hot/Whatsapp Number 📞 <span>+233558018403.</span> Thank You</p>

                <p><span>Email:</span> info@owass.edu.gh</p>

                <p><span>Tel:</span> +233558018403 / +233558018403 / +233558018403</p>

                <p><span>Skype:</span> owassonline</p>

                <p><span>Digital Address:</span> GA-658-6473</p>

                <div class="location">PMB 398, Senase, Berekum - Ghana</div>

                <p>Opposite the Senase health Clinic</p>
            </div>
        </div>
    </div>
    


<script>
    

    function displayImage() {
        const input = document.getElementById('passport-picture');
        const image = document.getElementById('display-image');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            image.src = '';
        }
    }




    
</script>
</body>
</html>
