<?php
// ตรวจสอบว่าเซสชันยังไม่ได้เริ่มต้น
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/condb.php';

// แสดงข้อผิดพลาด (สำหรับการพัฒนา)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// คิวรีประวัติการสั่งซื้อ
$query = $condb->prepare("SELECT * FROM tbl_order ORDER BY date_out DESC");
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">ประวัติการนำออกสินค้า</h2>
        <table class="table table-bordered">
            <thead>
                <tr class="table-info">
                    <th>วันที่</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาทุน</th>
                    <th>ราคาขาย</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): 
                    $totalPrice = $order['sell_price'] * $order['quantity'];
                ?>
                <tr>
                    <td><?= date('Y-m-d H:i:s', strtotime($order['date_out'])); ?></td>
                    <td><?= $order['product_name']; ?></td>
                    <td><?= number_format($order['cost_price'], 2); ?> บาท</td>
                    <td><?= number_format($order['sell_price'], 2); ?> บาท</td>
                    <td><?= $order['quantity']; ?></td>
                    <td><?= number_format($totalPrice, 2); ?> บาท</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
