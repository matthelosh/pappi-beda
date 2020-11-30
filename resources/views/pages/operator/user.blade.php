<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <i class="mdi mdi-card-account-details-outline"></i>
                Data Pengguna
                <div class="float-right">
                    <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalUser"    ><i class="mdi mdi-account"></i> Tambah</button>
                    <button class="btn btn-primary btn-import-user"><i class="mdi mdi-upload"></i> Unggah</button>
                </div>
            </h4>
            <hr>
            <div class="card-text">
                <div class="table-responsive">
                    <table class="table table-users table-sm table-striped table-users" id="table-users" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sekolah</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th class="d-none">ID</th>
                                <th>JK</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>HP</th>
                                <th>Alamat</th>
                                <th>Password Asli</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ $loop->index + 1}}</td>
                                    <td>{{ $user->sekolahs->nama_sekolah }}</td>
                                    <td><img class="img img-circle circled" src="{{ asset('img/users/'.$user->nip.'.jpg')}}" onerror="this.onerror=null;this.src='/img/users/user.jpg';" alt="Foto User" height="50px"></td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td class="d-none">{{ $user->id }}</td>
                                    <td>{{ $user->jk }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->hp }}</td>
                                    <td>{{ $user->alamat }}</td>
                                    <td>{{ $user->default_password }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-edit-user" title="Edit {{ $user->nama }}">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                                            </svg>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete-user" title=" Hapus {{ $user->nama }}">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                                            </svg>
                                        </button>
                                        <button class="btn btn-warning btn-sm btn-reset-password" title="Reset Password {{ $user->nama }}">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-reload') }}"></use>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>