<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$conn = new mysqli("localhost", "root", "", "westdenver");

if ($conn->connect_error) {
    die("Database Connection Failed");
}

$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$email      = $_POST['email'];
$phone      = $_POST['phone'];
$help       = $_POST['help'];
$message    = $_POST['message'];

$sql = "INSERT INTO contact_form 
(first_name, last_name, email, phone, inquiry_type, message)
VALUES 
('$first_name', '$last_name', '$email', '$phone', '$help', '$message')";

$conn->query($sql);




/* =========================
   OWNER EMAIL
========================= */

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '9a4a7c001@smtp-brevo.com';
    $mail->Password   = getenv('SMTP_KEY');
    $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
    $mail->Port       = 587;

    $mail->setFrom('mahalleavanti@gmail.com', 'WestDenver');

    $mail->addAddress('mahalleavanti@gmail.com');

    $mail->isHTML(true);

    $mail->Subject = 'New Contact Form Submission';

 $mail->Body = "
<div style='font-family:Arial,sans-serif;background:#f4f4f4;padding:40px 20px;'>

    <div style='max-width:600px;margin:auto;background:#ffffff;border-radius:12px;overflow:hidden;'>

        <div style='background:#355c50;padding:25px;text-align:center;'>
            <h2 style='color:#ffffff;margin:0;font-size:28px;'>
                New Contact Form Submission
            </h2>
        </div>

        <div style='padding:35px;'>

            <table style='width:100%;border-collapse:collapse;'>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;width:180px;'>
                        First Name:
                    </td>

                    <td style='padding:12px 0;color:#555;'>
                        $first_name
                    </td>
                </tr>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;'>
                        Last Name:
                    </td>

                    <td style='padding:12px 0;color:#555;'>
                        $last_name
                    </td>
                </tr>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;'>
                        Email:
                    </td>

                    <td style='padding:12px 0;color:#555;'>
                        $email
                    </td>
                </tr>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;'>
                        Phone:
                    </td>

                    <td style='padding:12px 0;color:#555;'>
                        $phone
                    </td>
                </tr>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;'>
                        Inquiry:
                    </td>

                    <td style='padding:12px 0;color:#555;'>
                        $help
                    </td>
                </tr>

                <tr>
                    <td style='padding:12px 0;font-weight:bold;color:#0c2330;vertical-align:top;'>
                        Message:
                    </td>

                    <td style='padding:12px 0;color:#555;line-height:1.7;'>
                        $message
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>
";

    $mail->send();

} catch (Exception $e) {
}




/* =========================
   USER THANK YOU EMAIL
========================= */

$userMail = new PHPMailer(true);

try {

    $userMail->isSMTP();
    $userMail->Host       = 'smtp-relay.brevo.com';
    $userMail->SMTPAuth   = true;
    $userMail->Username   = '9a4a7c001@smtp-brevo.com';
    $userMail->Password   = getenv('SMTP_KEY');
    $userMail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
    $userMail->Port       = 587;

    $userMail->setFrom('mahalleavanti@gmail.com', 'WestDenver');

    $userMail->addAddress($email);

    $userMail->isHTML(true);

    $userMail->Subject = 'Thank You For Contacting Us';

    $userMail->Body = "
<div style='font-family:Arial,sans-serif;background:#f4f4f4;padding:40px 20px;'>

    <div style='max-width:600px;margin:auto;background:#ffffff;border-radius:12px;overflow:hidden;'>

        <div style='background:#355c50;padding:30px;text-align:center;'>

            <h1 style='color:#ffffff;margin:0;font-size:32px;'>
                Thank You!
            </h1>

        </div>

        <div style='padding:40px 35px;'>

            <h2 style='color:#0c2330;margin-top:0;'>
                Dear $first_name,
            </h2>

            <p style='color:#555;font-size:16px;line-height:1.8;margin-bottom:20px;'>

                Thank you for contacting WestDenver.

                We have successfully received your message and our team will get back to you shortly.

            </p>
            <p style='color:#555;font-size:16px;line-height:1.8;'>

                We appreciate your interest and will contact you as soon as possible.

            </p>

            <p style='margin-top:35px;color:#0c2330;font-weight:bold;'>

                Regards,<br>
                WestDenver Team

            </p>

        </div>

    </div>

</div>
";

    $userMail->send();

} catch (Exception $e) {
}



echo "
<script>
alert('Form submitted successfully!');
window.location.href='../index.php';
</script>
";

?>