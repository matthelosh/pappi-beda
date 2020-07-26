<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-book') }}"></use>
                </svg>
                Data Kompetensi Dasar
                <button class="btn btn-import-kd btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-kd btn-info float-right mr-2" data-toggle="modal" data-target="#modalKd">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn  btn-success float-right mr-2 btn-print-kd">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-kdku" id="table-kdku" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KODE KD</th>
                            <th>TEKS KD</th>
                            <th>MAPEL</th>
                            <th>TINGKAT</th>
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