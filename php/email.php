<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = $_POST["email"];
    $subject = "Ostotarjous Email";
    $message = "Kiitos ostotarjouksestasi me katsomme sen läpi ja harkitsemme auton ostoa.";
    $headers = "From: ostotarluxcar@gmail.com";

    // Send email
    if (mail($to_email, $subject, $message, $headers)) {
        echo "Email lähetetty $to_email";
    } else {
        echo "Email lähetys ei onnistunut.";
    }
} else {
    // Redirect back to the form if accessed directly
    header("Location: pages/ostotarjoukset.html");
    exit();
}
?>