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
        $('#tblList2').dataTable({
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
                    "className": 'text-left'
                },
            ],
        });
        $('#tblList2_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#tblList2_length select').addClass('form-control');
    }

    $(document).on('click', '#cetak', function(e) {
        let tahun = $('#formFilter').find('select[name="filter_tahun"]').val();
        let opdID = $('#formFilter').find('select[name="opd_search"]').val();
        let opsi = $('#formFilter').find('select[name="filter_opsi"]').val();

        url = site + '/download?tahun=' + tahun + '&opdID=' + opdID + '&opsi=' + opsi;
        // window.location.href = url;
        window.open(url, '_blank');

    });
</script>