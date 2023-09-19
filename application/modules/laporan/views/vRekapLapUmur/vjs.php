<script type="text/javascript">
    //  custom js //
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    let site = '<?php echo site_url(isset($siteUri) ? $siteUri : ''); ?>';
    let msg = new alertMessage();
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
        getDataList();
    });

    function getDataList() {
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
                    "targets": [-3], //last column
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

    $(document).on('click', '#cetak', function(e) {
        let tahun = $('#formFilter').find('select[name="filter_tahun"]').val();
        let opdID = $('#formFilter').find('select[name="opd_search"]').val();
        let opsi = $('#formFilter').find('select[name="filter_opsi"]').val();

        url = site + '/download?tahun=' + tahun + '&opdID=' + opdID + '&opsi=' + opsi;
        // window.location.href = url;
        window.open(url, '_blank');

    });
    
    $(document).on('click', '.btnLihatPeserta', function(e) {
        e.stopPropagation();
        var idopd = $(this).data('id');
        var tahun = $(this).data('tahun');

        $('#modalDetailPeserta').modal({
            backdrop: 'static'
        });
        getDataListPeserta(idopd, tahun);
        console.log(idopd);
    });

    $(document).on('click', '.btnClose', function(e) {
        $('#modalDetailPeserta').modal('toggle');
    });

    var dataRecord = [];
    function getDataListPeserta(idopd, tahun) {
        let html = '';
        $.ajax({
            type: 'GET',
            url: site + '/review',
            data: {
                'idOPD': idopd,
                'tahun': tahun,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            },
            
            dataType: 'json',
            success: function(data) {
                total_stok = 0;
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status = 'RC200') {
                    if (Object.keys(data.message).length > 0) {
                        let no = 1;
                        // console.log(data.message);
                        dataRecord = [];
                        $.each(data.message, function(row, v) {
                            dataRecord[no - 1] = [
                                no, v.nama, v.nik, v.jk, v.tanggal_lahir, v.umur, v.alamat
                            ];
                            no++;
                        });
                        console.log(dataRecord);
                    } else
                        html = '<tr><td colspan="3"><i>Tidak Ada Data</i></td></tr>';
                } else
                    html = '<tr><td colspan="3"><i>Tidak Ada Data</i></td></tr>';
                $('#tblviewpeserta > tbody').html(html);
            },
            complete: function() {
                $('#tblviewpeserta').DataTable({
                    data: dataRecord,
                    destroy: true,
                    columnDefs: [
                        {
                            "targets": [0], //first column
                            "orderable": false, //set not orderable
                            "className": 'text-center'
                        },
                        {
                            "targets": [-2], //first column
                            "orderable": false, //set not orderable
                            "className": 'text-center',
                        },
                    ]
                });
            }
        });
    }
</script>