<?php
    
        $delimiters = array(
        ';' => 0,
        ',' => 0,
        "\t" => 0,
        "|" => 0
        );

        $handle = fopen($_FILES['perencanaan_csv']['tmp_name'], "r");
        $firstLine = fgets($handle);
        fclose($handle); 
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }

        $delimiter =  array_search(max($delimiters), $delimiters);

        $countmain=0;

        $fpmain = fopen($_FILES['perencanaan_csv']['tmp_name'],'r') or die("can't open file");
        
        while(($csv_linemain = fgetcsv($fpmain, 1000, $delimiter)) !== FALSE)
        {

         $countmain++;

            if($countmain == 1)
            {
                continue;
            }//keep this "if condition" if you want to remove the first row
            for($i = 0, $j = count($csv_linemain); $i < $j; $i++)
            {
                
                $insert_csvmain = [];
                $insert_csvmain['kode_drup'] = $csv_linemain[0];
                $insert_csvmain['nama_program'] = $csv_linemain[1];
                $insert_csvmain['kode_coa'] = $csv_linemain[2];
                $insert_csvmain['nama_coa'] = $csv_linemain[3];
                $insert_csvmain['nama_paket_pengadaan'] = $csv_linemain[4];
                $insert_csvmain['kode_biro'] = $csv_linemain[5];
                $insert_csvmain['nama_biro'] = $csv_linemain[6];
                $insert_csvmain['kode_dept'] = $csv_linemain[7];
                $insert_csvmain['nama_dept'] = $csv_linemain[8];
                $insert_csvmain['jenis_pengadaan'] = $csv_linemain[9];
                $insert_csvmain['jenis_penyedia'] = $csv_linemain[10];
                $insert_csvmain['jenis_swakelola'] = $csv_linemain[11];
                $insert_csvmain['tgl_pelaksanaan_mulai'] = $csv_linemain[12];
                $insert_csvmain['tgl_pelaksanaan_selesai'] = $csv_linemain[13];
                $insert_csvmain['tgl_pengadaan_mulai'] = $csv_linemain[14];
                $insert_csvmain['tgl_pengadaan_selesai'] = $csv_linemain[15];
                $insert_csvmain['jumlah_volume'] = str_replace(',', '.', $csv_linemain[16]);
                $insert_csvmain['satuan_volume'] = $csv_linemain[17];
                $insert_csvmain['anggaran_harsat'] = str_replace(',', '.', $csv_linemain[18]);
                $insert_csvmain['anggaran_total'] = str_replace(',', '.', $csv_linemain[19]);

                
            }

        $data[] = $insert_csvmain;

}
        
$data = json_encode($data);

$this->db->trans_begin();
$this->db->query("SELECT * FROM import_csv_simdiv('".$data."')");
if ($this->db->trans_status() === FALSE)
{   
        $this->db->trans_rollback();
        echo json_encode('fail');
}else{
        $this->db->trans_commit();
        echo json_encode('success');
}

fclose($fpmain);