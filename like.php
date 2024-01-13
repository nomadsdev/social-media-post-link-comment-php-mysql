<?php
// like.php

// รวมเข้ากับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "social_media");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลไลค์
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $user_name = $_POST["user_name"];

    // เพิ่มไลค์ลงในฐานข้อมูล
    $sql = "INSERT INTO likes (post_id, user_name) VALUES ('$post_id', '$user_name')";
    $conn->query($sql);
}

// กลับไปหน้าแสดงโพสต์หลัก
header("Location: index.php");
exit();
?>