<?php
// Assuming you have already established a database connection here
// Replace 'your_db_host', 'your_db_username', 'your_db_password', and 'your_db_name' with actual database credentials

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $machine = $_POST['machine'];
    $problem = $_POST['problem'];

    // Insert data into the database
    $conn = new mysqli('localhost', 'root', '', 'laptopbooking');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO data (Name, Email, Phone, Machine, Problem) VALUES ('$name', '$email', '$phone', '$machine', '$problem')";

    // Include the PHPMailer class
    // require 'D:\ivy\htdocs\LaptopRecords1\PHPMailer\Exception.php';
    // require 'D:\ivy\htdocs\LaptopRecords1\PHPMailer\PHPMailer.php';
    // require 'D:\ivy\htdocs\LaptopRecords1\PHPMailer\SMTP.php';

    if ($conn->query($sql) === TRUE) {
        echo "Data successfully submitted to the database.";
        $successMessage = "Data submitted successfully";

        $to = $email;
        $subject = 'Machine Received';
        $message = "Dear $name,\n\nThank you for submitting your machine details. We have received your machine details with the following information:\n\nMachine: $machine\nProblem: $problem\n\nWe will process your request as soon as possible.\n\nBest regards,\nLaptop Care ltd";

        // Instantiate PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Set SMTP settings for Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kajujuivy7872@gmail.com'; // Replace with your Gmail email address
            $mail->Password = 'hjsacjvkhkkcphdn'; // Replace with your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set email parameters
            $mail->setFrom('kajujuivy7872@gmail.com', 'ivy kajuju'); // Replace with your Gmail email address and display name
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send the email
            $mail->send();

            echo "An email has been sent to $email with the details.";
        } catch (Exception $e) {
            echo "Email sending failed. Error: {$mail->ErrorInfo}";
        }

        $conn->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
    }
}
?>
