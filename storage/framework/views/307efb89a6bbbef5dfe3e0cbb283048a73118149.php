<html>
    <title><?php echo e($p->izin->nama_izin); ?></title>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <style type="text/css">
        @page{
            size:21cm 27cm;
        }
        .page_break { page-break-before: always; }
            
        html{
            background-color: black;
            margin: 10px;
            padding: 0;
            font-size:12px;
            font-family: "Arial, Helvetica, sans-serif";
        }
        .header{
            width:21cm;
            clear:both;
                
        } 
        .judul {
            font-size:13px;
            font-weight:bold;           
                
        }
        .text-bold{
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align:center;
        }
        .kiriBawah{
            font-style:italic;
            top:-100px;
        }
        .content{
            padding:10px;
            display:inline;
        }
        #tableBO{
            border-collapse: collapse;
            border: 1px solid #eee;
            width: 100%;
        }
         #tableBO th{
            padding : 5px;
            border: 1px solid #333;
            text-align: center;
        }
        #tableBO td{
            padding : 5px;
            border: 1px solid #333;
        }
        .Valign{
            vertical-align: top !important;
        }
        .persyaratan{
            border-collapse: collapse;
            border: 1px solid #333;
            width: 100%;
        }

        .persyaratan th{
            border: 1px solid #333;
            padding: 5px;
        }
        .persyaratan td{
            border: 1px solid #333;
            padding: 5px;
        }
        .qrPetugas {
            width: 100%;
            padding : 10px;
            border : 1px solid green;
            border-radius : 5px;
            margin-top:10px;
        }
    </style>
    <body>
        <div class="header">
         <img src="http://localhost/2021/siJempol/BackEnd/public/images/cop_surat.png" />
        </div>
        <div style="padding:20px">
            <center class="judul">Routing Slip<br/> DPMPTSP PROVINSI KEPULAUAN RIAU</center>
            <br/><br/>
            <div style="width:60%; float:left">
            <table>
                <tr>
                    <td class="Valign">NPWP Perusahaan</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        <?php echo e($p->perusahaan->npwp); ?><br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Nama Perusahaan</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        <?php echo e($p->perusahaan->fullname); ?><br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Tanggal Pengajuan</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        <?php echo e($p->created_at); ?><br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Izin</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        <?php echo e($p->izin->nama_izin); ?><br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Pemohon</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        <?php echo e($p->pengurus->nama); ?><br/>
                    </td>
                </tr>
            </table>
            </div>
            <div style="float: right">
            <img src="data:image/png;base64, <?php echo $qrCode; ?>">
            </div>
            <div style="clear:both"></div>
            <br/><br/>
            <table class="persyaratan">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Persyaratan</th>
                    <th>Kelengkapan</th>
                </tr>
               </thead>
               <tbody>
                   <?php $__currentLoopData = $p->persyaratan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-bold"><center><?php echo e($e+1); ?></center></td>
                        <td><?php echo e($i->persyaratan); ?></td>
                        <td class="text-center"><div style="font-family: ZapfDingbats, sans-serif;">4</div></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                <tbody>
        </table>
           
        <br/><br/>
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                <?php echo e($fo->pesan); ?> <br/>
                <span class="text-bold"><?php echo e($fo->petugas->name); ?></span><br/>
                <span class="text-bold"><?php echo e($fo->created_at); ?></span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, <?php echo $foqrCode; ?>">
            </div>
            <div style="clear:both"></div>
         </div>
         <?php if($bo): ?>
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                <?php echo e($bo->pesan); ?><br/>
                <span class="text-bold"><?php echo e($bo->petugas->name); ?></span><br/>
                <span class="text-bold"><?php echo e($bo->created_at); ?></span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, <?php echo $boqrCode; ?>">
            </div>
            <div style="clear:both"></div>
         </div>

         <div class="qrPetugas">
            <div style="float: left; width:85%">
                <?php echo e($opd1->pesan); ?><br/>
                <span class="text-bold"><?php echo e($opd1->petugas->name); ?></span><br/>
                <span class="text-bold"><?php echo e($opd1->created_at); ?></span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, <?php echo $opdqrCode; ?>">
            </div>
            <div style="clear:both"></div>
         </div>
         <?php endif; ?>
          <?php if($opd): ?>
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                <?php echo e($opd->pesan); ?><br/>
                <span class="text-bold"><?php echo e($opd->petugas->name); ?></span><br/>
                <span class="text-bold"><?php echo e($opd->created_at); ?></span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, <?php echo $opdqrCode; ?>">
            </div>
            <div style="clear:both"></div>
         </div>
         <?php endif; ?>

           <?php if($kabid): ?>
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                <?php echo e($kabid->pesan); ?><br/>
                <span class="text-bold"><?php echo e($kabid->petugas->name); ?></span><br/>
                <span class="text-bold"><?php echo e($kabid->created_at); ?></span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, <?php echo $opdqrCode; ?>">
            </div>
            <div style="clear:both"></div>
         </div>
         <?php endif; ?>

         
        <br/><br/>

        <?php (date_default_timezone_set("Asia/Bangkok")); ?>
        <?php ($data = date("d/m/Y H:i:s")); ?>
        di print pada tanggal : <?php echo e($data); ?>

        </div>
    </body>
</html><?php /**PATH /var/www/html/2021/siJempol/BackEnd/resources/views/PDF/routing.blade.php ENDPATH**/ ?>