<div class="row">
    <div class="col-sm-8" >
        <div class="page_rapor text-center" id="biodata_rapor">
            <div class="content_biodata">
                <article style="background: transparent;">
                    <h2 class="text-center">IDENTITAS PESERTA DIDIK</h2>
                    <hr>
                    <br>
                    <table width="100%" id="table-biodata">
                        <tr>
                            <td class="text-left px-2">Nama Peserta Didi</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">NISN/NIS</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->nisn }}/{{ $siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Jenis Kelamin</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ ($siswa->jk == 'L')? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Agama</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->agama ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Pendidikan sebelumnya</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->tk ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Alamat Peserta Didik</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->alamat ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Nama Orang Tua</td>
                            <td class="text-center"></td>
                            <td class="text-left px-2"></td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Ayah</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Ibu</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->nama_ibu?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Pekerjaan Orang Tua</td>
                            <td class="text-center"></td>
                            <td class="text-left px-2"></td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Ayah</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->job_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Ibu</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->job_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Alamat Orang Tua</td>
                            <td class="text-center"></td>
                            <td class="text-left px-2"></td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Jalan</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->alamat ?? '-' }} </td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Kelurahan / Desa</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->desa ?? '-'}} </td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Kecamatan</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->kec ?? '-'}} </td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Kabupaten / Kota</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->kab ?? '-' }} </td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Provinsi</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->prov ?? '-'}} </td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Wali Peserta Didik</td>
                            <td class="text-center"></td>
                            <td class="text-left px-2"></td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Nama</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->nama_wali ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Pekerjaan</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->job_wali ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-left px-2">Alamat</td>
                            <td class="text-center">:</td>
                            <td class="text-left px-2">{{ $siswa->ortus->alamat_wali ?? '-' }}</td>
                        </tr>
                    </table>
                </article>
                <div class="row" style="margin-top: 50px">

                    <table width="100%" id="table-biodata-bawah">
                        <tr>
                            <td style="width:50%;">
                                @php
                                    $foto = '';
                                    if(file_exists(public_path('img/siswas/'.Session::get('sekolah_id').'_'.$siswa->nisn.'.jpg'))){
                                        $foto = 'img/siswas/'.Session::get('sekolah_id').'_'.$siswa->nisn.'.jpg';
                                    } else {
                                        $foto = 'img/no-foto.jpg';                                    
                                    }
                                @endphp
                                <div class="foto" style="border: 1px solid #666;content:'';margin-left:20px;width: 3cm; height: 4cm; background: url({{ asset("$foto") }}); background-size:contain;background-repeat:no-repeat; background-position: center">
                                </div>
                            </td>
                            <td style="width:50%; text-align: left;">
                                {{ $sekolah->kab }},  {{  $tanggal_rapor['biodata'] }} <br>
                                Kepala Sekolah, <br>
                                @if(file_exists(public_path('/img/ttd/'.$sekolah->npsn.'_'.$sekolah->ks->nip.'.png')))
                                    <img src="{{ asset('img/ttd/'.$sekolah->npsn.'_'.$sekolah->ks->nip.'.png') }}" style="width:200px;"/>
                                @else
                                    <br>
                                    <br>
                                    <br>
                                @endif
                                <br>
                                <strong><u>{{ $sekolah->ks->nama ?? '' }}</u></strong><br>
                                NIP. {{ $sekolah->ks->nip ?? '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4" style="padding: 20px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="mdi mdi-printer"></i>
                        Cetak Biodata
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-primary" id="btn-print-biodata">
                            <i class="mdi mdi-printer"></i>
                            Cetak
                        </button>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

</div>