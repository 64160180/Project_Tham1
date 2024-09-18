<?php
session_start();

require_once '../config/condb.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning' role='alert'>
            <h4 class='alert-heading'>รถเข็นของคุณยังไม่มีสินค้า</h4>
            <p><a href='product.php' class='btn btn-primary'>กลับไปยังหน้าสินค้า</a></p>
          </div>";
    exit();
}

$cartItems = $_SESSION['cart'];
$productIds = implode(',', array_keys($cartItems));

$query = $condb->prepare("SELECT * FROM tbl_product WHERE id IN ($productIds)");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>ชำระเงิน</h2>
        <table class="table table-bordered">
            <thead>
                <tr class="table-info">
                    <th>ชื่อสินค้า</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>ราคาทุน</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                    <th>กำไร</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalPrice = 0;
                $totalCost = 0;
                $totalProfit = 0;
                foreach ($products as $product): 
                    $quantity = $cartItems[$product['id']];
                    $total = $product['product_price'] * $quantity;
                    $cost = $product['cost_price'] * $quantity;
                    $profit = $total - $cost;
                    
                    $totalPrice += $total;
                    $totalCost += $cost;
                    $totalProfit += $profit;
                ?>
                <tr>
                    <td><?= $product['product_name']; ?></td>
                    <td><?= number_format($product['product_price'], 2); ?> บาท</td>
                    <td><?= number_format($product['cost_price'], 2); ?> บาท</td>
                    <td><?= $quantity; ?></td>
                    <td><?= number_format($total, 2); ?> บาท</td>
                    <td><?= number_format($profit, 2); ?> บาท</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <h3>ยอดรวมทั้งหมด: <?= number_format($totalPrice, 2); ?> บาท</h3>
            <h4>ต้นทุนรวม: <?= number_format($totalCost, 2); ?> บาท</h4>
            <h4>กำไรรวม: <?= number_format($totalProfit, 2); ?> บาท</h4>
            <form action="process_payment.php" method="POST">
                <a href="cart.php" class="btn btn-primary">กลับไปยังรถเข็น</a>
                <button type="submit" class="btn btn-success">ยืนยันการนำออก</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
