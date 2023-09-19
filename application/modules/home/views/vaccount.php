<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        Profile Akun
                    </h5>
                </div>
                <div class="card-body mb-0">
                    <div class="row mb-3 mt-1">
                        <div class="col-12 col-mb-12 mb-2">
                            <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:;')); ?>
                                <div class="card rgba-grey-slight">
                                    <div class="card-body">
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="nik" class="control-label font-weight-bolder">NIK <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control nominal" name="nik" id="nik" placeholder="NIK" value="<?php echo $profile->nik; ?>" required>
                                                <div class="valid-nip mt-1" style="font-size:80%;"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="nama_lengkap" class="control-label font-weight-bolder">Nama Peserta <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Peserta" value="<?php echo $profile->nama_lengkap; ?>" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="tempat_lhr" class="control-label font-weight-bolder">Tempat Lahir <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="tempat_lhr" id="tempat_lhr" placeholder="Tempat Lahir Peserta" value="<?php echo $profile->tempat_lhr; ?>" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="tanggal_lhr" class="control-label font-weight-bolder">Tanggal Lahir <span class="text-danger">*</span></label>
                                                <input placeholder="Select date" type="date" id="tanggal_lhr" name="tanggal_lhr" value="<?php echo $profile->tanggal_lhr; ?>" class="form-control">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-12 required">
                                                <label for="alamat_peserta" class="control-label font-weight-bolder">Alamat <span class="text-danger">*</span></label>
                                                <textarea class="form-control" required name="alamat_peserta" id="alamat_peserta" rows="1" placeholder="Alamat Peserta"><?php echo $profile->alamat_peserta; ?></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="province" class="control-label font-weight-bolder">Provinsi <span class="text-danger">*</span></label>
                                                    <?php echo form_dropdown('province', isset($data_provinsi) ? $data_provinsi : array(''=>'Pilih Data'), $this->input->post('province', TRUE), 'class="form-control select-all" id="province" required="" style="width:100%"');?>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="regency" class="control-label font-weight-bolder">Kabupaten/Kota <span class="text-danger">*</span></label>
                                                <?php echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all" id="regency" style="width:100%"'); ?>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-4 required">
                                                <label for="id_study" class="control-label font-weight-bolder">Pendidikan <span class="text-danger">*</span></label>
                                                    <?php echo form_dropdown('id_study', isset($data_study) ? $data_study : array(''=>'Pilih Data'), $this->input->post('id_study', TRUE), 'class="form-control select-all" id="id_study" required="" style="width:100%"');?>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-4 required">
                                                <label for="id_agama" class="control-label font-weight-bolder">Agama <span class="text-danger">*</span></label>
                                                    <?php echo form_dropdown('id_agama', isset($data_agama) ? $data_agama : array(''=>'Pilih Data'), $this->input->post('id_agama', TRUE), 'class="form-control select-all" id="id_agama" required="" style="width:100%"');?>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-4 required">
                                                <label for="id_gender" class="control-label font-weight-bolder">Jenis Kelamin <span class="text-danger">*</span></label>
                                                    <?php echo form_dropdown('id_gender', isset($data_gender) ? $data_gender : array(''=>'Pilih Data'), $this->input->post('id_gender', TRUE), 'class="form-control select-all" id="id_gender" required="" style="width:100%"');?>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="nm_kontak_darurat" class="control-label font-weight-bolder">Nama Kontak Darurat<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nm_kontak_darurat" id="nm_kontak_darurat" placeholder="Nama Kontak Darurat" value="<?php echo $profile->nm_kontak_darurat; ?>" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="no_darurat" class="control-label font-weight-bolder">No Darurat<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control nominal" name="no_darurat" id="no_darurat" placeholder="No Darurat" value="<?php echo $profile->no_darurat; ?>" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="kode_pos" class="control-label font-weight-bolder">Kode Pos<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode Pos" value="<?php echo $profile->kode_pos; ?>" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="upload_foto" class="control-label font-weight-bolder">Foto<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">File</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="upload_foto" name="upload_foto"
                                                        aria-describedby="inputGroupFileAddon01" value="<?php echo $profile->upload_foto; ?>">
                                                        <label class="custom-file-label" for="foto">Choose file</label>
                                                    </div>
                                                    <?php echo form_hidden('fotoshow', ''); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6 required">
                                                <label for="pekerjaan" class="control-label font-weight-bolder">Pekerjaan <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="pekerjaan" id="pekerjaan" rows="1" placeholder="Pekerjaan"><?php echo $profile->pekerjaan; ?></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-12 col-md-6 required">
                                                <label for="riwayat_penyakit" class="control-label font-weight-bolder">Riwayat Penyakit <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="riwayat_penyakit" id="riwayat_penyakit" rows="1" placeholder="Riwayat Penyakit Peserta"><?php echo $profile->riwayat_penyakit; ?></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-12 required">
                                                <label for="username" class="control-label font-weight-bolder">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="username" id="username" placeholder="Email" value="<?php echo $profile->username; ?>" required>
                                                <div class="invalid-feedback"></div>
                                                <div class="valid-username mt-1" style="font-size:80%;"></div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-12 col-md-6">
                                                <label for="password" class="control-label font-weight-bolder">Password <span class="grey-text" style="font-size: 80%;">(min 8 karakter)</span><span class="lblPass text-danger">*</span></label>
                                                <div class="input-group required">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="conf_password" class="control-label font-weight-bolder">Konfirmasi Password <span class="lblPass text-danger">*</span></label>
                                                <div class="input-group required">
                                                    <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="valid-password mt-1" style="font-size:80%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
