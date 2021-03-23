<div class="col-sm-12">
    <div class="card card-entri-nilai">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                        </svg>
                        Entri Nilai

                    </h4> 
                </div>
                <div class="col-sm-6">
                    <button class="btn float-right mr-2 btn-show-tool-form-nilai"><i class="mdi mdi-arrow-expand-down"></i></button>   
                    @if(Auth::user()->role != 'wali')
                        <div class="form-group float-right mr-2">
                            <select name="rombel" class="form-control selRombel" style="width:200px;">
                                <option value="0">Pilih Rombel</option>
                            </select>
                        </div>
                    @endif
                </div>
            </div>
             
            
        </div>
        <div class="card-body tool-form-nilai">
            <div class="row">
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="periode_id">Periode</label>
                        @php
                            $periode = Session::get('periode_aktif');
                        @endphp
                        <select name="periode_id" style="width:100%" class="selPeriode">
                            <option value="{{ $periode }}">20{{ substr($periode, 0, 2) }}/20{{ substr($periode, 2,2) }} - {{ (substr($periode, 4,1) == '1') ? 'Ganjil': 'Genap' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-2">
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
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="kd_id">Kompetensi Dasar</label>
                        <select name="kd_id" style="width:100%" class="selKd">
                            <option value="0">Pilih KD</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 text-center">
                    {{-- <div class="btn-group"> --}}
                        <button class="btn btn-square btn-info btn-form-nilai">
                            <i class="mdi mdi-magnify"></i>
                            Lihat
                        </button>
                        <button class="btn btn-square btn-danger btn-unduh-format">
                            <i class="mdi mdi-cloud-download-outline"></i>
                            Download Format
                        </button>
                    {{-- </div> --}}
                </div>
            </div>
            {{-- <hr> --}}
        </div>
    </div>
</div>
<div class="col-sm-12 d-none card-entri-nilai-parent">
    <div class="card card-entri-nilai">
        {{-- <div class="card-header">
        </div> --}}
        <div class="card-body">
            <div class="row" >
                <div class="col-sm-3">
                    <div class="card  card-impor-nilai">
                        <div class="card-header toggle-body" >
                            <h4 class="card-title text-center my-0"><i class="mdi mdi-clipboard-outline"></i> IMPOR NILAI</h4>
                        </div>
                        <div class="card-body d-none d-sm-block">
                            <form action="/{{ Auth::user()->username }}/nilais/import" class="form-import-nilai" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="row">
                                    <div class="form-group col-sm-12 text-center">
                                        <label for="file_nilai">File Nilai</label>
                                        <input type="file" name="file_nilai" style="display:none" id="file_nilai">
                                        {{-- <input type="text" name="nama_file" class="form-control"> --}}
                                        <span class="folder-file text-center d-block file-unpicked">
                                            <i class="mdi mdi-folder-upload-outline mdi-48px"></i>
                                        </span>
                                    </div>
                                    <div class="form-group col-sm-12 text-center">
                                        <button class="btn btn-primary btn-square btn-import-nilai">
                                            <i class="mdi mdi-cloud-upload-outline"></i>
                                            Unggah
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-9">
                    <div class="card card-form-nilai">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="card-title">Form Nilai</h4>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-danger btn-square btn-export-nilai float-right"><i class="mdi mdi-file-excel"></i> Export Excel</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            
                            <form action="/{{ Auth::user()->username }}/nilais/entri" method="POST" class="form-nilai">
                                @csrf()
                                <input type="hidden" name="periode_id" value="">
                                <input type="hidden" name="jenis" value="">
                                <input type="hidden" name="mapel_id" value="">
                                <input type="hidden" name="aspek" value="">
                                <input type="hidden" name="kd_id" value="">
                                <div class="table-responsive">
                                    
                                    <table class="table table-bordered table-form-nilai" style="width: 100%;" id="table-form-nilai">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">NIS / NISN</th>
                                                <th class="text-center">NAMA</th>
                                                <th class="text-center">NILAI</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <div class="form-list d-none justify-content-center align-items-center bg-info text-white" style="width: 100%; height: 105px;">
                                                <div class="text-center"><i class="mdi mdi-reload mdi-spin mdi-48px"></i><br>Tunggu Sebentar ..</div>
                                            </div>
                                        </tbody>
                                    </table>
                                    
                                    
                                </div>
                                <div class="row text-right">
                                    <button class="btn btn-primary d-none btn-lg btn-square mx-auto" type="submit"><i class="mdi mdi-pencil"></i> Simpan</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>

{{-- {{ dd(Session::all()) }} --}}