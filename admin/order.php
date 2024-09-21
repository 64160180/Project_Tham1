<?php
session_start();

// ตรวจสอบ session
if (empty($_SESSION['id']) && empty($_SESSION['name']) && empty($_SESSION['surname'])) {
    echo '<script>
        setTimeout(function() {
        swal({
        title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
        type: "error"
        }, function() {
        window.location = "index.php";
        });
        }, 1000);
    </script>';
    exit();
}

include 'header.php';
include 'navbar.php';
include 'sidebar_menu.php';
include 'footer.php';
include 'order_history.php';
?>
