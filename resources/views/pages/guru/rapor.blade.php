.<div class="card text-left col-sm-12">
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
        </tbody>
      </table>

    </div>
  </div> 
</div>

