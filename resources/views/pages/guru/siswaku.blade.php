<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                </svg>
                Data Siswa
                {{-- <button class="btn btn-export-siswas btn-danger btn-square float-right mr-2">
                    <i class="mdi mdi-cloud-download"></i>
                    Unduh
                </button> --}}
                <button class="btn btn-import-siswas btn-primary btn-square float-right mr-2">
                    <i class="mdi mdi-cloud-upload"></i>
                    Import
                </button>
                <button class="btn btn-new-siswas btn-info btn-square float-right mr-2" data-toggle="modal" data-target="#modalSiswa">
                    <i class="mdi mdi-plus"></i>
                    Buat
                </button>
                <a href="cetak-nisn?rombel={{ Session::get('rombel')->kode_rombel }}" target="_blank" class="btn btn-success float-right mr-2 btn-square btn-print-siswas d-none d-md-block">
                    <i class="mdi mdi-card-account-details-outline"></i>
                    Cetak Kartu NISN
                </a>
                {{-- <button class="btn btn-success float-right mr-2 btn-square btn-print-siswas d-none d-md-block">
                    <i class="mdi mdi-printer"></i>
                    Cetak
                </button> --}}
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-siswaku" id="table-siswaku" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIS / NISN</th>
                            <th>NAMA</th>
                            <th>JK</th>
                            <th>WALI MURID</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>