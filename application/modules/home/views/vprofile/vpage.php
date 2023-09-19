<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-personal mb-4">
                <div class="view">
                    <img class="card-img-top" src="<?php echo base_url('assets/img/avatar/'.fotoUser($profile->upload_foto)); ?>" alt="">
                    <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                    </a>
                </div>
                <div class="card-body">
                    <a>
                    <h4 class="card-title"><?php echo $profile->nama_lengkap; ?></h4>
                    </a>
                    <hr>
                    <a class="card-meta"><span><i class="fas fa-graduation-cap"></i> <?= empty($diklat->total) ? 0 : $diklat->total; ?> Total Mengikuti Pelatihan</span></a>
                    <hr>
                    <a class="card-meta"><span>Bergabung sejak <?php echo tgl_surat($profile->create_date); ?></span></a>
                </div>
            </div> 
        </div>
        <div class="col-md-9">
            <div class="card">
                <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/update' : ''), array('id' => 'formEntry', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                <div id="errSuccess"></div>
                <div id="errEntry"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="heading font-weight-bolder mb-3  mt-2"><i class="fas fa-user"></i> Data Pribadi <span class="lblMod"></span></h5>
                        </div>
                        <div class="col-md-6 ">
                            <div class="float-right">
                                <button style="border-radius: 20px;" type="submit" class="btn btn-danger btn-sm mx-auto d-block waves-effect waves-light font-weight-bold" name="save" id="save"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-4 required">
                            <label for="nik" class="control-label font-weight-bolder">NIK <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control nominal" name="nik" id="nik" placeholder="NIK" value="<?php echo $profile->nik; ?>" required>
                            <div class="valid-nik mt-1" style="font-size:80%;"></div>
                        </div>
                        <div class="col-12 col-md-4 required">
                            <label for="nama_lengkap" class="control-label font-weight-bolder">Nama Lengkap <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Peserta Diklat" value="<?php echo $profile->nama_lengkap; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-4 required">
                            <label for="upload_foto" class="control-label font-weight-bolder">Foto <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">File</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload_foto" name="upload_foto"
                                    aria-describedby="inputGroupFileAddon01" value="<?php echo $this->input->post('upload_foto', TRUE); ?>">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                                <?php echo form_hidden('fotoProfile', $profile->upload_foto); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="tempat_lhr" class="control-label font-weight-bolder">Tempat Lahir <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="tempat_lhr" id="tempat_lhr" placeholder="Tempat Lahir Peserta" value="<?php echo $profile->tempat_lhr; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="tanggal_lhr" class="control-label font-weight-bolder">Tanggal Lahir <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input placeholder="Select date" type="date" id="tanggal_lhr" name="tanggal_lhr" value="<?php echo $profile->tanggal_lhr; ?>" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12 required">
                            <label for="alamat_peserta" class="control-label font-weight-bolder">Alamat <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <textarea class="form-control" required name="alamat_peserta" id="alamat_peserta" rows="1" placeholder="Alamat Peserta"><?php echo $profile->alamat_peserta; ?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="province" class="control-label font-weight-bolder">Provinsi <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('province', isset($data_provinsi) ? $data_provinsi : array(''=>'Pilih Data'), $profile->id_province, 'class="form-control select-all" id="province" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="regency" class="control-label font-weight-bolder">Kabupaten/Kota <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <?php echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $profile->id_regency, 'class="select-all" id="regency" data-regency="'.$profile->id_regency.'" style="width:100%"'); ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-4 required">
                            <label for="id_study" class="control-label font-weight-bolder">Pendidikan <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('id_study', isset($data_study) ? $data_study : array(''=>'Pilih Data'), $profile->id_study, 'class="form-control select-all" id="id_study" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-4 required">
                            <label for="id_agama" class="control-label font-weight-bolder">Agama <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('id_agama', isset($data_agama) ? $data_agama : array(''=>'Pilih Data'), $profile->id_agama, 'class="form-control select-all" id="id_agama" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-4 required">
                            <label for="id_gender" class="control-label font-weight-bolder">Jenis Kelamin <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('id_gender', isset($data_gender) ? $data_gender : array(''=>'Pilih Data'), $profile->id_gender, 'class="form-control select-all" id="id_gender" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="kode_pos" class="control-label font-weight-bolder">Kode Pos <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Bidang Study Pendidikan" value="<?php echo $profile->kode_pos; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="pekerjaan" class="control-label font-weight-bolder">Pekerjaan <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Hoby" value="<?php echo $profile->pekerjaan; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="id_jenis_akun" class="control-label font-weight-bolder">Apa anda sudah memiliki usaha? <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('id_jenis_akun', isset($data_usaha) ? $data_usaha : array(''=>'Pilih Jawaban'), $profile->id_jenis_akun, 'class="form-control select-all" id="id_jenis_akun" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required" style="display:none;" id="field_rintis">
                            <label for="minat_usaha" class="control-label font-weight-bolder">Minat usaha yang akan dirintis? <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="minat_usaha" id="minat_usaha" placeholder="Minat Usaha" value="<?php echo isset($profile->minat_usaha) ? $profile->minat_usaha : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                    </div>
                    <div class="form-row mb-3">
                        
                    </div>
                </div>

                <!---------------------------------- Data Usaha ------------------------------------------------------------------------>
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->

                <div class="card-body" style="display:none;" id="field_usaha">
                    <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Data Usaha <span class="lblMod"></span></h5>
                    <!-- <p class="note note-primary">
                        <span><b> Note :</b> 
                            Jika salah satu isian tidak terpenuhi silahkan isi tanda [ - ] atau [ 0 ] pada form isian dibawah.
                        </span>
                    </p> -->
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="nama_pemilik" class="control-label font-weight-bolder">Nama Pemilik <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" placeholder="Pemilik Usaha" value="<?php echo isset($usaha_peserta->nama_pemilik) ? $usaha_peserta->nama_pemilik : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="nama_usaha" class="control-label font-weight-bolder">Nama Usaha <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" placeholder="Nama Usaha" value="<?php echo isset($usaha_peserta->nama_usaha) ? $usaha_peserta->nama_usaha : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <!-- <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="province" class="control-label font-weight-bolder">Provinsi <span class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php //echo form_dropdown('province', isset($data_provinsi) ? $data_provinsi : array(''=>'Pilih Data'), $this->input->post('province', TRUE), 'class="form-control select-all" id="province" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="regency" class="control-label font-weight-bolder">Kabupaten/Kota <span class="text-danger"><small>Wajib Isi</small></span></label>
                            <?php //echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all" id="regency" style="width:100%"'); ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> -->
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12 required">
                            <label for="alamat_usaha" class="control-label font-weight-bolder">Alamat <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <textarea class="form-control" required name="alamat_usaha" id="alamat_usaha" rows="1" placeholder="Alamat Usaha"><?php echo isset($usaha_peserta->alamat_usaha) ? $usaha_peserta->alamat_usaha : ''; ?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6 required">
                            <label for="telp" class="control-label font-weight-bolder">No Telp <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="telp" id="telp" placeholder="No Telepon Usaha" value="<?php echo isset($usaha_peserta->telp) ? $usaha_peserta->telp : '' ; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6 required">
                            <label for="wa" class="control-label font-weight-bolder">WhatsApp <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="wa" id="wa" placeholder="WhatsApp" value="<?php echo isset($usaha_peserta->wa) ? $usaha_peserta->wa : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-4 required">
                            <label for="id_bidang_usaha" class="control-label font-weight-bolder">Bidang Usaha <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                <?php echo form_dropdown('id_bidang_usaha', isset($data_jenis_usaha) ? $data_jenis_usaha : array(''=>'Pilih Data'), isset($usaha_peserta->id_bidang_usaha) ? $usaha_peserta->id_bidang_usaha : '' , 'class="form-control select-all" id="id_bidang_usaha" required="" style="width:100%"');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-4 required">
                            <label for="jenis_usaha" class="control-label font-weight-bolder">Jenis Usaha <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="jenis_usaha" id="jenis_usaha" placeholder="Jenis Usaha" value="<?php echo isset($usaha_peserta->jenis_usaha) ? $usaha_peserta->jenis_usaha : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- <div class="col-12 col-md-4 required">
                            <label for="produk_jual" class="control-label font-weight-bolder">Produk yang dijual <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="produk_jual" id="produk_jual" placeholder="Produk yang dijual" value="<?php //echo isset($usaha_peserta->produk_jual) ? $usaha_peserta->produk_jual : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div> -->
                    </div>
                    <!-- <div class="form-row mb-3">
                        <div class="col-12 col-md-9 required">
                            <label for="bentuk_pemasaran" class="control-label font-weight-bolder"> Bentuk Pemasaran <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control" name="bentuk_pemasaran" id="bentuk_pemasaran" placeholder="Online,Offline,Konvensional,Dll" value="<?php //echo isset($usaha_peserta->bentuk_pemasaran) ? $usaha_peserta->bentuk_pemasaran : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-3 required">
                            <label for="tahun_mulai_usaha" class="control-label font-weight-bolder">Tahun Berdiri <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control nominal" name="tahun_mulai_usaha" id="tahun_mulai_usaha" placeholder="Tahun Usaha" value="<?php //echo isset($usaha_peserta->tahun_mulai_usaha) ? $usaha_peserta->tahun_mulai_usaha : ''; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-3">
                            <label for="no_nib" class="control-label font-weight-bolder">Nomor NIB <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_nib" id="no_nib" placeholder="No Izin Berusaha" value="<?php echo isset($usaha_peserta->no_nib) ? $usaha_peserta->no_nib : ''; ?>">
                            
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_pirt" class="control-label font-weight-bolder">Nomor PIRT <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_pirt" id="no_pirt" placeholder="Sertifikat Produksi" value="<?php echo isset($usaha_peserta->no_pirt) ? $usaha_peserta->no_pirt : ''; ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_pkrt" class="control-label font-weight-bolder">Nomor PKRT <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_pkrt" id="no_pkrt" placeholder="Nomor PKRT" value="<?php echo isset($usaha_peserta->no_pkrt) ? $usaha_peserta->no_pkrt : ''; ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_iumk" class="control-label font-weight-bolder">Nomor IUMK <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_iumk" id="no_iumk" placeholder="Izin Usaha Mikro Kecil" value="<?php echo isset($usaha_peserta->no_iumk) ? $usaha_peserta->no_iumk : ''; ?>">
                        </div>
                    </div> 
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-3">
                            <label for="no_md" class="control-label font-weight-bolder">Nomor MD <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_md" id="no_md" placeholder="Izin Dalam Negeri" value="<?php //echo isset($usaha_peserta->no_md) ? $usaha_peserta->no_md : ''; ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_ml" class="control-label font-weight-bolder">Nomor ML <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_ml" id="no_ml" placeholder="Izin Luar Negeri" value="<?php //echo isset($usaha_peserta->no_ml) ? $usaha_peserta->no_ml : ''; ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_halal" class="control-label font-weight-bolder">Nomor Halal <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_halal" id="no_halal" placeholder="Izin Luar Negeri" value="<?php //echo isset($usaha_peserta->no_halal) ? $usaha_peserta->no_halal : ''; ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="no_merek" class="control-label font-weight-bolder">Nomor Merek <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control" name="no_merek" id="no_merek" placeholder="Izin Luar Negeri" value="<?php //echo isset($usaha_peserta->no_merek) ? $usaha_peserta->no_merek : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-3">
                            <label for="jumlah_produksi" class="control-label font-weight-bolder">Jumlah Produksi <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control nominal" name="jumlah_produksi" id="jumlah_produksi" placeholder="Kg/Ton/Pcs/Org" value="<?php //echo isset($usaha_peserta->jumlah_produksi) ? $usaha_peserta->jumlah_produksi : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="jumlah_penjualan" class="control-label font-weight-bolder">Jumlah Penjualan <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control nominal" name="jumlah_penjualan" id="jumlah_penjualan" placeholder="Penjualan" value="<?php //echo isset($usaha_peserta->jumlah_penjualan) ? $usaha_peserta->jumlah_penjualan : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="omset" class="control-label font-weight-bolder">Omset Penjualan <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control nominal" name="omset" id="omset" placeholder="Omset" value="<?php //echo isset($usaha_peserta->omset) ? $usaha_peserta->omset : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> -->
                    <!-- <div class="form-row mb-3">
                        <div class="col-12 col-md-12">
                            <label for="total_asset_lalu" class="control-label font-weight-bolder">Total Asset Tahun Lalu (Diluar tanah dan bangunan) <span class="text-danger"><small>*</small></span></label>
                            <input type="text" class="form-control nominal" name="total_asset_lalu" id="total_asset_lalu" placeholder="Total Asset" value="<?php //echo $this->input->post('total_asset_lalu', TRUE); ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12">
                            <label for="total_asset_sekarang" class="control-label font-weight-bolder">Total Asset Saat Ini (Diluar tanah dan bangunan) <span class="text-danger"><small>*</small></span></label>
                            <input type="text" class="form-control nominal" name="total_asset_sekarang" id="total_asset_sekarang" placeholder="Total Asset" value="<?php //echo $this->input->post('total_asset_sekarang', TRUE); ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> -->
                    <!-- <div class="form-row mb-3">
                        <div class="col-12 col-md-4">
                            <label for="jumlah_pekerja" class="control-label font-weight-bolder"> Jumlah Karyawan <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control nominal" name="jumlah_pekerja" id="jumlah_pekerja" placeholder="Total Karyawan" value="<?php //echo isset($usaha_peserta->jumlah_pekerjaan) ? $usaha_peserta->jumlah_pekerjaan : ''; ?>">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="menerima_pinjaman" class="control-label font-weight-bolder">Menerima Pinjaman <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <?php //echo form_dropdown('menerima_pinjaman', menerima_pinjaman(), isset($usaha_peserta->menerima_pinjaman) ? $usaha_peserta->menerima_pinjaman : '', 'class="form-control select-data" id="menerima_pinjaman" style="width:100%"=""');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-4" style="display:none;" id="field_pinjaman">
                            <label for="jumlah_pinjaman" class="control-label font-weight-bolder"> Jumlah Pinjaman <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                            <input type="text" class="form-control nominal" name="jumlah_pinjaman" id="jumlah_pinjaman" placeholder="Jumlah Pinjaman" value="<?php //echo isset($usaha_peserta->jumlah_pinjaman) ? $usaha_peserta->jumlah_pinjaman : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> -->
                    <!-- <div class="form-row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="id_skala_usaha" class="control-label font-weight-bolder">Skala Usaha</span></label>
                            <?php //echo form_dropdown('id_skala_usaha', skala_usaha(), isset($usaha_peserta->id_skala_usaha) ? $usaha_peserta->id_skala_usaha : '', 'class="form-control select-data" id="id_skala_usaha" style="width:100%"=""');?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="modal_awal" class="control-label font-weight-bolder"> Modal Awal <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Optional</small></span></label>
                            <input type="text" class="form-control nominal" name="modal_awal" id="modal_awal" placeholder="Modal Awal" value="<?php //echo isset($usaha_peserta->modal_awal) ? $usaha_peserta->modal_awal : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="media_sosial" class="control-label font-weight-bolder"> Media Sosial</label>
                            <input type="text" class="form-control" name="media_sosial" id="media_sosial" placeholder="Nama Media Sosial Promosi Usaha" value="<?php //echo isset($usaha_peserta->media_sosial) ? $usaha_peserta->media_sosial : ''; ?>">
                            <div class="invalid-feedback"></div>
                            
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="nama_toko_online" class="control-label font-weight-bolder"> Toko Online </label>
                            <input type="text" class="form-control" name="nama_toko_online" id="nama_toko_online" placeholder="Nama Toko Online Usaha" value="<?php //echo isset($usaha_peserta->nama_toko_online) ? $usaha_peserta->nama_toko_online : ''; ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12">
                            <label for="media_transaksi_digital" class="control-label font-weight-bolder"> Apa sudah ada media transaksi digital.? </span></label>
                            <input class="form-control" name="media_transaksi_digital" id="media_transaksi_digital" rows="1" placeholder="Cth : Gopay,Dana,Ovo,Qris,dll"><?php //echo isset($usaha_peserta->media_transaksi_digital) ? $usaha_peserta->media_transaksi_digital : ''; ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12">
                            <label for="kendala_usaha" class="control-label font-weight-bolder">Kedala usaha saat ini.? </span></label>
                            <textarea class="form-control" name="kendala_usaha" id="kendala_usaha" rows="1" placeholder="Kendala Usaha"><?php //echo isset($usaha_peserta->kendala_usaha) ? $usaha_peserta->kendala_usaha : ''; ?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-12 col-md-12">
                            <label for="pelatihan_diinginkan" class="control-label font-weight-bolder">Pelatihan yang diinginkan.? </span></label>
                            <textarea class="form-control" required name="pelatihan_diinginkan" id="pelatihan_diinginkan" rows="1" placeholder="Pelatihan"><?php //echo isset($usaha_peserta->pelatihan_diinginkan) ? $usaha_peserta->pelatihan_diinginkan : ''; ?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> -->
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
        
</section>