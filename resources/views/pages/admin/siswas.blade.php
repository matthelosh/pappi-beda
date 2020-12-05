<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                        </svg>
                        Data Siswa
                    </h4>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-import-siswas btn-square btn-primary float-right mr-2">
                        <i class="mdi mdi-cloud-upload-outline"></i>
                        Import
                    </button>
                    <button class="btn btn-new-siswas btn-info btn-square float-right mr-2" data-toggle="modal" data-target="#modalSiswa">
                        <i class="mdi mdi-account-plus"></i>
                        Buat
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
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