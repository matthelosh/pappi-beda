<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-institution') }}"></use>
                </svg>
                Data Sekolah
                <button class="btn btn-import-sekolah btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-sekolah btn-info float-right mr-2" data-toggle="modal" data-target="#modalSekolah">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn  btn-success float-right mr-2 btn-print-users">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-sekolahs" id="table-sekolahs" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NPSN</th>
                            <th>NAMA SEKOLAH</th>
                            <th>ALAMAT</th>
                            <th>DESA</th>
                            <th>KEC</th>
                            <th>KAB/KOTA</th>
                            <th>PROPINSI</th>
                            <th>KODE POS</th>
                            <th>TELP</th>
                            <th>EMAIL</th>
                            <th>WEBSITE</th>
                            <th>OPERATOR</th>
                            <th>KEPALA SEKOLAH</th>
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