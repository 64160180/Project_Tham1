<?php
session_start();
require_once '../config/condb.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$cartItems = $_SESSION['cart'];
$productIds = implode(',', array_keys($cartItems));

$query = $condb->prepare("SELECT * FROM tbl_product WHERE id IN ($productIds)");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

// คำนวณต้นทุน กำไร และยอดรวม
$totalPrice = 0;
$totalCost = 0;
$totalProfit = 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จการชำระเงิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">ใบเสร็จการชำระเงิน</h2>
        <hr>
        <div class="mb-4">
            <h4>รายละเอียดการสั่งซื้อ:</h4>
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
                    <?php foreach ($products as $product): 
                        $quantity = $cartItems[$product['id']];
                        $total = $product['product_price'] * $quantity;
                        $cost = $product['cost_price'] * $quantity;
                        $profit = $total - $cost;

                        $totalPrice += $total;
                        $totalCost += $cost;
                        $totalProfit += $profit;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_name']); ?></td>
                        <td><?= number_format($product['product_price'], 2); ?> บาท</td>
                        <td><?= number_format($product['cost_price'], 2); ?> บาท</td>
                        <td><?= htmlspecialchars($quantity); ?></td>
                        <td><?= number_format($total, 2); ?> บาท</td>
                        <td><?= number_format($profit, 2); ?> บาท</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <h4>ยอดรวมทั้งหมด: <?= number_format($totalPrice, 2); ?> บาท</h4>
                <h4>ต้นทุนรวม: <?= number_format($totalCost, 2); ?> บาท</h4>
                <h4>กำไรรวม: <?= number_format($totalProfit, 2); ?> บาท</h4>
            </div>
        </div>
        <div class="no-print">
            <a href="cart.php" class="btn btn-primary">กลับไปยังรถเข็น</a>
            <button onclick="window.print();" class="btn btn-info">พิมพ์ใบเสร็จ</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
