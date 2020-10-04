<div class="col-sm-12 rekap_page">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <i class="mdi mdi-chart-areaspline  "></i>
                Rekap Nilai
                {{-- <button class="btn btn-import-kkm btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button> --}}
                <button class="btn btn-new-kkm btn-info float-right mr-2" data-toggle="modal" data-target="#modalJurnalSiswa">
                    {{-- <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg> --}}
                    <i class="mdi mdi-cloud-download"></i>
                    Unduh
                </button>
                <button class="btn  btn-success float-right mr-2 btn-print-kkm">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>

            <div class="row">
                @if(Auth::user()->role != 'wali')
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="rombel">Rombel</label>
                            <select name="rombel" class="form-control selRombel">
                                <option value="0">Pilih Rombel</option>
                            </select>
                        </div>
                    </div>
                @else 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="mapel">Mapel</label>
                            <select name="mapel" class="form-control selMapel">
                                <option value="0">Pilih Mapel</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-rekap" id="table-rekap" style="width:100%">
                    {{-- <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS/NISN</th>
                            <th>NAMA</th>
                            <th>NILAI</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody> --}}
                    @if(Auth::user()->role == 'wali')
                        <div class="alert alert-danger">Pilih Mapel</div>
                    @else
                        <div class="alert alert-danger">Pilih Rombel</div>
                    @endif
                </table>
            </div>
        </div>

    </div>
</div>