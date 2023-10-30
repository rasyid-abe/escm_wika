 <?php foreach ($plandept as $key => $value) { ?>
<!-- <?php echo $key; ?>                   -->
        <?php foreach ($value as $ky => $val) { 
            if ($ky == "rkp") {   ?>                    
            <!-- PROYEK -->
              <table border="1">
                
                   <tr>
                      <td>No</td>
                      <td>SPK</td>
                      <td>J/O/KSO</td>
                      <td>Provinsi</td>
                      <td>Nilai Anggaran</td>
                   </tr> 
                
                
                  <?php $nt = 0; foreach ($val as $kp => $vp) { ?>
                   <tr>
                      <td><?php echo $kp+1; ?></td>
                      <td><?php echo $vp['spk']; ?></td>
                      <td><?php echo $vp['jo']; ?></td>
                      <td><?php echo $vp['prov']; ?></td>
                      <td><?php echo $vp['val'] ?></td>
                   </tr>
                 <?php $nt += $vp['val']; } ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td ><?php echo $nt ?></td>
                    </tr>
                
              </table>

              <br>
              <br>
              <br>
            <?php } else if ($ky == "rkap") {  ?>
           <!-- NON PROYEK -->
              <table border="1">
               
                   <tr>
                      <td>No</td>
                      <td>Mata Anggaran</td>
                      <td>Sub Anggaran</td>
                      <td>COA</td>
                      <td>Nama Perkiraan</td>
                      <td>Nilai Anggaran</td>
                   </tr> 
                
                
                   <?php $mt=0; foreach ($val as $knp => $vnp) { ?>
                   <tr>
                      <td><?php echo $knp+1 ?></td>
                      <td><?php echo $vnp['ma'] ?></td>
                      <td><?php echo $vnp['sma'] ?></td>
                      <td><?php echo $vnp['coa'] ?></td>
                      <td><?php echo $vnp['cname'] ?></td>
                      <td><?php echo $vnp['val']?></td>
                   </tr>
                   <?php $mt +=$vnp['val']; } ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td ><?php echo $mt ?></td>
                    </tr>
                
              </table>

              <br>
              <br>
              <br>
          <?php } 
        } ?>
      </div>
  </div>
<?php } ?>