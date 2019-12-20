<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));

                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dmango</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="style.css" type="text/css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-collapse layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index.php" class="nav-link">Menu</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="offers.php" class="nav-link">Offers</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="feedback.php" class="nav-link">Feedback</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
            <img src="adminlte/dist/img/Letter-D-icon.png"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">mango</span>
        </a>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="user/login.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Login
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="offers.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Offers
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="feedback.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Feedback
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-7">
                    <div id="product-grid">
                        <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");
                        if (!empty($product_array)) {
                            foreach($product_array as $key=>$value){
                                ?>
                                <div class="product-item">
                                    <form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                                            <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="shopping-cart">
                        <div class="txt-heading">Shopping Cart</div>

                        <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
                        <?php
                        if(isset($_SESSION["cart_item"])){
                            $total_quantity = 0;
                            $total_price = 0;
                            ?>
                            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                                <tbody>
                                <tr>
                                    <th style="text-align:left;">Name</th>
                                    <th style="text-align:left;">Code</th>
                                    <th style="text-align:right;" width="5%">Quantity</th>
                                    <th style="text-align:right;" width="10%">Unit Price</th>
                                    <th style="text-align:right;" width="10%">Price</th>
                                    <th style="text-align:center;" width="5%">Remove</th>
                                </tr>
                                <?php
                                foreach ($_SESSION["cart_item"] as $item){
                                    $item_price = $item["quantity"]*$item["price"];
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                                        <td><?php echo $item["code"]; ?></td>
                                        <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                                        <td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
                                        <td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
                                        <td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
                                    </tr>
                                    <?php
                                    $total_quantity += $item["quantity"];
                                    $total_price += ($item["price"]*$item["quantity"]);
                                }
                                ?>

                                <tr>
                                    <td colspan="2" align="right">Total:</td>
                                    <td align="right"><?php echo $total_quantity; ?></td>
                                    <td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="no-records">Your Cart is Empty</div>
                            <?php
                        }
                        ?>
                        <br>
                        <a href="menu.php" class="btnAddAction">Order Now</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Food Ordering System</b>
    </div>
    <strong>Copyright &copy; 2019 <a href="https://www.sm-asad.com">Dmango</a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="adminlte/dist/js/demo.js"></script>

</body>
</html>