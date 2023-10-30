<div class="row">
    <div class="col-12">
        <?php
            $link = $_SERVER['PHP_SELF'];
            $link_array = explode('/', $link);
            $menu = end($link_array);
            $active = 'badge badge-info mt-1';
            $inactive = 'badge badge-secondary mt-1';
        ?>
        <style>
            .section-tab {
                max-height: 250px;
                padding: 1rem;
                overflow-y: auto;
                direction: ltr;
                scrollbar-color: #d4aa70 #e4e4e4;
                scrollbar-width: thin;
            }

            .section-tab::-webkit-scrollbar {
                width: 20px;
            }

            .section-tab::-webkit-scrollbar-track {
                background-color: #e4e4e4;
                border-radius: 100px;
            }

            .section-tab::-webkit-scrollbar-thumb {
                border-radius: 100px;
                border: 5px solid transparent;
                background-clip: content-box;
                background-color: #2F8BE6;
            }
        </style>
        <?php 
            $data = $this->db->select("reg_status_id, mu_nilai")
            ->where('vendor_id', $this->session->userdata('userid'))
            ->get("vnd_header")->row_array();
            if ($data['reg_status_id'] == '14') { ?>

            <div class="alert bg-light-info" role="alert">
                <h4>Terima kasih, data sedang ditinjau</h4>
                <p>Mohon tunggu beberapa saat</p>
            </div>
            
        <?php } if ($data['reg_status_id'] == '8') { ?>
            <div class="alert bg-light-success" role="alert">
                <h4>Selamat akun Anda telah aktif</h4>
                <p>Silahkan login kembali</p>
            </div>
        <?php } ?>

        <?php if (!isset($data['mu_nilai'])) { ?>
            <div class="alert bg-light-info" role="alert">
                <h5>Lengkapi data tambahan terlebih dahulu. <a href="<?php echo site_url('registrasi_luar_negeri/tambahan');?>" class="text-bold-700">Klik disini.</a></h5>
            </div>
        <?php } ?>

        <div class="section-tab" style="overflow: auto;white-space: nowrap">
            <a href="<?php echo site_url('registrasi_luar_negeri/utama'); ?>" class="<?php echo $menu == 'utama' ? $active : $inactive; ?>">Utama</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/legal'); ?>" class="<?php echo $menu == 'legal' ? $active : $inactive; ?>">Legal</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/pajak'); ?>" class="<?php echo $menu == 'pajak' ? $active : $inactive; ?>">Pajak</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/keuangan'); ?>" class="<?php echo $menu == 'keuangan' ? $active : $inactive; ?>">Keuangan</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/saham'); ?>" class="<?php echo $menu == 'saham' ? $active : $inactive; ?>">Saham</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/pengurus'); ?>" class="<?php echo $menu == 'pengurus' ? $active : $inactive; ?>">Pengurus</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/personil'); ?>" class="<?php echo $menu == 'personil' ? $active : $inactive; ?>">Personil</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/pengalaman'); ?>" class="<?php echo $menu == 'pengalaman' ? $active : $inactive; ?>">Pengalaman</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/peralatan'); ?>" class="<?php echo $menu == 'peralatan' ? $active : $inactive; ?>">Fasilitas/Peralatan</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/produk'); ?>" class="<?php echo $menu == 'produk' ? $active : $inactive; ?>">Produk</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/katalog'); ?>" class="<?php echo $menu == 'katalog' ? $active : $inactive; ?>">e-Katalog</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/tambahan'); ?>" class="<?php echo $menu == 'tambahan' ? $active : $inactive; ?>">Data Tambahan</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/catatan'); ?>" class="<?php echo $menu == 'catatan' ? $active : $inactive; ?>">Catatan</a>
            <a href="<?php echo site_url('registrasi_luar_negeri/documents'); ?>" class="<?php echo $menu == 'documents' ? $active : $inactive; ?>">Documents</a>
        </div>
    </div>
</div>

<script>
    // Restricts input for the given textbox to the given inputFilter.
    function setInputFilter(textbox, inputFilter) {
        ["input"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
            this.value = "";
            }
        });
        });
    }

    // Install input filters.
    setInputFilter(document.getElementById("telp_inp"), function(value) {
        return /^-?\d*$/.test(value);
    });

    function getMaxDataNo(selector) {
        var min = null,
            max = null;
        $(selector).each(function() {
            var no_pp = parseInt($(this).attr('data-no'), 10);
            if ((max === null) || (no_pp > max)) {
                max = no_pp;
            }
        });
        return max;
    }
</script>