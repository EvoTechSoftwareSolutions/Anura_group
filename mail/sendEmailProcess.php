<?php

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

// Function to sanitize and validate input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Define variables
$name = $email = $mobile = $message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate each input
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $message = sanitizeInput($_POST['message']);
   

    // Validate Name
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors[] = "Only letters and white space allowed in name";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Validate Phone
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $errors[] = "Phone number should be a 10-digit number";
    }
    

    // Validate Message
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // If no errors, you can proceed with further actions
    if (empty($errors)) {
        
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sandilalometh2005@gmail.com';
    $mail->Password = 'mxownkxsjoqjtuiu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('sandilalometh2005@gmail.com', 'Client Message');
    $mail->addReplyTo('sandilalometh2005@gmail.com', 'Client Message');
    $mail->addAddress('kawarjanagunasekara@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Client message';
    $bodyContent = '<h1>Customer Message</h1>
    <h3>'.$name.'</h3>
    <h3>'.$email.'</h3>
    <h3>'.$phone.'</h3>
    <h3>'.$message.'</h3>';
    $mail->Body    = $bodyContent;

    if (!$mail->send()) {
        echo 'Service Unavailable. Please try again later';
    } else {
        echo 'Message Sent successfully';
    }
    } else {
        echo $errors[0];
    }
}