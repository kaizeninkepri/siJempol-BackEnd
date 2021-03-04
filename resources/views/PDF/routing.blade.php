<html>
    <title>{{$p->izin->nama_izin}}</title>
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
                        {{$p->perusahaan->npwp}}<br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Nama Perusahaan</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        {{$p->perusahaan->fullname}}<br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Tanggal Pengajuan</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        {{$p->created_at}}<br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Izin</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        {{$p->izin->nama_izin}}<br/>
                    </td>
                </tr>
                <tr>
                    <td class="Valign">Pemohon</td>
                    <td class="Valign">&nbsp;&nbsp; : &nbsp;&nbsp;</td>
                    <td class="Valign">
                        {{$p->pengurus->nama}}<br/>
                    </td>
                </tr>
            </table>
            </div>
            <div style="float: right">
            <img src="data:image/png;base64, {!! $qrCode !!}">
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
                   @foreach($p->persyaratan as $e => $i)
                    <tr>
                        <td class="text-bold"><center>{{$e+1}}</center></td>
                        <td>{{$i->persyaratan}}</td>
                        <td class="text-center"><div style="font-family: ZapfDingbats, sans-serif;">4</div></td>
                    </tr>
                    @endforeach   
                <tbody>
        </table>
           
        <br/><br/>
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                {{$fo->pesan}} <br/>
                <span class="text-bold">{{$fo->petugas->name}}</span><br/>
                <span class="text-bold">{{$fo->created_at}}</span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, {!! $foqrCode !!}">
            </div>
            <div style="clear:both"></div>
         </div>
         @if($bo)
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                {{$bo->pesan}}<br/>
                <span class="text-bold">{{$bo->petugas->name}}</span><br/>
                <span class="text-bold">{{$bo->created_at}}</span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, {!! $boqrCode !!}">
            </div>
            <div style="clear:both"></div>
         </div>

         <div class="qrPetugas">
            <div style="float: left; width:85%">
                {{$opd1->pesan}}<br/>
                <span class="text-bold">{{$opd1->petugas->name}}</span><br/>
                <span class="text-bold">{{$opd1->created_at}}</span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, {!! $opdqrCode !!}">
            </div>
            <div style="clear:both"></div>
         </div>
         @endif
          @if($opd)
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                {{$opd->pesan}}<br/>
                <span class="text-bold">{{$opd->petugas->name}}</span><br/>
                <span class="text-bold">{{$opd->created_at}}</span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, {!! $opdqrCode !!}">
            </div>
            <div style="clear:both"></div>
         </div>
         @endif

           @if($kabid)
         <div class="qrPetugas">
            <div style="float: left; width:85%">
                {{$kabid->pesan}}<br/>
                <span class="text-bold">{{$kabid->petugas->name}}</span><br/>
                <span class="text-bold">{{$kabid->created_at}}</span>
            </div>
            <div style="float: right; width:10%; text-align=right">
             <img src="data:image/png;base64, {!! $opdqrCode !!}">
            </div>
            <div style="clear:both"></div>
         </div>
         @endif

         
        <br/><br/>

        @php(date_default_timezone_set("Asia/Bangkok"))
        @php($data = date("d/m/Y H:i:s"))
        di print pada tanggal : {{$data}}
        </div>
    </body>
</html>