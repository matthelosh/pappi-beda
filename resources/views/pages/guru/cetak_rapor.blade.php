<div class="card col-sm-12">
    
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title">
                <a href="/{{ Auth::user()->username }}/rapor">
                    <i class="mdi mdi-arrow-left"></i>
                </a>
                Cetak Rapor {{ $siswa->nama_siswa }}</h4>
            </div>
            <div class="col-sm-4">
                <select name="siswa" id="siswa" class="form-control selSiswaKu" style="width:100%">
                    <option value="0">Pilih Siswa</option>
                    <option value="{{ $siswa->nisn }}" selected>{{ $siswa->nama_siswa }}</option>
                </select>
            </div>
        </div>
        
        
    </div>
    <div class="card-body rapor-tabs">

        
        <ul class="nav nav-tabs tabs-rapor">
            <li class="nav-item">
                <a href="#cover" data-toggle="tab" class="nav-link">
                    <i class="mdi mdi-book"></i>
                    Sampul
                </a>
            </li>
            <li class="nav-item">
                <a href="#biodata" data-toggle="tab" class="nav-link">
                    <i class="mdi mdi-account-box"></i>
                    Biodata
                </a>
            </li>
            <li class="nav-item">
                <a href="#rapor-pts" data-toggle="tab" class="nav-link active">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    Rapor PTS
                </a>
            </li>
            <li class="nav-item">
                <a href="#rapor-pas" data-toggle="tab" class="nav-link ">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    Rapor PAS
                </a>
            </li>
        </ul>
       
        <div class="tab-content py-3">
            <div class="tab-pane container-fluid" id="cover">
               @include('pages.guru.cover')
            </div>
            <div class="tab-pane container-fluid" id="biodata">
                @include('pages.guru.biodata')
            </div>
            <div class="tab-pane active container-fluid" id="rapor-pts">
                @include('pages.guru.rapor_pts')
            </div>
            <div class="tab-pane container-fluid" id="rapor-pas">
                @include('pages.guru.rapor_pas')
            </div>
        </div>

        <ul class="nav nav-tabs tabs-rapor">
            <li class="nav-item">
                <a href="#cover" data-toggle="tab" class="nav-link">
                    <i class="mdi mdi-book"></i>
                    Sampul
                </a>
            </li>
            <li class="nav-item">
                <a href="#biodata" data-toggle="tab" class="nav-link">
                    <i class="mdi mdi-account-box"></i>
                    Biodata
                </a>
            </li>
            <li class="nav-item">
                <a href="#rapor-pts" data-toggle="tab" class="nav-link active">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    Rapor PTS
                </a>
            </li>
            <li class="nav-item">
                <a href="#rapor-pas" data-toggle="tab" class="nav-link ">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    Rapor PAS
                </a>
            </li>
        </ul>
    </div>
</div>

 {{-- Modal Saran --}}
 <div class="modal fade" id="modalSaran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Masukkan Saran </h3>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="" class="form-saran">
                            <input type="hidden" value="{{ Session::get('periode_aktif') }}" name="semester">
                            <input type="hidden" value="{{ Session::get('rombel')->kode_rombel }}" name="rombel">
                            <input type="hidden"  name="siswa_id">
                            <input type="hidden"  name="jenis_rapor">
                            <input type="hidden"  name="saran_id">
                            <div class="form-group">
                                <label for="teks_saran">Saran</label>
                                <textarea name="teks_saran" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <button class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>