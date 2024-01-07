<style>
    .card {
        margin-bottom: 20px;
    }
</style>
<div class="content">
    <div class="container">
        <?php
        if (session()->getFlashdata('pesan')) {
            echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            echo session()->getFlashdata('pesan');
            echo '</div>';
        } ?>
        <?php echo form_open('home/update'); ?>
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                        <small class="float-right">Date: 2/10/2014</small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="100px">Qty</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($cart->contents() as $key => $value) { ?>
                                <tr>
                                    <td><input type="number" min=1 name="qty<?= $i++ ?>" class="form-control" value="<?= $value['qty'] ?>"></td>
                                    <td><?= $value['name'] ?></td>
                                    <td><?= number_to_currency($value['price'], 'IDR'); ?></td>
                                    <td><?= number_to_currency($value['subtotal'], 'IDR'); ?></td>
                                    <td><a href="<?= base_url('home/delete/' . $value['rowid']) ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
    <!-- accepted payments column -->
    <div class="col-6">
    </div>
    <!-- /.col -->
    <div class="col-6">
        <p class="lead">
            <button type="button" class="btn btn-block btn-outline-info" data-toggle="modal" data-target="#voucherModal">
                Pilih Voucher
            </button>
        </p>

        <div class="table-responsive">
            <table class="table">
            <tr>
                    <th style="width:50%">Total :</th>
                    <td id="totalAmount"><?= number_to_currency($cart->total(), 'IDR'); ?></td>
                </tr>
                <tr>
                    <th>Voucher</th>
                    <td id="selectedVoucher">-</td>
                </tr>
                <tr>
                    <th style="width:50%">Grand Total :</th>
                    <td id="totalAmount" data-original-total="<?= $cart->total(); ?>" class="total-belanja"><?= number_to_currency($cart->total(), 'IDR'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- this row will not appear when printing -->
<div class="row no-print">
    <div class="col-12">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        <a href="<?= base_url('home/clear/') ?>" class="btn btn-warning"><i class="fas fa-trash"></i> Reset</a>
        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Chekout
        </button>
    </div>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div>

<!-- Modal Voucher -->
<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherModalLabel">Pilih Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Voucher Belanja</h5>
                                <p class="card-text">Dapatkan potongan senilai 10rb untuk setiap pembelian minimal 2 juta. Berlaku untuk 3 bulan.</p>
                                <button class="btn btn-primary btn-sm" onclick="selectVoucher('Voucher Belanja')">Pilih</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Voucher ShopeePay</h5>
                                <p class="card-text">Dapatkan potongan 1rb setiap pembayaran menggunakan ShopeePay.</p>
                                <button class="btn btn-primary btn-sm" onclick="selectVoucher('Voucher ShopeePay')">Pilih</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menangani pemilihan voucher -->
<script>
    // Variabel untuk menyimpan nilai voucher
    let voucherValues = {
        'Voucher Belanja': 10000, // Nilai voucher belanja = 10rb
        'Voucher ShopeePay': 1000 // Nilai voucher ShopeePay = 1rb
    };

    function selectVoucher(voucherName) {
    // Lakukan sesuatu dengan voucher yang dipilih (misalnya, menyimpan ke variabel atau melakukan operasi tertentu)
    let voucherCode = '';

    // Logika untuk menentukan kode unik berdasarkan voucher yang dipilih
    if (voucherName === 'Voucher Belanja') {
        let totalBelanjaAsli = parseFloat($('.total-belanja').data('original-total'));
        if (totalBelanjaAsli >= 2000000) {
            voucherCode = generateUniqueVoucherCode();
        } else {
            // Tampilkan alert jika total belanja kurang dari 2jt
            alert('Maaf, total belanja tidak memenuhi syarat untuk menggunakan voucher ini.');
            return;
        }
    } else if (voucherName === 'Voucher ShopeePay') {
        voucherCode = generateUniqueVoucherCode();
    }

    // Set nilai voucher pada elemen dengan id "selectedVoucher"
    let voucherAmount = voucherValues[voucherName];
    let formattedVoucherAmount = '- ' + formatCurrency(voucherAmount);
    $('#selectedVoucher').html(formattedVoucherAmount);

    // Dapatkan total belanja asli sebelum voucher dimasukkan
    let totalBelanjaAsli = parseFloat($('.total-belanja').data('original-total'));

    // Hitung total belanja setelah memasukkan voucher
    let finalTotal = totalBelanjaAsli - voucherAmount;

    // Setelah mendapatkan nilai diskon, lakukan sesuatu dengan total belanja (misalnya, memperbarui tampilan halaman)
    $('.total-belanja').text(formatCurrency(finalTotal));

    // Tutup modal setelah memilih voucher
    $('#voucherModal').modal('hide');

    // Ganti teks pada tombol "Pilih Voucher" dengan kode unik dari masing-masing voucher yang dipilih
    $('.btn-outline-info').html(voucherCode);
}


    // Fungsi untuk memformat mata uang
    function formatCurrency(amount) {
        return 'IDR ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Fungsi untuk menghasilkan kode unik
    function generateUniqueVoucherCode(length = 6) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let voucherCode = '';

        for (let i = 0; i < length; i++) {
            voucherCode += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        return voucherCode;
    }
</script>
