<?php
// comment.php

// รวมเข้ากับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "social_media");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลคอมเมนต์
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $user_name = $_POST["user_name"];
    $comment_text = $_POST["comment_text"];

    // เพิ่มคอมเมนต์ลงในฐานข้อมูล
    $sql = "INSERT INTO comments (post_id, user_name, comment_text) VALUES ('$post_id', '$user_name', '$comment_text')";
    $conn->query($sql);
}

// กลับไปหน้าแสดงโพสต์หลัก
header("Location: index.php");
exit();
?>