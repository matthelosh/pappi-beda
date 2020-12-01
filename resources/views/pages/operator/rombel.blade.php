<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-room') }}"></use>
                </svg>
                Data Rombel
                <button class="btn btn-import-rombels btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-rombel btn-info float-right mr-2" data-toggle="modal" data-target="#modalRombel">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn btn-success float-right mr-2 btn-print-rombels d-none d-md-block">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-rombels" id="table-rombels" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>SEKOLAH</th>
                            <th>KODE ROMBEL</th>
                            <th>NAMA ROMBEL</th>
                            <th>TINGKAT</th>
                            <th>WALI KELAS</th>
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