<?php
session_start();
include '../pages/db_conn.php'; // Adjust the path as needed
require '../PHPMailer/PHPMailerAutoload.php'; // Ensure correct path to PHPMailer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Store data in the database
    $sql = "INSERT INTO contact_us (name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $email, $subject, $message);
    
    if ($stmt->execute()) {
        // Send email to user
        $user_mail = new PHPMailer(true);
        try {
            // Server settings
            $user_mail->isSMTP();
            $user_mail->Host = 'smtp.gmail.com';
            $user_mail->SMTPAuth = true;
            $user_mail->Username = 'shivagowriweb@gmail.com'; // Your SMTP username
            $user_mail->Password = 'vgtz ytia ofpx kpds'; // Your SMTP password
            $user_mail->SMTPSecure = 'tls';
            $user_mail->Port = 587;

            // Recipients
            $user_mail->setFrom('shivagowriweb@gmail.com', 'Shiva Gowri Enterprises');
            $user_mail->addAddress($email); // Add user email address

            // Content for User Email
            $user_mail->isHTML(true);
            $user_mail->Subject = 'Thank You for Contacting Us!';
            $user_mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Contact Us Confirmation</title>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
                    .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; }
                    .header { background: #000080; color: white; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { padding: 20px; }
                    .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
                    .footer a { color: #007bff; text-decoration: none; }
                    img.logo { max-width: 100px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <img src="https://th.bing.com/th/id/OIP.C7--aUtz1xrMloko-X4frwHaHR?rs=1&pid=ImgDetMain" alt="Company Logo" class="logo">
                        <h2>Shiva Gowri Enterprises</h2>
                    </div>
                    <div class="content">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for reaching out to us. We have received your message and will get back to you shortly.</p>
                        <p>If you have any immediate questions or concerns, please feel free to contact us at <strong>shivagowriweb@gmail.com</strong>.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' Shiva Gowri Enterprises. All rights reserved.</p>
                        <p><a href="https://yourwebsite.com/privacy">Privacy Policy</a> | <a href="https://yourwebsite.com/terms">Terms of Service</a></p>
                    </div>
                </div>
            </body>
            </html>';

            $user_mail->send();

            // Send email to admin
            $admin_mail = new PHPMailer(true);
            $admin_mail->isSMTP();
            $admin_mail->Host = 'smtp.gmail.com';
            $admin_mail->SMTPAuth = true;
            $admin_mail->Username = 'shivagowriweb@gmail.com';
            $admin_mail->Password = 'vgtz ytia ofpx kpds';
            $admin_mail->SMTPSecure = 'tls';
            $admin_mail->Port = 587;

            $admin_mail->setFrom('shivagowriweb@gmail.com', 'Shiva Gowri Enterprises');
            $admin_mail->addAddress('shivagowriweb@gmail.com'); // Replace with actual admin email

            // Content for Admin Email
            $admin_mail->isHTML(true);
            $admin_mail->Subject = 'New Contact Us Submission';
            $admin_mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>New Contact Request</title>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #000084; }
                    .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; }
                    .header { background: #dc3545; color: white; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { padding: 20px; }
                    .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
                    .footer a { color: #dc3545; text-decoration: none; }
                    img.logo { max-width: 100px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <img src="https://th.bing.com/th/id/OIP.C7--aUtz1xrMloko-X4frwHaHR?rs=1&pid=ImgDetMain" alt="Company Logo" class="logo">
                        <h2>New Contact Request</h2>
                    </div>
                    <div class="content">
                        <p>A new contact request has been submitted:</p>
                        <p><strong>Name:</strong> ' . htmlspecialchars($name) . '<br>
                           <strong>Phone:</strong> ' . htmlspecialchars($phone) . '<br>
                           <strong>Email:</strong> ' . htmlspecialchars($email) . '<br>
                           <strong>Subject:</strong> ' . htmlspecialchars($subject) . '<br>
                           <strong>Message:</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' Shiva Gowri Enterprises. All rights reserved.</p>
                        <p><a href="https://yourwebsite.com/privacy">Privacy Policy</a> | <a href="https://yourwebsite.com/terms">Terms of Service</a></p>
                    </div>
                </div>
            </body>
            </html>';

            $admin_mail->send();
            
            echo "Your message has been sent successfully!";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$user_mail->ErrorInfo}";
        }
    } else {
        echo "There was an error while submitting the form.";
    }
}
?>
