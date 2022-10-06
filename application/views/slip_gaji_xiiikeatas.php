<html>
    <head>
        <meta charset="utf-8">
        <title>SLIP GAJI</title>
    </head>

    <style type="text/css">
        .capitalize { text-transform: capitalize; }
        .uppercase { text-transform: uppercase; }
    </style>
    <script type="text/javascript">

    </script>

    <?php
        //pot btn
        if($pot_btn == null || $pot_btn == '' || !$pot_btn == 0 || $pot_btn == '-'){
          $tb_pot_btnsolo = "";

        }else{
          $tb_pot_btnsolo = "<tr><td style='padding-left: 10px;'> Potongan BTN</td><td>: </td><td>Rp.</td><td align='right'>".$pot_btn."</td></tr>";
        }
        //ket RS
        if($potongan_rs == null || $potongan_rs == '' || !$potongan_rs == 0 || $potongan_rs == '-'){
          $tb_ket_potonganRS = "";

        }else{          
          $tb_ket_potonganRS = "<tr><td style='padding-left: 10px;'>Potongan RS</td><td>: </td><td>Rp.</td><td align='right'>".$potongan_rs."</td></tr>";
        }

        if($pot_jkn_kelg == 0 || $pot_jkn_kelg == "" || $pot_jkn_kelg == null || !$pot_jkn_kelg ){
          $tb_potJKNKelg = "";
        }else{
          $tb_potJKNKelg = "<tr><td style='padding-left: 10px;'>Potongan JKN Keluarga</td><td>:</td><td>Rp.</td><td align='right'>".$pot_jkn_kelg."</td></tr>";
        }

        if($pot_koperasi == 0 || $pot_koperasi == "" || $pot_koperasi == null || !$pot_koperasi ){
          $tb_potKoperasi = "";
        }else{
          $tb_potKoperasi = "<tr><td style='padding-left: 10px;'>Potongan Koperasi</td><td>:</td><td>Rp.</td><td align='right'>".$pot_koperasi."</td></tr>";
        }

        if($nominal_lain == 0 || $nominal_lain == "" || $nominal_lain == null || !$nominal_lain ){
          $tb_ket_lain = "";
        }else{
          $tb_ket_lain = "<tr><td style='padding-left: 10px;'>".$ket_lain."</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_lain."</td></tr>";
        }

        if($ket_btn_solo == null || $ket_btn_solo == '' || !$ket_btn_solo || $ket_btn_solo == '-'){
          $tb_ket_btnsolo = "";
          
        }else{
          $tb_ket_btnsolo = "<tr><td style='padding-left: 10px;'>".$ket_btn_solo."</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_btnsolo."</td></tr>";
        }

        

        if($bulan == "01"){
          $nama_bulan = "Jan";
        }elseif ($bulan == "02") {
          $nama_bulan = "Feb";
        }elseif ($bulan == "03") {
          $nama_bulan = "Mar";
        }elseif ($bulan == "04") {
          $nama_bulan = "Apr";
        }elseif ($bulan == "05") {
          $nama_bulan = "Mei";
        }elseif ($bulan == "06") {
          $nama_bulan = "Jun";
        }elseif ($bulan == "07") {
          $nama_bulan = "Jul";
        }elseif ($bulan == "08") {
          $nama_bulan = "Ags";
        }elseif ($bulan == "09") {
          $nama_bulan = "Sep";
        }elseif ($bulan == "10") {
          $nama_bulan = "Okt";
        }elseif ($bulan == "11") {
          $nama_bulan = "Nov";
        }else{
          $nama_bulan = "Des";
        }
    ?>

    <body class="page" style="background-image: url(<?php echo base_url(); ?>assets/images/bgprint5.png);background-repeat: no-repeat; background-position: center; background-size: 100%; ">
        <div style="text-align: center;">

            <table width="100%" style="padding-bottom: 2px;">
              <tr>
                <td width="10%"><img src="<?php echo base_url(); ?>/assets/images/logo dr oen back putih.png" width="40px" height="40px"></td>
                <td width="40%" style="font-size: 7px;"><b>RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO</b><br>Jl. Brigjend Katamso No.55 Surakarta 57128</td>
                <td></td>
                <td width="50%" style="font-size: 8px;border: 1;border-width: thin;padding: 1px;" align="center"><b>PERINCIAN GAJI BULAN : <br><?php echo $nama_bulan; ?> <?php echo $tahun; ?></b></td></tr>
            </table>

            <table style="font-size: 8px;padding-bottom: 1px;" width="100%">
              <tr><td width="15%">Nama / NIK</td><td>:</td><td width="84%"><?php echo $nama; ?> / <?php echo $nik; ?></td></tr>
              <tr><td width="15%">Bagian </td><td>:</td><td width="84%"><?php echo $bagian; ?></td></tr>
              <tr><td colspan="3"><hr color="black"></td></tr>
            </table>


            <table style="font-size: 8px; border-spacing: 0px;" width="90%">
              <tr><td>Gaji Pokok </td><td>:</td><td>Rp.</td><td align="right"><?php echo $gaji_pokok; ?></td></tr>
              <tr><td>Tunj. Struktural </td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_struktural; ?></td></tr>
              <tr><td>Tunj. Khusus</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_khusus; ?></td></tr>
              <tr><td>Tunj. Alih Sistem</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_alih_sistem; ?></td></tr>
              <tr><td>Penyesuaian</td><td>:</td><td>Rp.</td><td align="right"><?php echo $penyesuaian; ?></td></tr>

              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;+</b></td></tr>
              <tr><td>Gross</td><td>:</td><td>Rp.</td><td align="right"><?php echo $gross; ?></td></tr>
              <tr><td>Honor</td><td>:</td><td>Rp.</td><td align="right"><?php echo $honor; ?></td></tr>
              <tr><td>THR</td><td>:</td><td>Rp.</td><td align="right"><?php echo $thr; ?></td></tr>
              <!-- <tr><td>Dinas Malam</td><td>:</td><td>Rp.</td><td align="right"><?php echo $dinas_malam; ?></td></tr> -->
              <tr><td>Lembur</td><td>:</td><td>Rp.</td><td align="right"><?php echo $lembur; ?></td></tr>
              <tr><td>Lain-lain/Rapel</td><td>:</td><td>Rp.</td><td align="right"><?php echo $lainlain_rapel; ?></td></tr>
              <tr><td>Insentif</td><td>:</td><td>Rp.</td><td align="right"><?php echo $insentif; ?></td></tr>
              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;+</b></td></tr>
              <tr><td>Total Gross</td><td>:</td><td>Rp.</td><td align="right"><?php echo $total_gross; ?></td></tr>
              <tr><td>Potongan JHT</td><td>:</td><td>Rp.</td><td align="right"><?php echo $potongan_jht; ?></td></tr>
              <tr><td>Potongan JP</td><td>:</td><td>Rp.</td><td align="right"><?php echo $potongan_jp; ?></td></tr>
              <tr><td>Pph 21</td><td>:</td><td>Rp.</td><td align="right"><?php echo $pph21; ?></td></tr>
              <tr><td>Potongan JKN</td><td>:</td><td>Rp.</td><td align="right"><?php echo $potongan_jkn; ?></td></tr>
              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;-</b></td></tr>
              <tr><td>THP Bulat</td><td>:</td><td>Rp.</td><td align="right"><?php echo $thp_bulat; ?></td></tr>
              <tr><td colspan="4"></br></td></tr>
              <tr><td colspan="4"><b><u>Potongan :</u><b></td></tr>
              <?php echo $tb_pot_btnsolo; ?>
              <?php echo $tb_potJKNKelg; ?> 
              <?php echo $tb_potKoperasi; ?> 
              <?php echo $tb_ket_btnsolo;?>
              <?php echo $tb_ket_potonganRS;?> 
              
              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;-</b></td></tr>
              <tr><td>Jml Potongan</td><td>:</td><td>Rp.</td><td align="right"><?php echo $jml_potongan; ?></td></tr>
              <tr><td width="30px" colspan="4"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;-</b></td></tr>

              <!-- <?php echo $tabel_ekstra; ?> -->
              <tr><td>Terima Bersih</td><td>:</td><td>Rp.</td><td align="right"><?php echo $jumlah_terima; ?></td></tr>
              <tr><td>Transfer ke CIMB Niaga</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tf_cimb_niaga; ?></td></tr>
              <tr><td>Transfer ke BCA</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tf_bca; ?></td></tr>
              
            </table>
        </div>
        
        <p style="font-size: 8px;"><i>*) <?php echo $info; ?></i></p>
        <p style="font-size: 7px;position: fixed;bottom: 0;right: 0;">Printed :     <?php echo $datetime;?></p>
    
    </body>
</html>