<script>
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
                    async : true,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    $('input[name="'+csrfName+'"]').val(data.csrfHash);
                    if(data.status == 'RC404') {
                        $('#formEntry').addClass('was-validated');
                        swalAlert.fire({
                            title: 'Gagal Simpan',
                            text: 'Proses simpan data gagal, silahkan diperiksa kembali',
                            icon: 'error',
                            confirmButtonText: '<i class="fas fa-check"></i> Oke',
                        }).then((result) => {
                            if (result.value) {
                                $('#errEntry').html(msg.error('Silahkan dilengkapi data pada form inputan dibawah'));
                                $.each(data.message, function(key,value){
                                    if(key != 'isi')
                                        $('input[name="'+key+'"], select[name="'+key+'"]').closest('div.required').find('div.invalid-feedback').text(value);
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
                                refresh();
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
            } else if (result.dismiss === Swal.DismissReason.cancel ) {
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

    $(document).on('change', 'select[name="id_jenis_akun"]', function(e) {
        let id   = $(this).val();
        if(id != 2) {
        $('#field_rintis').hide();
        $('#field_usaha').show();
        $('#minat_usaha').val("");
        } else {
        $('#field_rintis').show();
        $('#field_usaha').hide();
        }
    });
    
    if($("#id_jenis_akun").val() != 2){
        $('#field_rintis').hide();
        $('#field_usaha').show();
    }else{
        $('#field_rintis').show();
        $('#field_usaha').hide();
    }

    regeID = $("#regency").data("regency");
    $(document).ready(function(e) {
            getRegency($("#province").val());
    });


    $(document).on('change', '#province', function(e) {
        let id = $(this).val();
        regeID = "";
        getRegency(id);
    });
    

    //mengambil data kab/kota
    function getRegency(provinceId) {
        let lblReg = '';
        $.ajax({
        type: 'GET',
        url: site + '/regency',
        data: {'province' : provinceId},
        dataType: 'json',
        success: function(data) {
            $('input[name="'+csrfName+'"]').val(data.csrfHash);
            $('select[name="regency"]').html('').select2('data', null);
            if(data.status == 1) {
            lblReg = '<option value="">Pilih Kab/Kota</option>';
            $.each(data.message,function(key,value){
                lblReg += '<option value="'+value['id']+'">'+value['text']+'</option>';
            });
            } else
            lblReg = '<option value="">Pilih Kab/Kota</option>';
            $('select[name="regency"]').html(lblReg);
            $('select[name="regency"]').select2().val(regeID).trigger("change");
        }
        });
    }

    $(document).on('change', 'select[name="menerima_pinjaman"]', function(e) {
        let id   = $(this).val();
        if(id != 'Y') {
        $('#field_pinjaman').hide();
        $('#jumlah_pinjaman').val("");
        } else {
        $('#field_pinjaman').show();
        }
    });

    if($("#menerima_pinjaman").val() != 'Y'){
        $('#field_pinjaman').hide();
    }else{
        $('#field_pinjaman').show();
    }

    $(document).on('keyup keydown keypress change', '#nik', function() {
        const nik = $(this).val();
        if(nik.length == 16)
            checkNIP(nik);
    });
    function checkNIP(text='') {
        $.ajax({
            type: 'GET',
            url: site + '/searching',
            data: {'nik' : text, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
            dataType: 'json',
            success: function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                if(data.message > 0)
                    $('#nik').closest('div.required').find('div.valid-nik').html('<span class="text-danger">NIP sudah ada!</span>');
                else
                    $('#nik').closest('div.required').find('div.valid-nik').html('');
            }
        });
    }

    $('input#nik').attr('maxLength','16').keypress(limitMe);
    function limitMe(e) {
        if (e.keyCode == 8) { return true; }
        return this.value.length < $(this).attr("maxLength");
    }

    $(document).on('keypress keyup', '.nominal',function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
    });

    function refresh() {    
        setTimeout(function () {
            location.reload()
        }, 1000);
    }
</script>