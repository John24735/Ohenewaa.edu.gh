<?php
// Function to generate a random serial number
function generateSerialNumber() {
    // Generate a random string with both digits and uppercase letters
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $serialNumber = '';

    // Choose a random character from the set for each position in the serial number
    for ($i = 0; $i < 6; $i++) {
        $serialNumber .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $serialNumber;
}

include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['reference'])) {
    $reference = $_GET['reference'];

    // Verify payment with Paystack
    $url = 'https://api.paystack.co/transaction/verify/' . $reference;
    $headers = [
        'Authorization: Bearer sk_test_461d683c45666ac9edded6d41e55116a5300f682',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($result && $result['data']['status'] == 'success') {
        // Payment is successful
        // Proceed with registration and generate serial number
        $name = $_SESSION['registration_data']['name'];
        $password = $_SESSION['registration_data']['password'];
        $serial = generateSerialNumber();

        $insert_sql = $conn->prepare("INSERT INTO application (name, `serial-number`, password) VALUES (?, ?, ?)");
        $insert_sql->bind_param("sss", $name, $serial, $password);

        if ($insert_sql->execute()) {
            echo "Purchase and registration successful!";
            echo "Serial Number: " . $serial;
        } else {
            echo "Error: " . $insert_sql->error;
        }

        $insert_sql->close();
    } else {
        // Payment verification failed
        echo "Payment verification failed. Please try again.";
        echo "Response: " . print_r($result, true);
    }
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
