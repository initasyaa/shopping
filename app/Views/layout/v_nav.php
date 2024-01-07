<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="<?= base_url('') ?>" class="navbar-brand">
      <img src="<?=base_url()?>/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Online Shop</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="<?= base_url('') ?>" class="nav-link">Home</a>
        </li>
       <!--  <li class="nav-item">
          <a href="<?= base_url('') ?>" class="nav-link">Contact</a>
        </li> -->

      </ul>


    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <!-- Messages Dropdown Menu -->
      <?php
      $keranjang = $cart->contents();
      $jml_item = 0;
      foreach ($keranjang as $key => $value) {
        $jml_item = $jml_item + $value['qty'];
      }
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge"><?= $jml_item ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <?php if (empty($keranjang)) { ?>
            <a href="#" class="dropdown-item">
              <p>Keranjang Belanja Kosong</p>
            </a>
          <?php } else { ?>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->

              <?php foreach ($keranjang as $key => $value) { ?>

                <div class="media">
                  <img src="<?= base_url('gambar/' . $value['options']['gambar']) ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      <?= $value['name']?>
                     
                    </h3>
                    <p class="text-sm text-muted">Sub Total : <?=number_to_currency($value['subtotal'], 'IDR');?></p>
                    
                    <p class="text-sm text-muted">qty: <?=$value['qty']?></p>
                  </div>
                </div>
              <?php } ?>
            </a>
            <!-- Message End -->

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Total : <?=number_to_currency($cart->total(), 'IDR');?></a>
            <a href="<?=base_url('home/cart')?>" class="dropdown-item dropdown-footer">View Cart</a>
            <a href="#" class="dropdown-item dropdown-footer">Checkout</a>
          <?php } ?>


        </div>
      </li>
    </ul>
  </div>
</nav>
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> <?= $title ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->