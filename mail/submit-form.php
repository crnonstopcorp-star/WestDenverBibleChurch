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
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$help       = trim($_POST['help'] ?? '');
$message    = trim($_POST['message'] ?? '');

if (!$first_name || !$email || !$message) {
    die("Required fields missing");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

/* =========================
   INSERT INTO DATABASE
========================= */
$stmt = $conn->prepare("
    INSERT INTO contact_form 
    (first_name, last_name, email, phone, inquiry_type, message)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $help, $message);
$stmt->execute();

/* =========================
   OWNER EMAIL
========================= */
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username = '9a4a7c001@smtp-brevo.com';
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
    $mail->addAddress('mahalleavanti@gmail.com'); 

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';

   $mail->Body = "
<div style='max-width:600px; margin:0 auto; font-family:Source Sans 3; background:#ffffff; border:1px solid #e5e5e5; border-radius:10px; overflow:hidden;'>

    <div style='background:#2f4f46; padding:20px; text-align:center;'>
        <h2 style='color:#ffffff; margin:0; font-size:28px;'>
            New Contact Form Submission
        </h2>
    </div>

    <div style='padding:30px;'>

        <table style='width:100%; border-collapse:collapse;'>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee; width:35%;'>
                    First Name
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$first_name}
                </td>
            </tr>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee;'>
                    Last Name
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$last_name}
                </td>
            </tr>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee;'>
                    Email
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$email}
                </td>
            </tr>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee;'>
                    Phone
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$phone}
                </td>
            </tr>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee;'>
                    Inquiry
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$help}
                </td>
            </tr>

            <tr>
                <td style='padding:12px; font-weight:bold; color:#333; border-bottom:1px solid #eee;'>
                    Message
                </td>
                <td style='padding:12px; color:#555; border-bottom:1px solid #eee;'>
                    {$message}
                </td>
            </tr>
        </table>
    </div>

    <div style='background:#f5f5f5; padding:18px; text-align:center; color:#777; font-size:14px;'>
        WestDenver Bible Church Contact Form
    </div>

</div>
";

    $mail->send();

} catch (Exception $e) {
    echo "Mailer Error (Admin Mail): " . $mail->ErrorInfo;
    exit;
}

/* =========================
   USER THANK YOU EMAIL
========================= */
$userMail = new PHPMailer(true);

try {
    $userMail->isSMTP();
    $userMail->Host       = 'smtp-relay.brevo.com';
    $userMail->SMTPAuth   = true;
    $userMail->Username = '9a4a7c001@smtp-brevo.com';
    $userMail->Password   = $_ENV['SMTP_KEY'];
    $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $userMail->Port       = 587;
    
    $userMail->SMTPOptions = [
    'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true,
    ],
];


    $userMail->setFrom('mahalleavanti@gmail.com', 'WestDenver');

    $userMail->addAddress($email);

    $userMail->isHTML(true);
    $userMail->Subject = 'Thank You For Contacting Us';

  $userMail->Body = "

        <div style='max-width:600px; margin:0 auto; font-family:Source Sans 3; background:#ffffff; border:1px solid #e5e5e5; border-radius:10px; overflow:hidden;'>
            <div style='background:#2f4f46; padding:20px; text-align:center;'>
                <h2 style='color:#ffffff; margin:0; font-size:28px;'>
                    Thank You, {$first_name}!
                </h2>
            </div>

            <div style='padding:30px;'>

                <p style='font-size:16px; color:#555; line-height:1.8; margin-top:0;'>
                    We have received your message and will get back to you shortly.
                </p>

                <p style='font-size:16px; color:#555; line-height:1.8; margin-bottom:0;'>
                    Regards,<br>
                    <strong>WestDenver Team</strong>
                </p>

            </div>

        </div>
";

    $userMail->send();

} catch (Exception $e) {
    echo "Mailer Error (User Mail): " . $userMail->ErrorInfo;
    exit;
}

/* =========================
   SUCCESS RESPONSE
========================= */
echo "
<script>
alert('Form submitted successfully!');
window.location.href='../index.php';
</script>
";

?>

