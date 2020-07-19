$(document).ready(function() {
    var headers =  {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    // swal("Halo")
    // Add Menu MOdal 
    $('.btn-add-menu').on('click', function(e) {
        e.preventDefault()
        $('#menuModal').modal({'show': true})
        // var modalMenu = new coreui.Modal(document.getElementById('menuModal'), options);
        // modalMenu.modal()
    })

    // Sumbit Menu
    $(document).on('submit', '.form-menu', function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        $.ajax({
            type: $(this).prop('method'),
            url: $(this).prop('action'),
            data: data
        }).done(res => {
            $('#menuModal').hide({'backdrop': false, 'focus': false})
            hideModal()
            toastr.success(res.msg)
            
        }).fail(err => {
            $('#menuModal').hide({'backdrop': false, 'focus': false})
            hideModal()
            toastr.error(err.response.msg)
        })
    })

    function hideModal() {
        $('body .modal-backdrop').hide()
    }


    var tusers = $('.table-users').DataTable({
        dom: 'ftip',
        select: 'multi'
    })

    // var selectedTr = [];

    // $(document).on('click', 'tr', function(e) {
    //     $(this).toggleClass('selected')
    // })

    // Edit User
    $(document).on('click', '.btn-edit-user', function(e) {
        e.preventDefault()
        var user = tusers.row($(this).parents('tr')).data()
        $.ajax({
            headers: headers,
            url: '/users/'+user[2],
            type: 'get'
        }).done(res => {
            var user = res.user
            $('.form-user').append(`<input type="hidden" name="_method" value="put"><input type="hidden" name="id" value="${user.id}">`)
            $('.form-user select[name="sekolah_id"]').append(`<option value="${(user.sekolahs)?user.sekolah_id:'0'}" selected>${(user.sekolahs)?user.sekolahs.nama_sekolah:'Pilih Sekolah'}</option>`)
            $('.form-user input[name="nip"]').val(user.nip)
            $('.form-user input[name="nama"]').val(user.nama)
            $('.form-user select[name="jk"]').val(user.jk)
            $('.form-user input[name="username"]').val(user.username)
            $('.form-user input[name="email"]').val(user.email)
            $('.form-user input[name="password"]').val(user.default_password)
            $('.form-user select[name="role"]').val(user.role)
            $('.form-user input[name="hp"]').val(user.hp)
            $('.form-user textarea[name="alamat"]').val(user.alamat)
            $('#modalUser').modal()
        })
        
    })

    $(document).on('click', '.btn-reset-all', function(){
        var datas = []
        var trs = tusers.rows({selected: true}).data()
        trs.each(user => {
            console.log(user)
        })
    })

    // Import USer
    $(document).on('click', '.btn-import-user', function(e) {
        e.preventDefault()
        $('#modalImport .form-import').prop('action', '/users/import')
        $('#modalImport #model').text('Pengguna')
        $('#modalImport').modal()
    })

    // Hapus USer
    $(document).on('click', '.btn-delete-user', function(e) {
        e.preventDefault()
        var user = tusers.row($(this).parents('tr')).data()
        swal({
            title: "Yakin Menghapus "+user[2]+"?",
            text: "Pengguna  akan hilang dari database",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((hapus) => {
            if (hapus) {
              $.ajax({
                  headers: headers,
                  type:'post',
                  url: '/users/'+user[1],
                  data: {'_method': 'delete'}
              }).done(res => {
                  swal('Info', res.msg, 'info')
                  window.reload()
              }).fail(err => {
                  swal('Error', err.response.msg, 'error')
              })
            } else {
              swal("Data tidak dihapus");
            }
          });
        
    })

    // Reset Password User
    $(document).on('click', '.btn-reset-password', function(e) {
        e.preventDefault()
        var user = tusers.row($(this).parents('tr')).data()
        swal({
            title: 'Yakin Menyetel Ulang Sandi '+user[2]+'?',
            text: 'Sandi Pengguna akan diganti Sandi Asal',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then((lanjut) => {
            if(lanjut) {
                $.ajax({
                    headers: headers,
                    url: '/users/reset/'+user[1],
                    type: 'post',
                    data: {'_method': 'put'}
                }).done( res => {
                    swal('Info', res.msg, 'success')
                }).fail(err => {
                    swal('Error', err.response.msg, 'error')
                })
            } else {
                swal('Info', 'Sandi Pengguna tidak jadi direset', 'info');
            }
        })
    })

    // Reset Password All User
    $(document).on('click','.btn-reset-all', function(e) {
        e.preventDefault();
        swal({
            title: 'Yakin Menyetel Ulang Sandi Semua Pengguna?',
            text: 'Sandi Pengguna akan diganti Sandi Asal',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then((lanjut) => {
            if(lanjut) {
                $.ajax({
                    headers: headers,
                    url: '/users/reset',
                    type: 'post',
                    data: {'_method': 'put'}
                }).done( res => {
                    swal('Info', res.msg, 'success')
                }).fail(err => {
                    swal('Error', err.response.msg, 'error')
                })
            } else {
                swal('Info', 'Sandi Pengguna tidak jadi direset', 'info');
            }
        })
        
    })
    // Print Users
    $(document).on('click', '.btn-print-users', function(e) {
        e.preventDefault()

        $.ajax({
            headers: headers,
            url: '/users/get',
            type: 'post'
        }).done(res => {
            var tr = ''
            var users = res.users
            var i = 0
            users.forEach(user => {
                i++
                tr += `<tr>
                        <td>${i}</td>
                        <td>${user.nip}</td>
                        <td>${user.nama}</td>
                        <td>${user.username}</td>
                        <td>${user.default_password}</td>
                        <td>${user.email}</td>
                        <td>${user.jk}</td>
                        <td>${user.hp}</td>
                        <td>${user.alamat}</td>
                        <td>${user.level}</td>
                    </tr>`
            })
            var table = `
                <table border="1" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>USERNAME</th>
                            <th>PASSWORD</th>
                            <th>EMAIL</th>
                            <th>JK</th>
                            <th>HP</th>
                            <th>ALAMAT</th>
                            <th>LEVEL</th>
                        </tr>
                    </thead>
                    <tbody>${tr}</tbody>
                </table>
            `
            cetakTabel(table, "Data Pengguna")
        }).fail(err => {
            console.log(err)
        })
    })

    // Sekolah
    var tsekolahs = $('#table-sekolahs').DataTable({
        serverSide: true,
        ajax: {
            url: '/sekolah?req=dt',
            type: 'post',
            headers: headers
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "npsn"},
            {"data": "nama_sekolah"},
            {"data": "alamat"},
            {"data": "desa"},
            {"data": "kec"},
            {"data": "kab"},
            {"data": "prov"},
            {"data": "kode_pos"},
            {"data": "telp"},
            {"data": "email"},
            {"data": null, render: (data) => {
                return `<a href="${data.website}" target="_blank">${data.website}</a>`
            }},
            {"data": null, render: (data) => {
                return (data.operators != null) ? data.operators.nama : 'Belum ada'
            }},
            {"data": null, render: (data) => {
                return (data.ks != null) ? data.ks.nama : 'Belum ada'
            }},
            {"data": null, render: (data) => {
                return `
                        <button class="btn btn-warning btn-edit-sekolah btn-sm" title="${data.nama_sekolah}">
                            <svg class="c-icon">
                                <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                            </svg>
                        </button>
                        <button class="btn btn-danger btn-delete-sekolah btn-sm" title="${data.nama_sekolah}">
                            <svg class="c-icon">
                                <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                            </svg>
                        </button>
                `
            }},
        ]
    })

    // Edit Sekolah
    $(document).on('click', '.btn-edit-sekolah', function(e) {
        e.preventDefault()
        var sekolah = tsekolahs.row($(this).parents('tr')).data()
        $('#modalSekolah .form-sekolah').prepend(`<input type="hidden" name="_method" value="put"><input type="hidden" name="id" value="${sekolah.id}">`)
        $('#modalSekolah .form-sekolah input[name="npsn"]').val(sekolah.npsn)
        $('#modalSekolah .form-sekolah input[name="nama_sekolah"]').val(sekolah.nama_sekolah)
        $('#modalSekolah .form-sekolah textarea[name="alamat"]').val(sekolah.alamat)
        $('#modalSekolah .form-sekolah input[name="desa"]').val(sekolah.desa)
        $('#modalSekolah .form-sekolah input[name="kec"]').val(sekolah.kec)
        $('#modalSekolah .form-sekolah input[name="kab"]').val(sekolah.kab)
        $('#modalSekolah .form-sekolah input[name="prov"]').val(sekolah.prov)
        $('#modalSekolah .form-sekolah input[name="kode_pos"]').val(sekolah.kode_pos)
        $('#modalSekolah .form-sekolah input[name="telp"]').val(sekolah.telp)
        $('#modalSekolah .form-sekolah input[name="email"]').val(sekolah.email)
        $('#modalSekolah .form-sekolah input[name="website"]').val(sekolah.website)
        $('#modalSekolah .form-sekolah select[name="operator_id"]').append(`<option value="${(sekolah.operators)?sekolah.operator_id:'0'}" selected>${(sekolah.operators)?sekolah.operators.nama:'Pilih Operator'}</option>`)
        $('#modalSekolah .form-sekolah select[name="ks_id"]').append(`<option value="${(sekolah.ks)?sekolah.ks_id:'0'}" selected>${(sekolah.ks)?sekolah.ks.nama:'Pilih Kepala Sekolah'}</option>`)
        $('#modalSekolah').modal()
    })

    // Add Sekolah
    $(document).on('submit', '.form-sekolah', function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        $.ajax({
            headers: headers,
            url: '/sekolah',
            type: 'post',
            data: data
        }).done(res => {
            tsekolahs.ajax.reload()
            swal('Info', res.msg, 'info')
        }).fail(err => {
            // swal('Error', err.response.msg, 'error')
            console.log(err)
        })
    })

    // ROmbels
    var trombels = $('#table-rombels').DataTable({
        serverSide: true,
        ajax: {
            url: '/rombels?req=dt',
            type: 'post',
            headers: headers
        },
        columns:[
            {"data": "DT_RowIndex",  },
            {"data": null, render: (data) => {
                return (data.sekolahs)? data.sekolahs.nama_sekolah: 'Belum Ada Sekolah'
            }},
            {"data": "kode_rombel"  },
            {"data": "nama_rombel"},
            {"data": "tingkat"  },
            {"data": null, render: (data) => {
                return (data.gurus) ? data.gurus.nama: 'Belum ada Wali Kelas'
            }},
            {"data": null, render: (data) => {
                return  `
                    <button class="btn btn-info btn-mnj-rombel btn-sm" title="Manajemen Rombel ${data.nama_rombel} ?">
                        <svg class="c-icon">
                            <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-equalizer"></use>
                        </svg>
                    </button>
                    <button class="btn btn-warning btn-edit-rombel btn-sm" title="Edit Rombel ${data.nama_rombel} ?">
                        <svg class="c-icon">
                            <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg>
                    </button>
                    <button class="btn btn-danger btn-delete-rombel btn-sm" title="Hapus Rombel ${data.nama_rombel} ?">
                        <svg class="c-icon">
                            <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                        </svg>
                    </button>
                `
            }}
        ]
    })

    // Manajemen Rombel
    $(document).on('click', '.btn-mnj-rombel', function(e) {
        e.preventDefault()
        var rombel = trombels.row($(this).parents('tr')).data()
        // alert(rombel.kode_rombel)
        $('#modalMnjRombel').modal()
        $('#modalMnjRombel select[name="rombel_now"]').append(`<option value="${rombel.kode_rombel}" selected>${rombel.nama_rombel}</option>`)

        

        var tmembers = $('#modalMnjRombel #table-members').DataTable({
            select: 'multi',
            serverSide: true,
            ajax: {
                headers: headers,
                url: '/siswas?req=dt-members&rombel_id='+rombel.kode_rombel,
                type: 'post'
            },
            columns: [
                {"data" : 'DT_RowIndex'},
                {"data" : "nisn"},
                {"data" : "nama_siswa"}
            ]
        })
        var tnonmembers = $('#modalMnjRombel #table-non-members').DataTable({
            select: 'multi',
            serverSide: true,
            ajax: {
                headers: headers,
                url: '/siswas?req=dt-non-members',
                type: 'post'
            },
            columns: [
                {"data" : 'DT_RowIndex'},
                {"data" : "nisn"},
                {"data" : "nama_siswa"}
            ]
        })

        $('#modalMnjRombel .select-all').click(function(e) {
            if($(this).prop('checked')) {
                $(this).closest('table').DataTable().rows().select()
            } else {
                $(this).closest('table').DataTable().rows().deselect()
            }
            
        })

        // Keluarkan Siswa
        $(document).on('click', '.btn-keluarkan-member', function(e) {
            e.preventDefault()
            var seld_members = tmembers.rows({selected: true}).data()
            var ids = []
            var namas = ''
            seld_members.each(siswa => {
                ids.push(siswa.id)
                namas += siswa.nama_siswa+', '
            })
            swal({
                title: 'Yakin Keluarkan siswa?',
                text: namas,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((lanjut) => {
                if (lanjut) {
                    $.ajax({
                        headers: headers,
                        url: '/siswas/out',
                        type:'post',
                        data: {'ids': ids}
                    }).done(res => {
                        swal('Info', res.msg, 'info')
                        $('#modalMnjRombel .select-all').prop('checked', false)
                        tmembers.ajax.reload()
                        tnonmembers.draw()
                    }).fail(err=>{
                        swal('Error', err.response.msg, 'error')
                    })
                } else {
                    swal('Info', 'Siswa tidak dikeluarkan', 'info')
                }
            })
        })

        // Pindah Rombel
        $(document).on('click', '.btn-pindah-member', function(e) {
            e.preventDefault()
            var seld_members = tmembers.rows({selected: true}).data()
            var ids = []
            var namas = ''
            var rombel_asal = rombel.kode_rombel, rombel_tujuan = $('#modalMnjRombel select[name="rombel_now"]').val()
            // console.log(rombel_tujuan)
            seld_members.each(siswa => {
                ids.push(siswa.id)
                namas += siswa.nama_siswa+', '
            })

            if (rombel_asal == rombel_tujuan) {
                swal('Error', 'Rombel Tujuan Tidak boleh sama dengan rombel asal', 'error')
                return false
            } else if(ids.length < 1) {
                swal('Error', 'Belum ada Siswa Yang Dipilih', 'error')
                return false
            }

            swal({
                title: 'Yakin Pindahkan siswa ke rombel '+rombel_tujuan+'?',
                text: namas,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((lanjut) => {
                if (lanjut) {
                    $.ajax({
                        headers: headers,
                        url: '/siswas/pindah',
                        type:'post',
                        data: {'ids': ids, tujuan: rombel_tujuan}
                    }).done(res => {
                        swal('Info', res.msg, 'info')
                        $('#modalMnjRombel .select-all').prop('checked', false)
                        tmembers.draw()
                        tnonmembers.ajax.reload()
                    }).fail(err=>{
                        swal('Error', err.response.msg, 'error')
                    })
                } else {
                    swal('Info', 'Siswa tidak dikeluarkan', 'info')
                }
            })
            
        })

        
        // Masukkan Siswa
        $(document).on('click', '.btn-masukkan-member', function(e) {
            e.preventDefault()
            var seld_non_members = tnonmembers.rows({selected: true}).data()
            var rombel_id = rombel.kode_rombel
            var ids = []
            var namas = ''
            seld_non_members.each(siswa => {
                ids.push(siswa.id)
                namas += siswa.nama_siswa+', '
            })
            swal({
                title: 'Yakin Masukkan siswa?',
                text: namas,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((lanjut) => {
                if (lanjut) {
                    $.ajax({
                        headers: headers,
                        url: '/siswas/in',
                        type:'post',
                        data: {'ids': ids, 'rombel_id': rombel_id}
                    }).done(res => {
                        swal('Info', res.msg, 'info')
                        $('#modalMnjRombel .select-all').prop('checked', false)
                        tmembers.draw()
                        tnonmembers.ajax.reload()
                    }).fail(err=>{
                        swal('Error', err.response.msg, 'error')
                    })
                } else {
                    swal('Info', 'Siswa Tidak dimasukkan', 'info')
                }
            })
        })

        $('#modalMnjRombel').on('hide.coreui.modal', function(){
            tmembers.destroy()
            tnonmembers.destroy()
        //    trombels.ajax.reload()
        })



    })

    // Edit Rombel
    $(document).on('click', '.btn-edit-rombel', function(e) {
        e.preventDefault()
        var data = trombels.row($(this).parents('tr')).data()
        $('#modalRombel .mode-form').text('Edit')
        $('#formRombel').prepend(`<input type="hidden" name="id" value="${data.id}">`)
        $('#formRombel input[name="kode_rombel"]').val(data.kode_rombel)
        $('#formRombel input[name="nama_rombel"]').val(data.nama_rombel)
        $('#formRombel select[name="tingkat"]').val(data.tingkat)
        $('#formRombel select[name="guru_id"]').append(`<option value="${data.guru_id}" selected>${data.gurus.nama}</option>`)
        $('#formRombel select[name="sekolah_id"]').append(`<option value="${data.sekolah_id}" selected>${data.sekolahs.nama_sekolah}</option>`)

        $('#modalRombel').modal()

        
    })
// Hapus Rombel
    $(document).on('click', '.btn-delete-rombel', function(e) {
        e.preventDefault()
        var rombel = trombels.row($(this).parents('tr')).data()
        swal({
            title: "Yakin Menghapus Rombel "+rombel.nama_rombel+"?",
            text: "Rombel  akan hilang dari database",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((hapus) => {
            if (hapus) {
              $.ajax({
                  headers: headers,
                  type:'post',
                  url: '/rombels/'+rombel.id,
                  data: {'_method': 'delete'}
              }).done(res => {
                  swal('Info', res.msg, 'info')
                  trombels.ajax.reload()
              }).fail(err => {
                  swal('Error', err.response.msg, 'error')
              })
            } else {
              swal("Data tidak dihapus");
            }
          });
    })


    $(document).on('submit', '#formRombel', function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        var url = ($('#modalRombel .mode-form').text() == 'Buat') ? '/rombels/create' : '/rombels/update'
        $.ajax({
            headers: headers,
            url: url,
            type: 'post',
            data: data
        }).done(res => {
            swal('Info', res.msg, 'info')
            trombels.ajax.reload()
        }).fail(err => {
            swal('Error', err.response.msg, 'error')
        })
    })

    // import ROmbel
    $(document).on('click', '.btn-import-rombels', function(e) {
        e.preventDefault()
        $('#modalImport .form-import').prop('action', '/rombels/import')
        $('#modalImport #model').text('Rombel')
        $('#modalImport').modal()
    })

// Siswa
    var tsiswas = $('#table-siswas').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/siswas?req=dt',
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
                return (data.rombels)?data.rombels.nama_rombel:'-'
            }},
            {"data": null, render: (data) => {
                return (data.ortus) ? data.ortus.nama_ayah : '-'
            }},
            {"data": null, render: (data) => {
                return `
                <button class="btn btn-info btn-ortu btn-sm" title="Buat Ortu ${data.nama_siswa} ?">
                    <svg class="c-icon">
                        <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-blind"></use>
                    </svg>
                </button>
                <button class="btn btn-warning btn-edit-siswa btn-sm" title="Edit ${data.nama_siswa} ?">
                    <svg class="c-icon">
                        <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                    </svg>
                </button>
                <button class="btn btn-danger btn-delete-siswa btn-sm" title="Hapus ${data.nama_siswa} ?">
                    <svg class="c-icon">
                        <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                    </svg>
                </button>
                    `
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
            'action':'/siswas/'+siswa.id
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
        $('#form-siswa img.foto-siswa').prop({'src': 'img/siswas/'+siswa.sekolah_id+'_'+siswa.nisn+'.jpg'}).on('error', function(){
            $(this).prop('src', 'img/no-photo.jpg')
        })

        $('#modalSiswa').modal()
        
    })

    // Hapus Siswa
    $(document).on('click', '.btn-delete-siswa', function(e) {
        e.preventDefault();
        var siswa = tsiswas.row($(this).parents('tr')).data()
        swal({
            title: "Yakin Menghapus Siswa "+siswa.nama_siswa+"?",
            text: "Siswa  akan dihapus dari database",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((hapus) => {
            if (hapus) {
              $.ajax({
                  headers: headers,
                  type:'post',
                  url: '/siswas/'+siswa.id,
                  data: {'_method': 'delete'}
              }).done(res => {
                  swal('Info', res.msg, 'info')
                  tsiswas.ajax.reload()
              }).fail(err => {
                  swal('Error', err.response.msg, 'error')
              })
            } else {
              swal("Data Siswa Aman");
            }
          });

    })
    
    // Modal Ortu
    $(document).on('click', '.btn-ortu', function(e) {
        e.preventDefault()
        var siswa = tsiswas.row($(this).parents('tr')).data()
        $.ajax({
            headers: headers,
            url: '/ortus/siswa/'+siswa.nisn,
            type:'post'
        }).done(res => {
            if (res.ortu != null) {
                var ortu = res.ortu
                $('#modalOrtu .mode-form').text('Edit')
                $('#modalOrtu .siswa').text(siswa.nama_siswa)
                $('#form-ortu').prop({
                    'action': '/ortus/'+ortu.id,
                    
                }).prepend(`<input type="hidden" name="id" value="${ortu.id}"><input type="hidden" name="_method" value="put">`)
                $('#form-ortu input[name="nama_ayah"]').val(ortu.nama_ayah)
                $('#form-ortu input[name="job_ayah"]').val(ortu.job_ayah)
                $('#form-ortu input[name="nama_ibu"]').val(ortu.nama_ibu)
                $('#form-ortu input[name="job_ibu"]').val(ortu.job_ibu)
                $('#form-ortu input[name="nama_wali"]').val(ortu.nama_wali)
                $('#form-ortu input[name="job_wali"]').val(ortu.job_wali)
                $('#form-ortu input[name="hub_wali"]').val(ortu.hub_wali)
                $('#form-ortu input[name="alamat_wali"]').val(ortu.alamat_wali)
            } else {
                $('#modalOrtu .mode-form').text('Buat')
                $('#modalOrtu .siswa').text(siswa.nama_siswa)
                $('#form-ortu').prop({
                    'action': '/ortus/create',
                    
                })
            }
            $('#form-ortu').prepend(`<input type="hidden" name="siswa_id" value="${siswa.nisn}">`)
            $('#modalOrtu').modal()
        }).fail(err => {
            swal('Error', err.response.msg, 'error')
        })
    })

// Mapel
    var tmapels = $('#table-mapels').DataTable({
        serverSide: true,
        ajax: {
            headers: headers,
            url: '/mapels?req=dt',
            type: 'post'
        },
        columns: [
            {"data": "DT_RowIndex"},
            {"data": "kode_mapel"},
            {"data": "nama_mapel"},
            {"data": "label"},
            {"data": "tingkat"},
            {"data": null, render: (data) => {
                return `
                <button class="btn btn-warning btn-edit-mapel btn-sm" title="Edit ${data.nama_mapel} ?">
                    <svg class="c-icon">
                        <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                    </svg>
                </button>
                <button class="btn btn-danger btn-delete-mapel btn-sm" title="Hapus ${data.nama_mapel} ?">
                    <svg class="c-icon">
                        <use xlink:href="coreui/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                    </svg>
                </button>
                `
            }},
        ]
    })

// Import Mapel
    $(document).on('click', '.btn-import-mapel', function(e) {
        e.preventDefault()
        $('#modalImport #model').text('Mapel')
        $('#modalImport .form-import').prop('action', '/mapels/import')
        $('#modalImport').modal()
    })
// hapus Mapel
    $(document).on('click', '.btn-delete-mapel', function(e) {
        e.preventDefault()
        var mapel = tmapels.row($(this).parents('tr')).data()

        swal({
            title: 'Yakin Menghapus '+mapel.nama_mapel+'?',
            text: 'Mapel '+mapel.nama_mapel+'akan dihapus dari database',
            buttons: true,
            dangerMode: true,
            icon: 'warning'
        }).then((lanjut) => {
            if(lanjut) {
                $.ajax({
                    headers: headers,
                    url: '/mapels/'+mapel.id,
                    type: 'delete'
                }).done(res=>{
                    swal('Info', res.msg, 'info')
                    tmapels.ajax.reload()
                }).fail(err=>{
                    swal('Error', err.response.msg, 'error')
                })
            } else {
                swal('Info', 'Data Mapel tidak dihapus')
            }
           
        })
    })
    $(document).on('click', '.btn-edit-mapel', function(e) {
        e.preventDefault()
        var mapel = tmapels.row($(this).parents('tr')).data()
        $('#modalMapel .mode-form').text('Edit')
        $('#form-mapel').prop({'action': '/mapels/'+mapel.id}).prepend(`<input type="hidden" name="_method" value="put">`)
        $('#form-mapel input[name="kode_mapel"]').val(mapel.kode_mapel)
        $('#form-mapel input[name="nama_mapel"]').val(mapel.nama_mapel)
        $('#form-mapel input[name="label"]').val(mapel.label)
        $('#form-mapel select[name="tingkat"]').val(mapel.tingkat)

        $('#modalMapel').modal()
    })
// Select2
    // Select Rombel
    $('.selRombel').select2({
        ajax: {
            headers: headers,
            url: '/rombels?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.rombels
                    };
                },
                cache: true,

        },
    })
    // Fungsi select User
    $('.selUsers').select2({
        ajax: {
            headers: headers,
            url: '/users/get?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.users
                    };
                },
                cache: true,

        },
    })
    $('.selWali').select2({
        ajax: {
            headers: headers,
            url: '/users/get?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.users
                    };
                },
                cache: true,

        },
    })

    // Select Sekolah
    $('.selSekolah').select2({
        ajax: {
            headers: headers,
            url: '/sekolah?req=select',
            type: 'post',
                dataType: 'json',
                delay: 250,
                processResults: function(response) {
                    return {
                        results: response.sekolahs
                    };
                },
                cache: true,

        },
    })
    // Fungsi Cetak Tabel
    function cetakTabel(table, title) {
        var doc = `
            <!doctype html>
            <html>
                <head>
                    <title>${title}</title>

                    <style>
                        .table {
                            border-collapse:collapse;
                        }
                        .text-center {
                            text-align:center
                        }
                            
                    </style>
                </head>
                <body>
                        <h2 class="text-center">${title}</h2>
                        ${table}
                </body>
            </html>
            `
            console.log(doc)
        var win = window.open("_blank","", "width=700, height=800")
        win.document.write(doc)
        win.print()
        win.close()
    }
})