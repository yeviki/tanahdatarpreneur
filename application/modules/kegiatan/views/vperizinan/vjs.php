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

    $(document).on('keypress keyup', '.nominal', function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(document).ready(function(e) {
        tblList();
    });

    function tblList() {
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
                    "className": 'text-left'
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
        $('#id_jenis_kegiatan').select2().val('').trigger("change");
        $('#formEntry').attr('action', site + '/create');
        $('#errEntry').html('');
        $('form#formEntry').trigger('reset');
        $('form#formEntry').removeClass('was-validated');
        regeID = '';
    }
    $(document).on('submit', '#formEntry', function(e) {
        e.preventDefault();
        let postData = $(this).serialize();
        // get form action url
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
                    type: "POST",
                    data: postData,
                    dataType: "json",
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
                                tblList();
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
    $(document).on('click', '.btnEdit', function(e) {
        formReset();
        $('#formEntry').attr('action', site + '/update');
        var token = $(this).data('id');
        $('#modalEntryForm').modal({
            backdrop: 'static'
        });
        getDataKontrol(token);
    });

    function getDataKontrol(token) {
        run_waitMe($('#frmEntry'));
        $.ajax({
            type: 'POST',
            url: site + '/details',
            data: {
                'token': token,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 'RC200') {
                    $('input[name="tokenId"]').val(token);
                    $('#nik').val(data.message.nik);
                    $('#no_nib').val(data.message.no_nib);
                    $('#nama').val(data.message.nama);
                    $('#alamat').val(data.message.alamat);
                    $('#no_hp').val(data.message.no_hp);
                    $('#npwp').val(data.message.npwp);
                    $('#email').val(data.message.email);
                    $('#id_jenis_kegiatan').select2().val(data.message.id_jenis_kegiatan).trigger("change");
                    $('#id_pelatihan').select2().val(data.message.id_pelatihan).trigger("change");
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
                                tblList();
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

    $(document).on('click', '#btnImport', function(e) {
        resetFormImport();
        $('#modalImport').modal({
            backdrop: 'static'
        });
    });

    $(document).on('click', '.btnCloseImport', function(e) {
        resetFormImport();
        $('#modalImport').modal('toggle');
    });

    $(document).on('click', '.btnCloseDetail', function(e) {
        location.reload();
        $('#modalImportResult').modal('toggle');
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
        run_waitMe($('#frmEntry1'));
        swalAlert.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda ingin mengimport data perizinan ini, data yang sudah di import tidak dapat ditarik kembali, harap pastikan data sudah sesuai?',
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
                                $('#frmEntry1').waitMe('hide');
                                $('#modalImport').modal('toggle');
                            }
                        })
                    } else {
                        $('#frmEntry1').waitMe('hide');
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
                    $('#frmEntry1').waitMe('hide');
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
                        $('#frmEntry1').waitMe('hide');
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