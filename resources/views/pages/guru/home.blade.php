<div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg>
                Jurnal Spiritual
            </h4>
            <div class="row">
                <div class="col-8">
                    @if(Auth::user()->role !='gor' || Auth::user()->role !='gib')
                        <h4>Jumlah {{ $jurnals->count() }} Catatan</h4>
                        @php
                            $jmlA = 0;
                            $jmlC = 0;
                            $jmlD = 0;
                            foreach($jurnals as $jurnal)
                            {
                                switch($jurnal->nilai)
                                {
                                    case "A":
                                        $jmlA +=1;
                                    break;
                                    case "C":
                                        $jmlC +=1;
                                    break;
                                    case "D":
                                        $jmlD +=1;
                                    break;
                                }
                            }
                        @endphp
                        <p>A: {{ $jmlA }}</p>
                        <p>C: {{ $jmlC }}</p>
                        <p>D: {{ $jmlD }}</p>
                    @endif
                </div>
                <div class="col-4 text-right">
                    <btn class="btn btn-sm btn-primary btn-pill" data-toggle="modal" data-target="#modalJurnalSiswa">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                        </svg>
                    </btn>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg>
                Jurnal Sosial
            </h4>
            <div class="row">
                <div class="col-8">
                    <p>A: 3 siswa</p>
                    <p>C: 5 siswa</p>
                    <p>D: 1 siswa</p>
                </div>
                <div class="col-4 text-right">
                    <a href="/#" class="btn btn-sm btn-primary btn-pill">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg>
                Nilai Pengetahuan
            </h4>
            <div class="row">
                <div class="col-8">
                    <p>A: 3 siswa</p>
                    <p>C: 5 siswa</p>
                    <p>D: 1 siswa</p>
                </div>
                <div class="col-4 text-right">
                    <a href="/#" class="btn btn-sm btn-primary btn-pill">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <svg class="c-icon">
                    <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg>
                Nilai Keterampilan
            </h4>
            <div class="row">
                <div class="col-8">
                    <p>A: 3 siswa</p>
                    <p>C: 5 siswa</p>
                    <p>D: 1 siswa</p>
                </div>
                <div class="col-4 text-right">
                    <a href="/#" class="btn btn-sm btn-primary btn-pill">
                        <svg class="c-icon">
                          <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>