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
    <div class="card-body">
        <ul class="nav nav-tabs">
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

        <div class="tab-content">
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
    </div>
</div>
