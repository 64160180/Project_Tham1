<?php
session_start();

require_once '../config/condb.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$cartItems = $_SESSION['cart'];
$insufficientStock = false; // Flag to track if there's insufficient stock

foreach ($cartItems as $productId => $quantity) {
    // ตรวจสอบจำนวนสินค้าคงคลัง
    $query = $condb->prepare("SELECT product_qty FROM tbl_product WHERE id = :id");
    $query->execute([':id' => $productId]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product && $product['product_qty'] >= $quantity) {
        // ลดจำนวนสินค้า
        $query = $condb->prepare("UPDATE tbl_product SET product_qty = product_qty - :quantity WHERE id = :id");
        $query->execute([':quantity' => $quantity, ':id' => $productId]);
    } else {
        $insufficientStock = true; // Set flag if there's insufficient stock
        break; // Exit loop if insufficient stock is found
    }
}

// เคลียร์รถเข็นและแสดงข้อความหากจำนวนสินค้าไม่เพียงพอ
if ($insufficientStock) {
    $_SESSION['message'] = "จำนวนสินค้าไม่เพียงพอสำหรับบางรายการในรถเข็นของคุณ. กรุณากลับไปตรวจสอบและปรับเปลี่ยนรายการสินค้าของคุณ.";
    header('Location: product.php');
    exit();
}

// เคลียร์รถเข็นหลังจากการชำระเงิน
unset($_SESSION['cart']);

// นำทางไปยังหน้าสำเร็จ
header('Location: payment_success.php');
exit();
?>
