<div class="col-sm-12 jurnal_page">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg>
                Jurnal Siswa
                {{-- <button class="btn btn-import-kkm btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button> --}}
                <button class="btn btn-new-kkm btn-info float-right mr-2" data-toggle="modal" data-target="#modalJurnalSiswa">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                    </svg>
                    Buat
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
                @if(Auth::user()->role != 'wali' || Auth::user()->role != 'admin')
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="rombel">Rombel</label>
                            <select name="rombel" class="form-control selRombel">
                                <option value="0">Pilih Rombel</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-jurnal" id="table-jurnal" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>TANGGAL</th>
                            <th>NIS/NISN</th>
                            <th>NAMA</th>
                            <th>ROMBEL</th>
                            <th>CATATAN PERILAKU</th>
                            <th>BUTIR SIKAP</th>
                            <th>NILAI</th>
                            <th>ASPEK</th>
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