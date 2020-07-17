<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                </svg>
                Data Pengguna
                <button class="btn btn-reset-all btn-danger float-right">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-reload') }}"></use>
                    </svg>
                    Reset Password
                </button>
                <button class="btn btn-import-user btn-primary float-right mr-2">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-spreadsheet') }}"></use>
                    </svg>
                    Import
                </button>
                <button class="btn btn-add btn-info float-right mr-2" data-toggle="modal" data-target="#modalUser">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                    </svg>
                    Buat
                </button>
                <button class="btn btn-add btn-success float-right mr-2 btn-print-users">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
                    </svg>
                    Cetak
                </button>
            </h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-users" id="table-users" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
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
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->nama }}</td>
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