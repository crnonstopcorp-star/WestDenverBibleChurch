<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

/* =========================
   LOAD ENV
========================= */
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/* =========================
   DB CONNECTION
========================= */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
);

$conn->set_charset("utf8mb4");

/* =========================
   GET & VALIDATE INPUT
========================= */
$email = trim($_POST['email'] ?? '');

if (!$email) {
    die("Email is required");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

/* =========================
   CHECK EXISTING EMAIL
========================= */
$checkStmt = $conn->prepare("
    SELECT id FROM newsletter_subscribers 
    WHERE email = ?
");

$checkStmt->bind_param("s", $email);
$checkStmt->execute();

$result = $checkStmt->get_result();

if ($result->num_rows > 0) {

    echo "
    <script>
    alert('Email already subscribed!');
    window.history.back();
    </script>
    ";

    exit;
}

/* =========================
   INSERT INTO DATABASE
========================= */
$stmt = $conn->prepare("
    INSERT INTO newsletter_subscribers (email)
    VALUES (?)
");

$stmt->bind_param("s", $email);
$stmt->execute();

/* =========================
   OWNER EMAIL
========================= */
$ownerMail = new PHPMailer(true);

try {

    $ownerMail->isSMTP();
    $ownerMail->Host       = 'smtp-relay.brevo.com';
    $ownerMail->SMTPAuth   = true;
    $ownerMail->Username   = '9a4a7c001@smtp-brevo.com';
    $ownerMail->Password   = $_ENV['SMTP_KEY'];
    $ownerMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $ownerMail->Port       = 587;

    $ownerMail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $ownerMail->setFrom('mahalleavanti@gmail.com', 'WestDenver');

    // owner/admin email
    $ownerMail->addAddress('mahalleavanti@gmail.com');

    $ownerMail->isHTML(true);

    $ownerMail->Subject = 'New Newsletter Subscription';

    $ownerMail->Body = "

    <div style='max-width:600px; margin:0 auto; font-family:Source Sans 3; background:#ffffff; border:1px solid #e5e5e5; border-radius:10px; overflow:hidden;'>

        <div style='background:#2f4f46; padding:20px; text-align:center;'>
            <h2 style='color:#ffffff; margin:0; font-size:28px;'>
                New Newsletter Subscriber
            </h2>
        </div>

        <div style='padding:30px;'>

            <table style='width:100%; border-collapse:collapse;'>

                <tr>
                    <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee; width:35%;'>
                        Subscriber Email :
                    </td>

                    <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                        {$email}
                    </td>
                </tr>

            </table>

        </div>

        <div style='background:#f5f5f5; padding:18px; text-align:center; color:#777; font-size:14px;'>
            WestDenver Bible Church Newsletter
        </div>

    </div>
    ";

    $ownerMail->send();

} catch (Exception $e) {

    echo "Owner Mailer Error: " . $ownerMail->ErrorInfo;
    exit;
}

/* =========================
   THANK YOU EMAIL
========================= */
$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '9a4a7c001@smtp-brevo.com';
    $mail->Password   = $_ENV['SMTP_KEY'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom('mahalleavanti@gmail.com', 'WestDenver');

    // send email to subscriber
    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Newsletter Subscription';

    $mail->Body = "

    <div style='max-width:600px; margin:0 auto; font-family:Source Sans 3; background:#ffffff; border:1px solid #e5e5e5; border-radius:10px; overflow:hidden;'>

        <div style='background:#2f4f46; padding:20px; text-align:center;'>
            <h2 style='color:#ffffff; margin:0; font-size:28px;'>
                Thank You For Subscribing!
            </h2>
        </div>

        <div style='padding:30px;'>

            <p style='font-size:16px; color:#555; line-height:1.8; margin-top:0;'>
                You have successfully subscribed to our newsletter.
            </p>

            <p style='font-size:16px; color:#555; line-height:1.8;'>
                You will now receive updates and announcements from WestDenver Bible Church.
            </p>

            <p style='font-size:16px; color:#555; line-height:1.8; margin-bottom:0;'>
                Regards,<br>
                <strong>WestDenver Team</strong>
            </p>

        </div>

    </div>
    ";

    $mail->send();

} catch (Exception $e) {

    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
}

/* =========================
   SUCCESS RESPONSE
========================= */
echo "
<script>
alert('Subscribed Successfully!');
window.location.href='../index.php';
</script>
";

?>