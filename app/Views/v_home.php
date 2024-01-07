<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <?php 
            if(session()->getFlashdata('pesan')) { 
              echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
              echo session()->getFlashdata('pesan');
              echo '</div>';
            }?>
          </div>

          <?php foreach ($barang as $key => $value){ ?>

        <div class="col-lg-4">

          <?php 
          echo form_open('home/add'); 
          echo form_hidden('id', $value['id_barang']);
          echo form_hidden('price', $value['harga']);
          echo form_hidden('name', $value['nama_barang']);
          //option
          echo form_hidden('gambar', $value['gambar']);
          ?>

            <div class="card">
              <div class="card-body text-center">
                <h5 class="card-title"><?= $value['nama_barang']?></h5>

                <p class="card-text mt-5">
                  <img src="<?= base_url('gambar/' . $value['gambar']) ?>" alt="" height="180px" width="100%" style="object-fit: cover;">
                </p>

               <label><?= number_to_currency($value['harga'], 'IDR'); ?></label><br>
                <button type="submit" class="btn btn-success btn-sm "><i class="fa fa-shopping-basket mr-2"></i> Add</button>
              </div>
            </div>
            <?php echo form_close();?>
        </div>
        <?php } ?>
    </div>
</div>

