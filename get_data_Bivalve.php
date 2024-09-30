<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- เรียกใช้ Swal -->
</head>

<body>

    <?php
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

// รับค่า email จาก GET request
if ( !empty($_GET['email'])) {
    $email = $_GET['email'];
    
    // แก้ไขปัญหาการมี ' ซ้ำกัน
    date_default_timezone_set("Asia/Bangkok");

    // Escape ตัวแปร email เพื่อป้องกัน SQL Injection
    $email = $conn->real_escape_string($email);   
     $email = stripslashes($email);  
     $email = str_replace(" ", "'", $email);
     $query = "SELECT * FROM users WHERE email=".$email." AND end_time > NOW()";
    $result = $conn->query($query);
if ($result->num_rows > 0) {
    // กำหนดเส้นทางไปยังไฟล์ zip
   



    $file = './dataset/Ensi_Pict.zip';  // ใส่ที่อยู่ไฟล์ zip ของคุณ
    // ตรวจสอบว่าไฟล์มีอยู่จริงหรือไม่
    if (file_exists($file)) {
        // กำหนดส่วนหัวของ HTTP เพื่อให้ไฟล์ถูกดาวน์โหลด
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        
        // อ่านไฟล์และส่งให้ผู้ใช้ดาวน์โหลด
        flush(); // Flush system output buffer
        readfile($file);
        header('Location: ./index.php');
        exit; // ออกจาก script เพื่อให้ไฟล์ถูกดาวน์โหลดอย่างสมบูรณ์
    } else {
        ?>
    <script>
    Swal.fire({
        icon: "error",
        title: "Download Error!1",
        text: "The session has expired. Please request a new download link from the email.",
    }).then(() => {
        window.location.href = './index.php';

    });
    </script>
    <?php
    }
} else {
    // ถ้า end_time น้อยกว่าหรือเท่ากับเวลาปัจจุบัน ไม่สามารถดาวน์โหลดไฟล์ได้
    // header("Location: ./index.php");
    ?>
    <script>
    Swal.fire({
        icon: "error",
        title: "Download Error!2",
        text: "The session has expired. Please request a new download link from the email.",
    }).then(() => {
        window.location.href = './index.php';

    });
    </script>
    <?php
}
}
?>
</body>

</html>