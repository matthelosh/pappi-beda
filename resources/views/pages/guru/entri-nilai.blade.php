<div class="col-sm-12">
    <div class="card card-entri-nilai">
        <div class="card-header">
             <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                </svg>
                Entri Nilai

                
                {{-- <button class="btn btn-import-mapelku btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-new-mapelku btn-info float-right mr-2" data-toggle="modal" data-target="#modalMapel">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
                </button> --}}
            </h4>    
            <button class="btn  btn-success float-right mr-2 btn-print-mapelku">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                </svg>
                Cetak
            </button>
            @if(Auth::user()->role != 'wali')
                <div class="form-group float-right mr-2">
                    <select name="rombel" class="form-control selRombel" style="width:200px;">
                        <option value="0">Pilih Rombel</option>
                    </select>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="periode_id">Periode</label>
                        <select name="periode_id" style="width:100%" class="selPeriode">
                            <option value="0">Pilih Periode</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-1">
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <select name="jenis" style="width:100%" class="select">
                            <option value="0">Jenis Nilai</option>
                            <option value="uh">Harian</option>
                            <option value="pts">PTS</option>
                            <option value="pas">PAS</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="mapel_id">Mapel</label>
                        <select name="mapel_id" style="width:100%" class="selMapel">
                            <option value="0">Pilih Mapel</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="aspek">Aspek</label>
                        <select name="aspek" style="width:100%" class="select selAspek">
                            <option value="0">Aspek</option>
                            {{-- @if(Auth::user()->role == 'gpai')
                                <option value="1">K1</option>
                            @elseif(Auth::user()->role == 'wali')
                                <option value="2">K2</option>
                            @endif
                            <option value="3">K3</option>
                            <option value="4">K4</option> --}}
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="form-group">
                        <label for="kd_id">Kompetensi Dasar</label>
                        <select name="kd_id" style="width:100%" class="selKd">
                            <option value="0">Pilih KD</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 text-center">
                    {{-- <div class="btn-group"> --}}
                        <button class="btn btn-primary btn-form-nilai">
                            <i class="mdi mdi-magnify"></i>
                            Lihat
                        </button>
                        <button class="btn btn-primary btn-unduh-format">
                            <svg class="c-icon">
                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-cloud-download') }}"></use>
                            </svg>
                            Download Format
                        </button>
                    {{-- </div> --}}
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Nilai</h4>
                            <form action="/{{ Auth::user()->username }}/nilais/entri" method="POST" class="form-nilai">
                                @csrf()
                                <input type="hidden" name="periode_id" value="">
                                <input type="hidden" name="jenis" value="">
                                <input type="hidden" name="mapel_id" value="">
                                <input type="hidden" name="aspek" value="">
                                <input type="hidden" name="kd_id" value="">
                                <div class="table-responsive">
                                    
                                    <table class="table table-striped table-form-nilai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIS / NISN</th>
                                                <th>NAMA</th>
                                                <th>NILAI</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <div class="form-list d-none justify-content-center align-items-center bg-info text-white" style="width: 100%; height: 105px;">
                                                <div class="text-center"><i class="mdi mdi-reload mdi-spin mdi-48px"></i><br>Tunggu Sebentar ..</div>
                                            </div>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary d-none" type="submit">Simpan</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Impor Nilai</h4>
                            
                                <form action="/{{ Auth::user()->username }}/nilais/import" class="form-import-nilai" method="POST" enctype="multipart/form-data">
                                    @csrf()
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="file_nilai">File Nilai</label>
                                            <input type="file" name="file_nilai" style="display:none" id="file_nilai">
                                            <input type="text" name="nama_file" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12 text-center">
                                            <button class="btn btn-primary btn-import-nilai">
                                                <svg class="c-icon">
                                                    <use xlink:href="{{ asset('/coreui/vendors/@coreui/icons/svg/free.svg#cil-cloud-upload') }}"></use>
                                                </svg>
                                                Unggah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>