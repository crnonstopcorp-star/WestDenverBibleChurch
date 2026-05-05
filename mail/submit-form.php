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
    $mail->Username   = 'apikey';
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

    $mail->setFrom('noreply@westdenverbiblechurch.myconcept.website', 'WestDenver');
    $mail->addAddress('crnonstopcorp@gmail.com'); // your real inbox

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';

    $mail->Body = "
        <h2>New Contact Form Submission</h2>
        <p><strong>First Name:</strong> {$first_name}</p>
        <p><strong>Last Name:</strong> {$last_name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Inquiry:</strong> {$help}</p>
        <p><strong>Message:</strong><br>{$message}</p>
    ";

    $mail->send();

} catch (Exception $e) {
    echo "Mailer Error: " . $userMail->ErrorInfo;
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
    $userMail->Username   = 'apikey';
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

    $userMail->setFrom('noreply@westdenverbiblechurch.myconcept.website', 'WestDenver');
    $userMail->addAddress($email);

    $userMail->isHTML(true);
    $userMail->Subject = 'Thank You For Contacting Us';

    $userMail->Body = "
        <h2>Thank You, {$first_name}!</h2>
        <p>We have received your message and will get back to you shortly.</p>
        <p>Regards,<br>WestDenver Team</p>
    ";

    $userMail->send();

} catch (Exception $e) {
    echo "Mailer Error: " . $userMail->ErrorInfo; ✅
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