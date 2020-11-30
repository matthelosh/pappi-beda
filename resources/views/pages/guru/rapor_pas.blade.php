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
                        <td class="nama_siswa">{{ $siswa->nama_siswa }}</td>
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
                <table id="table34" border="1" width="100%" style="border-collapse:collapse;" class="table">
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
                                $kkm = $nilai['kkm']->nilai ?? 80;
                            @endphp
                            <tr>
                                <td class="text-center p-2">{{ ($loop->index +1) }}</td>
                                <td class="text-left p-2">
                                    {{ $nilai['nama_mapel'] }}
                                </td>
                                <td class="{{ ($na_k3 < $kkm) ? 'text-red' : '' }}">
                                    {{ ($na_k3 != null)? $na_k3 : '-' }}
                                </td>
                                <td class="{{ ($na_k3 < $kkm) ? 'text-danger': ''}}">
                                    @if($na_k3 != null)
                                        @if($na_k3 >= 90)
                                            A
                                        @elseif($na_k3 >= 80)
                                            B
                                        @elseif($na_k3 >= $kkm)
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
                        @foreach($ekskuls as $k=>$ekstra)
                            <tr>
                                <td>{{ ($loop->index + 1) }}</td>
                                <td class="text-left p-2" data-id="{{ $k }}">{{ $ekstra['nama_ekskul'] }}</td>
                                <td class="text-left p-2 ket-ekskul eks-{{ $k }}" data-id="{{ $ekstra['id_nilai'] }}" data-kode="{{ $k }}">{{ ($ekstra['ket']) ?? '-' }}</td>
                            </tr>

                        @endforeach
                        {{-- {{ dump($ekstras) }} --}}
                    </tbody>
                </table>
                <br>
                <h3 class="text-left" >D. Saran-saran</h3>
                <div class="box-saran p-5 saran-pas" style="width:100%; margin: auto; border: 2px solid black;text-align:center; vertical-align:middle;" data-jenis="pas" data-id="{{ ($sarans['pas'] != null) ? $sarans['pas']->id : null }}">
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
                            <td class="text-center p-2 td-fisik tb-1" data-id="{{ $fisik['tb']['1']->id ?? '0' }}" data-sem="1" data-fisik="tb" data-tapel="{{ substr(Session::get('periode_aktif'), 0,4) }}">
                                {{ $fisik['tb']['1']->tb ?? '-' }} cm
                            </td>
                            <td class="text-center p-2 td-fisik tb-2" data-id="{{ $fisik['tb']['2']->id ?? '0' }}" data-sem="2" data-fisik="tb" data-tapel="{{ substr(Session::get('periode_aktif'), 0,4) }}">
                                {{ $fisik['tb']['2']->tb ?? '-' }} cm
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Berat Badan</td>
                            <td class="text-center p-2 td-fisik bb-1"  data-id="{{ $fisik['bb']['1']->id ?? '0' }}" data-sem="1" data-fisik="bb" data-tapel="{{ substr(Session::get('periode_aktif'), 0,4) }}">
                                {{ $fisik['bb']['1']->bb ?? '-' }} kg
                            </td>
                            <td class="text-center p-2 td-fisik bb-2" data-id="{{ $fisik['bb']['2']->id ?? '0' }}" data-sem="2" data-fisik="bb" data-tapel="{{ substr(Session::get('periode_aktif'), 0,4) }}">
                                {{ $fisik['bb']['2']->bb ?? '-' }} kg
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">F. Kondisi Kesehatan</h3>
                <table id="table-kesehatan" border="1" width="100%" style="border-collapse:collapse;" data-id="{{ ($data_rapor['kesehatan']) ? $data_rapor['kesehatan']->id : 0 }}">
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
                            <td class="text-left p-2 sht sht-dengar">{{ ($data_rapor['kesehatan']) ? $data_rapor['kesehatan']->pendengaran : '-' }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Penglihatan</td>
                            <td class="text-left p-2 sht sht-lihat">{{ ($data_rapor['kesehatan']) ? $data_rapor['kesehatan']->penglihatan : '-' }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="text-left p-2">Gigi</td>
                            <td class="text-left p-2 sht sht-gigi">{{ ($data_rapor['kesehatan']) ? $data_rapor['kesehatan']->gigi : '-' }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="text-left p-2">Lainnya</td>
                            <td class="text-left p-2 sht sht-lain">{{ ($data_rapor['kesehatan']) ? $data_rapor['kesehatan']->lain : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">G. Prestasi</h3>
                <table id="table-prestasi" border="1" width="100%" style="border-collapse:collapse;" data-id="{{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->id : '0' }}">
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
                            <td class="text-left p-2 box-prestasi seni">
                                {{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->kesenian : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="text-left p-2">Olahraga</td>
                            <td class="text-left p-2 box-prestasi olahraga">
                                {{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->olahraga : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <h3 class="text-left">H. Ketidakhadiran</h3>
                <div style="position:relative; display:block; width: 100%;margin-bottom:150px;">
                    <table id="table-kehadiran" border="1" style="border-collapse:collapse;display:block; width:40%; position: absolute; left:0; ">
                        <tbody>
                            <tr>
                                <td style="width: 40%; border-right:none;" class="text-left px-3">Sakit</td>
                                <td style="width: 1%;border-left:none; border-right:none;">:</td>
                                <td style="width: 40%%;border-left:none;" class="td-sakit td-absensi"> {{ ($data_rapor['absensi']) ? $data_rapor['absensi']->sakit : '-'}} hari</td>
                            </tr>
                            <tr>
                                <td class="text-left px-3" style="border-right:none;">Izin</td>
                                <td style="border-left:none; border-right:none;">:</td>
                                <td style="border-left:none;" class="td-absensi td-ijin"> {{ ($data_rapor['absensi']) ? $data_rapor['absensi']->ijin : '-'}} hari</td>
                            </tr>
                            <tr>
                                <td class="text-left px-3" style="border-right:none;">Alpa</td>
                                <td style="border-left:none; border-right:none;">:</td>
                                <td style="border-left:none;" class="td-absensi td-alpa"> {{ ($data_rapor['absensi']) ? $data_rapor['absensi']->alpa : '-'}} hari</td>
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
                            <b><u style="text-transform: uppercase">{{ Auth::user()->nama }}</u></b> <br>
                            {{ (Auth::user()->status == 'pns') ? 'NIP.':'NIG.' }}  {{ Auth::user()->nip }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:33.3%"></td>
                        <td style="width:33.3%">
                            Mengetahui,
                            <br>
                            <br>
                            <br>
                            <b><u style="text-transform: uppercase">{{ $sekolah->ks->nama ?? '..................' }}</u></b> <br>
                            NIP. {{ $sekolah->ks->nip ?? '-' }}
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

<div class="modal fade" id="modalPrestasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Data Prestasi <br><small>{{ $siswa->nama_siswa }}</small></h3>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-prestasi">
                    @csrf()

                    <input type="hidden" name="siswa_id" value="{{ $siswa->nisn }}">
                    <input type="hidden" name="id_prestasi" value="{{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->id : '0' }}">
                    <div class="form-group">
                        <label for="kesenian">Kesenian</label>
                        <textarea name="kesenian" cols="30" rows="4" class="form-control" >{{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->kesenian : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="olahraga">Olah Raga</label>
                        <textarea name="olahraga" cols="30" rows="4" class="form-control" >{{ ($data_rapor['prestasis']) ? $data_rapor['prestasis']->olahraga : '' }}</textarea>
                    </div>
                    <div class="form-group text-center"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Modal Absensi --}}
<div class="modal fade" id="modalAbsensi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Data Absensi <br>
                    <small>{{ $siswa->nama_siswa ?? '' }}</small>
                    
                </h4>
                <button class="close" data-dismiss="modal"><i class="mdi mdi-close"></i></button>
            </div>
            <div class="modal-body">
                <form action="" class="form-absensi">
                    @csrf()
                    <input type="hidden" name="id_absensi" value="{{ ($data_rapor['absensi']) ? $data_rapor['absensi']->id : '0' }}">
                    <input type="hidden" name="siswa_id" value="{{ $siswa->nisn }}">
                    <div class="row">
                        
                        <div class="form-group col-sm-4">
                            <label for="sakit">Sakit</label>
                            <input type="number" name="sakit" class="form-control" value="{{ ($data_rapor['absensi']) ? $data_rapor['absensi']->sakit : '' }}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="ijin">Izin</label>
                            <input type="number" name="ijin" class="form-control" value="{{ ($data_rapor['absensi']) ? $data_rapor['absensi']->ijin : '' }}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="alpa">Alpa</label>
                            <input type="number" name="alpa" class="form-control" value="{{ ($data_rapor['absensi']) ? $data_rapor['absensi']->alpa : '' }}">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Kesehatan --}}
<div class="modal fade" id="modalKesehatan">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-stethoscope"></i> Data Kesehatan <br><small><span class="nama_siswa"></span></small></h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-kesehatan">
                    @csrf()
                    <input type="hidden" name="id_kesehatan" value="{{ $data_rapor['kesehatan'] ? $data_rapor['kesehatan']->id : '0' }}">
                    <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
                    <div class="form-group">
                        <label for="pendengaran">Pendengaran</label>
                        <div class="input-group">
                            <input type="text" name="pendengaran" class="form-control" value="{{ $data_rapor['kesehatan']->pendengaran??'' }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-ear-hearing"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="penglihatan">Penglihatan</label>
                        <div class="input-group">
                            <input type="text" name="penglihatan" class="form-control" value="{{ $data_rapor['kesehatan']->penglihatan??'' }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gigi">Gigi</label>
                        <div class="input-group">
                            <input type="text" name="gigi" class="form-control" value="{{ $data_rapor['kesehatan']->gigi ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-tooth"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lain">Lainnya</label>
                        <div class="input-group">
                            <input type="text" name="lain" class="form-control" value="{{ $data_rapor['kesehatan']->lain ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-more"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ekstrakurikuler --}}
<div class="modal" id="modalNilaiEkskul">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Nilai Ekskul <span class="nama_ekskul"></span></h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-nilai-ekskul">
                    @csrf()
                    <input type="hidden" name="siswa_id">
                    <input type="hidden" name="id_nilai" value="0">
                    <input type="hidden" name="periode_id">
                    <input type="hidden" name="rombel_id">
                    <input type="hidden" name="ekskul_id">
                    <div class="form-group">
                        <textarea name="keterangan" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Fisik Siswa --}}
<div class="modal" id="modalFisikSiswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">FISIK SISWA <br /><small><span id="nisn"></span></small></h3>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-fisik-siswa">
                    @csrf()
                    <input type="hidden" name="siswa_id">
                    <input type="hidden" name="id_fisik" value="0">
                    <input type="hidden" name="periode">
                    {{-- <input type="hidden" name="rombel_id"> --}}
                    <div class="row">
                        <div class="form-group col-sm-4 offset-sm-2">
                            <label for="tb">Tinggi Badan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="tb">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="bb">Berat Badan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bb">
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>