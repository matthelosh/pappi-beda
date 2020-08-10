.<div class="card text-left col-sm-12">
  {{-- <img class="card-img-top" src="holder.js/100px180/" alt=""> --}}
  <div class="card-header">
    <h4 class="card-title">Data Siswa Kelas {{ Session::get('rombel')->nama_rombel }} {{ Session::get('semester') }}</h4>
    <div class="row">
      <div class="form-group col-sm-2">
        <label for="tapel">Tapel:</label>
        <select name="tapel" id="tapel-rapor" class="form-control">
          @php
            $Y = date('Y');
            $m = date('m');
            for($i = ($Y-3) ; $i < ($Y + 5) ; $i++) {
              $sem = Session::get('semester');


              if($m < 7) {
                  $selected = ($i == ($Y -1)) ? 'selected' : '';
              } else {
                $selected = ($i == $Y) ? 'selected' : '';
              }
              
              echo '<option value="'.$i.'/'.($i+1).'" '.$selected.'>'.$i.'/'.($i+1).'</option>';
            }
          @endphp
          {{-- <option value="0">Semester</option> --}}
        </select>
      </div>
      <div class="col-sm-2 form-group">
        <label for="semester">Semester</label>
        <select name="semester" id="semester-rapor" class="form-control">
          @php
            $m = date('m');
            if($m > 6 ) {
              echo '<option value="1" selected>Ganjil</option>';
              echo '<option value="2" >Genap</option>';
            } else {
              echo '<option value="1" >Ganjil</option>';
              echo '<option value="2" selected >Genap</option>';
            }
          @endphp
          {{-- <option value="0">Semester</option> --}}
        </select>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="container-fluid">
      <table class="table table-striped table-lg" style="width:100%" id="table-siswa-rapor">
        <thead>
          <th>No</th>
          <th>NISN</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Opsi</th>
        </thead>
        <tbody>
          {{-- @foreach($siswas as $siswa)
            <tr>
              <td>{{ $loop->index +1 }}</td>
              <td>{{ $siswa->nisn }}</td>
              <td>
                <img src="{{ asset('img/siswas/'.Session()->get('sekolah_id').'_'.$siswa->nisn.'.jpg') }}" alt="Foto" onerror="this.onerror=null;this.src='/img/no-photo.jpg'" height="50px" class="img img-avatar">
              </td>
              <td>{{ $siswa->nama_siswa }}</td>
              <td>
                <a href="/rapor/cetak?nisn={{ $siswa->nisn }}&periode={{ Session()->get('periode_aktif') }}" class="btn btn-primary">
                  <i class="mdi mdi-printer"></i>
                </a>
                <button class="btn btn-info btn-edit-data"><i class="mdi mdi-pencil"></i></button>
              </td>
            </tr>
          @endforeach --}}
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="modal" id="modalDataRapor">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Data Rapor <span id="nama_siswa"></span></h4>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" id="form-saran">
          <h3>Saran</h3>
          <hr>
          @csrf()
          <input type="hidden" value="{{ Session::get('periode_aktif') }}" name="semester">
          <input type="hidden" value="{{ Session::get('rombel')->kode_rombel }}" name="rombel">
          <input type="hidden" value="0" name="siswa_id">
          <div class="container">
          <div class="row-fluid">
            <div class="form-group col-as-12">
              <label for="saran">Saran</label>
              <textarea name="saran" id="saran" cols="30" rows="5" class="form-control"></textarea>
            </div>
            {{-- <div class="form-group col-sm-12 text-center">
              <button class="btn btn-primary btn-simpan-saran">Simpan Saran</button>
            </div> --}}
            </div>
          </div>
        </form>
        <hr>
        <form action="" class="form form-detil-siswa">
          <h3>Detil Siswa</h3>
          <hr>
          @csrf()
          <div class="container">
            <div class="row">
              <div class="form-group col-sm-2">
                <label for="tb">Tinggi Badan</label>
                <input type="text" name="tb" class="form-control">
              </div>
              <div class="form-group col-sm-2">
                <label for="tb">Berat Badan</label>
                <input type="text" name="bb" class="form-control">
              </div>
              <div class="form-group col-sm-4">
                <label for="pendengaran">Pendengaran</label>
                <input type="text" name="pendengaran" class="form-control">
              </div>
              <div class="form-group col-sm-4">
                <label for="penglihatan">Pengelihatan</label>
                <input type="text" name="penglihatan" class="form-control">
              </div>
              <div class="form-group col-sm-4">
                <label for="gigi">Gigi</label>
                <input type="text" name="gigi" class="form-control">
              </div>
              <div class="form-group col-sm-4">
                <label for="fisik_lain">Fisik Lainnya</label>
                <input type="text" name="fisik_lain" class="form-control">
              </div>
              {{-- <div class="form-group col-sm-12 text-center">
                <button class="btn btn-primary btn-submit-detil-siswa">Simpan Detil Siswa</button>
              </div> --}}
            </div>
          </div>
        </form>
        <hr>
        <h3>Prestasi <button class="btn btn-more-prestasi btn-circle btn-secondary btn-sm">&plus;</button></h3>
        <hr>

        <form action="" class="form form-inline form-prestasi">
          @csrf()
          <div class="container container-row">
            {{-- <div class="row row-input my-2">
              <div class="form-group col-sm-3">
                <label for="tingkat">Tingkat:</label>
                <input type="text" name="tingkat[]" placeholder="cth. Korwil Wagir" class="form-control mx-2">
              </div>
              <div class="form-group col-sm-3">
                <label for="jenis_prestasi">Jenis Prestasi:</label>
                <input type="text" name="jenis_prestasi[]" placeholder="cth. Lomba Lari 100m" class="form-control mx-2">
              </div>
              <div class="form-group col-sm-5">
                <label for="ket">Keterangan:</label>
                <input type="text" name="ket[]" placeholder="cth. Juara 1" class="form-control mx-2" style="width:80%">
              </div>
              <div class="form-group col-sm-1">
                <button class="btn btn-danger btn-rem-row">Hapus</button>
              </div>
            </div> --}}
          </div>
          
        </form>
        <hr>
        <h3>Ketidak-hadiran</h3>
          <hr>
        <form action="" class="form form-inline form-absensi">
          
          @csrf()
          <div class="container">
            <div class="row">
              <div class="form-group col-sm-3">
                <label for="sakit" class="">Sakit:</label>
                <div class="input-group mx-2">
                  <input type="text" class="form-control" name="sakit">
                </div>
              </div>
              <div class="form-group col-sm-3">
                <label for="izin" class="">Izin:</label>
                <div class="input-group mx-2">
                  <input type="text" class="form-control" name="izin">
                </div>
              </div>
              <div class="form-group col-sm-3">
                <label for="alpa" class="">Alpa:</label>
                <div class="input-group mx-2">
                  <input type="text" class="form-control" name="alpa">
                </div>
              </div>
              
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="form-group col-sm-12 text-center">
          <div class="btn-group">
              <button class="btn btn-danger" data-dismiss="modal">Batal</button>
              <button class="btn btn-primary btn-simpan-detil">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>