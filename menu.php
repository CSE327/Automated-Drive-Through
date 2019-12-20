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
                    <a href="../gallery.html" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Offers
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../gallery.html" class="nav-link">
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

                <div class="col-lg-6">
                    <?php
                    require 'connect.php';
                    $result = mysqli_query($con, 'select * from product');
                    ?>
                    <table class="tbl-cart" cellpadding="10" cellspacing="1">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>Buy</th>
                        </tr>
                        <?php while($product = mysqli_fetch_object($result)) { ?>
                            <tr>
                                <td><?php echo $product->id; ?></td>
                                <td><?php echo $product->name; ?></td>
                                <td><?php echo $product->code; ?></td>
                                <td><?php echo $product->price; ?></td>
                                <td><a href="cart.php?id=<?php echo $product->id; ?>">Order Now</a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <div class="col-lg-6">
                    <form method="post">
                        <table cellpadding="2" cellspacing="2" border="1">
                            <tr>
                                <th>Option</th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity <input type="image" src="http://learningprogramming.net/wp-content/uploads/php-mysql//save.png"> <input
                                        type="hidden" name="update">
                                </th>
                                <th>Sub Total</th>
                            </tr>
                            <?php
                            $cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
                            $s = 0;
                            $index = 0;
                            for($i = 0; $i < count ( $cart ); $i ++) {
                                $s += $cart [$i]->price * $cart [$i]->quantity;
                                ?>
                                <tr>
                                    <td><a href="cart.php?index=<?php echo $index; ?>"
                                           onclick="return confirm('Are you sure?')">Delete</a></td>
                                    <td><?php echo $cart[$i]->id; ?></td>
                                    <td><?php echo $cart[$i]->name; ?></td>
                                    <td><?php echo $cart[$i]->price; ?></td>
                                    <td><input type="text" value="<?php echo $cart[$i]->quantity; ?>"
                                               style="width: 50px;" name="quantity[]"></td>
                                    <td><?php echo $cart[$i]->price * $cart[$i]->quantity; ?></td>
                                </tr>
                                <?php
                                $index ++;
                            }
                            ?>
                            <tr>
                                <td colspan="5" align="right">Sum</td>
                                <td align="left"><?php echo $s; ?></td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <a class="btnAddAction" href="index.php">Back to Menu</a>
                    <a class="btnAddAction" href="checkout.php">Order</a>
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