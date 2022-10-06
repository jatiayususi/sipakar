<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <p style="font-family: Merriweather, serif; font-size: 25px; ">Tabel Log</p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <table class="table table-bordered table-striped tabel-apps" style="width:100%" id="mytabeldetail">
                <thead>
                     <tr bgcolor="#4682B4">
                        <th><font color="#ffffff">NO</font></th>
                        <th><font color="#ffffff">NIK</font></th>
                        <th><font color="#ffffff">DESKRIPSI</font></th>
                        <th><font color="#ffffff">TANGGAL</font></th>
                        <th><font color="#ffffff">WAKTU</font></th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                        if(!$list_log){
                        } else {
                            foreach ($list_log as $log) { ?>
                                <tr>
                                    <td><?php echo $start; ?></td>
                                    <td><?php echo $log['v_nik']; ?></td>
                                    <td><?php echo $log['v_desc']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($log['tanggal'])); ?></td>
                                    <td><?php echo $log['jam']; ?></td>
                                </tr>
                            <?php 
                                $start++;
                            }
                        }?>
                </tbody>
                </table>

            </div>
        </div>
    </div>
</div>