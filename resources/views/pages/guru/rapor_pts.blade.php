<div class="row">
    <div class="col-sm-8" >
        <div class="page_rapor text-center" id="rapor_pts">
            <div class="content_rapor_pts">
                @php
                    $semester = Session::get('periode_aktif');
                    $sem = substr($semester,4,1);
                    $sem = ($sem == '1') ? 'I (Ganjil)' : 'II (Genap)';
                    $tapel = '20'.substr($semester, 0,2).'/'.'20'.substr($semester, 2,2);
                @endphp
                {{-- {{ $semester }} --}}
                <div class="kop text-center d-block" style="position:relative;">
                    <img src="{{ asset('img/malangkab.png') }}" alt="Logo Malangkab" class="logo-kab" height="100" style="position:absolute; left: 20px;top: 10px;">
                    <h4>PEMERINTAH KABUPATEN MALANG</h4>
                    <h4>DINAS PENDIDIKAN</h4>
                    <h4>KOORDINATOR WILAYAH DINAS PENDIDIKAN KECAMATAN {{ strtoupper($sekolah->kec) }}</h4>
                    <h2>{{ strtoupper($sekolah->nama_sekolah) }}</h2>
                    <p>{{ $sekolah->alamat }} {{ $sekolah->desa }}</p>
                    <p>Kecamatan {{ $sekolah->kec }} Kabupaten {{ $sekolah->kab }} Propinsi {{ $sekolah->prov }}</p>
                </div>
                <br>
                <h2 class="text-center">LAPORAN HASIL PENILAIAN TENGAH SEMESTER {{ $sem }}</h2>
                <br>
                <table id="table-profil-siswa" width="100%">
                    <tr>
                        <td class="text-left">Nama Peserta Didik</td>
                        <td>:</td>
                        <td class="text-left">{{ $siswa->nama_siswa }}</td>
                        <td></td>
                        <td class="text-left">Kelas</td>
                        <td>:</td>
                        <td class="text-left">{{ Session::get('rombel')->nama_rombel }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">NISN/NIS</td>
                        <td class="text-left">:</td>
                        <td class="text-left"><span class="nisn">{{ $siswa->nisn }}</span>/{{ $siswa->nis }}</td>
                        <td></td>
                        <td class="text-left">Semester</td>
                        <td>:</td>
                        <td class="text-left">{{ $sem }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Nama Sekolah</td>
                        <td>:</td>
                        <td class="text-left">{{ strtoupper($sekolah->nama_sekolah) }}</td>
                        <td></td>
                        <td class="text-left">Tahun Pelajaran</td>
                        <td>:</td>
                        <td class="text-left">{{ $tapel }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Alamat Sekolah</td>
                        <td>:</td>
                        <td colspan="7" class="text-left">{{ $sekolah->alamat.' '.$sekolah->desa.' '.$sekolah->kec.' '.$sekolah->kab.' '.$sekolah->prov }}</td>
                    </tr>
                </table>
                <br>
                <h3 class="text-left">A. Nilai Pengetahuan</h3>
                <table id="table34" border="1" width="100%" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="p-2">No</th>
                            <th rowspan="2" class="p-2" >Muatan Pelajaran</th>
                            <th rowspan="2" class="p-2" >KKM</th>
                            <th colspan="10" class="p-2" style="width:50%">NILAI KOMPETENSI DASAR</th>
                            <th colspan="2">RERATA</th>
                        </tr>

                        <tr>
                            <th class="p-2" colspan="5" style="width:25%">PENILAIAN HARIAN</th>
                            <th class="p-2" colspan="5" style="width:25%">PENILAIAN TENGAH SEMESTER</th>
                            <th>UH</th>
                            <th>UTS</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- <tr>
                            <td rowspan="2">1</td>
                            <td rowspan="2" class="text-left p-2">Pendidikan Agama dan Budi Pekerti</td>
                            <td rowspan="2">70</td>
                            <td  style="width:8.3%">3.1</td>
                            <td style="width:8.3%">3.2</td>
                            <td style="width:8.3%">3.3</td>
                            <td style="width:8.3%">3.1</td>
                            <td style="width:8.3%"> 3.2</td>
                            <td style="width:8.3%">3.3</td>
                        </tr>
                        <tr>
                            <td>70</td>
                            <td>80</td>
                            <td>90</td>
                            <td>100</td>
                            <td>80</td>
                            <td>70</td>
                        </tr> --}}
                        @foreach($pts as $pt)
                            <tr>
                                <td rowspan="2">{{ $loop->index+1 }}</td>
                                <td rowspan="2" class="text-left p-2">{{ $pt['nama_mapel'] }}</td>
                                <td rowspan="2">{{ $pt['kkm']->nilai}}</td>
                                @if(isset($pt['nilais']))
                                    {{-- @foreach ($pt['nilais']['uh'] as $k => $uh)
                                        <td>{{ $k }}</td>
                                    @endforeach --}}
                                    @php($uh_keys = array_keys($pt['nilais']['uh']))
                                    {{-- <td>{{ dd($uh_keys[]) }}</td> --}}
                                    @for ($i = 0; $i < 5; $i++)
                                        <td style="font-weight:600">
                                            @if(isset($uh_keys[$i]))
                                                {{ $uh_keys[$i] }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                    @endfor


                                    @php($pts_keys = array_keys($pt['nilais']['pts']))
                                    {{-- <td>{{ dd($uh_keys[]) }}</td> --}}
                                    @for ($i = 0; $i < 5; $i++)
                                        <td style="font-weight:600">
                                            @if(isset($pts_keys[$i]))
                                                {{ $pts_keys[$i] }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                    @endfor
                                @else
                                    @for ($i = 0; $i < 12; $i++)
                                        <td>-</td>
                                    @endfor
                                @endif

                                    @php($uh_keys = array_keys($pt['nilais']['uh']))
                                    @php($nhs =0)
                                    @for ($i = 0; $i < 5; $i++)
                                            @if(isset($uh_keys[$i]))
                                             @php($nhs += $pt['nilais']['uh'][$uh_keys[$i]]['nilai'] ?? 0)
                                            @endif

                                    @endfor
                                    @php($nhs = ($nhs > 0 ? number_format((float)$nhs/count($uh_keys), 2,',','') : 0))
                                <td rowspan="2" class="{{ ($nhs < $pt['kkm']->nilai ? 'text-danger': '')  }}">
                                    {{ $nhs }}
                                </td>

                                    @php($pts_keys = array_keys($pt['nilais']['pts']))
                                    @php($npts =0)
                                    @for ($i = 0; $i < 5; $i++)
                                            @if(isset($pts_keys[$i]))
                                             @php($npts += $pt['nilais']['pts'][$uh_keys[$i]]['nilai'] ?? 0)
                                            @endif

                                    @endfor
                                    @php( $npts = ($npts > 0 ? number_format((float)$npts/count($pts_keys), 2,',','') : 0))
                                <td rowspan="2" class="{{ ($npts < $pt['kkm']->nilai ? 'text-danger': '')  }}">
                                    {{ $npts }}
                                </td>
                            </tr>
                            <tr>
                                @if(isset($pt['nilais']))
                                    @php($uh_keys = array_keys($pt['nilais']['uh']))
                                    @for ($i = 0; $i < 5; $i++)
                                        <td>
                                            @if(isset($uh_keys[$i]))
                                            {{ ($pt['nilais']['uh'][$uh_keys[$i]]->nilai ?? '-' ) }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                    @endfor
                                    @php($pts_keys = array_keys($pt['nilais']['pts']))
                                    @for ($i = 0; $i < 5; $i++)
                                        <td>
                                            @if(isset($pts_keys[$i]))
                                                {{ ($pt['nilais']['pts'][$pts_keys[$i]]->nilai ?? '-' ) }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                    @endfor
                                @else
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                @endif
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                <br>

                <h3 class="text-left" >B. Saran-saran</h3>
                <div class="box-saran p-5" style="width:100%; margin: auto; border: 2px solid black;text-align:center; vertical-align:middle;" data-jenis="pts" data-id="{{ ($sarans['pts'] !=null) ? $sarans['pts']->id : null }}"> 
                    {{ ($sarans['pts'] != null) ? $sarans['pts']->teks : '-' }}
                </div>

                <br>
                <br>
                <table class="table-ttd-rapor" width="100%">
                    <tr>
                        <td style="width:33.3%">
                            Mengetahui,<br>
                            Orang Tua/Wali
                            <br>
                            <br>
                            <br>
                            <b>............................</b>
                        </td>
                        <td style="width:33.3%"></td>
                        <td style="width:33.3%">
                            
                            {{ $sekolah->kab }}, {{ date_format(date_create($tanggal_rapor['pts']), "d F Y") }} <br>
                            Guru Kelas,
                            <br>
                            <br>
                            <br>
                            <b><u>{{ strtoupper(Auth::user()->nama) }}</u></b> <br>
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
                            <b><u>{{ strtoupper($sekolah->ks->nama) }}</u></b> <br>
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
                        <button class="btn btn-lg btn-primary" id="btn-print-rapor-pts">
                            <i class="mdi mdi-printer"></i>
                            Cetak
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
