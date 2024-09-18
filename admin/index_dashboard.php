<?php 

    //จำนวนหมวดหมู่สินค้า
    $stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalView FROM tbl_type");
    $stmtCountCounter->execute();
    $rowC = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

    //จำนวนสมาชิก
    $stmtCountMember = $condb->prepare("SELECT COUNT(*) as totalMember FROM tbl_member");
    $stmtCountMember->execute();
    $rowM = $stmtCountMember->fetch(PDO::FETCH_ASSOC);

    //จำนวนสินค้า
    $stmtCountProduct = $condb->prepare("SELECT COUNT(*) as totalProduct FROM tbl_product");
    $stmtCountProduct->execute();
    $rowP = $stmtCountProduct->fetch(PDO::FETCH_ASSOC);

    // จำนวนสินค้าที่เหลือน้อยกว่า 10 ชิ้น
    $stmtCountLowStock = $condb->prepare("SELECT COUNT(*) as lowStock FROM tbl_product WHERE product_qty < 10");
    $stmtCountLowStock->execute();
    $rowLowStock = $stmtCountLowStock->fetch(PDO::FETCH_ASSOC);

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3> <?=$rowC['totalView'];?> </h3>

                                            <p>หมวดหมู่</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-pricetags-outline"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">เพิ่มเติม <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3> <?=$rowM['totalMember'];?> </h3>

                                            <p>สมาชิก</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-stalker"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">เพิ่มเติม <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><?=$rowP['totalProduct'];?></h3>
                                            <p>สินค้า</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">เพิ่มเติม <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3> <?=$rowLowStock['lowStock'];?> </h3>

                                            <p>แจ้งเตือนสินค้าเหลือน้อย</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">เพิ่มเติม <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->