<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="mdi mdi-card-account-details-outline"></i> Profil</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2 text-center">
                    @php
                        if(file_exists(public_path('/img/users/'.Auth::user()->nip.'.jpg'))) {
                            $foto = '/img/users/'.Auth::user()->nip.'.jpg';
                        } else {
                            if(Auth::user()->jk == 'l') {
                                $foto = '/img/users/guru_l.png';
                            } else {
                                $foto = '/img/users/guru_p.png';
                            }
                        }
                    @endphp
                    <img src="{{ $foto??'' }}" alt="Foto Profil" style="width: 100%;border-radius:50%;">
                </div>
                <div class="col-sm-8">
                    <h1 class="text-primary m-y-0">{{ Auth::user()->nama }}</h1>
                    <h4 class="my-0 text-blue">{{ Auth::user()->nip }}</h4>
                    <br>
                    <div class="form-group">
                        <button class="btn btn-lg btn-danger btn-square">Ganti Profil</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Detil</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td><i class="mdi mdi-mail"></i> Email</td>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-whatsapp"></i> No. HP</td>
                                <td>{{ Auth::user()->hp }}</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-map"></i> Alamat</td>
                                <td>{{ Auth::user()->alamat }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>