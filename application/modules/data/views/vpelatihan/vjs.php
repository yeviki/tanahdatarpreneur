<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
    //  custom js //
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    let site = '<?php echo site_url(isset($siteUri) ? $siteUri : ''); ?>';
    let msg = new alertMessage();
    let namaField = [];
    // let field = {
    //     "1" => {
    //         "max" => 16,
    //         "min" => 0,
    //         "type" => "numerik"
    //     }
    // };

    // console.log(field);
    const swalAlert = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    });

    function run_waitMe(el) {
        el.waitMe({
            effect: 'facebook',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: 100,
            waitTime: -1,
            textPos: 'vertical',
            source: '',
            fontSize: '',
            onClose: function(el) {}
        });
    }
    $(document).ready(function(e) {
        getDataListPelatihan();
    });

    $(document).on('click', '.btnFilter', function(e) {
        $('#formFilter').slideToggle('slow');
        $('form#formFilter').trigger('reset');
        $('form#formFilter .select-all').select2().val('').trigger("change");
    });

    $(document).on('click', '#cancel', function(e) {
        e.preventDefault();
        $('#formFilter').slideToggle('slow');
        $('form#formFilter').trigger('reset');
        $('form#formFilter .select-all').select2().val('').trigger("change");
        getDataListPelatihan();
    });
    $('#formFilter').submit(function(e) {
        e.preventDefault();
        getDataListPelatihan();
    });

    function getDataListPelatihan() {
        $('#tblList').dataTable({
            "pagingType": "full_numbers",
            "destroy": true,
            "processing": true,
            "language": {
                "loadingRecords": '&nbsp;',
                "processing": 'Loading data...'
            },
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": site + '/listview',
                "type": "POST",
                "data": {
                    "param": $('#formFilter').serializeArray(),
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $('input[name="' + csrfName + '"]').val()
                },
            },
            "columnDefs": [{
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                    "className": 'text-center'
                },
                {
                    "targets": [-1, -2], //last column
                    "orderable": false, //set not orderable
                    "className": 'text-center'
                },
            ],
        });
        $('#tblList_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#tblList_length select').addClass('form-control');
    }
    //panggil form Entri
    $(document).on('click', '#btnAdd', function(e) {
        formReset();
        $('#modalEntryForm').modal({
            backdrop: 'static'
        });
    });
    //close form entri
    $(document).on('click', '.btnClose', function(e) {
        formReset();
        $('#modalEntryForm').modal('toggle');
    });

    function formReset() {
        $('#formEntry').attr('action', site + '/create');
        $('#errEntry').html('');
        $('form#formEntry').trigger('reset');
        $('select[name="id_jadwal"]').select2().val('').trigger("change");
        $('select[name="id_metode_pelatihan"]').select2().val('1').trigger("change");
        $('form#formEntry').removeClass('was-validated');
        $(".syarat").hide();
        $(".pesan").hide();
        $('select[name="syarat_id[]"]').select2().val(["1"]).trigger("change");
        $('select[name="syarat_dinamis_id[]"]').select2().val(["1"]).trigger("change");
    }

    function formResetShow() {
        $('#formDaftarPeserta').attr('action', site + '/list-pendaftar');
        $('#errEntry').html('');
        $('form#formDaftarPeserta').trigger('reset');
        $('form#formDaftarPeserta').removeClass('was-validated');
        $(".syarat").hide();
        $(".pesan").hide();
        $('select[name="syarat_id[]"]').select2().val(["1"]).trigger("change");
    }

    $(document).on('submit', '#formEntry', function(e) {
        e.preventDefault();
        let postData = $(this).serialize();
        // get form action url
        var form = $('#formEntry')[0];
        let formActionURL = $(this).attr("action");
        $("#save").html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $("#save").addClass('disabled');
        run_waitMe($('#frmEntry'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin menyimpan data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: formActionURL,
                    mimeType: "multipart/form-data",
                    type: "POST",
                    data: new FormData(form),
                    dataType: "json",
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        $('#formEntry').addClass('was-validated');
                        swalAlert.fire({
                            title: 'Gagal Simpan',
                            text: 'Proses simpan data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errEntry').html(msg.error('Silahkan dilengkapi data pada form inputan dibawah'));
                                $.each(data.message, function(key, value) {
                                    if (key != 'isi')
                                        $('input[name="' + key + '"], select[name="' + key + '"]').closest('div.required').find('div.invalid-feedback').text(value);
                                    else {
                                        $('#pesanErr').html(value);
                                    }
                                });
                                $('#frmEntry').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmEntry').waitMe('hide');
                        $('#modalEntryForm').modal('toggle');
                        swalAlert.fire({
                            title: 'Berhasil Simpan',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSuccess').html(msg.success(data.message));
                                getDataListPelatihan();
                            }
                        })
                    }
                }).fail(function() {
                    $('#errEntry').html(msg.error('Harap periksa kembali data yang diinputkan'));
                    $('#frmEntry').waitMe('hide');
                }).always(function() {
                    $("#save").html('<i class="fas fa-check"></i> SUBMIT');
                    $("#save").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Simpan',
                    text: 'Proses simpan data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmEntry').waitMe('hide');
                        $("#save").html('<i class="fas fa-check"></i> SUBMIT');
                        $("#save").removeClass('disabled');
                    }
                })
            }
        })
    });

    // Combobox pemilihan jadwal pelatihan
    $(document).on('change input keyup', 'select[name="id_jadwal"]', function(e) {
        let id = $(this).val();
        // getPertemuan(id);
        getDataDetail(id);
    });

    function getDataDetail(jadwalID) {
        $.ajax({
            type: 'POST',
            url: site + '/views',
            data: {
                'jadwal_id': jadwalID,
                'flag': '',
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {
                    $('#nm_pelatihan').val(data.message.nm_pelatihan);
                    $('#nm_jenis_kegiatan').val(data.message.nm_jenis_kegiatan);
                    $('#tanggal_pelatihan').val(data.message.tanggal_pelatihan);
                    $('#daterange').val(data.message.daterange);
                    $('#tempat_pelatihan').val(data.message.tempat_pelatihan);
                    $('#pagu_anggaran').val(data.message.pagu_anggaran);
                    $('#nm_sub_kegiatan').val(data.message.nm_sub_kegiatan);
                } else if (data.status == 'RC404') {
                    $('#nm_pelatihan').val('');
                    $('#nm_jenis_kegiatan').val('');
                    $('#tanggal_pelatihan').val('');
                    $('#daterange').val('');
                    $('#tempat_pelatihan').val('');
                    $('#pagu_anggaran').val('');
                    $('#nm_sub_kegiatan').val('');
                }
            }
        });
    }

    $(document).on('click', '.btnEdit', function(e) {
        e.stopPropagation();
        formReset();
        $('#formEntry').attr('action', site + '/update');
        var token = $(this).data('id');
        $('#modalEntryForm').modal({
            backdrop: 'static'
        });
        getDataEdit(token);
    });

    function getDataEdit(token) {
        run_waitMe($('#frmEntry'));
        $.ajax({
            type: 'POST',
            url: site + '/details',
            data: {
                'token': token,
                'flag': 'ED',
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {
                    $('input[name="tokenId"]').val(token);
                    $('input[name="fileshow"]').val(data.message.upload_brosur);
                    $('#id_jadwal').select2().val(data.message.id_jadwal).trigger("change");
                    $('#id_sumber').select2().val(data.message.id_sumber).trigger("change");
                    tinymce.get('keterangan').setContent(data.message.keterangan);
                    $('#id_metode_pelatihan').select2().val(data.message.id_metode_pelatihan).trigger("change");
                    $('#kuota').val(data.message.kuota);
                    $('select[name="syarat_id[]"]').select2().val(data.message.syarat_id).trigger("change");
                    $('select[name="syarat_dinamis_id[]"]').select2().val(data.message.syarat_dinamis_id).trigger("change");
                    $('#status').select2().val(data.message.status).trigger("change");
                    // $.each(data.message.syarat_id, function(key, g){
                    //     $('input[type="select-all"][name="syarat_id[]"]#syarat_id_'+g).prop('checked', true);
                    // });
                }
                $('#frmEntry').waitMe('hide');
            }
        });
    }

    $(document).on('click', '.btnShow', function(e) {
        e.stopPropagation();
        formResetShow();
        $(this).html('<i class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></i>');
        $(this).addClass('disabled');
        $('#formEntry').attr('action', site + '/update');
        var token = $(this).data('id');
        var pelatihan = $(this).data('pe');
        var status = $(this).data('vl');

        $('#modalViewPelatihan').modal({
            backdrop: 'static'
        });
        getDataView(token, pelatihan, status);
    });

    function getDataView(token, pelatihan, status) {
        run_waitMe($('#frmViewShow'));
        $.ajax({
            type: 'POST',
            url: site + '/details',
            data: {
                'token': token,
                'flag': '',
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {
                    $('input[name="tokenView"]').val(token);
                    $('input[name="pelatihanId"]').val(pelatihan);
                    $('input[name="statusId"]').val(status);
                    $('#judul_show').html(data.message.nm_pelatihan);
                    $('#id_jenis_kegiatan_show').html(data.message.id_jenis_kegiatan);
                    $('#urusan_pemerintahan_show').html(data.message.urusan_pemerintahan);
                    $('#id_metode_pelatihan_show').html(data.message.id_metode_pelatihan);
                    $('#keterangan_show').html(data.message.keterangan);
                    $('#mulai_registrasi_show').html(data.message.mulai_registrasi);
                    $('#akhir_registrasi_show').html(data.message.akhir_registrasi);
                    $('#kuota_show').html(data.message.kuota);
                    $('#alamat_show').html(data.message.tempat_pelatihan);
                    $('#jadwal_pelatihan_show').html(data.message.tanggal_pelatihan);

                    //console.log(data.message.syarat);
                    let html = '';
                    let n = 0;
                    let st = '';
                    // Syarat Pelatihan
                    $.each(data.message.syarat, function(key, val) {
                        if (val.nilai) {
                            st = 'readonly';
                            color = 'class="text-success"';
                            mandatory = '<i class="fas fa-check-circle"></i>';
                        } else {
                            st = '';
                            color = 'class="text-danger"';
                            mandatory = 'Wajib diisi';
                        }
                        html += '<div class="col-12 col-md-4 required">' +
                            '<label for="nik" class="control-label font-weight-bolder">' + val.label + ' <span style="margin-top:6px;font-size:12px;" ' + color + '><small>' + mandatory + '</small></span></label>' +
                            '<input type="text" class="form-control" ' + st + ' name="fields[' + val.id + ']" id="' + val.id + '" value="' + val.nilai + '" required>' +
                            '<div class="valid-nik mt-1" style="font-size:80%;"></div>' +
                            '</div>';
                        namaField[n] = val.id;
                        n = n + 1;

                    });

                    $('#tampil').html(html);


                    if (data.message.syarat_dinamis != null) {
                        $('#syarat_tambahan').show();
                        let dataUpload = [];
                        let tabel = '';
                        $('#tblSyaratPeserta > tbody').html(tabel);
                        let no = 1;
                        $.each(data.message.syarat_dinamis, function(key, val) {

                            if (Object.keys(data.message.syarat_dinamis).length > 0) {
                                dataUpload[no - 1] = "upload_bukti_" + val.id;
                                tabel += '<tr>';
                                tabel += '<td class="text-center">' + no + '.</td>';
                                tabel += '<td>' + val.nm_syarat_dinamis + '</td>';
                                tabel += '<td>';
                                // tabel += '<div class="input-group">';
                                // tabel += '<div class="custom-file">';
                                tabel += '<input type="file" class="uploadSyarat" data-id="' + val.id + '" id="upload_bukti_' + val.id + '" name="upload_bukti[' + val.id + ']">';
                                // tabel += '<label class="custom-file-label" for="upload_bukti">Choose file</label>';
                                // tabel += '</div>';
                                // tabel += '</div>';
                                tabel += '</td>';
                                tabel += '<td class="text-center" >' + val.status + '</td>';
                                tabel += '</tr>';
                                no = no + 1;

                            } else {
                                tabel = '<tr><td colspan="2"><i>Tidak Ada Data</i></td></tr>';
                            }

                        });
                        $('#tblSyaratPeserta > tbody').append(tabel);
                    } else {
                        $('#syarat_tambahan').hide();
                    }

                }
                $('#frmViewShow').waitMe('hide');
            }
        });
    }

    //close form entri
    $(document).on('click', '.btnCloseView', function(e) {
        formResetShow();
        $('.btnShow').removeClass('disabled');
        $('#modalViewPelatihan').modal('toggle');
        getDataListPelatihan();
    });

    $(document).on('submit', '#formDaftarPeserta', function(e) {
        e.preventDefault();
        // let tambah = "";
        // let idSyarat = [];
        // $.each(dataUpload, function(key, val){
        //     idSyarat[key] = val.replace('upload_bukti_','');
        //     tambah += "&"+val+"="+$("#"+val).val();

        // });
        let postData = $(this).serialize();
        var data = new FormData($('#formDaftarPeserta')[0]);


        $(".btnDaftar").html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $(".btnDaftar").addClass('disabled');
        run_waitMe($('#formDaftarPeserta'));
        console.log(data);
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin mendaftar pada pelatihan ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/daftar',
                    type: "POST",
                    enctype: 'multipart/form-data',
                    data: data,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Daftar',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errDaftar').html(msg.error(data.message));
                            }
                        })
                    } else {
                        swalAlert.fire({
                            title: 'Berhasil Daftar',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errDaftar').html(msg.success(data.message));
                                $('#frmViewShow').waitMe('hide');
                                $('#modalViewPelatihan').modal('toggle');
                                getDataListPelatihan();
                            }
                        })
                    }
                    $('#formDaftarPeserta').waitMe('hide');
                }).fail(function() {
                    $('#errDaftar').html(msg.error('Harap periksa kembali data'));
                    $('#formDaftarPeserta').waitMe('hide');
                }).always(function() {
                    $('.btnDaftar').html('<i class="fas fa-check-circle"> Daftar</i>');
                    $('.btnDaftar').removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Daftar',
                    text: 'Proses daftar telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#formDaftarPeserta').waitMe('hide');
                        $('.btnDaftar').html('<i class="fas fa-check-circle"> Daftar</i>');
                        $('.btnDaftar').removeClass('disabled');
                    }
                })
            }
        })
    });


    $(document).on('click', '.btnDelete', function(e) {
        e.preventDefault();
        let postData = {
            'tokenId': $(this).data('id'),
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        $(this).html('<i class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></i>');
        $(this).addClass('disabled');
        run_waitMe($('#formParent'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin menghapus data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/delete',
                    type: "POST",
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Hapus',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSuccess').html(msg.error(data.message));
                            }
                        })
                    } else {
                        swalAlert.fire({
                            title: 'Berhasil Hapus',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSuccess').html(msg.success(data.message));
                                getDataListPelatihan();
                            }
                        })
                    }
                    $('#formParent').waitMe('hide');
                }).fail(function() {
                    $('#errSuccess').html(msg.error('Harap periksa kembali data yang akan dihapus'));
                    $('#formParent').waitMe('hide');
                }).always(function() {
                    $('.btnDelete').html('<i class="fas fa-trash-alt"></i>');
                    $('.btnDelete').removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Hapus',
                    text: 'Proses hapus data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#formParent').waitMe('hide');
                        $('.btnDelete').html('<i class="fas fa-trash-alt"></i>');
                        $('.btnDelete').removeClass('disabled');
                    }
                })
            }
        })
    });

    //panggil form daftar list peserta pelatihan
    $(document).on('click', '.btnListPeserta', function(e) {
        formReset();
        $('#modalListPesertaPelatihan').modal({
            backdrop: 'static'
        });
        let token = $(this).data('id');
        let label = $(this).data('jd');
        $('input[name="tokenPelatihan"]').val(token);
        $('.lblMod').text(label);
        getDataListPendaftar(token);
    });

    //close form entri
    $(document).on('click', '.btnCloseListPeserta', function(e) {
        formReset();
        $('#modalListPesertaPelatihan').modal('toggle');
        $('#eventList').hide();
        $('#btnTolakPeserta').attr('disabled', '');
        $('#btnTerimaPeserta').attr('disabled', '');
        $('#btnSelesaiPelatihan').attr('disabled', '');
        $('#checkAll').prop('checked', '');
    });

    function getDataListPendaftar(token) {
        let html = '';
        $.ajax({
            type: 'GET',
            url: site + '/list-pendaftar',
            data: {
                'tokenPelatihan': token,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status = 'RC200') {
                    if (Object.keys(data.message).length > 0) {
                        $.each(data.message, function(key, val) {
                            // html += ' <tr class="table-info"><td colspan="4"><strong>Nama Kontrol : '+key+'</strong></td></tr>';
                            let no = 1;
                            $.each(val, function(row, v) {
                                html += '<tr>';
                                html += '<td class="text-center">' +
                                    '<div class="custom-control custom-checkbox ml-2">' +
                                    '<input type="checkbox" class="custom-control-input" name="checkid[]" id="checkid_' + key.toLowerCase().replace(' ', '_') + '_' + no + '" class="checkid" value="' + v['id_history_pelatihan'] + '">' +
                                    '<label class="custom-control-label" for="checkid_' + key.toLowerCase().replace(' ', '_') + '_' + no + '"></label>' +
                                    '</div>' +
                                    '</td>';
                                html += '<td class="text-center">' + no + '.</td>';
                                html += '<td>' + v['nik'] + '</td>';
                                html += '<td class="text-left">' + v['nama_lengkap'] + '</td>';
                                html += '<td class="text-left">' + v['province'] + '</td>';
                                html += '<td class="text-left">' + v['regency'] + '</td>';
                                html += '<td class="text-center">' + v['flag'] + '</td>';
                                html += '<td width="7%" class="text-center"> <button class="btn btn-primary btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnLihatPeserta" data-peserta="' + v['id_peserta'] + '" data-pelatihan="' + v['token'] + '"> Detail </button> </td>';
                                html += '</tr>';
                                no++;
                            });
                        });
                    } else
                        html = '<tr><td colspan="8"><i>Tidak Ada Data Pendaftar</i></td></tr>';
                } else
                    html = '<tr><td colspan="8"><i>Tidak Ada Data Pendaftar</i></td></tr>';
                $('#tblListPendaftar > tbody').html(html);
            }
        });
    }

    //panggil form detail list peserta pendaftar pelatihan
    $(document).on('click', '.btnLihatPeserta', function(e) {
        formReset();
        $('#modalProfilePesertaPelatihan').modal({
            backdrop: 'static'
        });
        let token_peserta = $(this).data('peserta');
        let token_pelatihan = $(this).data('pelatihan');
        $('input[name="tokenPeserta"]').val(token_peserta);
        getDataDetailPeserta(token_peserta, token_pelatihan);
    });

    function getDataDetailPeserta(token_peserta, token_pelatihan) {
        $.ajax({
            type: 'POST',
            url: site + '/review',
            data: {
                'tokenPeserta': token_peserta,
                'tokenPelatihan': token_pelatihan,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {

                    $('#nikpeserta').html(data.message.nik);
                    $('#namaPeserta').html(data.message.nama_lengkap);
                    $('#tempatLhr').html(data.message.tempat_lhr + ' / ' + data.message.tanggal_lhr);
                    $('#alamatPeserta').html(data.message.alamat_peserta);
                    $('#genderPeserta').html(data.message.id_gender);
                    $('#studyPeserta').html(data.message.id_study);
                    $('#agamaPeserta').html(data.message.id_agama);
                    $('#pekerjaanPeserta').html(data.message.pekerjaan);
                    $('#imagesPeserta').attr('src', '<?php echo base_url(); ?>assets/img/avatar/' + data.message.upload_foto);
                    $('#kode_pos').html(data.message.kode_pos);

                    if (data.message.pekerjaan != 2) {
                        $('#field_usaha').show();
                        $('#nmPemilik').html(data.message.nama_pemilik);
                        $('#nmUsaha').html(data.message.nama_usaha);
                        $('#alamatUsaha').html(data.message.alamat_usaha);
                        $('#telpUsaha').html(data.message.telp);
                        $('#waUsaha').html(data.message.wa);
                        $('#bidangUsaha').html(data.message.id_bidang_usaha);
                        $('#jenisUsaha').html(data.message.jenis_usaha);
                    } else {
                        $('#field_usaha').hide();
                    }

                    if (data.message.syarat_dinamis != 0) {
                        $('#tblViewSyarat').show();

                        let tabel = '';
                        $('#tblViewSyarat > tbody').html(tabel);
                        let no = 1;
                        $.each(data.message.syarat_dinamis, function(key, val) {
                            if (Object.keys(data.message.syarat_dinamis).length > 0) {
                                tabel += '<tr>';
                                tabel += '<td class="text-center">' + no + '.</td>';
                                tabel += '<td>' + val.nm_syarat_dinamis + '</td>';
                                tabel += '<td class="text-center" >' + val.status + '</td>';
                                tabel += '<td width="7%" class="text-center"> <button class="btn btn-primary btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnLihatBerkas" data-berkas="<?php echo base_url(); ?>repository/pelatihan/' + val.id_pelatihan + '/' + val.year + '/' + val.date + '/' + val.id_peserta + '/' + val.nama_file + '" data-id="' + val.id_berkas + '"> Lihat File </button> </td>';
                                tabel += '</tr>';
                                no = no + 1;
                            } else {
                                tabel = '<tr><td colspan="2"><i>Tidak Ada Data</i></td></tr>';
                            }
                        });
                        $('#tblViewSyarat > tbody').append(tabel);

                    } else {
                        $('#tblViewSyarat').hide();
                    }
                }
            }
        });
    }

    //panggil form detail list peserta pendaftar pelatihan
    $(document).on('click', '.btnLihatBerkas', function(e) {
        formReset();
        $('#modalLihatBerkas').modal({
            backdrop: 'static'
        });
        let idBerkas = $(this).data('berkas');
        // alert(idBerkas);
        // $('#frameShow').attr('src', $(this).data('berkas') + '?v=<?php //echo date('YmdHis'); 
                                                                    ?>');
        // $('#frameShow').attr('src',$idBerkas);

        let parent = $('#modalLihatBerkas').find('iframe').parent();
        let srcpdf = $('#modalLihatBerkas').find('iframe');
        let newElement = '<iframe src="' + idBerkas + '" width="100%" height="500px">';
        $(srcpdf).remove();
        parent.append(newElement);
    });

    $(document).on('click', '.btnCloseFile', function(e) {
        $('#frameShow').trigger('reset');
        $('#modalFile').modal('toggle');

    });

    //close form entri
    $(document).on('click', '.btnCloseDetailPeserta', function(e) {
        $('#modalProfilePesertaPelatihan').modal('toggle');
        $('#imagesPeserta').attr('src', '');
    });

    // Handle click on "check all" control
    $(document).on('click', '#checkAll', function() {
        $('#tblListPendaftar > tbody input[type="checkbox"]').prop('checked', this.checked).trigger('change');
    });
    // Handle click on "checked" control
    $(document).on('change', '#tblListPendaftar > tbody input[type="checkbox"]', function(e) {
        let rowCount = $('#tblListPendaftar > tbody input[type="checkbox"]').length;
        let n = $('#tblListPendaftar > tbody input[type="checkbox"]').filter(':checked').length;
        if (n > 0) {
            $('#eventList').show();
            $('#btnTolakPeserta').removeAttr('disabled');
            $('#btnTerimaPeserta').removeAttr('disabled');
            $('#btnSelesaiPelatihan').removeAttr('disabled');
        } else {
            $('#eventList').hide();
            $('#btnTolakPeserta').attr('disabled', '');
            $('#btnTerimaPeserta').attr('disabled', '');
            $('#btnSelesaiPelatihan').attr('disabled', '');
        }
        $(this).is(':checked') ? $(this).closest('tr').addClass('table-active') : $(this).closest('tr').removeClass('table-active');
        if (rowCount !== n)
            $('#checkAll').prop('checked', '');
        else
            $('#checkAll').prop('checked', 'checked');
    });
    // Handle click on "tr" control
    $(document).on('click', '#tblListPendaftar > tbody > tr', function() {
        let n = $(this).find('input[type="checkbox"]');
        n.prop('checked', (n.is(':checked')) ? false : true).trigger('change');
    });
    //btn tolak peserta pada pelatihan
    $(document).on('click', '#btnTolakPeserta', function(e) {
        e.preventDefault();
        let token = $('input[name="tokenPelatihan"]').val();
        let peserta = [];
        $.each($('#tblListPendaftar > tbody input[type="checkbox"]:checked'), function() {
            peserta.push($(this).val());
        });
        const postData = {
            'tokenId': token,
            'pesertaId': peserta,
            'flag': '<?= $this->encryption->encrypt('TL'); ?>',
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        // get form action url
        $(this).html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $(this).addClass('disabled');
        run_waitMe($('#frmListPeserta'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin menolak permintaan ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/list-pendaftar/set-flag',
                    type: 'POST',
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Hapus',
                            text: 'Proses tolak data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.error(data.message));
                                $('#frmListPeserta').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmListPeserta').waitMe('hide');
                        swalAlert.fire({
                            title: 'Berhasil Hapus',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.success(data.message));
                                getDataListPendaftar(data.kode);
                            }
                        })
                    }
                }).fail(function() {
                    $('#errList').html(msg.error('Harap periksa kembali data yang dihapus'));
                    $('#frmListPeserta').waitMe('hide');
                }).always(function() {
                    $("#btnTolakPeserta").html('<i class="fas fa-trash-alt"></i> Tolak');
                    $("#btnTolakPeserta").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Hapus',
                    text: 'Proses tolak data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmListPeserta').waitMe('hide');
                        $("#btnTolakPeserta").html('<i class="fas fa-trash-alt"></i> Tolak');
                        $("#btnTolakPeserta").removeClass('disabled');
                    }
                })
            }
        })
    });
    //btn update status aktif
    $(document).on('click', '#btnTerimaPeserta', function(e) {
        e.preventDefault();
        let token = $('input[name="tokenPelatihan"]').val();
        let peserta = [];
        $.each($('#tblListPendaftar > tbody input[type="checkbox"]:checked'), function() {
            peserta.push($(this).val());
        });
        const postData = {
            'tokenId': token,
            'pesertaId': peserta,
            'flag': '<?= $this->encryption->encrypt('TR'); ?>',
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        // get form action url
        $(this).html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $(this).addClass('disabled');
        run_waitMe($('#frmListPeserta'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin menerima permintaan ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/list-pendaftar/set-flag',
                    type: 'POST',
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Update',
                            text: 'Proses update status data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.error(data.message));
                                $('#frmListPeserta').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmListPeserta').waitMe('hide');
                        swalAlert.fire({
                            title: 'Berhasil Update',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.success(data.message));
                                getDataListPendaftar(data.kode);
                            }
                        })
                    }
                }).fail(function() {
                    $('#errList').html(msg.error('Harap periksa kembali data yang diupdate'));
                    $('#frmListPeserta').waitMe('hide');
                }).always(function() {
                    $("#btnTerimaPeserta").html('<i class="fas fa-check"></i> Terima');
                    $("#btnTerimaPeserta").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Update',
                    text: 'Proses update status data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmListPeserta').waitMe('hide');
                        $("#btnTerimaPeserta").html('<i class="fas fa-check"></i> Terima');
                        $("#btnTerimaPeserta").removeClass('disabled');
                    }
                })
            }
        })
    });
    //btn update status non aktif
    $(document).on('click', '#btnSelesaiPelatihan', function(e) {
        e.preventDefault();
        let token = $('input[name="tokenPelatihan"]').val();
        let peserta = [];
        $.each($('#tblListPendaftar > tbody input[type="checkbox"]:checked'), function() {
            peserta.push($(this).val());
        });
        const postData = {
            'tokenId': token,
            'pesertaId': peserta,
            'flag': '<?= $this->encryption->encrypt('SL'); ?>',
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        // get form action url
        $(this).html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $(this).addClass('disabled');
        run_waitMe($('#frmListPeserta'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin merubah status menjadi selesai ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/list-pendaftar/set-flag',
                    type: 'POST',
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Update',
                            text: 'Proses update status data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.error(data.message));
                                $('#frmListPeserta').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmListPeserta').waitMe('hide');
                        swalAlert.fire({
                            title: 'Berhasil Update',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.success(data.message));
                                getDataListPendaftar(data.kode);
                            }
                        })
                    }
                }).fail(function() {
                    $('#errList').html(msg.error('Harap periksa kembali data yang diupdate'));
                    $('#frmListPeserta').waitMe('hide');
                }).always(function() {
                    $("#btnSelesaiPelatihan").html('<i class="fas fa-times"></i> Selesai');
                    $("#btnSelesaiPelatihan").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Update',
                    text: 'Proses update status data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmListPeserta').waitMe('hide');
                        $("#btnSelesaiPelatihan").html('<i class="fas fa-times"></i> Selesai');
                        $("#btnSelesaiPelatihan").removeClass('disabled');
                    }
                })
            }
        })
    });

    // Tombol Tambah Syarat
    //panggil form tambahan syarat pelatihan
    $(document).on('click', '#btnTambahSyarat', function(e) {
        formResetSyaratTambahan();
        $('#modalListSyaratTambahan').modal({
            backdrop: 'static'
        });
        getDataListSyaratTambahan();
    });

    function getDataListSyaratTambahan() {
        let html = '';
        $.ajax({
            type: 'GET',
            url: site + '/list-syarat',
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status = 'RC200') {
                    if (Object.keys(data.message).length > 0) {
                        let no = 1;
                        $('#syarat_dinamis_id').html('');
                        let opt = '';
                        $.each(data.message, function(key, val) {
                            html += '<tr>';
                            html += '<td class="text-center">' + no + '.</td>';
                            html += '<td>' + val['nm_syarat_dinamis'] + '</td>';
                            html += '</tr>';
                            no++;

                            opt += '<option value="' + val['id_syarat_dinamis'] + '">' + val['nm_syarat_dinamis'] + '</option>';
                        });

                        $('#syarat_dinamis_id').html(opt);
                        $('#syarat_dinamis_id').select2().val('').trigger('change');

                    } else
                        html = '<tr><td colspan="2"><i>Tidak Ada Data</i></td></tr>';
                } else
                    html = '<tr><td colspan="2"><i>Tidak Ada Data</i></td></tr>';
                $('#tblSyaratTambahan > tbody').html(html);
            }
        });
    }

    $(document).on('click', '.btnCloseSyaratTambahan', function(e) {
        formResetSyaratTambahan();
        $('#modalListSyaratTambahan').modal('toggle');
    });

    function formResetSyaratTambahan() {
        $('#formSyaratTambahan').attr('action', site + '/add-syarat');
        $('#errEntry').html('');
        $('form#formSyaratTambahan').trigger('reset');
        $('form#formSyaratTambahan').removeClass('was-validated');
        $(".syarat").hide();
        $(".pesan").hide();
        // $('select[name="syarat_id[]"]').select2().val(["1"]).trigger("change");
    }

    $(document).on('submit', '#formSyaratTambahan', function(e) {
        e.preventDefault();
        let postData = $(this).serialize();
        // get form action url
        let formActionURL = $(this).attr("action");
        $("#saveSyarat").html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $("#saveSyarat").addClass('disabled');
        run_waitMe($('#frmSyarat'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin menyimpan data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: formActionURL,
                    type: "POST",
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        $('#formSyaratTambahan').addClass('was-validated');
                        swalAlert.fire({
                            title: 'Gagal Simpan',
                            text: 'Proses simpan data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errEntry').html(msg.error('Silahkan dilengkapi data pada form inputan dibawah'));
                                $.each(data.message, function(key, value) {
                                    if (key != 'isi')
                                        $('input[name="' + key + '"], select[name="' + key + '"]').closest('div.required').find('div.invalid-feedback').text(value);
                                    else {
                                        $('#pesanErr').html(value);
                                    }
                                });
                                $('#frmSyarat').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmSyarat').waitMe('hide');
                        // $('#modalEntryForm').modal('toggle');
                        swalAlert.fire({
                            title: 'Berhasil Simpan',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSyaratT').html(msg.success(data.message));
                                getDataListSyaratTambahan();
                            }
                        })
                    }
                }).fail(function() {
                    $('#errEntry').html(msg.error('Harap periksa kembali data yang diinputkan'));
                    $('#frmSyarat').waitMe('hide');
                }).always(function() {
                    $("#saveSyarat").html('<i class="fas fa-check"></i> SUBMIT');
                    $("#saveSyarat").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Simpan',
                    text: 'Proses simpan data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmSyarat').waitMe('hide');
                        $("#saveSyarat").html('<i class="fas fa-check"></i> SUBMIT');
                        $("#saveSyarat").removeClass('disabled');
                    }
                })
            }
        })
    });


    $(document).on('keypress keyup', '.nominal', function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });


    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    $('input[name="daterange"]').on("change", function() {

        console.log($(this).val());
    })

    $(document).on('click', '.btnImport', function() {
        resetFormImport();
        $('input[name="id_pelatihan"]').val($(this).data('id'));
        $('input[name="id_opd"]').val($(this).data('opd'));
        $('input[name="regis"]').val($(this).data('regis'));
        $('#pelatihan_name_to_import').text($(this).data('title'));
        $('#pelatihan_schedule_to_import').text($(this).data('schedule'));
        $('#pelatihan_name_to_import_result').text($(this).data('title'));
        $('#pelatihan_schedule_to_import_result').text($(this).data('schedule'));
        $('#modalImport').modal('toggle');
        // $('#modalImportResult').modal('toggle');
    });

    $(document).on('click', '.btnCloseImport', function() {
        $('#modalImport').modal('toggle');

    });

    function resetFormImport() {
        $('#errEntry').html('');
        $('form#formEntryImport').trigger('reset');
    }

    $(document).on('click', '#importNow', function(e) {
        e.preventDefault();
        var form = $('#formEntryImport')[0];
        $(this).html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $(this).addClass('disabled');
        run_waitMe($('#frmListPeserta'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ini mengimport data peserta pada pelatihan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/import-excel',
                    mimeType: "multipart/form-data",
                    type: "POST",
                    data: new FormData(form),
                    dataType: "json",
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Import',
                            text: 'Proses import data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.error(data.message));
                                $('#frmListPeserta').waitMe('hide');
                                $('#modalImport').modal('toggle');
                            }
                        })
                    } else {
                        $('#frmListPeserta').waitMe('hide');
                        swalAlert.fire({
                            title: 'Berhasil Import',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errList').html(msg.success(data.message));
                                renderResult(data.data)
                                $('#modalImport').modal('toggle');
                            }
                        })
                    }
                }).fail(function() {
                    $('#errList').html(msg.error('Harap periksa kembali data yang diupdate'));
                    $('#frmListPeserta').waitMe('hide');
                }).always(function() {
                    $("#importNow").html('<i class="fas fa-check"></i> Submit');
                    $("#importNow").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Import',
                    text: 'Proses import data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmListPeserta').waitMe('hide');
                        $("#importNow").html('<i class="fas fa-check"></i> Submit');
                        $("#importNow").removeClass('disabled');
                    }
                })
            }
        })
    });

    function renderResult(data) {
        $('#importResultTable').html('');
        let html = '';
        for (a = 0; a < data.length; a++) {
            let status = '';
            if (data[a].status == 'success') {
                status = '<span class="badge badge-success">Berhasil Import</span>';
            } else if (data[a].status == 'existed') {
                status = '<span class="badge badge-warning">Gagal, Sudah Terdaftar Sebelumnya</span>';
            } else if (data[a].status == 'invalid') {
                status = '<span class="badge badge-danger">Gagal, NIK Tidak Valid</span>';
            } else {
                status = '<span class="badge badge-danger">Gagal</span>';
            }
            html += '<tr>';
            html += '<td>' + (a + 1) + '</td>';
            html += '<td>' + data[a].nik + '</td>';
            html += '<td>' + data[a].nama_lengkap + '</td>';
            html += '<td>' + status + '</td>';
            html += '</tr>';
        }
        $('#importResultTable').html(html);
        $('#modalImportResult').modal('toggle');
    }
</script>