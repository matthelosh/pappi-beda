<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                </svg>
                Data Siswa
                <button class="btn btn-export-siswas btn-danger float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-cloud-download') }}"></use>
                    </svg>
                    Unduh
                </button>
                <button class="btn btn-import-siswas btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-siswas btn-info float-right mr-2" data-toggle="modal" data-target="#modalSiswa">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn btn-success float-right mr-2 btn-print-siswas d-none d-md-block">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-siswas" id="table-siswas" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIS / NISN</th>
                            <th>NAMA</th>
                            <th>JK</th>
                            <th>ROMBEL</th>
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