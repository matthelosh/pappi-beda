<div class="row">
    <div class="col-sm-8" >
        <div class="page_rapor text-center" id="rapor_pas">
            <div class="content_rapor_pas">
                <h2 class="text-center">PROFIL DAN RAPOR PESERTA DIDIK </h2>
                <hr>
                @php
                    $semester = Session::get('periode_aktif');
                    $sem = substr($semester,4,1);
                    $sem = ($sem == '1') ? 'I (Ganjil)' : 'II (Genap)';
                    $tapel = '20'.substr($semester, 0,2).'/'.'20'.substr($semester, 2,2);
                @endphp
                <table id="table-profil-siswa" width="100%">
                    <tr>
                        <td>Nama Peserta Didik</td>
                        <td>:</td>
                        <td>{{ $siswa->nama_siswa }}</td>
                        <td></td>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ Session::get('rombel')->nama_rombel }}</td>
                    </tr>
                    <tr>
                        <td>NISN/NIS</td>
                        <td>:</td>
                        <td>{{ $siswa->nisn }}/{{ $siswa->nis }}</td>
                        <td></td>
                        <td>Semester</td>
                        <td>:</td>
                        <td>{{ $sem }}</td>
                    </tr>
                    <tr>
                        <td>Nama Sekolah</td>
                        <td>:</td>
                        <td>{{ strtoupper($sekolah->nama_sekolah) }}</td>
                        <td></td>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>{{ $tapel }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Sekolah</td>
                        <td>:</td>
                        <td colspan="7">{{ $sekolah->alamat.' '.$sekolah->desa.' '.$sekolah->kec.' '.$sekolah->kab.' '.$sekolah->prov }}</td>
                    </tr>
                </table>
                <hr>
                <h3 class="text-left text-bold" >A. Sikap</h3>
                <table id="table-sikap" width="100%" border="1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th colspan="2"><h3>Deskripsi</h3></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left p-2">
                                <h3>1. Sikap Spiritual</h3>
                            </td>
                            <td class="text-left p-2" style="width:75%">
                                Ananda {{ ucwords($siswa->nama_siswa, " ") }}
                                @if($sikaps['k1'] != null)
                                    @foreach($sikaps['k1'] as $k1)
                                        {{ $k1 }},
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left p-2">
                                <h3>2. Sikap Sosial</h3>
                            </td>
                            <td class="text-left p-2">
                                Ananda {{ ucwords($siswa->nama_siswa, " ") }} 
                                @if($sikaps['k2'] != null)
                                    @foreach($sikaps['k2'] as $k2)
                                        {{ $k2 }},
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">B. Pengetahuan dan Keterampilan</h3>
                <table id="table34" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="p-2">No</th>
                            <th rowspan="2" class="p-2">Muatan Pelajaran</th>
                            <th colspan="3" class="p-2" style="width:40%">Pengetahuan</th>
                            <th colspan="3" class="p-2" style="width:40%">Keterampilan</th>
                        </tr>
                        <tr>
                            <th class="p-2">Nilai</th>
                            <th class="p-2">Predikat</th>
                            <th class="p-2">Deskripsi</th>
                            <th class="p-2">Nilai</th>
                            <th class="p-2">Predikat</th>
                            <th class="p-2">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($nilais) }} --}}
                        @foreach($pas as $k=>$nilai)
                            @php
                                $na_k3 = (isset($nilai['k3']['na'])) ? round($nilai['k3']['na']) : null;
                                $na_k4 = (isset($nilai['k4']['na'])) ? round($nilai['k4']['na']) : null;
                                $kkm=70;
                            @endphp
                            <tr>
                                <td class="text-center p-2">{{ ($loop->index +1) }}</td>
                                <td class="text-left p-2">
                                    {{ $nilai['nama_mapel'] }}
                                </td>
                                <td class="{{ ($na_k3 < $kkm) ? 'text-red' : '' }}">
                                    {{ ($na_k3 != null)? $na_k3 : '-' }}
                                </td>
                                <td class="{{ ($na_k3 < 75) ? 'text-danger': ''}}">
                                    @if($na_k3 != null)
                                        @if($na_k3 >= 90)
                                            A
                                        @elseif($na_k3 >= 80)
                                            B
                                        @elseif($na_k3 >= 70)
                                            C
                                        @else
                                            D
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-left p-2">
                                    @if($na_k3 == null)
                                        -
                                    @else
                                        Ananda {{ $siswa->nama_siswa }}
                                        @foreach ($nilai['k3']['max'] as $max)
                                            {{ $max }}
                                        @endforeach
                                        ,
                                        @foreach ($nilai['k3']['min'] as $min)
                                            {{ $min }}
                                        @endforeach
                                    @endif
                                </td>
                                <td class="{{ ($na_k4 < $kkm) ? 'text-red' : '' }}">
                                    {{ ($na_k4 != null)? $na_k4 : '-' }}
                                </td>
                                <td class="{{ ($na_k4 < 75) ? 'text-danger': ''}}">
                                        @if($na_k4 != null)
                                        @if($na_k4 >= 90)
                                            A
                                        @elseif($na_k4 >= 80)
                                            B
                                        @elseif($na_k4 >= 70)
                                            C
                                        @else
                                            D
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-left p-2">
                                    @if($na_k4 == null)
                                        -
                                    @else
                                        Ananda {{ $siswa->nama_siswa }}
                                        @foreach ($nilai['k4']['max'] as $max)
                                            {{ $max }}
                                        @endforeach
                                        ,
                                        @foreach ($nilai['k4']['min'] as $min)
                                            {{ $min }}
                                        @endforeach
                                    @endif
                                </td>
                            </tr>  
                        @endforeach
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">C. Ekstra Kurikuler</h3>
                <table id="table-ekstra" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ekstra Kurikuler</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ekskuls as $ekstra)
                            <tr>
                                <td>{{ ($loop->index + 1) }}</td>
                                <td class="text-left p-2">{{ $ekstra['nama_ekskul'] }}</td>
                                <td class="text-left p-2">{{ ($ekstra['ket']) ?? '-' }}</td>
                            </tr>

                        @endforeach
                        {{-- {{ dump($ekstras) }} --}}
                    </tbody>
                </table>
                <br>
                <h3 class="text-left" >D. Saran-saran</h3>
                <div class="box-saran p-5" style="width:100%; margin: auto; border: 2px solid black;text-align:center; vertical-align:middle;" data-jenis="pas" data-id="{{ ($sarans['pas'] != null) ? $sarans['pas']->id : null }}">
                    {{ ($sarans['pas'] != null) ? $sarans['pas']->teks : '-' }}
                </div>
                <br>
                <h3 class="text-left">E. Tinggi dan Berat Badan</h3>
                <table id="table-tb-bb" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Aspek</th>
                            <th colspan="2">Semester</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="text-left p-2">Tinggi Badan</td>
                            <td class="text-left p-2">
                                @if(substr(Session::get('semester'), 4,1) == '1')
                                    {{ ($detil) ? $detil->tb: '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-left p-2">
                                @if(substr(Session::get('semester'), 4,1) == '2')
                                    {{($detil) ? $detil->tb : '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Berat Badan</td>
                            <td class="text-left p-2">
                                @if(substr(Session::get('semester'), 4,1) == '1')
                                    {{ ($detil) ? $detil->bb : '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-left p-2">
                                @if(substr(Session::get('semester'), 4,1) == '2')
                                    {{ ($detil) ? $detil->bb : '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">F. Kondisi Kesehatan</h3>
                <table id="table-kesehatan" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aspek Fisik</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="text-left p-2">Pendengaran</td>
                            <td class="text-left p-2">{{ ($detil) ? $detil->pendengaran : '-' }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Penglihatan</td>
                            <td class="text-left p-2">{{ ($detil) ? $detil->penglihatan : '-' }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="text-left p-2">Gigi</td>
                            <td class="text-left p-2">{{ ($detil) ? $detil->gigi : '-' }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="text-left p-2">Lainnya</td>
                            <td class="text-left p-2">{{ ($detil) ? $detil->fisik_lain : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">G. Prestasi</h3>
                <table id="table-kesehatan" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Prestasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="text-left p-2">Kesenian</td>
                            <td class="text-left p-2">
                            @if($prestasis)
                                @foreach($prestasis as $key => $prestasi)
                                    @if($prestasi->jenis_prestasi == 'Kesenian')
                                        {{ $loop->index+1 }}. {{ $prestasi->ket }} Tingkat {{ $prestasi->tingkat }}<br>
                                    @endif
                                @endforeach
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Olahraga</td>
                            <td class="text-left p-2">
                            @if($prestasis)
                                @foreach($prestasis as $key => $prestasi)
                                    @if($prestasi->jenis_prestasi == 'Olahraga')
                                        {{ $loop->index+1 }}. {{ $prestasi->ket }} Tingkat {{ $prestasi->tingkat }}
                                    @endif
                                @endforeach
                            @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">F. Kondisi Kesehatan</h3>
                <div style="position:relative; display:block; width: 100%;margin-bottom:150px;">
                    <table id="table-kehadiran" border="1" style="border-collapse:collapse;display:block; width:40%; position: absolute; left:0; ">
                        <tbody>
                            <tr>
                                <td style="width: 40%; border-right:none;" class="text-left p-3">Sakit</td>
                                <td style="width: 1%;border-left:none; border-right:none;">:</td>
                                <td style="width: 40%%;border-left:none;"> {{ ($absensi) ? $absensi->sakit : '-'}} hari</td>
                            </tr>
                            <tr>
                                <td class="text-left p-3" style="border-right:none;">Izin</td>
                                <td style="border-left:none; border-right:none;">:</td>
                                <td style="border-left:none;"> {{ ($absensi) ? $absensi->izin : '-'}} hari</td>
                            </tr>
                            <tr>
                                <td class="text-left p-3" style="border-right:none;">Tanpa Keterangan</td>
                                <td style="border-left:none; border-right:none;">:</td>
                                <td style="border-left:none;"> {{ ($absensi) ? $absensi->alpa : '-'}} hari</td>
                            </tr>
                        </tbody>
                    </table>
                    @if(substr(Session::get('semester'),4,1) == '2' )
                        <div class="box" style="border:3px solid black; width: 40%; display:block; position: absolute; right: 0!important;">
                            Keputusan: <br>
                            Berdasarkan pencapaian seluruh kompetensi, peserta didi dinyatakan: <br>
                            <br>
                            Naik/<strike>Tinggal</strike>*) kelas {{ (Int) Session::get('rombel')->tingkat + 1 }}
                            <br>
                            <br>
                            *) Coret yang tidak perlu
                        </div>
                    @endif
                </div>
                <br>
                <br>
                <br>
                <table id="table-ttd-rapor-pas" width="100%">
                    <tr>
                        <td style="width:33.3%">
                            Mengetahui,<br>
                            Orang Tua/Wali
                            <br>
                            <br>
                            <br>
                            <b>Nama Orang Tua</b>
                        </td>
                        <td style="width:33.3%"></td>
                        <td style="width:33.3%">
                            {{ $sekolah->kab }}, {{ date_format(date_create($tanggal_rapor['pas']), "d F Y") }} <br>
                            Guru Kelas,
                            <br>
                            <br>
                            <br>
                            <b><u>{{ Auth::user()->fullname }}</u></b> <br>
                            NIP. {{ Auth::user()->nip }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:33.3%"></td>
                        <td style="width:33.3%">
                            Mengetahui,
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $sekolah->ks->nama }}</u></b> <br>
                            NIP. {{ $sekolah->ks->nip }}
                        </td>
                        <td style="width:33.3%"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4" style="padding: 20px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="mdi mdi-printer"></i>
                        Cetak Rapor PAS
                    </h4>
                </div>
                <div class="card-body">
                    <div class="form-group rapor-pas-cetak-toolbox">
                        <label for="siswa">Siswa</label>
                        <select name="siswa" class="form-control selSiswa" style="width:100%">
                            <option value="0">Pilih Siswa</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-primary" id="btn-print-rapor-pas">
                            <i class="mdi mdi-printer"></i>
                            Cetak
                        </button>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

</div>