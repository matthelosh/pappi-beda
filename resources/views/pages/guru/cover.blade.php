<div class="row">
    <div class="col-sm-8" >
        <div class="page_rapor text-center" id="cover_rapor">
            <div class="content_cover">
                <img src="{{ asset('img/tutwuri.png') }}" alt="Tutwuri" height="150px" class="logo_tutwuri">
                <div class="judul">
                    <h2 class="text-center">RAPOR</h2>
                    <h2 class="text-center">PESERTA DIDIK</h2>
                    <h2 class="text-center">SEKOLAH DASAR</h2>
                    <h2 class="text-center">(SD)</h2>
                </div>

                <div class="nama_siswa">
                    <p class="text-center">Nama Peserta Didik</p>
                    <p class="text-center nama">{{ $siswa->nama_siswa }}</p>
                    <p class="text-center">NISN/NIS</p>
                    <p class="text-center nis">{{ $siswa->nisn }}/{{ $siswa->nis ?? '-' }}</p>
                </div>

                <h2 class="text-center teks-bawah">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN <br /> REPUBLIK INDONESIA</h2>
            </div>
            
        </div>
    </div>
    <div class="col-sm-4" style="padding: 20px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="mdi mdi-printer"></i>
                        Cetak Cover
                    </h4>
                </div>
                <div class="card-body" class="cetak-raport-toolbox">
                    {{-- <div class="form-group cetak-toolbox">
                        <label for="siswa">Siswa</label>
                        <select name="siswa" id="siswa" class="form-control selSiswaKu" style="width:100%">
                            <option value="0">Pilih Siswa</option>
                        </select>
                    </div> --}}
                    <div class="form-group text-center">
                        <button class="btn btn-lg btn-primary" id="btn-print-cover">
                            <i class="mdi mdi-printer"></i>
                            Cetak
                        </button>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

</div>