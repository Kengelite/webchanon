<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = '147.50.227.17';
$db = 'drnadech_webchanon';
$user = 'drnadech_adminwebchanon';
$pass = 'Nc*262kk9';
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $country = $conn->real_escape_string($_POST['country']);
    $university = $conn->real_escape_string($_POST['university']);

    // ตรวจสอบว่า email มีอยู่ในฐานข้อมูลหรือไม่
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if (!$result->num_rows > 0) {
// ถ้า email ไม่มีอยู่ ให้เพิ่มข้อมูลใหม่
$insert = "INSERT INTO users (id,email, country, university,end_time) VALUES (UUID(),'$email', '$country', '$university',DATE_ADD(NOW(), INTERVAL 1 DAY))";
$conn->query($insert);
// if ($conn->query($insert) === TRUE) {
// echo "<div class='alert alert-success text-center'>สมัครสมาชิกสำเร็จ! ข้อมูลถูกบันทึกและเข้าสู่ระบบเรียบร้อยแล้ว.</div>
// ";
} else {
$query_update = "
UPDATE users
SET end_time = DATE_ADD(NOW(), INTERVAL 1 DAY)
WHERE email='$email'
";
$conn->query($query_update);
}


// เริ่มการส่งอีเมล
$mail = new PHPMailer(true); // สร้างวัตถุ PHPMailer
try {
// ตั้งค่าเซิร์ฟเวอร์ SMTP


$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // ใช้ SMTP host ของ Gmail
$mail->SMTPAuth = true;
$mail->Username = 'apipath79@gmail.com'; // อีเมลของคุณ
$mail->Password = 'azdt yvpp ewjd yfek'; // ถ้าใช้การยืนยัน 2 ขั้นตอนให้ใช้ App Password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // ใช้ SSL
$mail->Port = 465; // ใช้พอร์ต 465 สำหรับ SSL

// ตั้งค่าผู้ส่งและผู้รับ
$mail->setFrom($email, 'Asst. Prof. Chanon Dechsupa, Ph.D.');
$mail->addAddress($email); // ส่งอีเมลไปยังผู้ที่ลงทะเบียน
// ตั้งค่าหัวเรื่องและข้อความ
// Email content
$mail->isHTML(true); // Set email format to HTML
$mail->Subject = "Data Request for Bivalve Research by Chanon";
$mail->Body = '<h1>Bivalve Research Data Access</h1>
<p>Dear User,</p>
<p>We are pleased to provide you with access to the bivalve research data. Please click the link below to download the data.</p>
<a href="https://drnadech.com/get_data_Bivalve.php?email=' . "'".$email  ."'".'>Click here to access the data</a>
<p>If you have any questions or require further assistance, feel free to contact us.</p>
<p>Best regards,</p>
<p>Chanon</p>';
$mail->AltBody = 'Bivalve Research Data Access - Click the link to download the data.';
$mail->send();
if(!$mail->send()) {
echo 'Message could not be sent.';
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    $email_message = "Send Data to :  $email";
    ?>
    <script>
    Swal.fire({
        title: "Thank you",
        text: "<?php echo $email_message; ?>",
        icon: "success"
    }).then((result) => {
        if (result.isConfirmed) {
            // ทำบางอย่างที่นี่ เช่น เปลี่ยนหน้า
            window.location.href = "index.php"; // เปลี่ยนเส้นทางไปยังหน้าอื่น
        }
    });
    </script>
    <?php
    
}
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


$conn->close();


?>
</body>

</html>