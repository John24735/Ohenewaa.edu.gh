<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];

        if ($action === 'approve') {
            // Move the application to the "Approved Applications" table or update the status
            mysqli_query($conn, "UPDATE application SET status = 'Approved' WHERE id = $id");
            
        } elseif ($action === 'reject') {
            // Move the application to the "Rejected Applications" table or update the status
            mysqli_query($conn, "UPDATE application SET status = 'Rejected' WHERE id = $id");
        } if ($action === 'undo') {
            // Move the application to the "Approved Applications" table or update the status
            mysqli_query($conn, "UPDATE application SET status = 'Pendding' WHERE id = $id");
            
        }

        // Redirect back to the admin page
        header("Location: admin.php#pendding");
        exit();
    }
}
?>
