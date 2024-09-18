<?php
session_start();

// การเชื่อมต่อฐานข้อมูล
require_once '../config/condb.php';

// แสดงข้อผิดพลาด (สำหรับการพัฒนา)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ตรวจสอบว่ารถเข็นมีสินค้าอยู่หรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning' role='alert'>
            <h4 class='alert-heading'>รถเข็นของคุณยังไม่มีสินค้า</h4>
            <p><a href='product.php' class='btn btn-primary'>กลับไปยังหน้าสินค้า</a></p>
          </div>";
    exit();
}

// สร้างรายการสินค้าที่อยู่ในรถเข็น
$cartItems = $_SESSION['cart'];
$productIds = implode(',', array_keys($cartItems));

// คิวรีข้อมูลสินค้าจากฐานข้อมูลตาม ID ที่อยู่ในรถเข็น
$query = $condb->prepare("SELECT * FROM tbl_product WHERE id IN ($productIds)");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รถเข็นสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>รถเข็นสินค้า</h2>
        <table class="table table-bordered">
            <thead>
                <tr class="table-info">
                    <th>ภาพสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalPrice = 0;
                foreach ($products as $product): 
                    $quantity = $cartItems[$product['id']];
                    $total = $product['product_price'] * $quantity;
                    $totalPrice += $total;
                ?>
                <tr>
                    <td><img src="../assets/product_img/<?= $product['product_image']; ?>" class="img-thumbnail" width="70px"></td>
                    <td><?= $product['product_name']; ?></td>
                    <td><?= number_format($product['product_price'], 2); ?> บาท</td>
                    <td><?= $quantity; ?></td>
                    <td><?= number_format($total, 2); ?> บาท</td>
                    <td>
                        <a href="cat_from_remove.php?id=<?= $product['id']; ?>&action=decrease" class="btn btn-warning btn-sm">ลดจำนวน</a>
                        <a href="cat_from_remove.php?id=<?= $product['id']; ?>&action=remove" class="btn btn-danger btn-sm">ลบทั้งหมด</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <h3>ยอดรวมทั้งหมด: <?= number_format($totalPrice, 2); ?> บาท</h3>
            <div>
                <a href="product.php" class="btn btn-primary">กลับไปยังหน้าสินค้า</a>
                <a href="payment.php" class="btn btn-success">นำออก</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
