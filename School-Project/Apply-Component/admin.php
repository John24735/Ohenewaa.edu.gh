<?php
// Include or require your database connection file here
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: apply.php");
    exit();
}

// Retrieve user information from the session
$user = $_SESSION['user'];



// Display user information
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="top">
        <div class="logo">
            <img src="../images/Logo.jpg" alt="logo">
            <h3>OWASS</h3>
        </div>
        <h2>ADMISSION PORTAL</h2>
        
        <a href="../index.html">Main Website</a>
    </div>

    <div class="container">
        <header>
            <h2>Home</h2>
            <h3>Administrator Dashboard</h3>
        </header>

        <div class="field">
            <div class="card-1">
                <div class="user-details">
            Welcome, <?php echo htmlspecialchars($user['name']); ?> <br>
                </div>
            
                <div class="down">
                <a href="admin.php#pendding">Pendding Applications</a>
                <a href="admin.php#rejected">Rejected Applications</a>
                <a href="admin.php#total">Total Approved</a>
                <a href="admin.php#purchase">Total Purchases</a>
                </div>
                <a href="logout.php" id="logout">Logout</a>
            </div>

            <div class="card-container">

               <div class="card" id="pendding">
                <h3>Pendding Applications</h3>

                <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT id, name, dob, gender, home, religion, disability, g_name, g_home, g_tel, main_choice, second_choice, form_type, accomodation, previous_school, passport, bece_results FROM application WHERE status = 'Pendding' AND form_type != '' ORDER BY id ASC");


                    ?>
                      <?php foreach($rows as $row) : ?>
                
                <div class="income">
                    
                <div class="uploads">
        <span>Uploads</span>
        <div class="profile">
        <?php
        if(isset($row["passport"])) {
        $passportPath = $row["passport"];
        
        // Check if the file exists before displaying
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $passportPath)) {
            echo "<img src='$passportPath' alt='Passport Picture'>";
        } else {
            echo "Passport Picture not found at: $passportPath";
        }
       } else {
        echo "Passport key not found in the row array";
      }
    ?>
        </div>
        <div class="results">
    <?php
    if(isset($row["bece_results"])) {
        $beceResultsPath = $row["bece_results"];
        
        // Check if the file exists before displaying
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $beceResultsPath)) {
            echo "<img src='$beceResultsPath' alt='BECE Results'>";
        } else {
            echo "BECE Results not found at: $beceResultsPath";
        }
    } else {
        echo "BECE Results key not found in the row array";
    }
    ?>
</div>
    </div>

                    

                    <div class="per-details">
                        <span>Personal Details</span>
                        <div class="output">Full name: <?php echo $row["name"]; ?></div>
                        <div class="output">Date of birth: <?php echo $row["dob"]; ?></div>
                        <div class="output">Home town: <?php echo $row["home"]; ?></div>
                        <div class="output">Religion: <?php echo $row["religion"]; ?></div>
                        <div class="output">Gender: <?php echo $row["gender"]; ?></div>
                        <div class="output">Disabilities: <?php echo $row["disability"]; ?></div>
                        <div class="output">Emergency contact: <?php echo $row["g_tel"]; ?></div>
                    </div>

                    <div class="edu-details">
                        <span>Educational Details</span>
                        <div class="output">First choice: <?php echo $row["main_choice"]; ?></div>
                        <div class="output">Second choice: <?php echo $row["second_choice"]; ?></div>
                        <div class="output">Form Type: <?php echo $row["form_type"]; ?></div>
                        <div class="output">Accomodation: <?php echo $row["accomodation"]; ?></div>
                        <div class="output">Previous school: <?php echo $row["previous_school"]; ?></div>
                        
                <div class="buttons">
                        <a href="admin_actions.php?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
                         <a href="admin_actions.php?action=reject&id=<?php echo $row['id']; ?>" id="reject">Reject</a>
             </div>
                    </div>
                    

                    
                </div>
                <?php endforeach; ?>
              </div>

               <div class="card" id="rejected">
                <h3>Rejected Applications</h3>

                <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT id, name, dob, gender, home, religion, disability, g_name, g_home, g_tel, main_choice, second_choice, form_type, accomodation, previous_school, passport, bece_results FROM application WHERE status = 'Rejected' ORDER BY id ASC");
                    ?>
                      <?php foreach($rows as $row) : ?>
                <div class="income">
                    <div class="uploads">
                        <span>Uploads</span>
                        <div class="profile">
                        <?php
        if(isset($row["passport"])) {
        $passportPath = $row["passport"];
        
        // Check if the file exists before displaying
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $passportPath)) {
            echo "<img src='$passportPath' alt='Passport Picture'>";
        } else {
            echo "Passport Picture not found at: $passportPath";
        }
       } else {
        echo "Passport key not found in the row array";
      }
    ?>
                        </div>
                        <div class="results">
                        <?php
    if(isset($row["bece_results"])) {
        $beceResultsPath = $row["bece_results"];
        
        // Check if the file exists before displaying
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $beceResultsPath)) {
            echo "<img src='$beceResultsPath' alt='BECE Results'>";
        } else {
            echo "BECE Results not found at: $beceResultsPath";
        }
    } else {
        echo "BECE Results key not found in the row array";
    }
    ?>
                        </div>
                    </div>

                    <div class="per-details">
                        <span>Personal Details</span>
                        <div class="output">Full name: <?php echo $row["name"]; ?></div>
                        <div class="output">Date of birth: <?php echo $row["dob"]; ?></div>
                        <div class="output">Home town: <?php echo $row["home"]; ?></div>
                        <div class="output">Religion: <?php echo $row["religion"]; ?></div>
                        <div class="output">Gender: <?php echo $row["gender"]; ?></div>
                        <div class="output">Disabilities: <?php echo $row["disability"]; ?></div>
                        <div class="output">Emergency contact: <?php echo $row["g_tel"]; ?></div>
                    </div>

                    <div class="edu-details">
                        <span>Educational Details</span>
                        <div class="output">First choice: <?php echo $row["main_choice"]; ?></div>
                        <div class="output">Second choice: <?php echo $row["second_choice"]; ?></div>
                        <div class="output">Form Type: <?php echo $row["form_type"]; ?></div>
                        <div class="output">Accomodation: <?php echo $row["accomodation"]; ?></div>
                        <div class="output">Previous school: <?php echo $row["previous_school"]; ?></div>
                        
                    <div class="buttons">
                    <a href="admin_actions.php?action=undo&id=<?php echo $row['id']; ?>">Undo Reject</a>
                     </div>
                    </div>

                    
                </div>
              <?php endforeach; ?>
              </div>

               <div class="card" id="total">
                <h3>Total Approved</h3>
                <table border= 1 cellspacing = 0 cellpadding = 10>
                    <tr>
                        <th>No.</th>
                        <td>Names</td>
                        <td>Serial Numbers</td>
                        <td>Contacts</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>

                    
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM application WHERE status = 'Approved' ORDER BY id ASC");
                     ?>

<?php foreach ($rows as $row) : ?>
    <tr>
        <th><?php echo $i++ ?></th>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["serial-number"]; ?></td>
        <td><?php echo $row["g_tel"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
        <td><a href="admin_actions.php?action=undo&id=<?php echo $row['id']; ?>">Undo</a></td>
    </tr>
<?php endforeach; ?>

                </table>
              </div>

              <div class="card" id="purchase">
                <h3>Total Purchase</h3>
                <table border= 1 cellspacing = 0 cellpadding = 10>
                    <tr>
                        <th>No.</th>
                        <td>Names</td>
                        <td>Serial Numbers</td>
                        <td>Amount</td>
                        <td>Status</td>
                    </tr>

                    
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM application WHERE status != 'Admin' ORDER BY id ASC");
                     ?>

<?php foreach ($rows as $row) : ?>
    <tr>
        <th><?php echo $i++ ?></th>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["serial-number"]; ?></td>
        <td><?php echo "GHS 20"; ?></td>
        <td><?php echo $row["status"]; ?></td>
    </tr>
<?php endforeach; ?>

                </table>
              </div>
            </div>

        </div>
    </div>



</body>
</html>