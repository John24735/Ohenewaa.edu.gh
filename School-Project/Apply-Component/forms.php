<?php
// Include or require your database connection file here
include 'config.php';

$passportPath = '';
$beceResultsPath = '';

// Start the session
session_start();
// Retrieve user information from the session
$user = $_SESSION['user'];

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $home = $_POST["home"];
    $religion = $_POST["religion"];
    $disability = $_POST["disability"];
    $g_name = $_POST["g_name"];
    $g_home = $_POST["g_home"];
    $g_tel = $_POST["g_tel"];
    $main_choice = $_POST["main_choice"];
    $second_choice = $_POST["second_choice"];
    $form_type = $_POST["form_type"];
    $accomodation = $_POST["accomodation"];
    $previous_school = $_POST["previous_school"];

    // Handle file uploads for Passport
    $passport = $_FILES['passport']['name'];
    $passport_temp = $_FILES["passport"]["tmp_name"];
    $uploads_path_passport = __DIR__ . "/uploads/" . $passport;

    if (move_uploaded_file($passport_temp, $uploads_path_passport)) {
        $passportPath = $uploads_path_passport;
    } else {
        echo "Error moving passport file";
        exit; // Stop execution if an error occurs
    }

    // Handle file uploads for BECE Results
    $bece_results = $_FILES['bece_results']['name'];
    $bece_results_path = $_FILES["bece_results"]["tmp_name"];
    $uploads_path_bece = __DIR__ . "/uploads/" . $bece_results;

    if (move_uploaded_file($bece_results_path, $uploads_path_bece)) {
        $beceResultsPath = $uploads_path_bece;
    } else {
        echo "Error moving BECE results file";
        exit; // Stop execution if an error occurs
    }

    // Check if the name matches
    $check_credentials_sql = "SELECT * FROM application WHERE name = ?";
    $stmt = mysqli_prepare($conn, $check_credentials_sql);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $credentials_result = mysqli_stmt_get_result($stmt);



    if ($credentials_result !== false) {
        if (mysqli_num_rows($credentials_result) > 0) {
            // Name matches, proceed with the update
            // ...

            // Proceed with the update
            $update_sql = "UPDATE application SET 
                name = '$name', 
                dob = '$dob', 
                gender = '$gender', 
                home = '$home', 
                religion = '$religion', 
                disability = '$disability', 
                g_name = '$g_name', 
                g_home = '$g_home', 
                g_tel = '$g_tel', 
                main_choice = '$main_choice', 
                second_choice = '$second_choice', 
                form_type = '$form_type', 
                accomodation = '$accomodation', 
                previous_school = '$previous_school', 
                passport = '$passportPath', 
                bece_results = '$beceResultsPath', 
                status = 'Pendding' 
                WHERE name = '$name'";

            if (mysqli_query($conn, $update_sql)) {
                $registrationMassage = '<div class ="massage success">Form submitted successfully!</div>';

                $newId = mysqli_insert_id($conn);

                $updateQuery = "UPDATE application SET status = 'Pendding' WHERE id = $newId";
                // echo "Form submitted successfully!";
            } else {
                echo "Error submitting the forms";
            }
        } else {
            echo "Invalid credentials for updating the record";
        }
    } else {
        echo "Error executing the query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="forms.css">
</head>
<body>
    <div class="top">
        <div class="logo">
            <img src="../images/Logo.jpg" alt="logo">
            <h3>OWASS</h3>
        </div>
        <h2>APPLICATION FORMS</h2>
        <a href="home.php">Go Home</a>
    </div>
    <div class="container">
        <header>Registration</header>
        <?php
        if (isset($registrationMassage)) {
            echo $registrationMassage;
        }
        ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="submitForm(event)" enctype="multipart/form-data">
            <div class="first form">
                <div class="details personal">
                    <span class="titl">Personal Details</span>

                    <span class="title">Upload Picture</span>
        <div class="image-field">
                       <label for="passport">Clear Passport Picture (jpeg or png)</label>
                      <div class="image">
        <!-- Display selected passport picture -->
        <input type="file" name="passport" id="passport" accept="image/*" onchange="showImage()" required>
<img id="show-image" src="<?php echo isset($passportPath) ? $passportPath : ''; ?>" alt="passport picture">
              </div>
          </div>
    
                    <div class="fields">
                        <div class="input-field">
                            <label for="full-name">Full Name</label>
                            <input type="text" name="name" placeholder="Enter your full name" required>
                        </div>

                        <div class="input-field">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" required>
                        </div>

                        <div class="input-field">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option value="None">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label for="home-town">Home Town</label>
                            <input type="text" name="home" id="home-town" placeholder="Your home town" required>
                        </div>

                        <div class="input-field">
                            <label for="religion">Religion</label>
                            <select name="religion" id="religion">
                                <option value="None">Select Religion</option>
                                <option value="Christian">Christian</option>
                                <option value="Muslim">Muslim</option>
                                <option value="Traditional">Traditional</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label for="disability">Any Disabilities or Diseases</label>
                            <select name="disability" id="disability">
                                <option value="None">None</option>
                                <option value="Yes">Yes, I have</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="details personal">
                    <span class="titl">Guidance Details</span>
    
                    <div class="fields">

                        <div class="input-field">
                            <label for="full-name">Guidance Full Name</label>
                            <input type="text" name="g_name" placeholder="Enter guidance full name" required>
                        </div>

                        <div class="input-field">
                            <label for="ghome-town">Guidance Home Town</label>
                            <input type="text" name="g_home" id="ghome-town" required>
                        </div>

                        <div class="input-field">
                            <label for="contact">Guidance Phone Number</label>
                            <input type="tel" name="g_tel" id="contact" pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" required>
                        </div>


                    </div>
                </div>

                <div class="details personal">
                    <span class="titl">Educational Details</span>
    
                    <span class="title">Course Applying</span>
                    <div class="fields">
                        <div class="input-field">
                            <label for="course">First Choice</label>
                            <select name="main_choice"  id="course">
                                <option value="None">Select Course</option>
                                <option value="General Science">General Science</option>
                                <option value="General Arts">General Arts</option>
                                <option value="Home Eonomics">Home Eonomics</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label for="course">Second Choice</label>
                            <select name="second_choice" id="course">
                                <option value="None">Select Course</option>
                                <option value="General Science">General Science</option>
                                <option value="General Arts">General Arts</option>
                                <option value="Home Eonomics">Home Eonomics</option>
                            </select>
                        </div>
                        
                        <div class="input-field">
                            <label for="type">Form Type</label>
                            <select name="form_type" id="type">
                                <option value="SHS 1">SHS 1</option>
                                <option value="SHS 2">SHS 2</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label for="accomodation">Accomodation</label>
                            <select name="accomodation" id="accomodation">
                                <option value="Day">Day</option>
                                <option value="Hostel">Hostel</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label for="old-school">Previuos School Attended</label>
                            <input type="text" name="previous_school" placeholder="Enter your school name" required>
                        </div>

            <div class="image-field">
                      <label for="bece-results">BECE Result (jpeg, pdf or png)</label>
                  <div class="image">
        <!-- Display selected BECE results -->
        <input type="file" name="bece_results" id="bece-results" accept="application/*" onchange="displayImage()" required>
<img id="display-image" src="<?php echo isset($beceResultsPath) ? $beceResultsPath : ''; ?>" alt="BECE Results">
             </div>
           </div>


                    </div>
                </div>
                <div class="declear">
                    <span>Declaretion</span>  declare that I have read and filled this above informations correctly, so if the information given by me is incorrect, you have the right to cancle without informing me.</p>
                </div>
                <button type="submit">Submit Application</button>
            </div>
        </form>
    </div>



<script>
    function displayImage() {
        var input = document.getElementById('bece-results');
        var image = document.getElementById('display-image');
        var file = input.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            image.src = '';
        }
    }

    function showImage() {
        const input = document.getElementById('passport');
        const image = document.getElementById('show-image');
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
