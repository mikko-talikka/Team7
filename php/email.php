<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = $_POST["email"];
    $subject = "Ostotarjous Email";
    $message = "Kiitos ostotarjouksestasi me katsomme sen läpi ja harkitsemme auto ostoa.";
    $headers = "From: ostotarjoukset@luxcar.com";

    // Send email
    if (mail($to_email, $subject, $message, $headers)) {
        echo "Email sent successfully to $to_email";
    } else {
        echo "Failed to send email.";
    }
} else {
    // Redirect back to the form if accessed directly
    header("Location: ostotarjoukset.html");
    exit();
}
?>