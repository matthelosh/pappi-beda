<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu NISN</title>

    <style>
        * {
            margin:0;
            padding:0;
        }
        body {
            /* background: #efefef; */
        }
        .wrapper {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            width: 21cm;
            background: #efefef;
            margin: auto;
        }
        .card {
            background: #ffffff;
            /* padding: 20px; */
            margin:10px ;
            width: 20cm;
            height: 5cm;
            border-radius: 3px;
            /* border: 1px solid #333; */
            position: relative;
            display: flex;
            justify-content: center;
        }

        .front, .back {
            width: 10cm;
            height: 5cm;
            position: relative;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 3px;
            border: 1px solid #989898;
            
        }

        .front {
            background: url({{ asset('/img/bg_front.png') }});
            background-repeat: no-repeat;
        }
        .back {
            background: url({{ asset('/img/bg_back.png') }});
            background-repeat: no-repeat;
        }

        .text-upper {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .btn-print-kartu-nisn {
            position: fixed;
            z-index: 10;
            top: 50px;
            right: 50px;
            padding: 10px 20px;
            background: #a4d4d1;
            outline: none;
            border: none;
            box-shadow: 2px 3px 5px #a7c2c0a1;
            color: #fff;
        }
        .btn-print-kartu-nisn:hover {
            cursor: pointer;
            background: #82aeab;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        {{-- {{ dd(Session::all()) }} --}}
        @foreach($siswas as $siswa)
            <div class="card">
                <div class="front">
                    <div class="kop" style="width:100%; border-bottom: 2px double black;">
                        <img src="{{ asset('/img/tutwuri.png') }}" alt="Tutwuri" style="width: 50px; position: absolute;">
                        <h4 class="text-center text-upper">{{ Session::get('sekolah')->nama_sekolah }}</h4>
                        <p class="text-center">{{ Session::get('sekolah')->alamat }} - {{ Session::get('sekolah')->desa }}</p>
                        <p class="text-center"> Kec. {{ Session::get('sekolah')->kec }}</p>
                    </div>
                    <div class="content">
                        <h4>KARTU NISN</h4>
                        <p>Nomor Induk Siswa Nasional</p>
                        <p>
                            <ol style="margin-left: 20px;">
                                <li>Kartu NISN ini dicetak oleh Admin/Operator Sekolah.</li>
                                <li>Website arsip NISN. https://referensi.data.kemdikbud.go.id/nisn/</li>
                                <li>NISN ini bersumber dari referensi data dapodik.</li>
                                <li>Kartu berlaku selama yang bersangkutan menjadi siswa.</li>
                            </ol>
                        </p>
                        
                    </div>

                </div>
                <div class="back">
                    <div class="kop">
                        <h4 class="text-center">Nomor Induk Siswa Nasional</h4>
                    </div>
                    <div class="content">
                        <div class="foto" style="width: 100px; float: left; text-align: center;">
                            @php
                                if (file_exists(public_path('/img/siswas/'.Session::get('sekolah_id').'_'.$siswa->nisn.'.jpg'))) {
                                    $foto_siswa = '/img/siswas/'.Session::get('sekolah_id').'_'.$siswa->nisn.'.jpg';
                                } else {
                                    if (strtolower($siswa->jk) == 'l') {
                                        $foto_siswa = '/img/no-photo.jpg';
                                    } else {
                                        $foto_siswa = '/img/siswa-p.png';
                                    }
                                }
                            @endphp
                            <img src="{{ asset('/img/logo_nisn.png') }}" alt="Logo NISN" style="width: 50px;">
                            <img src="{{ asset($foto_siswa) }}" alt="Foto Siswa" style="width:65px;box-shadow: 0 0 3px rgba(0,0,0,0.7)">
                        </div>
                        <div class="biodata" style="width: 350px;">
                            <h4 class="text-center text-upper">{{ $siswa->nama_siswa }}</h4>
                            <table>
                                <tr>
                                    <td>NISN</td>
                                    <td>:</td>
                                    <td><strong>{{ $siswa->nisn }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tgl. Lahir</td>
                                    <td>:</td>
                                    <td>{{ $siswa->tempat_lahir??'-' }}, <br> {{  $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D-MM-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ (strtolower($siswa->jk) == 'l' ) ? 'Laki-laki' : 'Perempuan'}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td>:</td>
                                    <td>{{ $siswa->ortus->nama_ibu ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="btn btn-lg btn-danger btn-print-kartu-nisn">
        Cetak
    </button>

    <script src="{{ asset('/jquery/jquery.js') }}"></script>
    <script>
        $(document).on('ready', function(){
            $(window).on('load', function(){
                window.print()
            })
        })
       $(document).on('click', '.btn-print-kartu-nisn', function(){
           window.print()
       })
    </script>
</body>
</html>