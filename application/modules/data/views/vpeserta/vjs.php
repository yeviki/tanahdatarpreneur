<script type="text/javascript">
    //  custom js //
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    let site = '<?php echo site_url(isset($siteUri) ? $siteUri : ''); ?>';
    let msg = new alertMessage();
    let regeID = '';

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

    $('input#nik').attr('maxLength', '16').keypress(limitMe);

    function limitMe(e) {
        if (e.keyCode == 8) {
            return true;
        }
        return this.value.length < $(this).attr("maxLength");
    }

    $(document).on('click', '#btnImport', function(e) {
        formReset();
        $('#modalEntryForm1').modal({
            backdrop: 'static'
        });
    });

    $(document).on('change', 'select[name="id_jenis_akun"]', function(e) {
        let id = $(this).val();
        if (id != 2) {
            $('#field_rintis').hide();
        } else {
            $('#field_rintis').show();
        }
    });

    $(document).ready(function(e) {
        getDataListUser();
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
        getDataListUser();
    });
    $('#formFilter').submit(function(e) {
        e.preventDefault();
        getDataListUser();
    });

    function getDataListUser() {
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
            }, ],
        });
        $('#tblList_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#tblList_length select').addClass('form-control');
    }
    // Handle click on "check all" control
    $(document).on('click', '#checkAll', function() {
        $('#tblList > tbody input[type=checkbox]').prop('checked', this.checked).trigger('change');
    });
    // Handle click on "checked" control
    $(document).on('change', '#tblList > tbody input[type=checkbox]', function(e) {
        const rowCount = $('#tblList > tbody input[type=checkbox]').length;
        const n = $('#tblList > tbody input[type=checkbox]').filter(':checked').length;
        if (n > 0) {
            $('#btnDelete').show();
            $('#btnsendMail').show();
        } else {
            $('#btnDelete').hide();
            $('#btnsendMail').hide();
        }

        if (rowCount == n)
            $('#checkAll').prop('checked', 'checked');
        else
            $('#checkAll').prop('checked', '');
    });
    $(document).on('click', '#tblList > tbody > tr', function() {
        let n = $(this).find('input[type=checkbox]');
        n.prop('checked', (n.is(':checked')) ? false : true).trigger('change');
    });
    //panggil form Entri
    $(document).on('click', '#btnAdd', function(e) {
        formReset();
        $('#modalEntryForm').modal({
            backdrop: 'static'
        });
    });
    //close form entri
    $(document).on('click', '.btnClose', function(e) {
        //get modal id
        let id = $(this).closest('div.modal').attr('id');
        formReset();
        $('#' + id).modal('toggle');
    });

    function formReset() {
        $('#status').select2().val('1').trigger("change");
        $('#blokir').select2().val('0').trigger("change");
        $('#status').select2().val('1').trigger("change");
        $('form#formEntry .select-all').select2().val('').trigger("change");
        $('#formEntry').attr('action', site + '/create');
        $('#errEntry').html('');
        $('#errSuccess').html('');
        $('form#formEntry').trigger('reset');
        $('form#formEntry').removeClass('was-validated');
        $('.lblPass').text('*');
        $('.progress-title').text('');
        $('.contextual-progress').hide();
        regeID = '';
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
                                getDataListUser();
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

    // Button import data
    $(document).on('submit', '#formEntry1', function(e) {

        e.preventDefault();
        let postData = $(this).serialize();
        // get form action url
        var form = $('#formEntry1')[0];
        let formActionURL = $(this).attr("action");

        $("#save1").html('<i class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></i> DIPROSES...');
        $("#save1").addClass('disabled');
        run_waitMe($('#frmEntry1'));
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
                        $('#formEntry1').addClass('was-validated');
                        $('.invalid-feedback').removeClass('valid-feedback').text('');
                        swalAlert.fire({
                            title: 'Gagal Simpan',
                            text: 'Proses simpan data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errEntry1').html(msg.error('Silahkan dilengkapi data pada form inputan dibawah'));
                                $.each(data.message, function(key, val) {
                                    if (key != 'isi') {
                                        $('input[name="' + key + '"], select[name="' + key + '"]').closest('div.required').find('div.invalid-feedback').addClass('valid-feedback').text(val);
                                    } else {
                                        $('#pesanErr1').html(val);
                                    }
                                });
                                $('#frmEntry1').waitMe('hide');
                            }
                        })
                    } else {
                        $('#frmEntry1').waitMe('hide');
                        $('#modalEntryForm1').modal('toggle');
                        swalAlert.fire({
                            title: 'Berhasil Simpan',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSuccess1').html(msg.success(data.message));
                                getDataListUser();
                            }
                        })
                    }
                }).fail(function() {
                    $('#errEntry1').html(msg.error('Harap periksa kembali data yang diinputkan'));
                    $('#frmEntry1').waitMe('hide');
                }).always(function() {
                    $("#save1").html('<i class="fas fa-check"></i> SUBMIT');
                    $("#save1").removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Simpan',
                    text: 'Proses simpan data telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#frmEntry1').waitMe('hide');
                        $("#save1").html('<i class="fas fa-check"></i> SUBMIT');
                        $("#save1").removeClass('disabled');
                    }
                })
            }
        })
    });

    $(document).on('click', '.btnEdit', function(e) {
        e.stopPropagation();
        formReset();
        $('#formEntry').attr('action', site + '/update');
        let token = $(this).data('id');
        $('.lblPass').text('');
        $('#modalEntryForm').modal({
            backdrop: 'static'
        });
        getDataPeserta(token);
    });

    function getDataPeserta(token) {
        run_waitMe($('#frmEntry'));
        $.ajax({
            type: 'POST',
            url: site + '/details',
            data: {
                'tokenId': token,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {
                    $('input[name="tokenId"]').val(token);
                    $('input[name="fotoshow"]').val(data.message.upload_foto);

                    $('#username').val(data.message.username);
                    $('#blokir').select2().val(data.message.blokir).trigger("change");
                    $('#status').select2().val(data.message.status).trigger("change");

                    $('#nik').val(data.message.nik);
                    $('#nama_lengkap').val(data.message.nama_lengkap);
                    $('#tempat_lhr').val(data.message.tempat_lhr);
                    $('#tanggal_lhr').val(data.message.tanggal_lhr);
                    $('#alamat_peserta').val(data.message.alamat_peserta);
                    $('#no_hp').val(data.message.no_hp);
                    $('#id_study').select2().val(data.message.id_study).trigger("change");
                    $('#id_agama').select2().val(data.message.id_agama).trigger("change");
                    $('#id_gender').select2().val(data.message.id_gender).trigger("change");
                    $('#pekerjaan').val(data.message.pekerjaan);
                    $('#id_jenis_akun').select2().val(data.message.id_jenis_akun).trigger("change");
                    $('#id_pelatihan').select2().val(data.message.id_pelatihan).trigger("change");
                    $('#minat_usaha').val(data.message.minat_usaha);
                    $('#kode_pos').val(data.message.kode_pos);
                    $('#province').select2().val(data.message.id_province).trigger("change");
                    regeID = data.message.id_regency;
                }
                $('#frmEntry').waitMe('hide');
            }
        });
    }

    $(document).on('change', 'select[name="province"]', function(e) {
        let id = $(this).val();
        getRegency(id);
    });

    //mengambil data kab/kota
    function getRegency(provinceId) {
        regeID = (regeID != '') ? regeID : '<?php echo $this->input->post('regency', TRUE); ?>';
        let lblReg = '';
        $.ajax({
            type: 'GET',
            url: site + '/regency',
            data: {
                'province': provinceId
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                $('select[name="regency"]').html('').select2('data', null);
                if (data.status == 1) {
                    lblReg = '<option value="">Pilih Kab/Kota</option>';
                    $.each(data.message, function(key, value) {
                        lblReg += '<option value="' + value['id'] + '">' + value['text'] + '</option>';
                    });
                } else
                    lblReg = '<option value="">Pilih Kab/Kota</option>';
                $('select[name="regency"]').html(lblReg);
                $('select[name="regency"]').select2().val(regeID).trigger("change");
            }
        });
    }

    $(document).on('click', '#btnDelete', function(e) {
        e.preventDefault();
        let token = [];
        $.each($('#tblList > tbody input[type=checkbox]:checked'), function() {
            token.push($(this).val());
        });
        const postData = {
            'tokenId': token,
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        $(this).html('<i class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></i> DIPROSES...');
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
                                getDataListUser();
                                $('#btnDelete').hide();
                            }
                        })
                    }
                    $('#formParent').waitMe('hide');
                }).fail(function() {
                    $('#errSuccess').html(msg.error('Harap periksa kembali data yang akan dihapus'));
                    $('#formParent').waitMe('hide');
                }).always(function() {
                    $('#btnDelete').html('<i class="fas fa-trash-alt"></i> Delete User');
                    $('#btnDelete').removeClass('disabled');
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
                        $('#btnDelete').html('<i class="fas fa-trash-alt"></i> Delete User');
                        $('#btnDelete').removeClass('disabled');
                    }
                })
            }
        })
    });

    $(document).on('click', '#btnsendMail', function(e) {
        e.preventDefault();
        let token = [];
        $.each($('#tblList > tbody input[type=checkbox]:checked'), function() {
            token.push($(this).val());
        });
        const postData = {
            'tokenId': token,
            '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        $(this).html('<i class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></i> DIPROSES...');
        $(this).addClass('disabled');
        run_waitMe($('#formParent'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin mengirim username dan password data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, lanjutkan',
            cancelButtonText: '<i class="fas fa-times"></i> Tidak, batalkan',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: site + '/kirim-email',
                    type: "POST",
                    data: postData,
                    dataType: "json",
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC404') {
                        swalAlert.fire({
                            title: 'Gagal Kirim',
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
                            title: 'Berhasil Kirim',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errSuccess').html(msg.success(data.message));
                                getDataListUser();
                                $('#btnsendMail').hide();
                            }
                        })
                    }
                    $('#formParent').waitMe('hide');
                }).fail(function() {
                    $('#errSuccess').html(msg.error('Harap periksa kembali data yang akan dikirim'));
                    $('#formParent').waitMe('hide');
                }).always(function() {
                    $('#btnsendMail').html('<i class="fas fa-envelope"></i> Kirim Email');
                    $('#btnsendMail').removeClass('disabled');
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalAlert.fire({
                    title: 'Batal Kirim',
                    text: 'Proses telah dibatalkan',
                    icon: 'error',
                    confirmButtonText: '<i class="fas fa-check"></i> Oke',
                }).then((result) => {
                    if (result.value) {
                        $('#formParent').waitMe('hide');
                        $('#btnsendMail').html('<i class="fas fa-envelope"></i> Kirim Email');
                        $('#btnsendMail').removeClass('disabled');
                    }
                })
            }
        })
    });

    $(document).on('keyup', '#username', function() {
        const name = $(this).val();
        if (name.length > 0)
            checkUsername(name);
    });

    function checkUsername(text = '') {
        $.ajax({
            type: 'GET',
            url: site + '/searching',
            data: {
                'username': text,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.message > 0)
                    $('#username').closest('div.required').find('div.valid-username').html('<span class="text-danger">Username sudah ada!</span>');
                else
                    $('#username').closest('div.required').find('div.valid-username').html('');
            }
        });
    }
    const defaults = {
        minimumChars: 8
    };
    const progressHtml = "<div class='contextual-progress mt-1'>" +
        "<div class='clearfix'>" +
        "<div class='progress-title grey-text font-weight-bolder font-small'></div>" +
        "</div>" +
        "<div class='progress' style='height: 3px;'>" +
        "<div id='password-progress' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%;'></div>" +
        "</div>" +
        "</div>";
    $(progressHtml).insertAfter($('input[type=password]:first').closest('div.input-group'));
    $('.progress-title').text('');
    $('.contextual-progress').hide();
    $('#password').keyup(function(event) {
        $('.contextual-progress').show();
        const element = $(event.target);
        const password = element.val();
        if (password.length == 0) {
            $('.progress-title').html('');
            $('.contextual-progress').hide();
        } else {
            const score = calculatePasswordScore(password, defaults);
            $('.progress-bar').css('width', score + '%').attr('aria-valuenow', score);
            if (score == 0) {
                $('.progress-title').html('Too short')
            } else if (score < 50) {
                $('.progress-title').html('Weak password');
                $('#password-progress').removeClass();
                $('#password-progress').addClass('progress-bar bg-warning');
            } else if (score >= 50 && score <= 60) {
                $('.progress-title').html('Normal password');
                $('#password-progress').removeClass();
                $('#password-progress').addClass('progress-bar bg-primary');
            } else if (score > 60 && score <= 80) {
                $('.progress-title').html('Good password');
                $('#password-progress').removeClass();
                $('#password-progress').addClass('progress-bar bg-success');
            } else if (score > 80) {
                $('.progress-title').html('Strong password');
                $('#password-progress').removeClass();
                $('#password-progress').addClass('progress-bar bg-danger');
            }
        }
    });
    $('#conf_password').keyup(function(event) {
        $('.progress-title').html('');
        $('.contextual-progress').hide();
        let password = $('#password').val();
        let confirm = $(this).val();
        if (password !== confirm && confirm.length > 0)
            $(this).closest('div.required').parent('div').find('div.valid-password').html('<span class="text-danger">Password tidak cocok!</span>');
        else
            $(this).closest('div.required').parent('div').find('div.valid-password').html('');
    });
    $(document).on('click', '.showPass', function(e) {
        let div = $(this).closest('div.input-group');
        let id = div.find('input').attr('id');
        if ($(this).hasClass('open')) {
            div.find('#' + id).attr('type', 'password');
            $(this).removeClass('open').addClass('closed').html('<i class="fa fa-eye"></i>');
        } else {
            div.find('#' + id).attr('type', 'text');
            $(this).removeClass('closed').addClass('open').html('<i class="fa fa-eye-slash"></i>');
        }
    });

    function calculatePasswordScore(password, options) {
        let count;
        let score = 0;
        let hasNumericChars = false;
        let hasSpecialChars = false;
        let hasMixedCase = false;
        if (password.length < 1)
            return score;
        if (password.length < options.minimumChars)
            return score;
        //match numbers
        if (/\d+/.test(password)) {
            hasNumericChars = true;
            score += 20;
            count = (password.match(/\d+?/g)).length;
            if (count > 1) {
                //apply extra score if more than 1 numeric character
                score += 10;
            }
        }
        //match special characters including spaces
        if (/[\W]+/.test(password)) {
            hasSpecialChars = true;
            score += 20;
            count = (password.match(/[\W]+?/g)).length;
            if (count > 1) {
                //apply extra score if more than 1 special character
                score += 10;
            }
        }
        //mixed case
        if ((/[a-z]/.test(password)) && (/[A-Z]/.test(password))) {
            hasMixedCase = true;
            score += 20;
        }
        if (password.length >= options.minimumChars && password.length < 12) {
            score += 10;
        } else if (!hasMixedCase && password.length >= 12) {
            score += 10;
        }
        if ((password.length >= 12 && password.length <= 15) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 20;
        } else if (password.length >= 12 && password.length <= 15) {
            score += 10;
        }
        if ((password.length > 15 && password.length <= 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 30;
        } else if (password.length > 15 && password.length <= 20) {
            score += 10;
        }
        if ((password.length > 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
            score += 40;
        } else if (password.length > 20) {
            score += 20;
        }
        if (score > 100) score = 100;
        return score;
    }


    $(document).on('keypress keyup', '.nominal', function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });


    $(document).on('change', '#filter_tahun', function() {
        const baseurl = '<?= site_url('data/peserta/export-to-pdf') ?>';
        $('#btn-print').attr('href', baseurl + '/' + $(this).val());
    })
</script>