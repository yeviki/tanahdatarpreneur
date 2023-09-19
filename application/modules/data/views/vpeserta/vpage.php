<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data Peserta
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                        <button type="button" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light px-3 py-2 font-weight-bold" id="btnDelete" style="display:none;"><i class="fa fa-trash-alt"></i> Delete User</button>
                        <!-- <button type="button" class="btn btn-info waves-effect waves-light px-3 py-2 font-weight-bold" id="btnsendMail" style="display:none;"><i class="fa fa-envelope"></i> Kirim Email</button> -->
                        <!-- <button type="button" class="btn btn-warning waves-effect waves-light px-3 py-2 font-weight-bold" id="btnImport"><i class="fas fa-plus-circle"></i> Import Excel</button> -->
                        <?php if ($this->app_loader->current_opdid()) { ?>
                            <a href="<?= site_url('data/peserta/export-to-pdf') ?>" target="_blank" class="btn btn-info waves-effect waves-light px-3 py-2 font-weight-bold" id="btn-print">
                                <i class="fas fa-print"></i> Print
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body mb-0">
                    <div class="row mb-3 mt-1">
                        <div class="col-12 col-md-12">
                            <h5 class="font-weight-bold">
                                <a href="javascript:void(0);" class="btnFilter text-decoration-none text-black">
                                    <i class="fas fa-sliders-h"></i> Filter Data
                                </a>
                            </h5>
                        </div>
                        <div class="col-12 col-mb-12 mb-2">
                            <?php echo form_open(site_url('#'), array('id' => 'formFilter', 'style' => 'display:none;')); ?>
                            <div class="card rgba-grey-slight">
                                <div class="card-body">
                                    <div class="form-row mb-3 ">
                                        <div class="col-12 col-md-3">
                                            <label for="nama_lengkap_search" class="control-label font-weight-bolder">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap_search" placeholder="Nama Lengkap" value="<?php echo $this->input->post('nama_lengkap_search', TRUE); ?>">
                                        </div>
                                        <?php if ($this->app_loader->current_opdid()) { ?>
                                            <div class="col-12 col-md-3">
                                                <label for="tahun" class="control-label font-weight-bolder">Tahun</label>
                                                <?php echo form_dropdown('filter_tahun', array('' => 'Pilih Tahun', '2021' => '2021', '2022' => '2022', '2023' => '2023'), date('Y'), 'class="form-control select-all" name="filter_tahun"  id="filter_tahun" style="width:100%"'); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="col-12 col-md-3">
                                            <label for="nik_search" class="control-label font-weight-bolder">NIK</label>
                                            <input type="text" class="form-control" name="nik_search" placeholder="NIK" value="<?php echo $this->input->post('nik_search', TRUE); ?>">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="group" class="control-label font-weight-bolder">Provinsi</label>
                                            <?php echo form_dropdown('province_search', isset($data_provinsi) ? $data_provinsi : array('' => 'Pilih Data'), $this->input->post('province_search', TRUE), 'class="form-control select-all" name="province_search" style="width:100%"'); ?>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="regency_search" class="control-label font-weight-bolder">Kab/Kota</label>
                                            <?php echo form_dropdown('regency_search', array('' => 'Pilih Kab/Kota'), $this->input->post('regency_search', TRUE), 'class="select-all" name="regency_search" style="width:100%"'); ?>
                                        </div>
                                        <!-- <div class="col-12 col-md-2">
                                            <label for="status" class="control-label font-weight-bolder">Status</label>
                                            <?php echo form_dropdown('status', array('' => 'Pilih Status', 1 => 'Aktif', 0 => 'Tidak Aktif'), $this->input->post('status', TRUE), 'class="form-control select-all" style="width:100%"'); ?>
                                        </div> -->
                                    </div>
                                    <div class="form-row">
                                        <div class="col-12 col-md-12">
                                            <div class="d-flex justify-content-lg-start align-items-center" style="margin-right: -5px;">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="filter" id="filter"><i class="fas fa-filter"></i> Lakukan Pencarian</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light px-3 py-2 font-weight-bold" name="cancel" id="cancel"><i class="fas fa-sync-alt"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div class="table-responsive-md">
                        <table cellspacing="0" class="table table-striped table-borderless table-hover table-sm" id="tblList" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">
                                        <div class="custom-control custom-checkbox mt-0 pt-0">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label font-weight-bolder" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th width="3%" class="font-weight-bold">#</th>
                                    <th width="5%" class="font-weight-bold">Foto</th>
                                    <th class="font-weight-bold">Pengguna</th>
                                    <th class="font-weight-bold">Provinsi</th>
                                    <th class="font-weight-bold">Kabupaten/Kota</th>
                                    <th width="7%" class="font-weight-bold">Edit</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data Peserta</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/create' : ''), array('id' => 'formEntry', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                        <div id="errEntry"></div>
                        <?php echo form_hidden('tokenId', ''); ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Entry Data Pribadi <span class="lblMod"></span></h5>
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
                                            <?php echo form_hidden('fotoshow', ''); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="pekerjaan" class="control-label font-weight-bolder">Pekerjaan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="pekerjaan" id="pekerjaan" rows="1" placeholder="Pekerjaan"><?php echo $this->input->post('pekerjaan', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="no_hp" class="control-label font-weight-bolder">Nomor HP <span class="text-danger">*</span></label>
                                        <textarea class="form-control nominal" name="no_hp" id="no_hp" rows="1" placeholder="Nomor HP"><?php echo $this->input->post('no_hp', TRUE); ?></textarea>
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
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Pelatihan Peserta<span class="lblMod"></span></h5>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="id_pelatihan" class="control-label font-weight-bolder">Pelatihan <span class="text-danger">*</span></label>
                                        <?php echo form_dropdown('id_pelatihan', isset($data_pelatihan) ? $data_pelatihan : array('' => 'Pilih Data'), $this->input->post('id_pelatihan', TRUE), 'class="form-control select-all" id="id_pelatihan" required="" style="width:100%"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="blockquote-footer">
                                    <span>
                                        <b>Perhatian : </b><span class="text-danger">Pelatihan hanya bisa dipilih dan disimpan satu kali, harap cek kembali penempatan peserta pada pelatihan yang akan dipilih</span>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Entry Data Akun <span class="lblMod"></span></h5>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="username" class="control-label font-weight-bolder">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="username" id="username" placeholder="Email" value="<?php echo $this->input->post('username', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                        <div class="valid-username mt-1" style="font-size:80%;"></div>
                                    </div>
                                </div>


                                <?php
                                if ($this->app_loader->is_super()) {
                                    echo '<div class="form-row mb-3">';
                                    echo '<div class="col-12 col-md-6">';
                                    echo '<label for="password" class="control-label font-weight-bolder">Password <span class="grey-text" style="font-size: 80%;">(min 8 karakter)</span><span class="lblPass text-danger">*</span></label>';
                                    echo '<div class="input-group required">';
                                    echo '<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="' . $this->input->post('password', TRUE) . '" required>';
                                    echo '<div class="input-group-append">';
                                    echo '<span class="input-group-text showPass"><i class="fa fa-eye"></i></span>';
                                    echo '</div>';
                                    echo '<div class="invalid-feedback"></div>';
                                    echo '</div>';
                                    echo '</div>';

                                    echo '<div class="col-12 col-md-6">';
                                    echo '<label for="conf_password" class="control-label font-weight-bolder">Konfirmasi Password <span class="lblPass text-danger">*</span></label>';
                                    echo '<div class="input-group required">';
                                    echo '<input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="' . $this->input->post('conf_password', TRUE) . '" required>';
                                    echo '<div class="input-group-append">';
                                    echo '<span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                        </div>';
                                    echo ' <div class="invalid-feedback"></div>';
                                    echo '</div>';
                                    echo '<div class="valid-password mt-1" style="font-size:80%;"></div>';
                                    echo '</div>';
                                    echo '</div>';

                                    echo '<div class="form-row mb-3">';
                                    echo '<div class="col-12 col-md-4 required">';
                                    echo '<label for="blokir" class="control-label font-weight-bolder">Blokir <span class="text-danger">*</span></label>';
                                    echo form_dropdown('blokir', blokir(), $this->input->post('blokir', TRUE), 'class="form-control select-data" id="blokir" style="width:100%" required=""');
                                    echo '<div class="invalid-feedback"></div>';
                                    echo '</div>';
                                    echo '<div class="col-12 col-md-4 required">';
                                    echo '<label for="status" class="control-label font-weight-bolder">Status <span class="text-danger">*</span></label>';
                                    echo form_dropdown('status', status(), $this->input->post('status', TRUE), 'class="form-control select-data" id="status" style="width:100%" required=""');
                                    echo '<div class="invalid-feedback"></div>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="blockquote-footer">';
                                    echo '<span>';
                                    echo '<b>Note : </b><span class="text-danger">Password akun akan di create otomatis oleh sistem, dengan defaultnya (Asdf@1234)</span>
                                            </span>';
                                    echo '</div>';
                                }
                                ?>
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

<div class="modal fade" id="modalEntryForm1" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry1">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Import</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/import_excel' : ''), array('id' => 'formEntry1', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
            <div class="modal-body">
                <div id="errEntry1"></div>
                <?php echo form_hidden('tokenId', ''); ?>
                <div class="bg-light p-1 mt-3 mb-3">
                    <h4 class="text-center"><i><b>Import Data Peserta</b></i></h4>
                </div>
                <p class="text-justify">Upload data sesuai dengan template file yang telah ditentukan. Format file bisa didownload dibawah ini <br>
                    <a href="<?= base_url('/repository/import_data_peserta.xlsx') ?>" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" title="Download Format Excel Import data" style="margin:.375rem 0"><i class="fas fa-file-download"></i> Format file excel</a>
                </p>

                <div class="form-row mb-3">
                    <div class="col-12 col-md-12">
                        <label for="file_name" class="control-label font-weight-bolder">Import File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file_name" id="file_name" placeholder="Import File" value="<?php echo $this->input->post('file_name', TRUE); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnClose"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="save1" id="save1"><i class="fas fa-check"></i> Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->