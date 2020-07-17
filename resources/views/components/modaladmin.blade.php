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
                        <select name="parent_id" class="form-control">
                            <option value="0">Menu Induk</option>
                            @if(isset($datas))
                                @foreach($datas as $menu)
                                    @if($menu->parent_id == 0)
                                        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                    @endif
                                @endforeach
                            @endif
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

{{-- Modal Import User --}}
<div class="modal fade" id="modalImport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
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
{{-- End Modal Import User --}}

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
                <form action="" method="post" class="form">
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
                                <select name="operator_id" class="form-control">
                                    <option value="0">PILIH OPERATOR</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ks_id">Kepala Sekolah</label>
                                <select name="ks_id" class="form-control">
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