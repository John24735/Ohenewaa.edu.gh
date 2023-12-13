<?php
session_start();

if (!isset($_SESSION['registration_data'])) {
    header("Location: index.php");
    exit();
}

$registration_data = $_SESSION['registration_data'];
$name = $registration_data['name'];
$password = $registration_data['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
    <h1>Payment</h1>
    <p>Total Amount: GHS 20</p>
    
    <button onclick="payWithPaystack()">Pay Now</button>

    <script>
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: 'pk_test_0cfb345bdaa919543ee61eb593e4f0efe8ce2ef0',
            email: 'user@example.com',
            amount: 2000, // Amount in kobo (20 GHS in kobo: 1 GHS = 100 kobo)
            currency: 'GHS',
            ref: 'registration_<?php echo time(); ?>',
            callback: function(response) {
                window.location.href = 'process_payment.php?reference=' + response.reference;
            },
            onClose: function() {
                alert('Payment closed without completing');
            }
        });
        handler.openIframe();
    }
</script>
</body>
</html>
