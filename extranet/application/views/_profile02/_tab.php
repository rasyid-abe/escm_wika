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
            $status_aktivasi = $this->db->select("reg_status_id")
            ->where('vendor_id', $this->session->userdata('userid'))
            ->get("vnd_header")->row()->reg_status_id;
            if ($status_aktivasi == '14') { ?>

            <div class="alert bg-light-info" role="alert">
                <h4>Terima kasih, data sedang ditinjau</h4>
                <p>Mohon tunggu beberapa saat</p>
            </div>
            
        <?php } if ($status_aktivasi == '8') { ?>
            <div class="alert bg-light-success" role="alert">
                <h4>Selamat akun Anda telah aktif</h4>
                <p>Silahkan login kembali</p>
            </div>
        <?php } ?>

        <div class="section-tab" style="overflow: auto;white-space: nowrap">
            <a href="<?php echo site_url('registrasi_perorangan/utama'); ?>" class="<?php echo $menu == 'utama' ? $active : $inactive; ?>">Utama</a>
            <a href="<?php echo site_url('registrasi_perorangan/pendidikan'); ?>" class="<?php echo $menu == 'pendidikan' ? $active : $inactive; ?>">Pendidikan</a>
            <a href="<?php echo site_url('registrasi_perorangan/pengalaman_cv'); ?>" class="<?php echo $menu == 'pengalaman_cv' ? $active : $inactive; ?>">Pengalaman</a>
            <a href="<?php echo site_url('registrasi_perorangan/pelatihan'); ?>" class="<?php echo $menu == 'pelatihan' ? $active : $inactive; ?>">Pelatihan</a>
            <a href="<?php echo site_url('registrasi_perorangan/catatan'); ?>" class="<?php echo $menu == 'catatan' ? $active : $inactive; ?>">Catatan</a>
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