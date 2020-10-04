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

