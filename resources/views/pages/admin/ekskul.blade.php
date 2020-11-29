<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-tennis') }}"></use>
                </svg>
                Data Ekstrakurikuler
                <button class="btn btn-import-ekskul btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-ekskul btn-info float-right mr-2" data-toggle="modal" data-target="#modalEkskul">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn  btn-success float-right mr-2 btn-print-ekskul">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-ekskul" id="table-ekskul" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KODE EKSKUL</th>
                            <th>NAMA EKSKUL</th>
                            <th>SEKOLAH</th>
                            <th>PEMBINA</th>
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

<div class="modal" id="modalEkskul">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat Ekstrakurikuler</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form form-ekskul">
                    @csrf()
                    <div class="form-group">
                        <label for="sekolah_id">Sekolah</label>
                        <select name="sekolah_id" id="sekolah_id" class="selSekolah form-control col-sm-12" width="100%" style="width:100%;height: 48px;">
                            <option value="0">Pilih sekolah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode_ekskul">Kode Kegiatan</label>
                        <input type="text" name="kode_ekskul" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_ekskul">Nama Kegiatan</label>
                        <input type="text" name="nama_ekskul" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="pembina">Nama Pembina</label>
                        <input type="text" class="form-control" name="pembina">
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>