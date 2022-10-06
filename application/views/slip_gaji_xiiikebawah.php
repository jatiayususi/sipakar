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

        //ket RS
        if($ket_rek_rs == null || $ket_rek_rs == '' || !$ket_rek_rs || $ket_rek_rs == '-'){
          $tabel_ketrs = "";

        }else{
          // $tabel_ketrs = "<table style='font-size: 10px;border:1;'><tr><td width='152px'>".$ket_rek_rs."</td><td>: </td><td>Rp.</td><td align='right' width='78px'>".$nominal_rek."</td></tr></table>";
          
          $tabel_ketrs = "<tr><td style='padding-left: 10px;'>".$ket_rek_rs."</td><td>: </td><td>Rp.</td><td align='right'>".$nominal_rek."</td></tr>";
        }

        // ket Lain-lain
        if($ket_lain == null || $ket_lain == '' || !$ket_lain || $ket_lain == '-'){
          $tabel_ketlain = "";

        }else{
          // $tabel_ketlain = "<table style='font-size: 10px;border:1;'><tr><td width='152px'>".$ket_lain."</td><td>:</td><td>Rp.</td><td align='right' width='78px'>".$nominal_lain."</td></tr></table>";
          $tabel_ketlain = "<tr><td style='padding-left: 10px;'>".$ket_lain."</td><td>: </td><td>Rp.</td><td align='right'>".$nominal_lain."</td></tr>";
        }

        // ket prr btn 
        if($ket_prr_btn == null || $ket_prr_btn == '' || !$ket_prr_btn || $ket_prr_btn == '-'){
          $tabel_ketprrbtn = "";
          
        }else{
          $tabel_ketprrbtn = "<tr><td style='padding-left: 10px;'>".$ket_prr_btn."</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_prr_btn."</td></tr>";
        }

        //ket btn solo
        if($ket_btn_solo == null || $ket_btn_solo == '' || !$ket_btn_solo || $ket_btn_solo == '-'){
          $tabel_ketbtnsolo = "";
          
        }else{
          $tabel_ketbtnsolo = "<tr><td style='padding-left: 10px;'>".$ket_btn_solo."</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_btnsolo."</td></tr>";
        }

        // nominal koperasi
        if($ket_koperasi == null || $ket_koperasi == '' || !$ket_koperasi || $ket_koperasi == '-'){
          $tabel_ketkoperasi = "";
          
        }else{
          $tabel_ketkoperasi = "<tr><td style='padding-left: 10px;'>".$ket_koperasi."</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_koperasi."</td></tr>";
        }

        // ket ekstra
        if($ket_ekstra == null || $ket_ekstra == '' || !$ket_ekstra || $ket_ekstra == '-'){
          $tabel_ekstra = "";
        }else{
          if($jenis_ekstra == "tambah"){
            $tabel_ekstra = "<tr><td>".$ket_ekstra."(+)</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_ekstra."</td></tr>";
          }else if($jenis_ekstra == "kurang"){
            $tabel_ekstra = "<tr><td>".$ket_ekstra."(-)</td><td>:</td><td>Rp.</td><td align='right'>".$nominal_ekstra."</td></tr>";
          }else{
            $tabel_ekstra = "";
          }
          
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

            <table style="font-size: 8px;border-spacing: 0px;" width="90%">
              <tr><td>Gaji Pokok </td><td>:</td><td>Rp.</td><td align="right"><?php echo $gaji_pokok; ?></td></tr>
              <tr><td>Tunj. Struktural </td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_struktural; ?></td></tr>
              <tr><td>Tunj. Khusus</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_khusus; ?></td></tr>
              <tr><td>Tunj. Alih Sistem</td><td>:</td><td>Rp.</td><td align="right"><?php echo $tunjangan_alih_sistem; ?></td></tr>
              <tr><td>Penyesuaian</td><td>:</td><td>Rp.</td><td align="right"><?php echo $penyesuaian; ?></td></tr>

              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;+</b></td></tr>
              <tr><td>Gross</td><td>:</td><td>Rp.</td><td align="right"><?php echo $gross; ?></td></tr>
              <tr><td>Dinas Malam</td><td>:</td><td>Rp.</td><td align="right"><?php echo $dinas_malam; ?></td></tr>
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
              <tr><td colspan="4"><b><u>Ket.Potongan Lain</u></b></td></tr>
              <?php echo $tabel_ketrs;?>
              <?php echo $tabel_ketlain; ?> 
              <?php echo $tabel_ketprrbtn; ?>
              <?php echo $tabel_ketbtnsolo; ?>
              <?php echo $tabel_ketkoperasi; ?> 
              <tr><td width="150px"></td><td width="30px" colspan="3"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;-</b></td></tr>
              <tr><td>Jml Potongan Lain</td><td>:</td><td>Rp.</td><td align="right"><?php echo $nominal_lain; ?></td></tr>
              <tr><td width="30px" colspan="4"><hr style="border: 1px solid #878483;"/></td><td width="30px"><b>&emsp;-</b></td></tr>
              <?php echo $tabel_ekstra; ?>
              <tr><td>Terima Bersih</td><td>:</td><td>Rp.</td><td align="right"><?php echo $jumlah_terima; ?></td></tr>
            </table>

        </div>
        <br>
        <p style="font-size: 8px;"><i>*) <?php echo $info; ?></i></p>
        <p style="font-size: 7px;position: fixed;bottom: 0;right: 0;">Printed :     <?php echo $datetime;?></p>
    </body>
    
</html>