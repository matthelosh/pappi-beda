<div class="col-sm-12 rekap_page">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2">
                    <h4 class="card-title">
                        <i class="mdi mdi-chart-areaspline  "></i>
                        Rekap Nilai
                    </h4>
                </div>
                <div class="col-sm-10">
                    <div class="row">
                    @if(Auth::user()->role != 'wali')
                    <div class="col-sm-3">
                        <div class="form-group">
                            {{-- <label for="rombel">Rombel</label> --}}
                            <select name="rombel" class="form-control selRombel">
                                <option value="0">Pilih Rombel</option>
                            </select>
                        </div>
                    </div>
                @else 
                    <div class="col-sm-3">
                        <div class="form-group">
                            {{-- <label for="mapel">Mapel</label> --}}
                            <select name="mapel" class="form-control selMapel">
                                <option value="0">Pilih Mapel</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-sm-3">
                    <div class="form-group">
                        {{-- <label for="jenis">Jenis Penilaian</label> --}}
                        <select name="jenis" class="form-control selJenis">
                            <option value="0">Pilih Jenis</option>
                            <option value="uh">Harian</option>
                            <option value="pts">PTS</option>
                            <option value="pas">PAS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {{-- <label for="aspek">Aspek Penilaian</label> --}}
                        <select name="aspek" class="form-control selAspek">
                            <option value="0">Pilih Aspek</option>
                            <option value="1">Spiritual</option>
                            <option value="2">Sosial</option>
                            <option value="3">Pengetahuan</option>
                            <option value="4">Keterampilan</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        {{-- <label for="b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> --}}
                        <button class="btn btn-square btn-danger btn-rekap-nilai"> Lihat  </button>
                    </div>

                </div>
            </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped table-rekap" id="table-rekap" style="width:100%">
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