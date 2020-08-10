<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-book') }}"></use>
                </svg>
                Data Tema
                <button class="btn btn-import-kd btn-primary float-right mr-2 ">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-kd btn-info float-right mr-2 d-none" data-toggle="modal" data-target="#modalKd">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn  btn-success float-right mr-2 btn-print-kd d-none">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-tema" id="table-tema" style="width:100%">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>KODE TEMA</th>
                            <th>TEKS TEMA</th>
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

<modal class="modal" id="modal-subtema">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Subtema <span id="tema"></span></h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                    
                    </div>
                </div>
                <div class="modal-row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-subtema" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Tema</th>
                                        <th>Kode Subtema</th>
                                        <th>Teks Subtema</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row row-kd" style="display:none;">
                    
                    <div class="col-sm-12">
                        <div class="card">
                        
                            <div class="card-body">
                            <h4 class="card-title">Daftar KD Subtema <span id="subtema"></span></h4>
                            
                                {{-- <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="mapel">Pilih Mapel</label>
                                        <select name="mapel" class="form-control selMapel" style="width:100%">
                                            <option value="0">Pilih Mapel</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="form-group">
                                            <label for="aspek">Aspek</label>
                                            <select name="aspek" style="width:100%" class="select selAspek">
                                                <option value="0">Aspek</option>
                                                <option value="3">K3</option>
                                                <option value="4">K4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="kd">Pilih Mapel</label>
                                        <select name="kd" class="form-control selKd" style="width:100%">
                                            <option value="0">Pilih KD</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="button" style="color:transparent">Tambahkan KD</label>
                                        <button class="btn btn-primary btn-add-kd">Tambah KD</button>
                                    </div>
                                </div> --}}
                                <div class="tes">
                                    <table class="table-kdtema table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mapel</th>
                                                <th>KD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</modal>

