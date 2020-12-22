$(document).ready(function(){
    var headers =  {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    // Siswa
    var tsiswas = $('#table-siswaku').DataTable({
        dom: "Bftlip",
        processing: true,
        language: {
            processing: '<i class="mdi mdi-load mdi-spin"></i><span class="sr-only">Sebentar...</span>'
        },
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/siswaku?req=dt&rombel_id='+sessionStorage.getItem('rombel_id'),
            type: 'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": null, render: (data) => {
                return ((data.nis) ? data.nis: '-') +'/'+ ((data.nisn) ? data.nisn : '-')
            }},
            {"data": null, render: (data) => {
                
                return `<img src=/img/siswas/${data.sekolah_id}_${data.nisn}.jpg alt="Foto ${data.nama_siswa}" onerror="this.error=null;this.src='/img/${(data.jk == 'L') ? 'no-photo.jpg' : 'siswa-p.png'}';" height="40px" class="img img-avatar" />` 
            }},
            {"data": "nama_siswa"},
            {"data": "jk"},
            {"data": null, render: (data) => {
                return (data.ortus) ? data.ortus.nama_ayah : '-'
            }},
            {"data": null, render: (data) => {
                return `
                <button class="btn btn-info btn-square btn-ortu btn-sm" title="Buat Ortu ${data.nama_siswa} ?">
                    <i class="mdi mdi-account-child"></i>
                </button>
                <button class="btn btn-warning btn-square btn-edit-siswa btn-sm" title="Edit ${data.nama_siswa} ?">
                    <i class="mdi mdi-pencil-outline"></i>
                </button>`

            }}
        ]
    })


    $(document).on('click', '.btn-import-siswas', function(e) {
        e.preventDefault()
        $('#modalImport .form-import').prop('action', '/'+sessionStorage.getItem('username')+'/siswaku/import')
        $('#modalImport #model').text('Siswa')
        $('#modalImport').modal()
    })
    
    var selectedFile;
    $(document).on('change', '#modalImport .form-import input[name="file"]', function(e) {
        selectedFile = e.target.files[0];
        // console.log(selectedFile);
    })


     // Submit File Import
     $(document).on('submit', '#modalImport .form-import', function(e){
        e.preventDefault()
        var url = $(this).prop('action');
        if ( selectedFile ) {
            // console.log(selectedFile)
            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                    type: "binary"
                });
                workbook.SheetNames.forEach( sheet => {
                    let datas = XLSX.utils.sheet_to_row_object_array(
                        workbook.Sheets[sheet]
                    );
                    var data = {siswas :datas}
                    $.ajax({
                        headers: headers,
                        url: url,
                        data: data,
                        type: 'post',
                        dataType:'json',
                        success: function(res) {
                            Swal.fire('Info', res.msg, 'info')
                            $('.modal').modal('hide')
                            $('.table').DataTable().draw()
                        }
                    }).fail(err => {
                        var msg = (err.responseJSON.code == '23000') ? 'Data email / NIP / username ada yang sama atau sudah dipakai.' : err.responseJSON.msg
                        Swal.fire('Error', msg, 'error')
                    })
                });
            };
            fileReader.readAsBinaryString( selectedFile );
        }
    })


    // Ambil Foto Siswa
    $(document).on('change', '#form-siswa input[name="foto_siswa"]', function(e) {
        $('#form-siswa img.foto-siswa').prop('src', URL.createObjectURL(e.target.files[0]))
    })
    // Edit Siswa
    $(document).on('click', '.btn-edit-siswa', function(e) {
        e.preventDefault()
        var siswa = tsiswas.row($(this).parents('tr')).data()
        console.log(siswa)
        $('#modalSiswa ')
        $('#form-siswa').prop({
            'action':'/'+sessionStorage.getItem('username')+'/siswaku/'+siswa.id
        }).prepend(`<input type="hidden" name="_method" value="put">`)

        $('#form-siswa input[name="nis"]').val(siswa.nis)
        $('#form-siswa input[name="nisn"]').val(siswa.nisn)
        $('#form-siswa input[name="nama_siswa"]').val(siswa.nama_siswa)
        $('#form-siswa select[name="agama"]').val(siswa.agama)
        $('#form-siswa input[name="tempat_lahir"]').val(siswa.tempat_lahir)
        $('#form-siswa input[name="tanggal_lahir"]').val(siswa.tanggal_lahir)
        $('#form-siswa select[name="jk"]').val(siswa.jk)
        $('#form-siswa textarea[name="alamat"]').val(siswa.alamat)
        $('#form-siswa input[name="desa"]').val(siswa.desa)
        $('#form-siswa input[name="kec"]').val(siswa.kec)
        $('#form-siswa input[name=kab]').val(siswa.kab)
        $('#form-siswa input[name=prov]').val(siswa.prov)
        $('#form-siswa input[name=hp]').val(siswa.hp)
        $('#form-siswa select[name=sekolah_id]').append(`<option value="${(siswa.sekolahs)?siswa.sekolah_id:'0'}" selected>${(siswa.sekolahs)?siswa.sekolahs.nama_sekolah:'Pilih Sekolah'}</option>`)
        $('#form-siswa select[name=rombel_id]').append(`<option value="${(siswa.rombels)?siswa.rombel_id:'0'}" selected>${(siswa.rombels)?siswa.rombels.nama_rombel:'Pilih rombel'}</option>`)
        $('#form-siswa img.foto-siswa').css('cursor', 'pointer').prop({'src': '/img/siswas/'+siswa.sekolah_id+'_'+siswa.nisn+'.jpg'}).on('error', function(){
            var img = (siswa.jk == 'L') ? 'no-photo.jpg' : 'siswa-p.png'
            $(this).prop('src', '/img/'+img)
        })

        $('#modalSiswa').modal()

    })


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
            Swal.fire('Error', err.response.msg, 'error')
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
        Swal.fire({
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
                    Swal.fire('Info', res.msg, 'info')
                    tkds.ajax.reload()
                }).fail(err => {
                    Swal.fire('Error', err.response.msg, 'error')
                })
            } else {
                Swal.fire('Info', 'KD tidak dihapus.', 'info')
            }
        })
    })

    // Import
    $(document).on('click', '.btn-import-kd', function(e) {
        $('#modalImport #model').text('KD')
        $('#modalImport .form-import').prop('action','/'+sessionStorage.getItem('username')+'/kdku/import')
        $('#modalImport').modal()
    })




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


    // Pilihan Aspek Form Entri Nilai
    $('.card-entri-nilai').on('select2:select', '.selMapel', function(e){
        var mapel = e.params.data.id
        var options = `
            <option value="0">Aspek Nilai</option>
            ${(mapel == 'pabp') ? '<option value="1">Spiritual (K1)</option>' : (mapel == 'ppkn') ? '<option value="2">Sosial (K2)</option>':''}
            <option value="3">Pengetahuan (K3)</option>
            <option value="4">Keterampilan (K4)</option>
        `
        $('.card-entri-nilai select[name="aspek"]').html(options)
    })


    $('.btn-show-tool-form-nilai').on('click', function(){
        $('.tool-form-nilai').slideToggle()
        // $(this).hide()
    })

    // Form Nilai
    $(document).on('click', '.btn-form-nilai', function(e) {
        if($('select[name="jenis"]').val() == '0') {
            Swal.fire('Perhatian', 'Pilih dulu Jenis Penilaian', 'warning');
            return false;
        } else if($('select[name="mapel_id"]').val() == '0') {
            Swal.fire('error', 'Pilih Mapel Dulu', 'warning')
            return false
        } else if ($('select[name="aspek"]').val() == '0') {
            Swal.fire('error', 'Pilih Aspek Penilaian', 'warning')
            return false
        }
        var data = {
            periode_id : $('select[name="periode_id"').val(),
            jenis : $('select[name="jenis"').val(),
            mapel_id : $('select[name="mapel_id"').val(),
            aspek : $('.selAspek').select2().val(),
            kd_id : $('select[name="kd_id"]').val(),
            rombel : (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val()
        }


             
        
        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/nilais?req=view',
            type: 'post',
            data: data,
            beforeSend: function() {
                $('.loading').fadeIn()
                $('.form-list').addClass('d-flex').removeClass('d-none')
                $('.table-form-nilai tbody').html('')
            }
        }).done(res => {
            $('.loading').fadeOut()
            $('.card-entri-nilai-parent').removeClass('d-none')
            $('.tool-form-nilai').slideUp()
            $('.btn-show-tool-form-nilai').show()
            // if(res.status_form != 'update') {
            //     $('.btn-export-nilai').addClass('d-none')
            // } else {
            //     $('.btn-export-nilai').removeClass('d-none')
            // }
            var siswas = res.datas
            var trs = ''
            var no = 0
            for(var i = 0; i < siswas.length; i++) {
                trs += `<tr><td class="text-center">${i+1}</td><td class="text-center">${siswas[i].nisn}</td><td>${siswas[i].nama_siswa}</td><td class="nilai text-center" data-id="${siswas[i].id_nilai}">
                <input type="hidden" name="id_nilais[${siswas[i].nisn}]" value="${siswas[i].id_nilai}]" />
                <input type="${(res.status_form == 'create') ? 'number' : 'hidden'}" min="0" max="100" name="nilais[${siswas[i].nisn}]" value="${siswas[i].nilai}" ${(res.status_form == 'update') ? 'disabled':'' } class="input_nilai">
                <span class="nilai" style="display:${(res.status_form=='update')? 'block' : 'none'};background:#b5e6dd;">${Math.round(siswas[i].nilai)}</span>
                
                </td></tr>`
            }
            $('.form-nilai input[name="periode_id"]').val(data.periode_id)
            $('.form-nilai input[name="jenis"]').val(data.jenis)
            $('.form-nilai input[name="mapel_id"]').val(data.mapel_id)
            $('.form-nilai input[name="aspek"]').val(data.aspek)
            $('.form-nilai input[name="kd_id"]').val(data.kd_id)
            $('.form-nilai').append(`<input type="hidden" name="status_form" value="${res.status_form}" />`)
            $('.form-list').addClass('d-none').removeClass('d-flex')
            // $('.table-form-nilai tbody').html(trs)
            if(res.status_form == 'create') {
                $('.form-nilai button[type="submit"]').removeClass('d-none')
                $('.table-form-nilai tbody').html(trs)
                $('.btn-export-nilai').addClass('d-none')
            } else {
                $('.table-form-nilai tbody').html(trs)
                $('.form-nilai button[type="submit"]').addClass('d-none')
                $('.btn-export-nilai').removeClass('d-none')
                // Export Nilai 
                $(document).on('click', '.btn-export-nilai', function(e){
                    e.preventDefault()
                    // var elt = document.getElementById('table-form-nilai')
                    var ws = XLSX.utils.json_to_sheet(siswas)
                    var wb = XLSX.utils.book_new()
                    XLSX.utils.book_append_sheet(wb, ws, $('.selKd').val())
                    XLSX.writeFile(wb, 'Nilai '+$('select[name="jenis"]').val()+' '+$('.selMapel').val()+' Kelas '+ rombel +'.xlsx')

                })
            }
        }).fail(err => {
            Swal.fire('Error', err.resposne.msg, 'error')
        })
    })

    // Submit Nilai

    $(document).on('submit', '.form-nilai', function(e) {
        e.preventDefault()
        if (sessionStorage.getItem('rombel_id') == 'all' && $('select.selRombel').val() == '0') {
            Swal.fire('Error', 'Pilih Dulu Rombel', 'error')
            return false
        }
        var data = $(this).serialize()
        // var rombel = $('select.selRombel') ? $('select.selRombel').val() : sessionStorage.getItem('rombel_id')
        var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select.selRombel').val()
        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/nilais/entri?rombel='+rombel,
            type:'post',
            data: data,
            beforeSend: ()=>{
                $('.loading').fadeIn()
            },
            success: function(res) {
                $('.loading').fadeOut()
                Swal.fire('Info', res.msg, 'info')
                $('.btn-form-nilai').trigger('click')
            }
        })
    })

    var nilai_lama;

    $(document).on('click', 'span.nilai', function(){
        var nilai = $(this).text()
        var id = $(this).parents('td').data('id')
        var tr = $(this).parents('tr')
        var tds = tr.find('td')

        var nisn = $(tds[1]).text()
        // alert(id)
        Swal.fire({
            title: 'Ubah Nilai ?',
            input: 'number',
            inputValue: nilai,
            showCancelButton: true,
            inputValidator: (value) => {
                if (value == nilai) {
                    return "Nilai sama dengan yang lama"
                } else {
                    var data = {
                        id_nilai: id,
                        nilai: value,
                        aspek: $('select[name="aspek"]').val(),
                        _method: 'PUT',
                        siswa_id: nisn,
                        rombel_id: (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select.selRombel').val(),
                        mapel_id: $('select.selMapel').val(),
                        jenis: $('select[name="jenis"]').val(),
                        periode: $('.selPeriode').val(),
                        kd_id: $('.selKd').val()
                    }
                    var span = `<span class="nilai" style="background: #b5e6dd;display: block;">${data.nilai}</span>`
                    $.ajax({
                        headers: headers,
                        url: '/'+sessionStorage.getItem('username')+'/nilais/update',
                        data: data,
                        type: 'post',
                        beforeSend: function(){
                            $('.loading').fadeIn()
                        }
                    }).done(res => {
                            $('.loading').fadeOut()
                        Swal.fire('Info', res.msg, 'info')
                        // $(this).parents('td.nilai').html(span)
                        $('.btn-form-nilai').trigger('click')
                    }).fail(err=>{
                        Swal.fire('Error', err.response.msg, 'error')
                    })
                }
            }
        })
    })

    

    // Jurnal Siswa
    var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('.jurnal_page select[name="rombel"]').val();
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

    $('.toggle-body').on('click', function(){
        // alert('hi')
        $(this).parents('.card').css('width', '100%')
        $(this).siblings('.card-body').toggleClass('d-none')
    })

    $(document).on('click', '.form-import-nilai span.folder-file', function(){
        $('#file_nilai').trigger('click');
    });
    var fileNilai;
    $('#file_nilai').on('change', function(e) {
        var file = e.target.files[0]
        $('.form-import-nilai label[for="file_nilai"]').text(file.name)
        $('.form-import-nilai span.folder-file').addClass('file-picked').removeClass('file-unpicked')
        
        fileNilai = file
    })

   
    $('.form-import-nilai').submit(function(e){
        e.preventDefault()
        // var datas = {nilais: [], mapel: '', aspek: '', periode: ''}
        var periode = $('select[name="periode_id"').val(),
            mapel = $('select[name="mapel_id"').val(),
            aspek= $('select[name="aspek"]').val(),
            jenis = $('select[name="jenis"]').val(),
            rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('.selRombel').val()

        if (periode == '0') {
            Swal.fire('Peringatan', 'Pilih Periode Nilai Dulu.', 'error')
            return false
        } else if (jenis == '0') {
            Swal.fire('Peringatan', 'Pilih Jenis Penilaian Harian, PTS atau PAS.', 'error')
            $('.selMapel').focus()
            return false
        } else if ( aspek == '0' ) {
            Swal.fire('Peringatan', 'Pilih Aspek Nilai Dulu.', 'error')
            $('.selAspek').focus()
            return false
        } else if ( mapel == '0' ) {
            Swal.fire('Peringatan', 'Pilih Mapel Dulu', 'error')
            return false
        }
        if (fileNilai) {
            var fileReader = new FileReader()
            fileReader.onload = function(event) {
                var data = event.target.result
                var workbook = XLSX.read(data, {
                    type: "binary"
                })

                workbook.SheetNames.forEach( sheet => {
                    let datas = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                    $.ajax({
                        headers: headers,
                        type: 'post',
                        url: '/'+sessionStorage.getItem('username')+'/nilais/import',
                        data: {
                            periode: datas['periode'] = periode,
                            mapel: mapel,
                            jenis: jenis,
                            aspek: aspek,
                            rombel: rombel,
                            nilais: datas
                            
                        },
                        dataType: 'json',
                        beforeSend: function(){
                            $('.loading').fadeIn()
                        },
                        success: function(res) {
                            $('.loading').fadeOut()
                            Swal.fire('Info', res.msg, 'info')
                            $('.btn-form-nilai').trigger('click')
                        }
                    }).fail(err => {
                        console.log(err)
                    })
                })
            }
            fileReader.readAsBinaryString( fileNilai )
        }
    })

    $(document).on('click', '.btn-unduh-format', function(e) {
        e.preventDefault()
        var data = {
            mapel: $('select[name="mapel_id"]').val(),
            rombel:  (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('select[name="rombel"]').val(),
            aspek: $('select[name="aspek"]').val()
        }

        var fileName = data.rombel+"-"+data.mapel+".xlsx"

        $.ajax({
            headers: headers,
            url:'/'+sessionStorage.getItem('username')+'/nilais/format',
            type:'get',
            data: data,
            dataType: 'json'
        }).done(res => {
            // console.log(res)
            var data = res.data
            var ws = XLSX.utils.json_to_sheet(data)
            var wb = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(wb, ws, $('select[name="jenis"]').val()+'-'+$('.selAspek').val())
            XLSX.writeFile(wb, fileName)
        }).fail(err => {
            console.log(err)
        })
    })


// Rekap Nilai
var rombel = (sessionStorage.getItem('rombel_id') != 'all') ? sessionStorage.getItem('rombel_id') : $('.selRombel').val();
// var mapel =
var trekaps;

$('.btn-rekap-nilai').on('click', function(){
    $('#table-rekap').html('')
    var rombel = (sessionStorage.getItem('role') == 'wali') ? sessionStorage.getItem('rombel_id') : $('.selRombel').val()
    var data = {
        mapel : (sessionStorage.getItem('role') == 'wali') ? $('.selMapel').val() : sessionStorage.getItem('mapel'),
        jenis: $('.selJenis').val(),
        aspek: $('.selAspek').val()
    }
    if(data.mapel == '0') {
        Swal.fire('Error', 'Pilih Mapel', 'error')
        return false
    } else if (data.jenis == '0') {
        Swal.fire('Error', 'Pilih Jenis Penilaian', 'error')
        return false
    } else if (data.aspek == '0') {
        Swal.fire('Error', 'Pilih Aspek Nilai', 'error')
        return false
    }

    
    $.ajax({
        headers: headers,
        url: '/'+sessionStorage.getItem('username')+'/nilais/rekap?req=dt&rombel='+rombel,
        type: 'post',
        data: data,
        beforeSend: function() {
            $('.loading').fadeIn()
        },
        success: function(res) {
           var datas = res.datas
            $('.loading').fadeOut()
            var tr =''
            var nilais = []
            var ths = '<td>NISN</td><td>Nama</td>'
            var tbody =''
            var kds = []
            $.each(datas, (item, value)=>{
                nilais[item] = value.nilais
                tr += `
                    <tr><td>${value.nisn}</td><td>${value.nama_siswa}</td></td>
                `
                res.kds.forEach(kd=>{
                    tr += `<td>${(value[kd.kd_id]) ? Math.round(value[kd.kd_id]) : '-'}</td>`
                })
                tr +='<td>'+Math.round(value.rekap)+'</td></tr>'
            })

            res.kds.forEach(kd=>{
                ths += `<td>${kd.kd_id}</td>`
            })
            ths += '<th>Rata2</th>'
            var thead = '<thead><tr>'+ths+'</tr></thead>'
            tbody = '<tbody>'+tr+'</tbody>'
            var table = thead+tbody
            if ($.fn.DataTable.isDataTable('#table-rekap')) {
                $('#table-rekap').DataTable().clear()
                $('#table-rekap').DataTable().destroy()
            }
            $('#table-rekap').html(table)
            $('#table-rekap').DataTable({
                paging: false,
                dom: 'Bft',
                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                        title: 'Rekap Nilai '+ data.jenis+ ' '+data.mapel+ ' Kelas ' + rombel.slice(9, rombel.length).toUpperCase()
                    },
                    {
                        extend: 'print',
                        messageTop: `
                            <h4>Kelas: ${rombel.slice(9, rombel.length).toUpperCase()} | Mapel: ${data.mapel.toUpperCase()} | Jenis Penilaian: ${data.jenis.toUpperCase()}</h4>
                        `,
                        messageBottom: `
                            <div style="width: 50%; float: right; ">
                                <p>Dalisodo, ${new Date()} </p>


                            </div>
                        `
                    },
                ]
            })
        },
        fail: function(err){
            $('.loading').fadeOut()
        }
    })
    
    $('.alert').fadeOut()
})

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
        var theads = `<thead>
                <tr>
                    <th rowspan="2">NO</th>
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
            var mpl = $('.rekap_page select[name="mapel"]').val()
            var uh3 = 'n3_'+mpl+'_uh',pts3 = 'n3_'+mpl+'_pts',pas3 = 'n3_'+mpl+'_pas'
            var uh4 = 'n4_'+mpl+'_uh',pts4 = 'n4_'+mpl+'_pts',pas4 = 'n4_'+mpl+'_pas'
            tr +=`<tr>
                <td>${index+1}</td>
                <td>${(item.nis)?item.nis:'-'}</td>
                <td>${item.nisn}</td>
                <td>${item.nama_siswa}</td>
                <td class="${(item[uh4] < res.kkms[0].nilai || item[uh4] == null)?'text-danger font-weight-bold':''}">${item[uh4]}</td>
                <td class="${(item[pts4] < res.kkms[0].nilai || item[pts4] == null)?'text-danger font-weight-bold':''}">${item[pts4]}</td>
                <td class="${(item[pas4] < res.kkms[0].nilai || item[pas4] == null)?'text-danger font-weight-bold':''}">${item[pas4]}</td>
                <td class="${(item[uh3] < res.kkms[0].nilai || item[uh3] == null)?'text-danger font-weight-bold':''}">${item[uh3]}</td>
                <td class="${(item[pts3] < res.kkms[0].nilai || item[pts3] == null)?'text-danger font-weight-bold':''}">${item[pts3]}</td>
                <td class="${(item[pas3] < res.kkms[0].nilai || item[pas3] == null)?'text-danger font-weight-bold':''}">${item[pas3]}</td>
            </tr>`
        })

        $('.rekap_page #table-rekap').html(theads + `<tbody>${tr}</tbody>`)
            trekaps = $('.rekap_page #table-rekap').DataTable({
                "dom": "Bftip"
            }).draw()
    })
}


// Cetak Rapor
    // Rapor Home
    // tabs rapor
    $('.nav-tabs li a').click(function(e) {
        var href = $(this).attr('href')

        $('.nav-tabs li').removeClass('active')

        $('.nav-tabs li a[href="'+href+'"]').closest('li').addClass('active')

        $('.tab-pane').removeClass('active')
        $('.tab-pane'+href).addClass('active')

    })

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
                    <img src="/img/siswas/${sessionStorage.getItem('sekolah_id')+'_'+data.nisn+'.jpg'}" onerror="this.error=null;this.src='/img/${(data.jk == 'L') ? 'no-photo.jpg' : 'siswa-p.png'}';" height="40px" class="img img-avatar" /> 
                `
            }},
            {"data": "nama_siswa"},
            {"data": null, render: (data) => {
                return `
                    <a href="/${sessionStorage.getItem('username')}/rapor/cetak?nisn=${data.nisn}&periode=${sessionStorage.getItem('periode')}" class="btn btn-danger btn-cetak-rapor" ><i class="mdi mdi-printer"></i> Cetak</a>

                `
            }},
        ]
    })




    $(document).on('change', '.selSiswaKu', function(e) {
        // alert('hi')
        window.location.href = '/'+sessionStorage.getItem('username')+'/rapor/cetak?nisn='+$(this).val()+'&periode='+sessionStorage.getItem('periode')
    })

    $('#btn-print-rapor-pts').on('click', function(e) {
        e.preventDefault();
        cetakRapor('rapor_pts', 'Rapor PTS')
    })
    $('#btn-print-rapor-pas').on('click', function(e) {
        e.preventDefault();
        cetakRapor('rapor_pas', 'Rapor PAS')
    })

    $('#btn-print-biodata').on('click', function(e) {
        e.preventDefault()
        cetakRapor('biodata_rapor', 'Cetak Biodata')
    })
    $('#btn-print-cover').on('click', function(e) {
        e.preventDefault()
        cetakRapor('cover_rapor', 'Cetak Cover')
    })

    function cetakRapor(divId, title){
        var page = document.querySelector('#'+divId)
        var win = window.open('', '_blank', 'location=yes,height=1400,width=1024,scrollbars=yes,status=yes')
        var head = `<head>
                    <title>Cetak ${title}</title>
                    <link rel="stylesheet" href="/css/app.css" />
                    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
                    <link rel="stylesheet" href="/css/rapor.css" />
                </head>`
        var body = page.outerHTML
        var html = `
                <!doctype html>
                <html>
                    ${head}
                    <body>
                        ${body}
                    </body>
                </html>

        `
        win.document.write(html)
        setTimeout(() => {
            win.print()
        }, 1500)
    }

    // Ekskul
        $('#table-ekstra td.ket-ekskul').on('dblclick', function(e) {
            var url = new URL(window.location.href)
            var nisn = url.searchParams.get('nisn')
            var ekskul_id = $(this).data('kode')
            var nama_ekskul = $(this).parents('tr').find('td').eq(1).text()
            var periode = url.searchParams.get('periode')
            var id_nilai = ($(this).data('id') != '') ? $(this).data('id') : '0'
            var ket = (id_nilai) ? $(this).text() : 'Ganti Teks ini dengan keterangan.'
            $('#modalNilaiEkskul span.nama_ekskul').text(nama_ekskul)
            $('#modalNilaiEkskul input[name="id_nilai"').val(id_nilai)
            $('#modalNilaiEkskul input[name="siswa_id"').val(nisn)
            $('#modalNilaiEkskul input[name="periode_id"').val(periode)
            $('#modalNilaiEkskul input[name="ekskul_id"').val(ekskul_id)
            $('#modalNilaiEkskul textarea').val(ket)
            $('#modalNilaiEkskul input[name="rombel_id"').val(sessionStorage.getItem('rombel_id'))

            $('#modalNilaiEkskul').modal()
        })


    // Save Nilai-Eksksul
        $(document).on('submit', '#modalNilaiEkskul .form-nilai-ekskul', function(e){
            e.preventDefault()
            var data = $(this).serialize()
            // console.log(data)
            $.ajax({
                url:'/'+sessionStorage.getItem('username')+'/ekskul?id='+$(this).find('input[name="id_nilai"]').val(),
                type: 'post',
                data: data,
                headers: headers,
                success: function(res) {
                    Swal.fire('Info', res.msg, 'info')
                    $('#table-ekstra td.eks-'+$('#modalNilaiEkskul input[name="ekskul_id"').val()).text($('#modalNilaiEkskul textarea').val())
                }
            })
        })

    // Fisik /TB BB
        $(document).on('dblclick','.td-fisik', function() {
            var url = new URL(window.location.href),
                nisn = url.searchParams.get('nisn'),
                periode = $(this).data('tapel')+''+$(this).data('sem'),
                id_fisik = $(this).data('id'),
                tb = ($(this).data('sem') == '1') ? $('.tb-1').text() : $('.tb-2').text(),
                bb = ($(this).data('sem') == '1') ? $('.bb-1').text() : $('.bb-2').text()
            
            $('#modalFisikSiswa form.form-fisik-siswa input[name="siswa_id"]').val(nisn)
            $('#modalFisikSiswa form.form-fisik-siswa input[name="id_fisik"]').val(id_fisik)
            $('#modalFisikSiswa form.form-fisik-siswa input[name="periode"]').val(periode)
            
            $('#modalFisikSiswa form.form-fisik-siswa input[name="tb"]').val(tb.replace(/[^0-9]/g,''))
            $('#modalFisikSiswa form.form-fisik-siswa input[name="bb"]').val(bb.replace(/[^0-9,]/g,''))


            $('#modalFisikSiswa .modal-title span').text($('td.nama_siswa').text())
            $('#modalFisikSiswa').modal()
        
        })

    // Simpan Fisik
    $(document).on('submit','#modalFisikSiswa form.form-fisik-siswa', function(e) {
        e.preventDefault()
        
        var periode = $('#modalFisikSiswa form.form-fisik-siswa input[name="periode"]').val()




        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/rapor/data/fisik',
            type: 'post',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Info',res.msg, 'info')
                $('.tb-'+periode.substr(4,1)).text($('#modalFisikSiswa form.form-fisik-siswa input[name="tb"]').val()+' cm')
                $('.bb-'+periode.substr(4,1)).text($('#modalFisikSiswa form.form-fisik-siswa input[name="bb"]').val()+' kg')
                $('#modalFisikSiswa').modal('hide')
            }
        })
    })


    // KEsehatan
    $(document).on('dblclick','.sht', function(){
        $('#modalKesehatan .modal-title span.nama_siswa').text($('td.nama_siswa').text())
     
        $('#modalKesehatan').modal()
    })

    $(document).on('submit','#modalKesehatan .form-kesehatan', function(e){
        e.preventDefault()
        var data = $(this).serialize()

        $.ajax({
            headers: headers,
            url: '/'+sessionStorage.getItem('username')+'/rapor/data/kesehatan',
            data: data,
            type: 'post',
            success: function(res) {
                Swal.fire(res.status, res.msg, res.icon)
                $('.sht-dengar').text($('#modalKesehatan .form-kesehatan input[name="pendengaran"]').val())
                $('.sht-lihat').text($('#modalKesehatan .form-kesehatan input[name="penglihatan"]').val())
                $('.sht-gigi').text($('#modalKesehatan .form-kesehatan input[name="gigi"]').val())
                $('.sht-lain').text($('#modalKesehatan .form-kesehatan input[name="lain"]').val())
                $('#modalKesehatan').modal('hide')
            }
        })
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
            $('.row-kd .card-title #subtema').text(subtema.kode_subtema+' . '+subtema.teks_subtema)

            $.ajax({
                headers: headers,
                url: '/'+sessionStorage.getItem('username')+'/pemetaan?subtema='+subtema.kode_subtema,
                type:'post'
            }).done(res=>{
                var datas = res.datas
                var tr = ''
                $.each(datas, (key,value) => {
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
                    Swal.fire('Info', res.msg, 'info')
                }).fail(err => {
                    console.log(err.response)
                })
            })
        })
    })



    var rombel = (sessionStorage.getItem('rombel_id') == 'all') ? $('.jurnal_page select[name="rombel"]').val() : sessionStorage.getItem('rombel_id');

    $(document).on('change', 'select[name="rombel_id"]', function(){
        $('.selSiswaku').select2()
    })
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
    }).focus(function () { $(this).select2('focus'); })

    $('.selSikap').select2().focus(function () { $(this).select2('focus'); })
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


    // Saran Rapor

    $(document).on('dblclick', '.box-saran', function(){
        var url = new URL(window.location.href)
        var nisn = url.searchParams.get('nisn')
        // alert(nisn)

        $('#modalSaran .form-saran textarea').val($(this).text().trim()).focus()
        $('#modalSaran .form-saran input[name="jenis_rapor"]').val($(this).data('jenis'))
        $('#modalSaran .form-saran input[name="siswa_id"]').val(nisn)
        $('#modalSaran .form-saran input[name="saran_id"]').val($(this).data('id'))
        $('#modalSaran').modal()
    })
    $(document).on('submit', '#modalSaran .form-saran', function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        // console.log(data)
        $.ajax({
            url: '/'+sessionStorage.getItem('username')+'/rapor/data/saran',
            type:'POST',
            data:data,
            headers: headers,
            success: function(res) {
                Swal.fire('Info', res.msg, 'info')
                $('.box-saran.saran-'+$('#modalSaran .form-saran input[name="jenis_rapor"]').val()).text($('#modalSaran .form-saran textarea').val())
                $('#modalSaran').modal('hide')
            }
        })


        
    })

    // Prestasi
    $(document).on('dblclick', '.box-prestasi', function(){
        var url = new URL(window.location.href)
        var nisn = url.searchParams.get('nisn')


        $('#modalPrestasi').modal()
    })

    $(document).on('submit', '#modalPrestasi .form-prestasi', function(e){
        e.preventDefault()

        var data = $(this).serialize()
        $.ajax({
            url: '/'+sessionStorage.getItem('username')+'/rapor/data/prestasi',
            type:'POST',
            data:data,
            headers: headers,
            success: function(res) {
                Swal.fire('Info', res.msg, 'info')
                $('.box-prestasi.seni').text($('textarea[name="kesenian"]').val())
                $('.box-prestasi.olahraga').text($('textarea[name="olahraga"]').val())
                $('#modalPrestasi').modal('hide')
            }
        })

    })

    // Absensi
    $(document).on('dblclick', 'td.td-absensi', function() {
        

        $('#modalAbsensi').modal()
    })

    $(document).on('submit', '#modalAbsensi .form-absensi', function(e) {
        e.preventDefault()

        var data = $(this).serialize()
        $.ajax({
            url: '/'+sessionStorage.getItem('username')+'/rapor/data/absensi',
            type:'POST',
            data:data,
            headers: headers,
            success: function(res) {
                Swal.fire('Info', res.msg, 'info')
                $('.td-absensi.td-sakit').text($('input[name="sakit"]').val()+" hari")
                $('.td-absensi.td-ijin').text($('input[name="ijin"]').val()+" hari")
                $('.td-absensi.td-alpa').text($('input[name="alpa"]').val()+" hari")
                $('#modalAbsensi').modal('hide')
            }
        })
    })

    // Model Rapor PTS
    $(document).on('change', 'input#model-rapor', function(){
        var val = $(this).prop('checked')
        if ( val == true) {
            $('.dg-deskripsi').show()
            $('.per-kd').hide()
            $('.label-model-rapor').text('Dengan Deskripsi')
        } else {
            $('.dg-deskripsi').hide()
            $('.per-kd').show()
            $('.label-model-rapor').text('Dengan Per KD')
        }
    })



})
