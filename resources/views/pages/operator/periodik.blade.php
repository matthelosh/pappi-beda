<div class="col-sm-12">
    <div class="card">          
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">
                        <i class="mdi mdi-periodic-table"></i>
                        Data Periodik
                    </h4>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-sm btn-square btn-primary btn-create-periodik float-right mr-2">
                        <i class="mdi mdi-plus"></i>
                        Buat
                    </button>
                    <button class="btn btn-sm btn-square btn-primary btn-import-periodik float-right mr-2">
                        <i class="mdi mdi-cloud-upload"></i>
                        Unggah
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-periodik" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPeriodik">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
                <button class="btn btn-square btn-danger" data-dismiss="modal" style="position: absolute; top:0;right:-15px; cursor:pointer;display:block;z-index:10">
                    &times;
                </button>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="mdi mdi-periodic-table"></i> Data Periodik <span id="periode_terpilih"></span></h4>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-periodik-detil" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Rombel</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>