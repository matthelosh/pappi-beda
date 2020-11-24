{{-- Modal Menu --}}
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form form-menu" method="POST" action="/menus">
                @csrf()
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Menu Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="parent_id" class="col-form-label">Menu Induk:</label>
                        <select name="parent_id" class="form-control selMenu" style="width:100%">
                            <option value="0">Menu Induk</option>
                            {{-- @if(isset($datas))
                                @foreach($datas as $menu)
                                    @if($menu->parent_id == 0)
                                        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                    @endif
                                @endforeach
                            @endif --}}
                        </select>
                    </div>
                    <div class="form-group">

                        <label for="title" class="col-form-label">Label:</label>
                        <input type="text" class="form-control" name="title" placeholder="Label Menu">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-form-label">URL:</label>
                        <input class="form-control" name="url" type="text" placeholder="URL Menu">
                    </div>
                    <div class="form-group">
                        <label for="ikon" class="col-form-label">Icon:</label>
                        <input class="form-control" name="ikon" placeholder="contoh: home">
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-form-label">Pengguna:</label>
                        <select name="role" class="form-control">
                            <option value="all">Pengguna</option>
                            <option value="admin">Admin</option>
                            <option value="wali">Wali Kelas</option>
                            <option value="guru">Guru Mapel</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal Menu --}}

{{-- Modal Users --}}
<div class="modal fade" id="modalUser">
    <div class="modal-dialog" role="document">
        <form action="/users" method="POST" class="modal-user form-user">
            @csrf()
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg>
                        Pengguna
                    </h4>
                    <button class="close" data-dismiss="modal">&times</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="sekolah_id">NIP</label>
                            <select name="sekolah_id" class="form-control selSekolah" style="width:100%">

                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" name="nip" placeholder="Cth: 198709081992011001">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="jk">Jenis Kelamin</label>
                            <select name="jk" class="form-control">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="username">Nama Pengguna</label>
                            <input type="text" name="username" class="form-control" placeholder="Nama Pengguna">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="role">Peran</label>
                            <select name="role"  class="form-control">
                                <option value="0">Pilih</option>
                                <option value="ks">Kepala Sekolah</option>
                                <option value="gmapel">Guru Mapel</option>
                                <option value="wali">Wali Kelas</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="password">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="hp">No. HP</label>
                            <input type="text" name="hp" class="form-control" placeholder="Cth. 6280807989098">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" cols="30" rows="3" class="form-control" placeholder="Alamat"></textarea>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- End MOdal Users --}}

{{-- Modal Import--}}
<div class="modal fade" id="modalImport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Impor <span id="model"></span>
                </h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" enctype="multipart/form-data" class="form form-import" method="POST">
                    @csrf()
                    <div class="form-group">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-cloud-upload') }}"></use>
                        </svg>
                        Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Import --}}

{{-- Modal Dialog Konfirmasi --}}
<div class="modal fade" id="modalConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title">
                    <span id="confirm-text"></span>
                </h4>
                <span class="id"></span>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-danger btn-lanjut">Lanjut</button>
                    <button class="btn btn-primary btn-batal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Modal Dialog Konfirmasi --}}

{{-- Modal Sekolah --}}
<div class="modal fade" id="modalSekolah">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-institution') }}"></use>
                    </svg>
                    <span class="mode-form">Entri</span> Sekolah
                </h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form form-sekolah">
                    @csrf()
                    <div class="container">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="npsn">NPSN</label>
                                <input type="text" name="npsn" placeholder="NPSN" class="form-control">
                            </div>
                            <div class="form-group col-sm-8">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" placeholder="NAMA SEKOLAH" class="form-control">
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" cols="30" rows="2" class="form-control" placeholder="ALAMAT"></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="desa">Desa/Kelurahan</label>
                                <input type="text" name="desa" placeholder="DESA/KELURAHAN" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="kec">Kecamatan</label>
                                <input type="text" name="kec" placeholder="KECAMATAN" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="kab">Kab/Kota</label>
                                <input type="text" name="kab" placeholder="KAB/KOTA" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="prov">Provinsi</label>
                                <input type="text" name="prov" placeholder="PROVINSI" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" name="kode_pos" placeholder="KODE POS" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="telp">No. Telp</label>
                                <input type="text" name="telp" placeholder="NO. TELEPON" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email">Email</label>
                                <input type="text" name="email" placeholder="EMAIL" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="website">Website</label>
                                <input type="text" name="website" placeholder="WEBSITE" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="operator_id">Operator</label>
                                <select name="operator_id" class="form-control selUsers" style="width:100%">
                                    <option value="0">PILIH OPERATOR</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ks_id">Kepala Sekolah</label>
                                <select name="ks_id" class="form-control selUsers" style="width:100%">
                                    <option value="0">Pilih Kepala Sekolah</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END Modal Sekolah --}}

{{-- Modal ROmbel --}}
<div class="modal fade" id="modalRombel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-room') }}"></use>
                    </svg>
                    <span class="mode-form">Buat</span> Rombel
                </h4>
                <button class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <form action="" class="form" id="formRombel">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="kode_rombel">Kode Rombel</label>
                            <input type="text" name="kode_rombel" placeholder="Kode Rombel" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama_rombel">Nama Rombel</label>
                            <input type="text" name="nama_rombel" placeholder="Nama Rombel" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="tingkat">Tingkat</label>
                            <select name="tingkat" class="form-control">
                                <option value="0">Pilih Tingkat</option>
                                <option value="1">1 (Satu)</option>
                                <option value="2">2 (Dua)</option>
                                <option value="3">3 (Tiga)</option>
                                <option value="4">4 (Empat)</option>
                                <option value="5">5 (Lima)</option>
                                <option value="6">6 (Enam)</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="guru_id">Wali Kelas</label>
                            <select name="guru_id" class="form-control selWali" style="width:100%"></select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="sekolah_id">Sekolah</label>
                            <select name="sekolah_id" class="form-control selSekolah" style="width:100%"></select>
                        </div>
                        <div class="form-group col-sm-12 text-right">
                            <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Manajemen ROmbel --}}
<div class="modal fade" id="modalMnjRombel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                    </svg>
                    <span class="small">Manajemen</span> Rombel
                </h4>
                <button class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Anggota Rombel <span class="rombel-now"></span></h4>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <select name="rombel_now" class="selRombel" style="width:100%"></select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button class="btn btn-sm btn-warning btn-pindah-member">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-left') }}"></use>
                                            </svg>
                                            Pindah
                                        </button>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <button class="btn btn-sm btn-danger btn-keluarkan-member">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-right') }}"></use>
                                            </svg>
                                            Keluarkan
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-members" id="table-members" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NISN</th>
                                                <th>NAMA</th>
                                                <th>
                                                    <label for="select_members">
                                                    <input type="checkbox" name="select_members" class="select-all">
                                                    Pilih Semua</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td>1</td>
                                                <td>Bejo</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Dina</td>
                                                <td></td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Belum Masuk Rombel</h4>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <button class="btn btn-sm btn-primary btn-masukkan-member">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-left') }}"></use>
                                            </svg>
                                            Masukkan
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-non-members" id="table-non-members" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NISN</th>
                                                <th>NAMA</th>
                                                <th>
                                                    <label for="select_members">
                                                    <input type="checkbox" name="select_members" class="select-all">
                                                    Pilih Semua</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td>1</td>
                                                <td>Bejo</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Dina</td>
                                                <td></td>
                                            </tr> --}}
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
</div>
{{-- End Manajemen Rombel --}}

{{-- Modal Siswa --}}
<div class="modal fade" id="modalSiswa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                    </svg>
                    <span class="mode-form">Buat</span> Siswa
                </h4>
                <button class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <form action="/siswas/create" method="POST" class="form form-siswa" id="form-siswa" enctype="multipart/form-data">
                    @csrf()
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="nis">NIS</label>
                            <input type="text" name="nis"  class="form-control" placeholder="NIS">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="nisn">NISN</label>
                            <input type="text" name="nisn"  class="form-control" placeholder="NISN">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" name="nama_siswa"  class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="jk">JK</label>
                            <select name="jk" class="form-control">
                                <option value="0">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="agama">Agama</label>
                            <select name="agama" class="form-control">
                                <option value="0">Pilih</option>
                                <option value="Islam">Islam</option>
                                <option value="Protestan">Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konguchu">Konghuchu</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" cols="30" rows="2" class="form-control" placeholder="Alamat"></textarea>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="desa">Desa/Kelurahan</label>
                            <input type="text" name="desa" placeholder="Desa/Kelurahan" class="form-control">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="kec">Kecamatan</label>
                            <input type="text" name="kec" placeholder="Kecamatan" class="form-control">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="kab">Kab/Kota</label>
                            <input type="text" class="form-control" name="kab" placeholder="Kab/Kota">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="prov">Provinsi</label>
                            <input type="text" class="form-control" name="prov" placeholder="Provinsi">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="hp">HP</label>
                            <input type="text" class="form-control" name="hp" placeholder="No. HP">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="sekolah_id">Sekolah</label>
                            <select name="sekolah_id" class="form-control selSekolah" style="width:100%">
                                <option value="0">Sekolah</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="rombel_id">Rombel</label>
                            <select name="rombel_id" class="form-control selRombel" style="width:100%">
                                <option value="0">Rombel</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="foto">Foto Siswa</label>
                            <input type="file" name="foto_siswa" class="form-control">
                        </div>
                        <div class="form-group col-sm-4">
                            <img src="" alt="Foto Siswa" class="img img-thumbnail foto-siswa" onerror="this.onerror=null;this.src='img/favicon.png'">
                        </div>
                        <div class="form-group col-sm-12 text-right">
                            <button class="btn btn-primary" type="submit">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ortu --}}
<div class="modal fade" id="modalOrtu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-blind') }}"></use>
                    </svg>
                    <span class="mode-form">Buat</span> Ortu <span class="siswa"></span>
                </h4>
                <button class="close" data-dismiss="modal">&times</button>
            </div>
            <div class="modal-body">
                <form action="/ortus/create" method="POST" class="form form-ortu" id="form-ortu">
                    @csrf()
                    <input type="hidden" name="siswa_id" value>
                    <div class="d-none hidden-input"></div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="nama_ayah">Nama Ayah</label>
                            <input type="text" name="nama_ayah"  class="form-control" placeholder="Nama Ayah">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="job_ayah">Pekerjaan Ayah</label>
                            <input type="text" name="job_ayah"  class="form-control" placeholder="Pekerjaan Ayah">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" name="nama_ibu"  class="form-control" placeholder="Nama Ibu">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="job_ibu">Pekerjaan Ibu</label>
                            <input type="text" name="job_ibu"  class="form-control" placeholder="Pekerjaan Ibu">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nama_wali">Nama Wali</label>
                            <input type="text" name="nama_wali"  class="form-control" placeholder="Nama Wali">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="job_wali">Pekerjaan Wali</label>
                            <input type="text" name="job_wali"  class="form-control" placeholder="Pekerjaan Wali">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="hub_wali">Hubungan Dengan Siswa</label>
                            <input type="text" name="hub_wali"  class="form-control" placeholder="Hubungan Wali">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="alamat_wali">Alamat Wali</label>
                            <textarea name="alamat_wali" cols="30" rows="5" class="form-control" placeholder="Alamat Wali"></textarea>
                        </div>
                        <div class="form-group col-sm-12 text-right">
                            <button class="btn btn-primary" type="submit">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Mapel --}}
    <div class="modal fade" id="modalMapel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-layers') }}"></use>
                        </svg>
                        <span class="mode-form">Buat</span> Mapel
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/mapels/create" class="form form-mapel" id="form-mapel" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="kode_mapel">Kode Mapel</label>
                                <input type="text" name="kode_mapel" placeholder="Kode Mapel" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="nama_mapel">Nama Mapel</label>
                                <input type="text" name="nama_mapel" placeholder="Nama Mapel" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="label">Label Mapel</label>
                                <input type="text" name="label" placeholder="cth.: MTK" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="tingkat">Tingkat</label>
                                <select name="tingkat" class="form-control">
                                    <option value="0">Pilih Tingkat</option>
                                    <option value="all">Semua Tingkat</option>
                                    <option value="besar">Kelas Besar</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Modal Kd --}}
    <div class="modal fade" id="modalKd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-book') }}"></use>
                        </svg>
                        <span class="mode-form">Buat</span> Kompetensi Dasar
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/kds/create" class="form form-kd" id="form-kd" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ranah">Ranah KD</label>
                                <select name="ranah" placeholder="Kode KD" class="form-control">
                                    <option value="0">Pilih Ranah Kompetensi</option>
                                    <option value="1">Spiritual</option>
                                    <option value="2">Sosial</option>
                                    <option value="3">Pengetahuan</option>
                                    <option value="4">Keterampilan</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="kode_kd">Kode KD</label>
                                <input type="text" name="kode_kd" placeholder="Kode KD" class="form-control">
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="teks_kd">Teks KD</label>
                                <textarea name="teks_kd"  cols="30" rows="6" class="form-control" placeholder="Teks KD"></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="mapel_id">Mapel</label>
                                <select name="mapel_id" class="form-control selMapel" style="width:100%; height: 41px;">
                                    <option value="0">Pilih Mapel</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="tingkat">Tingkat</label>
                                <select name="tingkat" class="form-control">
                                    <option value="0">Pilih Tingkat</option>
                                    <option value="1">1 (Satu)</option>
                                    <option value="2">2 (Dua)</option>
                                    <option value="3">3 (Tiga)</option>
                                    <option value="4">4 (Empat)</option>
                                    <option value="5">5 (Lima)</option>
                                    <option value="6">6 (Enam)</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Modal Periode --}}
    <div class="modal fade" id="modalPeriode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-calendar') }}"></use>
                        </svg>
                        <span class="mode-form">Buat</span> Periode
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/periode/create" class="form form-periode" id="form-periode" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="tanggal">Piih Tanggal</label>
                                <input class="form-control" type="date" name="tanggal" placeholder="Pilih Tanggal untuk menentukan kode periode">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="kode_periode">Kode Periode</label>
                                <input class="form-control" type="text" name="kode_periode" placeholder="Kode Periode">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="tapel">Tahun Pelajaran</label>
                                <input class="form-control" type="text" name="tapel" placeholder="Tahun Pelajaran">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="semester">Semester</label>
                                <input class="form-control" type="text" name="semester" placeholder="Semester">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="label">Label</label>
                                <input class="form-control" type="text" name="label" placeholder="Label">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="status">Status</label>
                                <select class="form-control" name="status">
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Modal TanggalRapor --}}
    <div class="modal fade" id="modalTanggalRapor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-calendar') }}"></use>
                        </svg>
                        <span class="mode-form">Buat</span> Tanggal Rapor
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/tanggal-rapor/create" class="form form-tanggal-rapor" id="form-tanggal-rapor" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="sekolah_id">Piih Sekolah</label>
                                <select class="form-control selSekolah" name="sekolah_id" style="width:100%">
                                    <option value="0">Pilih Sekolah</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="periode_id">Piih Periode</label>
                                <select class="form-control selPeriode" name="periode_id" style="width:100%">
                                    <option value="0">Pilih Periode</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="tanggal">Piih Tanggal</label>
                                <input class="form-control" type="date" name="tanggal" placeholder="Pilih Tanggal untuk menentukan kode periode">
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{-- Modal KKM --}}
    <div class="modal fade" id="modalKkm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-sort-numeric-up') }}"></use>
                        </svg>
                        <span class="mode-form">Buat</span> KKM
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/{{ Auth::user()->username }}/kkm/create" class="form form-kkm" id="form-kkm" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="sekolah_id">Piih Sekolah</label>
                                <select class="form-control selSekolah" name="sekolah_id" style="width:100%">
                                    <option value="0">Pilih Sekolah</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="periode_id">Piih Periode</label>
                                <select class="form-control selPeriode" name="periode_id" style="width:100%">
                                    <option value="0">Pilih Periode</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="mapel_id">Piih Mapel</label>
                                <select class="form-control selMapel" name="mapel_id" style="width:100%">
                                    <option value="0">Pilih Mapel</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="kkm">KKM</label>
                                <input type="number" min="0" max="100" class="form-control kkm" name="nilai" style="width:100%" placeholder="Min 0; Max 100">

                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- Modal Jurnal Siswa --}}
    <div class="modal fade" id="modalJurnalSiswa">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                        </svg>
                        <span class="mode-form">Entri</span> Jurnal Sikap
                    </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/{{ Auth::user()->username }}/jurnals/create" class="form form-jurnal" id="form-jurnal" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="tanggal ">Tanggal Kejadian</label>
                                <input type="date" class="form-control" name="tanggal">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="aspek">Aspek</label>
                                <select class="form-control" name="aspek" style="width:100%">
                                    <option value="0">Pilih Aspek</option>
                                    @if(Auth::user()->role == 'gpai')
                                        <option value="1">Spiritual</option>
                                    @else
                                        <option value="2">Sosial</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="siswa_id">Siswa</label>
                                <select class="form-control selSiswaKu" name="siswa_id" style="width:100%">
                                    <option value="0">Pilih Siswa</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="catatan">Catatan Perilaku</label>
                                <textarea name="catatan" cols="30" rows="3" class="form-control" placeholder="Perilaku Siswa"></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="butir_sikap">Butir Sikap</label>
                                <select name="butir_sikap" class="form-control selSikap" style="width:100%">
                                    <option value="0">Butir Sikap</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="nilai">Nilai</label>
                                <select name="nilai" class="form-control">
                                    <option value="0">Nilai Sikap</option>
                                    <option value="A">Sangat Baik</option>
                                    <option value="B" selected>Baik</option>
                                    <option value="C">Cukup</option>
                                    <option value="D">Perlu Bimbingan</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <button class="btn btn-primary btn-submit-rombel" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@if(Auth::user()->role != 'admin')
    <div class="modal fade" id="modalDataRapor">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content" style="width:100%">
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
                    </div>
                </div>
                </form>
                <hr>
                <h3>Prestasi <button class="btn btn-more-prestasi btn-circle btn-secondary btn-sm">&plus;</button></h3>
                <hr>

                <form action="" class="form form-inline form-prestasi">
                @csrf()
                <div class="container container-row">
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

    <div class="modal fade" id="modalEditNilai">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Edit Nilai </h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h3 class="nama_siswa"></h3>
                   
                    <form action="/{{ Auth::user()->username }}/nilais/update" method="POST" class="formEditNilai">
                        {{-- @csrf() --}}
                        <input type="hidden" name="id_nilai">
                        <input type="hidden" name="nisn">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="aspek" >
                        <div class="form-group">
                            <input type="number" min="0" max="100" placeholder="Nilai Baru" 
                            name="nilai" class="form-control">
                        </div>
                        <button class="btn btn-primary">Perbarui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
