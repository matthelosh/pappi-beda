<h1>{{ Auth::user()->level }}</h1>
<div class="col-sm-3">
    <div class="card bg-gradient-warning">
        <div class="card-body">
            <h5 class="card-title text-white">
                <svg class="c-icon mr-2">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                </svg>
                Pengguna
            </h5>

            <div class="text-value-lg text-white">10 Orang</div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card bg-gradient-danger">
        <div class="card-body">
            <h5 class="card-title text-white">
                <svg class="c-icon mr-2">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                </svg>
                Siswa
            </h5>
            <div class="text-value-lg text-white">221 Orang</div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card bg-gradient-info">
        <div class="card-body">
            <h5 class="card-title text-white">
                <svg class="c-icon mr-2">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-room') }}"></use>
                </svg>
                Rombel
            </h5>
            <div class="text-value-lg text-white">8</div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card bg-gradient-success">
        <div class="card-body">
            <h5 class="card-title text-white">
                <svg class="c-icon mr-2">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-book') }}"></use>
                </svg>
                Mapel
            </h5>
            <div class="text-value-lg text-white">10</div>
        </div>
    </div>
</div>