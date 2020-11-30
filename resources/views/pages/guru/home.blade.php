<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Selamat Datang {{ Auth::user()->nama }}
            </h4>
            <p class="card-text">{{ Session::get('sekolah')->nama_sekolah }}</p>
        </div>
    </div>
</div>