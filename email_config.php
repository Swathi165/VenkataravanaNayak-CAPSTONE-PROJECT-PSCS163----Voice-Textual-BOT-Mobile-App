<?php
require '../PHPMailer/PHPMailerAutoload.php';

function sendWelcomeEmail($userEmail, $fullName) {
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'shopsphere1546@gmail.com'; // SMTP username
        $mail->Password = 'rdvw lwtc niis gukr'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('shopsphere1546@gmail.com', 'Shop Sphere');
        $mail->addAddress($userEmail); 

        // Company logo URL (update the path to the correct location of your logo)
        $logoUrl = 'https://projectforengineers.com/shopsphere/users/assets/images/logo.png';

        // HTML content for the email
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Shop Sphere!';
        $mail->Body    = "
        <div style='text-align: center; padding: 20px; background-color: #f7f7f7; font-family: Arial, sans-serif;'>
            <div style='background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                <img src='$logoUrl' alt='Shop Sphere' style='width: 150px;'>
                <h1 style='color: #2c3e50; font-size: 24px; margin-top: 20px;'>Welcome to Shop Sphere!</h1>
                <p style='font-size: 18px; color: #34495e;'>Dear <strong>$fullName</strong>,</p>
                <p style='font-size: 16px; color: #7f8c8d;'>
                    We are thrilled to have you on board. Shop Sphere is committed to providing the best experience for all our members.
                </p>
                <div style='background-color: #3498db; padding: 15px; margin: 20px 0; border-radius: 5px;'>
                    <p style='font-size: 18px; color: white;'>
                        Start exploring our platform today!
                    </p>
                </div>
                <p style='font-size: 14px; color: #95a5a6;'>
                    If you have any questions, feel free to contact us.
                </p>
                <p style='font-size: 14px; color: #95a5a6;'>
                    Best Regards,<br>
                    Shop Sphere Team
                </p>
            </div>
            <footer style='margin-top: 20px; font-size: 12px; color: #95a5a6;'>
                <p>&copy; " . date('Y') . " Shop Sphere. All Rights Reserved.</p>
            </footer>
        </div>";

        // Send the email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
