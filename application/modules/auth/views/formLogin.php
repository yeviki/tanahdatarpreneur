<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= 'Login | ' . (isset($appName) ? $appName : ''); ?></title>
    <meta name="description" content="<?= isset($appDescs) ? $appDescs : ''; ?>">
    <meta name="author" content="<?= isset($appAuthor) ? $appAuthor : ''; ?>">
    <meta name="keywords" content="<?= isset($appKeys) ? $appKeys : ''; ?>" />
    <link rel="icon" type="image/png" href="<?php echo $this->asset->image_path((isset($appFavico) ? $appFavico : '')) ?>">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"> -->
    <?php echo $this->asset->css('fontawesome/css/all.css'); ?>
    <!-- Bootstrap core CSS -->
    <?php echo $this->asset->css('themes/bootstrap.min.css'); ?>
    <!-- Material Design Bootstrap -->
    <?php echo $this->asset->css('themes/mdb.min.css'); ?>
    <!-- Our Custom CSS -->
    <?php echo $this->asset->css('themes/sign-style.css'); ?>

    <!-- Bootstrap core CSS -->
    <?= $this->asset->css('themes/bootstrap.min.css'); ?>
    <!-- Material Design Bootstrap -->
    <?= $this->asset->css('themes/mdb.min.css'); ?>
    <!-- Our Custom CSS -->
    <?= $this->asset->css('themes/style.css'); ?>
    <!-- Datatables CSS-->
    <?= $this->asset->css('addons/datatables.min.css'); ?>
    <?= $this->asset->css('addons/datatables-select.min.css'); ?>
    <!-- NProgress CSS -->
    <?= $this->asset->css('plugins/nprogress/nprogress.css'); ?>
    <!-- Select2 CSS -->
    <?= $this->asset->css('plugins/select2/dist/css/select2.css'); ?>
    <!-- Sweet Alert -->
    <?= $this->asset->css('plugins/sweetalert2/dist/sweetalert2.min.css'); ?>
    <!-- Waitme CSS -->
    <?= $this->asset->css('plugins/waitme/waitMe.css'); ?>
</head>

<body>
    <!-- Start your project here-->
    <main class="main">
        <div class="app-container">
            <div class="app-login">
                <div class="app-screen">
                    <div class="app-screen-left text-center" style="height:100%">
                        <img class="img-fluid mx-auto" style="height:100%;" src="<?php echo base_url('assets/img/animasi.svg') ?>">
                    </div>
                    <div class="app-screen-right">
                        <div class="app-screen-form">
                            <div class="app-screen-header">
                                <?php //echo $this->asset->image((isset($appIcon) ? $appIcon: ''), '', array('style'=>'width:40%;', 'alt'=>(isset($appName) ? 'Logo '.$appName : 'Logo Aplikasi'))); 
                                ?>
                                <h1 class="text-danger font-weight-bold"><?= isset($appName) ? '' . $appName : ''; ?></h1>
                                <h5 class="mt-2 text-black font-weight-bold font-smaller">Silahkan login untuk masuk ke akun anda</h5>
                            </div>
                            <div class="app-screen-body">
                                <!-- Material form login -->
                                <?php echo form_open('auth/signin/login', array('id' => 'formLogin', 'novalidate' => '')); ?>
                                <?php echo form_hidden('authorization', $this->encryption->encrypt('login')); ?>
                                <?php echo $this->session->flashdata('message'); ?>
                                <div id="errSuccess"></div>
                                <div id="errLog"></div>
                                <!-- Email -->
                                <div class="md-form form-lg required">
                                    <label for="username">Username/Email</label>
                                    <input type="text" class="form-control" name="username" id="username" value="" required>
                                    <div class="invalid-feedback">Username harus diisi</div>
                                </div>
                                <!-- Password -->
                                <div class="md-form form-lg required">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" value="" required>
                                    <div class="invalid-feedback">Password harus diisi</div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <!-- Remember me -->
                                    <div class="col-md-6 col-6 text-left">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="rememberme" id="rememberme">
                                            <label class="custom-control-label" for="rememberme">Remember me</label>
                                        </div>
                                    </div>
                                    <!-- Forgot password -->
                                    <!-- <div class="col-md-6 col-6">
                                    <a href="javascript:;" class="d-flex justify-content-end">Forgot password ?</a>
                                </div> -->
                                </div>
                                <!-- Sign in button -->
                                <button class="btn btn-primary btn-block my-4" type="submit" name="submit" id="submit">Sign In</button>
                                <?php echo form_close(); ?>
                                <!-- Don't have Account -->
                                <p class="font-small grey-text app-contact">
                                    Belum punya akun ?
                                    <!-- <a href="javascript:;" class="text-danger">Please contact admin</a> -->
                                    <button type="button" class="btn btn-success waves-effect waves-light px-1 py-0 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Klik Disini</button>
                                </p>
                                <!-- copyright -->
                                <?php $year = isset($appYear) ? $appYear : date('Y'); ?>
                                <!-- <p class="font-small grey-text text-center"><?= (isset($appAuthor) ? $appAuthor : ''); ?></p> -->
                                <p class="font-small grey-text text-center"><?= ' &copy; ' . (($year == date('Y')) ? $year : $year . ' - ' . date('Y')) . ' Aplikasi ' . (isset($appName) ? $appName : ''); ?></p>
                                <!-- Material form login -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- /Start your project here-->

    <div class="modal fade" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry">
            <div class="modal-content">
                <div class="modal-header aqua-gradient-rgba">
                    <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Pendaftaran Peserta</h4>
                    <button type="button" class="close btnClose" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 clearfix mb-3">
                            <?php echo form_open(site_url('auth/signin/create_account'), array('id' => 'formEntry', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                            <div id="errEntry"></div>
                            <?php echo form_hidden('tokenId', ''); ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Data Pribadi <span class="lblMod"></span></h5>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="nik" class="control-label font-weight-bolder">NIK <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control nominal" name="nik" id="nik" placeholder="NIK" value="<?php echo $this->input->post('nik', TRUE); ?>" required>
                                            <div class="valid-nip mt-1" style="font-size:80%;"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="nama_lengkap" class="control-label font-weight-bolder">Nama Peserta <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Peserta" value="<?php echo $this->input->post('nama_lengkap', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="tempat_lhr" class="control-label font-weight-bolder">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="tempat_lhr" id="tempat_lhr" placeholder="Tempat Lahir Peserta" value="<?php echo $this->input->post('tempat_lhr', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="tanggal_lhr" class="control-label font-weight-bolder">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input placeholder="Select date" type="date" id="tanggal_lhr" name="tanggal_lhr" class="form-control">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-12 required">
                                            <label for="alamat_peserta" class="control-label font-weight-bolder">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control" required name="alamat_peserta" id="alamat_peserta" rows="1" placeholder="Alamat Peserta"><?php echo $this->input->post('alamat_peserta', TRUE); ?></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="province" class="control-label font-weight-bolder">Provinsi <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('province', isset($data_provinsi) ? $data_provinsi : array('' => 'Pilih Data'), $this->input->post('province', TRUE), 'class="form-control select-all" id="province" required="" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="regency" class="control-label font-weight-bolder">Kabupaten/Kota <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('regency', array('' => 'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all" id="regency" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-4 required">
                                            <label for="id_study" class="control-label font-weight-bolder">Pendidikan <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_study', isset($data_study) ? $data_study : array('' => 'Pilih Data'), $this->input->post('id_study', TRUE), 'class="form-control select-all" id="id_study" required="" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-4 required">
                                            <label for="id_agama" class="control-label font-weight-bolder">Agama <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_agama', isset($data_agama) ? $data_agama : array('' => 'Pilih Data'), $this->input->post('id_agama', TRUE), 'class="form-control select-all" id="id_agama" required="" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-4 required">
                                            <label for="id_gender" class="control-label font-weight-bolder">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_gender', isset($data_gender) ? $data_gender : array('' => 'Pilih Data'), $this->input->post('id_gender', TRUE), 'class="form-control select-all" id="id_gender" required="" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="kode_pos" class="control-label font-weight-bolder">Kode Pos<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode Pos" value="<?php echo $this->input->post('kode_pos', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="upload_foto" class="control-label font-weight-bolder">Foto<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">File</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="upload_foto" name="upload_foto" aria-describedby="inputGroupFileAddon01" value="<?php echo $this->input->post('upload_foto', TRUE); ?>">
                                                    <label class="custom-file-label" for="foto">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="pekerjaan" class="control-label font-weight-bolder">Pekerjaan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" value="<?php echo $this->input->post('pekerjaan', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="no_hp" class="control-label font-weight-bolder">Nomor HP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control nominal" name="no_hp" id="no_hp" placeholder="Nomor HP" value="<?php echo $this->input->post('no_hp', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-12 required">
                                            <label for="id_jenis_akun" class="control-label font-weight-bolder">Apa anda sudah memiliki usaha? <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_jenis_akun', isset($data_usaha) ? $data_usaha : array('' => 'Pilih Jawaban'), $this->input->post('id_jenis_akun', TRUE), 'class="form-control select-all" id="id_jenis_akun" required="" style="width:100%"'); ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-12 required" style="display:none;" id="field_rintis">
                                            <label for="minat_usaha" class="control-label font-weight-bolder">Minat usaha yang akan dirintis? <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="minat_usaha" id="minat_usaha" placeholder="Minat Usaha" value="<?php echo $this->input->post('minat_usaha', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Data Akun <span class="lblMod"></span></h5>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-12 required">
                                            <label for="username_signup" class="control-label font-weight-bolder">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="username_signup" id="username_signup" placeholder="Email" value="<?php echo $this->input->post('username_signup', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                            <div class="valid-email mt-1" style="font-size:80%;"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="password_signup" class="control-label font-weight-bolder">Password <span class="grey-text" style="font-size: 80%;">(min 8 karakter)</span><span class="lblPass text-danger">*</span></label>
                                            <div class="input-group required">
                                                <input type="password" class="form-control pass-signup" name="password_signup" id="password_signup" placeholder="Password" value="<?php echo $this->input->post('password_signup', TRUE); ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="conf_password" class="control-label font-weight-bolder">Konfirmasi Password <span class="lblPass text-danger">*</span></label>
                                            <div class="input-group required">
                                                <input type="password" class="form-control pass-signup" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="<?php echo $this->input->post('conf_password', TRUE); ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="valid-password mt-1" style="font-size:80%;"></div>
                                        </div>
                                    </div>
                                    <small>
                                        <span><b> NB :</b>
                                            Format <span class="text-danger"><b>Password</b></span> minimal 8 karakter, mengandung satu huruf besar, satu huruf kecil, dan setidaknya satu angka dan satu karakter simbol. Contoh : Vxzy@9876
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnClose"><i class="fas fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="save" id="save"><i class="fas fa-check"></i> Submit</button>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- SCRIPTS -->
    <!-- jQuery CDN - min version -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
    <!-- CDNJS Offline -->
    <?= $this->asset->js('cdnjs/jquery-3.5.1.js'); ?>
    
    <!-- Bootstrap tooltips -->
    <?php echo $this->asset->js('themes/popper.min.js'); ?>
    <!-- Bootstrap core JavaScript -->
    <?php echo $this->asset->js('themes/bootstrap.min.js'); ?>
    <!-- MDB core JavaScript -->
    <?php echo $this->asset->js('themes/mdb.min.js'); ?>
    <!-- JavaScript Custom -->
    <!-- jQuery CDN - min version -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/js/mdb.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <!-- Datatables JS -->
    <?= $this->asset->js('addons/datatables.min.js'); ?>
    <?= $this->asset->js('addons/datatables-select.min.js'); ?>
    <!-- NProgress JS -->
    <?= $this->asset->js('plugins/nprogress/nprogress.js'); ?>
    <!-- Select2 JS -->
    <?= $this->asset->js('plugins/select2/dist/js/select2.min.js'); ?>
    <!-- Sweet Alert -->
    <?= $this->asset->js('plugins/sweetalert2/dist/sweetalert2.min.js'); ?>
    <!-- Waitme JS -->
    <?= $this->asset->js('plugins/waitme/waitMe.js'); ?>
    <!-- Our Custom JS -->
    <?= $this->asset->js('themes/scripts.js'); ?>

    <script type="text/javascript">
        //  custom js //
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        let msg = new alertMessage();
        let site = '<?php echo site_url(); ?>';
        let regeID = '';

        const swalAlert = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        });

        $('input#nik').attr('maxLength', '16').keypress(limitMe);

        function limitMe(e) {
            if (e.keyCode == 8) {
                return true;
            }
            return this.value.length < $(this).attr("maxLength");
        }

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

        $(document).on('change', 'select[name="id_jenis_akun"]', function(e) {
            let id = $(this).val();
            if (id != 2) {
                $('#field_rintis').hide();
            } else {
                $('#field_rintis').show();
            }
        });

        $(document).ready(function(e) {
            getDataListFrontEnd();
        });

        function getDataListFrontEnd() {
            $('#tblListFrontEnd').dataTable({
                "pagingType": "full_numbers",
                "destroy": true,
                "processing": true,
                "language": {
                    "loadingRecords": '&nbsp;',
                    "processing": 'Loading data...'
                },
                // "aLengtMenu" : [[10, 40, 60, -1], [10, 40, 60, "All"]],
                // "iDisplayLength" : 10,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                    "url": site + 'auth/signin/listview',
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
                        "className": 'text-center'
                    },
                ],
            });
            $('#tblListFrontEnd_filter input').addClass('form-control').attr('placeholder', 'Search Data');
            $('#tblListFrontEnd_length select').addClass('form-control');
        }

        $(function() {
            $(document).on('submit', '#formLogin', function(e) {
                e.preventDefault();
                let postData = $(this).serialize();
                let formActionURL = $(this).attr("action");
                $("#submit").html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Loading...');
                $("#submit").addClass('disabled');
                $.ajax({
                    url: formActionURL,
                    type: "POST",
                    data: postData,
                    dataType: "json"
                }).done(function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 0) {
                        $('#formLogin').addClass('was-validated');
                        $('#errLog').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<strong>Error!</strong></br>' +
                            '<span id="pesanErr"> Silahkan dilengkapi data pada form dibawah</span>' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '</div>');
                        $.each(data.message, function(key, value) {
                            if (key != 'isi') {
                                $('#pesanErr').html('Silahkan dilengkapi data pada form dibawah');
                                $('input[name="' + key + '"]').closest('div.required').find('div.invalid-feedback').text(value);
                            } else {
                                $('#pesanErr').html(value);
                            }
                        });
                    } else if (data.status == 1) {
                        location.href = data.message.url;
                    } else if (data.status == 2) {
                        $('.app-screen-body').html(data.message);
                    }
                }).fail(function() {
                    $('#errLog').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<strong>Error!</strong></br>Harap periksa kembali data yang diinputkan' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>');
                }).always(function(data) {
                    $("#submit").html((data.flag == 2) ? 'NEXT' : 'SIGN IN');
                    $("#submit").removeClass('disabled');
                });
            });
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
            $('form#formEntry .select-all').select2().val('').trigger("change");
            $('#formEntry').attr('action', site + 'auth/signin/create_account');
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

        $(document).on('click', '.btnShow', function(e) {
            e.stopPropagation();
            formReset();
            $(this).html('<i class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></i>');
            $(this).addClass('disabled');
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
                url: site + 'auth/signin/details',
                data: {
                    'token': token,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
                },
                dataType: 'json',
                success: function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.status == 'RC200') {
                        $('input[name="tokenView"]').val(token);
                        $('input[name="pelatihanId"]').val(pelatihan);
                        $('input[name="statusId"]').val(status);
                        $('#judul_show').html(data.message.judul);
                        $('#id_jenis_kegiatan_show').html(data.message.id_jenis_kegiatan);
                        $('#deskripsi_show').html(data.message.deskripsi);
                        $('#id_metode_pelatihan_show').html(data.message.id_metode_pelatihan);
                        $('#persyaratan_show').html(data.message.persyaratan);
                        $('#mulai_registrasi_show').html(data.message.mulai_registrasi);
                        $('#akhir_registrasi_show').html(data.message.akhir_registrasi);
                        $('#kuota_show').html(data.message.kuota);
                        $('#alamat_show').html(data.message.alamat);
                        $('#jadwal_pelatihan_show').html(data.message.jadwal_pelatihan);
                    }
                    $('#frmViewShow').waitMe('hide');
                }
            });
        }
        //close form entri
        $(document).on('click', '.btnCloseView', function(e) {
            formReset();
            $('.btnShow').removeClass('disabled');
            $('#modalViewPelatihan').modal('toggle');
            getDataListFrontEnd();
        });

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
                url: site + 'auth/signin/regency',
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

        $(document).on('keyup', '#username_signup', function() {
            const name = $(this).val();
            if (name.length > 0)
                checkUsername(name);
        });

        function checkUsername(text = '') {
            $.ajax({
                type: 'GET',
                url: site + 'auth/signin/searching',
                data: {
                    'username': text,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
                },
                dataType: 'json',
                success: function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    if (data.message > 0)
                        $('#username_signup').closest('div.required').find('div.valid-email').html('<span class="text-danger">Email sudah ada!</span>');
                    else
                        $('#username_signup').closest('div.required').find('div.valid-email').html('');
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
        $(progressHtml).insertAfter($('.pass-signup:first').closest('div.input-group'));
        $('.progress-title').text('');
        $('.contextual-progress').hide();
        $('#password_signup').keyup(function(event) {
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
            let password = $('#password_signup').val();
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
    </script>
</body>

</html>