$(document).ready(function(){
    var headers =  {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    // $(document).on('click', '.c-sidebar-nav-dropdown-toggle', function(e) {
    //     e.preventDefault()
    //     alert($(this).prop('href'))
    //     console.log(e)
    // })
    // Siswa
    var tsiswas = $('#table-siswaku').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            
            type: 'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": null, render: (data) => {
                return ((data.nis) ? data.nis: '-') +'/'+ ((data.nisn) ? data.nisn : '-')
            }},
            {"data": "nama_siswa"},
            {"data": "jk"},
            {"data": null, render: (data) => {
                return (data.ortus) ? data.ortus.nama_ayah : '-'
            }},
            {"data": null, render: (data) => {
                return `
                <button class="btn btn-info btn-ortu btn-sm" title="Buat Ortu ${data.nama_siswa} ?">
                    <svg class="c-icon">
                        <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-blind"></use>
                    </svg>
                </button>
                <button class="btn btn-warning btn-edit-siswa btn-sm" title="Edit ${data.nama_siswa} ?">
                    <svg class="c-icon">
                        <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                    </svg>
                </button>`
                // <button class="btn btn-danger btn-delete-siswa btn-sm" title="Hapus ${data.nama_siswa} ?">
                //     <svg class="c-icon">
                //         <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                //     </svg>
                // </button>
                    
            }}
        ]
    })

    $(document).on('click', '.btn-import-siswas', function(e) {
        e.preventDefault()
        $('#modalImport .form-import').prop('action', '/siswas/import')
        $('#modalImport #model').text('Siswa')
        $('#modalImport').modal()
    })
    // Ambil Foto Siswa
    $(document).on('change', '#form-siswa input[name="foto_siswa"]', function(e) {
        $('#form-siswa img.foto-siswa').prop('src', URL.createObjectURL(e.target.files[0]))
    })
    // Edit Siswa
    $(document).on('click', '.btn-edit-siswa', function(e) {
        e.preventDefault()
        var siswa = tsiswas.row($(this).parents('tr')).data()
        $('#modalSiswa ')
        $('#form-siswa').prop({
            'action':'/'+sessionStorage.getItem('username')+'/siswaku/'+siswa.id
        }).prepend(`<input type="hidden" name="_method" value="put">`)

        $('#form-siswa input[name="nis"]').val(siswa.nis)
        $('#form-siswa input[name="nisn"]').val(siswa.nisn)
        $('#form-siswa input[name="nama_siswa"]').val(siswa.nama_siswa)
        $('#form-siswa select[name="agama"]').val(siswa.agama)
        $('#form-siswa select[name="jk"]').val(siswa.jk)
        $('#form-siswa textarea[name="alamat"]').val(siswa.alamat)
        $('#form-siswa input[name="desa"]').val(siswa.desa)
        $('#form-siswa input[name="kec"]').val(siswa.kec)
        $('#form-siswa input[name=kab]').val(siswa.kab)
        $('#form-siswa input[name=prov]').val(siswa.prov)
        $('#form-siswa input[name=hp]').val(siswa.hp)
        $('#form-siswa select[name=sekolah_id]').append(`<option value="${(siswa.sekolahs)?siswa.sekolah_id:'0'}" selected>${(siswa.sekolahs)?siswa.sekolahs.nama_sekolah:'Pilih Sekolah'}</option>`)
        $('#form-siswa select[name=rombel_id]').append(`<option value="${(siswa.rombels)?siswa.rombel_id:'0'}" selected>${(siswa.rombels)?siswa.rombels.nama_rombel:'Pilih rombel'}</option>`)
        $('#form-siswa img.foto-siswa').prop({'src': '/img/siswas/'+siswa.sekolah_id+'_'+siswa.nisn+'.jpg'}).on('error', function(){
            $(this).prop('src', '/img/no-photo.jpg')
        })

        $('#modalSiswa').modal()
        
    })

    // Hapus Siswa
    // $(document).on('click', '.btn-delete-siswa', function(e) {
    //     e.preventDefault();
    //     var siswa = tsiswas.row($(this).parents('tr')).data()
    //     swal({
    //         title: "Yakin Menghapus Siswa "+siswa.nama_siswa+"?",
    //         text: "Siswa  akan dihapus dari database",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //       })
    //       .then((hapus) => {
    //         if (hapus) {
    //           $.ajax({
    //               headers: headers,
    //               type:'post',
    //               url: '/siswas/'+siswa.id,
    //               data: {'_method': 'delete'}
    //           }).done(res => {
    //               swal('Info', res.msg, 'info')
    //               tsiswas.ajax.reload()
    //           }).fail(err => {
    //               swal('Error', err.response.msg, 'error')
    //           })
    //         } else {
    //           swal("Data Siswa Aman");
    //         }
    //       });

    // })
    
    // Modal Ortu
    $(document).on('click', '.btn-ortu', function(e) {
        e.preventDefault()
        var siswa = tsiswas.row($(this).parents('tr')).data()
        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/siswaku/'+siswa.nisn+'/ortu',
            type:'post'
        }).done(res => {
            if (res.ortu != null) {
                var ortu = res.ortu
                $('#modalOrtu .mode-form').text('Edit')
                $('#modalOrtu .siswa').text(siswa.nama_siswa)
                $('#form-ortu').prop({
                    'action': '/'+sessionStorage.getItem('username')+'/siswaku/ortu/'+ortu.id,
                })

                $('#form-ortu .hidden-input').html(`<input type="hidden" name="id" value="${ortu.id}"><input type="hidden" name="_method" value="put">`)
                $('#form-ortu input[name="nama_ayah"]').val(ortu.nama_ayah)
                $('#form-ortu input[name="job_ayah"]').val(ortu.job_ayah)
                $('#form-ortu input[name="nama_ibu"]').val(ortu.nama_ibu)
                $('#form-ortu input[name="job_ibu"]').val(ortu.job_ibu)
                $('#form-ortu input[name="nama_wali"]').val(ortu.nama_wali)
                $('#form-ortu input[name="job_wali"]').val(ortu.job_wali)
                $('#form-ortu input[name="hub_wali"]').val(ortu.hub_wali)
                $('#form-ortu textarea[name="alamat_wali"]').val(ortu.alamat_wali)
            } else {
                $('#modalOrtu .mode-form').text('Buat')
                $('#modalOrtu .siswa').text(siswa.nama_siswa)
                $('#form-ortu').prop({
                    'action': '/'+sessionStorage.getItem('username')+'/siswaku/ortu/create',
                })
                $('#form-ortu .hidden-input').html('')
            }
            $('#form-ortu input[name="siswa_id"]').val(siswa.nisn)
            $('#modalOrtu').modal()
        }).fail(err => {
            swal('Error', err.response.msg, 'error')
        })
    })

    // Mapelku
    var tmapels = $('#table-mapelku').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/mapelku?req=dt&rombel_id='+sessionStorage.getItem('rombel_id'),
            type: 'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "kode_mapel"},
            {"data": "nama_mapel"},
            {"data": "label"},
            {"data": "tingkat"},
            // {"data": null, render: (data) => {
            //     return `
            //     <button class="btn btn-warning btn-edit-mapel btn-sm" title="Edit ${data.nama_mapel} ?">
            //         <svg class="c-icon">
            //             <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
            //         </svg>
            //     </button>
            //     <button class="btn btn-danger btn-delete-mapel btn-sm" title="Hapus ${data.nama_mapel} ?">
            //         <svg class="c-icon">
            //             <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
            //         </svg>
            //     </button>
            //     `
            // }},
        ]
    })

    // Kd
    var tkds = $('#table-kdku').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url:'/'+sessionStorage.getItem('username')+'/kdku?req=dt&rombel_id='+sessionStorage.getItem('rombel_id'),
            type:'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "kode_kd"},
            {"data": "teks_kd"},
            {"data": null, render: (data) =>{
                return (data.mapels) ? data.mapels.label : '-'
            }},
            {"data": "tingkat"},
            {"data": null, render: (data) => {
                return `
                <button class="btn btn-warning btn-edit-kd btn-sm" title="Edit ${data.nama_mapel} ?">
                    <svg class="c-icon">
                        <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                    </svg>
                </button>
                <button class="btn btn-danger btn-delete-kd btn-sm" title="Hapus ${data.nama_mapel} ?">
                    <svg class="c-icon">
                        <use xlink:href="/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                    </svg>
                </button>
                `
            }}
        ]
    })

    $(document).on('click', '.btn-edit-kd', function(e) {
        e.preventDefault()
        var kd = tkds.row($(this).parents('tr')).data()
        $('#modalKd .mode-form').text('Edit')
        $('#form-kd').prop('action', '/kds/'+kd.id).prepend(`<input type="hidden" name="_method" value="put">`)
        var kode = kd.kode_kd.split('.')
        $('#form-kd select[name="ranah"]').val(kode[0])
        $('#form-kd input[name="kode_kd"]').val(kd.kode_kd)
        $('#form-kd textarea[name="teks_kd"]').val(kd.teks_kd)
        $('#form-kd select[name="mapel_id"]').append(`<option value="${kd.mapel_id}" selected>${kd.mapels.label}</option>`)
        $('#form-kd select[name="tingkat"]').val(kd.tingkat)
        $('#modalKd').modal()

    })

    $(document).on('click', '.btn-delete-kd', function(e){
        e.preventDefault()
        var kd = tkds.row($(this).parents('tr')).data()
        swal({
            title: 'Yakin Mengapus '+kd.kode_kd+'?',
            text: kd.teks_kd,
            buttons: true,
            dangerMode: true,
            icon: 'warning'
        }).then((lanjut) => {
            if( lanjut ) {
                $.ajax({
                    headers: headers,
                    url: '/kds/'+kd.id,
                    type: 'delete'
                }).done(res=>{
                    swal('Info', res.msg, 'info')
                    tkds.ajax.reload()
                }).fail(err => {
                    swal('Error', err.response.msg, 'error')
                })
            } else {
                swal('Info', 'KD tidak dihapus.', 'info')
            }
        })
    })

    // Import
    $(document).on('click', '.btn-import-kd', function(e) {
        $('#modalImport #model').text('KD')
        $('#modalImport .form-import').prop('action','/'+sessionStorage.getItem('username')+'/kdku/import')
        $('#modalImport').modal()
    })



    // Select2
    // $('.selSekolah').select2({
    //     ajax: {
    //         headers: headers,
    //         url: '/sekolah?req=select',
    //         type: 'post',
    //             dataType: 'json',
    //             delay: 250,
    //             processResults: function(response) {
    //                 return {
    //                     results: response.sekolahs
    //                 };
    //             },
    //             cache: true,

    //     },
    // })

    // $('.selPeriode').select2({
    //     ajax: {
    //         headers: headers,
    //         url: '/periode?req=select',
    //         type: 'post',
    //             dataType: 'json',
    //             delay: 250,
    //             processResults: function(response) {
    //                 return {
    //                     results: response.periodes
    //                 };
    //             },
    //             cache: true,

    //     },
    // })\
    
// KKM
    var tkkm = $('#table-kkm').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/kkm?req=dt',
            type:'post'
        },
        columns: [
            {"data" : "DT_RowIndex"},
            {"data" : null, render: ()=>{return '-'}},
            {"data" : "mapels.label"},
            {"data" : "nilai"},
            {"data" : null, render:(data) => {return 'opsi'}},
        ]
    })


    // Form Nilai
    $(document).on('click', '.btn-form-nilai', function(e) {
        if(sessionStorage.getItem('role') != 'wali' && $('select[name="rombel"]').val() =='0') {
            swal('Perhatian', 'Pilih dulu Rombel', 'warning');
            return false;
        }
        var data = {
            periode_id : $('select[name="periode_id"').val(),
            jenis : $('select[name="jenis"').val(),
            mapel_id : $('select[name="mapel_id"').val(),
            aspek : $('select[name="aspek"').val(),
            kd_id : $('select[name="kd_id"').val(),
            rombel : (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val()
        }

        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/nilais?req=view',
            type: 'post',
            data: data,
            beforeSend: function() {
                $('.form-list').addClass('d-flex').removeClass('d-none')
            }
        }).done(res => {
            var siswas = res.datas
            var trs = ''
            var no = 0
            for(var i = 0; i < siswas.length; i++) {
                trs += `<tr><td>${i+1}</td><td>${((siswas[i].nis)?siswas[i].nis:'-')+' / '+ siswas[i].nisn}</td><td>${siswas[i].nama_siswa}</td><td><input type="number" min="0" max="100" name="nilais[${siswas[i].nisn}]" value="${siswas[i].nilai}"></td></tr>`
            }
            $('.form-nilai input[name="periode_id"]').val(data.periode_id)
            $('.form-nilai input[name="jenis"]').val(data.jenis)
            $('.form-nilai input[name="mapel_id"]').val(data.mapel_id)
            $('.form-nilai input[name="aspek"]').val(data.aspek)
            $('.form-nilai input[name="kd_id"]').val(data.kd_id)
            $('.form-list').addClass('d-none').removeClass('d-flex')
            $('.table-form-nilai tbody').html(trs)
            $('.form-nilai button[type="submit"]').removeClass('d-none')
        }).fail(err => {
            swal('Error', err.resposne.msg, 'error')
        })
    })

    // Jurnal Siswa
    var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val();
    var tjurnals = $('#table-jurnal').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/jurnals?req=dt&rombel='+rombel,
            type: 'post'
        },
        columns: [
            {'data' : 'DT_RowIndex'},
            {'data': 'tanggal'},
            {'data': null, render: (data) => {
                return ((data.siswas.nis) ? data.siswas.nis: '-') + ' / ' + data.siswas.nisn
            }},
            {'data': 'siswas.nama_siswa'},
            {'data' : 'rombel_id'},
            
            {'data': 'catatan'},
            {'data': 'butir_sikap'},
            {'data': 'nilai'},
            {'data': 'aspek'},
            {'data': null, render: (data) => {
                return 'Opsi'
            }}
        ],
        'createdRow': (row, data, dataIndex) => {
            var bg  = (data.nilai == 'A') ? 'bg-success' : (data.nilai == 'B') ? 'bg-info' : (data.nilai == 'C') ? 'bg-warning' : 'bg-danger'
            $(row).addClass(bg) 
        }
    })


    $('.jurnal_page select[name="rombel"]').on('change', function(){
        tjurnals.ajax.url('/'+sessionStorage.getItem('username')+'/jurnals?req=dt&rombel='+$(this).val()).draw()
    })


    $(document).on('click', '.form-import-nilai input[name="nama_file"]', function(){
        $('#file_nilai').trigger('click');
    });

    $('#file_nilai').on('change', function(e) {
        var file = e.target.files[0]
        
        // application/vnd.openxmlformats-officedocument.spreadsheetml.sheet = xlsx
        // application/vnd.ms-excel = csv, xls application/vnd.ms-excel
        // application/vnd.oasis.opendocument.spreadsheet = ods
        if(file.type == 'application/vnd.ms-excel' || file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file.type =='application/vnd.oasis.opendocument.spreadsheet') {
            $('.form-import-nilai input[name="nama_file"]').val(file.name)
        } else {
            swal('Error', 'File harus berjenis xls, xlsx, csv, ods', 'error')
            $('.form-import-nilai input[name="nama_file"]').val('')
            $(this).val(null)
        }
        
    })


    $(document).on('click', '.btn-unduh-format', function(e) {
        e.preventDefault()
        var data = {
            mapel: $('select[name="mapel_id"]').val(),
            rombel:  (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val(),
            aspek: $('select[name="aspek"]').val()
        }

        $.ajax({
            headers: headers,
            url:'/'+sessionStorage.getItem('username')+'/nilais/format',
            type:'get',
            data: data,
            xhrFields: { responseType: 'blob' }
        }).done(res => {
            console.log(res)
            var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val()
            var blob = res
                const a = document.createElement('a')
                var filename = 'Nilai.'+rombel+'.'+$('select[name="mapel_id"]').val()+"."+$('select[name="aspek"]').val()+'.xlsx'
                document.body.appendChild(a)
                a.href = window.URL.createObjectURL(blob)
                a.download = filename
                a.target = '_blank'
                a.click()
                a.remove()
        })
    })


// Rekap Nilai
var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('.rekap_page select[name="rombel"]').val();
// var mapel = 
var trekaps;
// Get Rekap

getRekap34()

function getRekap34(url=null) {
    var mapel_id = (sessionStorage.getItem('role') == 'gpai') ? 'pabp' : (sessionStorage.getItem('role') == 'gor') ? 'pjok' : 'big'
    var mapel = (sessionStorage.getItem('rombel_id') == 'all') ? '&mapel='+mapel_id: '&mapel='+$('.rekap_page select[name="mapel"]').val()
    $.ajax({
        headers: headers,
            url: (url == null)?'/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+rombel+mapel: url,
            type: 'post'
    }).done(res => {
        var dataRekap = []
        var columnRekap = []
        // dataRekap = res
        var theads = `<thead>
                <tr>
                    <th rowspan="2">NO ${res.kkms[0].nilai}</th>
                    <th rowspan="2">NIS</th>
                    <th  rowspan="2">NISN</th>
                    <th  rowspan="2">NAMA</th>
                    <th colspan="3">K4</th>
                    <th colspan="3">K3</th>
                </tr>
                <tr>
                    <th>NH</th>
                    <th>NPTS</th>
                    <th>NPAS</th>
                    <th>NH</th>
                    <th>NPTS</th>
                    <th>NPAS</th>
                </tr>
                </thead>
            `
        var tr = ''
        res.rekap34.forEach((item, index) => {
            tr +=`<tr>
                <td>${index+1}</td>
                <td>${(item.nis)?item.nis:'-'}</td>
                <td>${item.nisn}</td>
                <td>${item.nama_siswa}</td>
                <td class="${(item.n4_pabp_uh < res.kkms[0].nilai || item.n4_pabp_uh == null)?'text-danger font-weight-bold':''}">${item.n4_pabp_uh}</td>
                <td class="${(item.n4_pabp_pts < res.kkms[0].nilai || item.n4_pabp_pts == null)?'text-danger font-weight-bold':''}">${item.n4_pabp_pts}</td>
                <td class="${(item.n4_pabp_pas < res.kkms[0].nilai || item.n4_pabp_pas == null)?'text-danger font-weight-bold':''}">${item.n4_pabp_pas}</td>
                <td class="${(item.n3_pabp_uh < res.kkms[0].nilai || item.n3_pabp_uh == null)?'text-danger font-weight-bold':''}">${item.n3_pabp_uh}</td>
                <td class="${(item.n3_pabp_pts < res.kkms[0].nilai || item.n3_pabp_pts == null)?'text-danger font-weight-bold':''}">${item.n3_pabp_pts}</td>
                <td class="${(item.n3_pabp_pas < res.kkms[0].nilai || item.n3_pabp_pas == null)?'text-danger font-weight-bold':''}">${item.n3_pabp_pas}</td>
            </tr>`
        })

        // $.each(res[0],(key, value) => {
        //     var item = {}
        //     item.data = key,
        //     item.title = key;
        //     columnRekap.push(item)
            
            
        // })
        $('.rekap_page #table-rekap').html(theads + `<tbody>${tr}</tbody>`)
        // console.log(dataRekap)
        trekaps = $('.rekap_page #table-rekap').DataTable({
            // data: dataRekap,
            // "columns":columnRekap
            "dom": "Bftip"
        })
    })
}

 
// Cetak Rapor
    // Rapor Home
    var trapors = $('#table-siswa-rapor').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url:  '/'+sessionStorage.getItem('username')+'/siswaku?req=dt&rombel_id='+sessionStorage.getItem('rombel_id'),
            type: 'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "nisn"},
            {"data": null, render: (data) => {
                return `
                    <img src="/img/siswas/${sessionStorage.getItem('sekolah_id')+'_'+data.nisn+'.jpg'}" onerror="this.error=null;this.src='/img/no-photo.jpg';" height="40px" class="img img-avatar" />
                `
            }},
            {"data": "nama_siswa"},
            {"data": null, render: (data) => {
                return `
                    <button class="btn btn-info btn-edit-rapor"><i class="mdi mdi-pencil"></i></button>
                    <a href="/${sessionStorage.getItem('username')}/rapor/cetak?nisn=${data.nisn}&periode=${sessionStorage.getItem('periode')}" class="btn btn-primary btn-cetak-rapor" ><i class="mdi mdi-printer"></i></a>

                `
            }},
        ]
    })

    $(document).on('click', '.btn-edit-rapor', function(){
        var data = trapors.row($(this).parents('tr')).data();
        $('#modalDataRapor').modal()
        $('#modalDataRapor .modal-title #nama_siswa').text(data.nama_siswa)
        

    })

    $('.rekap_page select[name="rombel"]').on('change', function(){
        // trekaps.ajax.url('/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+$(this).val()).draw()
        $('.rekap_page #table-rekap').DataTable().destroy()
        getRekap34('/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+$(this).val())
    })
    $('.rekap_page select[name="mapel"]').on('change', function(){
        // trekaps.ajax.url('/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+$(this).val()).draw()
        // $('.rekap_page #table-rekap').DataTable().destroy()
        getRekap34('/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&mapel='+$(this).val())
    })

    $(document).on('change', '.selSiswaKu', function(e) {
        // alert('hi')
        window.location.href = '/'+sessionStorage.getItem('username')+'/rapor/cetak?nisn='+$(this).val()+'&periode='+sessionStorage.getItem('periode')
    })




// Tema
    var ttemas = $('#table-tema').DataTable({
        serverSide: true,
        ajax: {
            url: '/'+sessionStorage.getItem('username')+'/tema?req=dt',
            type: 'post',
            headers: headers
        },
        columns:[
            // {'data': 'DT_RowIndex'},
            {'data': 'kode_tema'},
            {'data': 'teks_tema'},
            {'data': null, render: (data) => {
                return `
                    <button class="btn btn-warning btn-edit-tema">
                        <i class="mdi mdi-pencil"></i>
                        Edit
                    </button>
                    <button class="btn btn-info btn-subtema">
                        <i class="mdi mdi-subdirectory-arrow-left"></i>
                        Subtema
                    </button>
                `
            }},
        ]
    })

    $(document).on('click', '.btn-subtema', function(){
        var tema = ttemas.row($(this).parents('tr')).data()
        var modalSubtema = $('#modal-subtema')
        modalSubtema.find('.modal-header .modal-title span').text(tema.kode_tema+' '+tema.teks_tema)

        var tsubtema = $('.table-subtema').DataTable({
            serverSide: true,
            ajax: {
                url: '/'+sessionStorage.getItem('username')+'/subtema?req=dt&tema='+tema.kode_tema,
                type: 'post',
                headers: headers
            },
            columns: [
                {"data": "DT_RowIndex"},
                {"data": "tema_id"},
                {"data": "kode_subtema"},
                {"data": "teks_subtema"},
                {"data": null, render: (data) => {
                    return `
                        <button class="btn btn-success btn-tambah-kdtema">Tambah KD</button>
                    `
                }},
            ]
        })

        modalSubtema.modal()

        $(document).on('hide.coreui.modal', '#modal-subtema', function(e) {
            tsubtema.destroy()
        })

        $(document).on('click', '.btn-tambah-kdtema', function(){
            var subtema = tsubtema.row($(this).parents('tr')).data()
            // console.log(subtema)
            $('.row-kd .card-title #subtema').text(subtema.kode_subtema+' . '+subtema.teks_subtema)

            $.ajax({
                headers: headers,
                url: '/'+sessionStorage.getItem('username')+'/pemetaan?subtema='+subtema.kode_subtema,
                type:'post'
            }).done(res=>{
                var datas = res.datas   
                var tr = ''
                $.each(datas, (key,value) => {
                    // var kds = value.split(',')
                    tr += `<tr>
                        <td>${key}</td>
                        <td>
                            <span class="kd">${value}</span>
                            <input  type="text" class="input-kd" value="" style="display:none;width: 60%;padding:5px 10px;" placeholder="Pisahkan KD dengan koma. Contoh: 3.1,4.1,3.3,4.3">
                            <button class="btn btn-danger btn-sm float-right btn-add-kdtema" data-subtema="${subtema.kode_subtema}">
                                <i class="mdi mdi-plus-box"></i>
                            </button>
                        </td>
                    </tr>`
                })

                $('.table-kdtema tbody').html(tr)
                
            })
            $('.row-kd').toggle()
        })

        $(document).on('click', '.btn-add-kdtema', function(){
            $(this).siblings('.input-kd').val($(this).siblings('.kd').text()).toggle().focus()
            $(this).siblings('.kd').toggle()
            // alert('hi')
            $(this).siblings('.input-kd').on('blur', function(){
                var subtema_id = $(this).siblings('.btn-add-kdtema').data('subtema')
                var mapel_id = $(this).parents('tr').find('td').first().text()
                // alert(subtema_id);
                var data = {kds: $(this).val()}

                $.ajax({
                    url: '/'+sessionStorage.getItem('username')+'/pemetaan/'+subtema_id+'/'+mapel_id,
                    type: 'put',
                    headers: headers,
                    data:data
                }).done(res=>{
                    $(this).hide()
                    $(this).siblings('.kd').toggle().text($(this).val())
                    // console.log(res)
                    swal('Info', res.msg, 'info')
                }).fail(err => {
                    console.log(err.response)
                })
            })
        })
    })

    

    var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : 'null';

    // $(document).on('change', 'select[name="rombel_id"]', function(){
    //     $('.selSiswaku').select2()
    // })
    $('.selSiswaKu').select2({
        
        ajax: {
        headers: headers,
        url: '/'+localStorage.getItem('username')+'/siswaku?req=select&rombel='+ rombel,
        type: 'post',
            dataType: 'json',
            delay: 250,
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true,

        },
    })

    $('.selSikap').select2()
    $(document).on('change', '.form-jurnal select[name="aspek"]', function(){
        var aspek = $(this).val()
        // alert(aspek)
        $.ajax({
            headers: headers,
            type: 'post',
            dataType: 'json',
            url: '/'+sessionStorage.getItem('username')+'/kdku?req=select&aspek='+aspek,
            success: function(res){
                var kdOpt = ''
                res.forEach(item => {
                    kdOpt += `
                        <option value="${item.id}">${item.text}</option>
                    `
                    $('.selSikap').html(kdOpt)
                })
            }
        })
    })
})