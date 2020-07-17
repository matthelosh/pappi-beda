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
            url: '/users/'+user[1],
            type: 'get'
        }).done(res => {
            var user = res.user
            $('.form-user').append(`<input type="hidden" name="_method" value="put"><input type="hidden" name="id" value="${user.id}">`)
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
            {"data": "operators.nama"},
            {"data": "ks.nama"},
            {"data": null, render: (data) => {
                return "Opsi"
            }},
        ]
    })

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