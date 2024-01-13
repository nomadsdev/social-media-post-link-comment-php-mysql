<?php
// index.php

// รวมเข้ากับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "social_media");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลโพสต์
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $post_text = $_POST["post_text"];

    // เพิ่มโพสต์ลงในฐานข้อมูล
    $sql = "INSERT INTO posts (user_name, post_text) VALUES ('$user_name', '$post_text')";
    $conn->query($sql);
}

// ดึงข้อมูลโพสต์
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

// แสดงโพสต์
while ($row = $result->fetch_assoc()) {
    echo "<div class='flex justify-center'>";
    echo "<div class='bg-zinc-50 shadow-md rounded-md p-5'>";
    echo "<div class=''>";
        echo "<p class='pr-2'>User : {$row['user_name']}</p>";
        echo "<p>{$row['post_text']}</p>";
    echo "</div>";

    echo "<div class='flex py-2'>";
    // แสดงจำนวนไลค์
    $likeResult = $conn->query("SELECT COUNT(*) as like_count FROM likes WHERE post_id = {$row['id']}");
    $likeRow = $likeResult->fetch_assoc();
    $likeCount = $likeRow['like_count'];
    echo "<p class='pr-2 text-rose-500'>{$likeCount}</p>";

    // แสดงปุ่มไลค์
    echo "<form method='post' action='like.php'>";
    echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
    echo "<input type='submit' value='Like' class='bg-rose-500 text-white rounded-md px-4 hover:bg-rose-600 cursor-pointer transition'>";
    echo "</form>";
    echo "</div>";
    
    // แสดงคอมเมนต์
    echo "<form method='post' action='comment.php'>";
    echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
    $commentResult = $conn->query("SELECT * FROM comments WHERE post_id = {$row['id']} ORDER BY created_at DESC");
    echo "<ul class='py-2'>";
    while ($commentRow = $commentResult->fetch_assoc()) {
        echo "<li class='text-zinc-500'>{$row['user_name']} : {$commentRow['comment_text']}</li>";
    }
    echo "</ul>";
    echo "<input type='text' name='comment_text' placeholder='Add a comment...' class='rounded-sm pl-2 mr-2'>";
    echo "<input type='submit' value='Comment' class='shadow-sm py-1 bg-sky-500 text-white rounded-md px-4 hover:bg-sky-600 cursor-pointer transition'>";
    echo "</form>";

    echo "</div>";
    echo "</div>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>social</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">   
    <style>
        *{ 
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class='grid grid-cols-3 gap-5 p-10'>

        <!-- แบบฟอร์มเพิ่มโพสต์ -->
        <div class='flex justify-center'>
            <div class='bg-zinc-50 shadow-md rounded-xl p-5'>
                <div class='pb-4'>
                    <img class='w-10' src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="">
                </div>
                <form method="post" action="" class='grid grid-cols-2 gap-5'>
                    <input type="text" name="user_name" placeholder="Your Name" required class='rounded-md pl-2'>
                    <textarea name="post_text" placeholder="What's on your mind?" required class='rounded-md pl-2 resize-none'></textarea>
                    <input type="submit" value="Post" class='shadow-sm py-2 bg-sky-500 text-white rounded-md px-4 hover:bg-sky-600 cursor-pointer transition'>
                </form>
            </div>
        </div>

    
</body>
</html>