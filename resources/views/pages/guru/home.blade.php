<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                Selamat Datang {{ (Auth::user()->jk == 'l') ? 'Bapak ' : 'Ibu ' }} {{ ucwords(Auth::user()->nama) }}
            </h4>
            <p class="card-text">{{ Session::get('sekolah')->nama_sekolah }}</p>
        </div>
    </div>
</div>

<div class="col-sm-6">
   <div class="card">
       <div class="card-body">
           <h4 class="card-title">Coba Chart</h4>
           <canvas id="myChart" width="100%" ></canvas>
       </div>
   </div>
    
</div>