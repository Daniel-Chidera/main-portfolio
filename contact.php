<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate input data
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $subject = trim(htmlspecialchars($_POST['subject']));
    $message = trim(htmlspecialchars($_POST['message']));
    
    // Validation
    $errors = [];
    
    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // Validate message
    if (empty($message)) {
        $errors[] = "Message is required.";
    }
    
    // If no errors, proceed with sending email
    if (empty($errors)) {
        
        // Email configuration
        $to = "chairmandaniel1@gmail.com";
        $email_subject = !empty($subject) ? $subject : "New Contact Form Message from $name";
        
        // Email body
        $email_body = "You have received a new message from your portfolio contact form.\n\n";
        $email_body .= "Here are the details:\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n\n";
        $email_body .= "Message:\n$message\n";
        
        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Send email
        if (mail($to, $email_subject, $email_body, $headers)) {
            // Success - redirect with success message
            header("Location: index.html?status=success");
            exit();
        } else {
            // Error sending email
            header("Location: index.html?status=error");
            exit();
        }
        
    } else {
        // Validation errors - redirect back with error
        header("Location: index.html?status=validation_error");
        exit();
    }
    
} else {
    // If someone tries to access this file directly
    header("Location: index.html");
    exit();
}
?>