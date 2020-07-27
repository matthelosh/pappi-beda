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
            url:  '/'+sessionStorage.getItem('username')+'/siswaku?req=dt&rombel_id='+sessionStorage.getItem('rombel_id'),
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
    var trekaps = $('.rekap_page #table-rekap').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+rombel,
            type: 'post'
        },
        columns: [
            {'data': 'DT_RowIndex'},
            {'data': null, render: (data) => {
                return ((data.siswas.nis) ? data.siswas.nis : '-') + ' / ' + data.siswas.nisn
            }},
            {'data': 'siswas.nama_siswa'},
            {'data': 'nilai'},
            {'data': null, render: (data) => {
                return 'Opsi'
            }}
        ]
    })

    $('.rekap_page select[name="rombel"]').on('change', function(){
        trekaps.ajax.url('/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+$(this).val()).draw()
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
                    results: response.siswas
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