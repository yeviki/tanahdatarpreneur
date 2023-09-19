

<section>
    <?= "Selamat Datang Di Digital Talent Provinsi Sumatera Barat"; ?>
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    
    <p class="note note-primary mt-3">
        <span><b> Perhatian :</b> 
            Data usaha belum lengkap, silahkan dilengkapi <a class="btn aqua-gradient btn-sm" href="<?php echo base_url('home/profile'); ?>">disini....</a>
        </span>
    </p>

    

</section>

<!-- <div class="modal fade" id="modalEntryForm" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Silahkan lengkapi profile usaha anda</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <?php //echo form_open(site_url(isset($siteUri) ? $siteUri.'/create' : ''), array('id' => 'formEntry', 'class='=>'needs-validated', 'novalidate'=>'')); ?>
                        <div id="errEntry"></div>
                        <d iv class="card">
                            <div class="card-body">
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Data Usaha <span class="lblMod"></span></h5>
                                <p class="note note-primary">
                                    <span><b> Note :</b> 
                                        Jika salah satu isian tidak terpenuhi silahkan isi tanda [ - ] atau [ 0 ] pada form isian dibawah.
                                    </span>
                                </p>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="nama_pemilik" class="control-label font-weight-bolder">Nama Pemilik <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" placeholder="Pemilik Usaha" value="<?php //echo $this->input->post('nama_pemilik', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="nama_usaha" class="control-label font-weight-bolder">Nama Usaha <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" placeholder="Nama Usaha" value="<?php //echo $this->input->post('nama_usaha', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="province" class="control-label font-weight-bolder">Provinsi <span class="text-danger"><small>*</small></span></label>
                                            <?php //echo form_dropdown('province', isset($data_provinsi) ? $data_provinsi : array(''=>'Pilih Data'), $this->input->post('province', TRUE), 'class="form-control select-all" id="province" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="regency" class="control-label font-weight-bolder">Kabupaten/Kota <span class="text-danger"><small>*</small></span></label>
                                        <?php //echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all" id="regency" style="width:100%"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="alamat_usaha" class="control-label font-weight-bolder">Alamat <span class="text-danger"><small>*</small></span></label>
                                        <textarea class="form-control" required name="alamat_usaha" id="alamat_usaha" rows="1" placeholder="Alamat Usaha"><?php //echo $this->input->post('alamat_usaha', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="telp" class="control-label font-weight-bolder">No Telp <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="telp" id="telp" placeholder="No Telepon Usaha" value="<?php //echo $this->input->post('telp', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="wa" class="control-label font-weight-bolder">WhatsApp <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="wa" id="wa" placeholder="WhatsApp" value="<?php //echo $this->input->post('wa', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="id_bidang_usaha" class="control-label font-weight-bolder">Bidang Usaha <span class="text-danger"><small>*</small></span></label>
                                            <?php //echo form_dropdown('id_bidang_usaha', isset($data_jenis_usaha) ? $data_jenis_usaha : array(''=>'Pilih Data'), $this->input->post('id_bidang_usaha', TRUE), 'class="form-control select-all" id="id_bidang_usaha" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-4 required">
                                        <label for="no_pirt" class="control-label font-weight-bolder">Nomor PIRT <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_pirt" id="no_pirt" placeholder="Sertifikat Produksi" value="<?php //echo $this->input->post('no_pirt', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-4 required">
                                        <label for="no_pkrt" class="control-label font-weight-bolder">Nomor PKRT <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_pkrt" id="no_pkrt" placeholder="Nomor PKRT" value="<?php //echo $this->input->post('no_pkrt', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-4 required">
                                        <label for="no_iumk" class="control-label font-weight-bolder">Nomor IUMK <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_iumk" id="no_iumk" placeholder="Izin Usaha Mikro Kecil" value="<?php //echo $this->input->post('no_iumk', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-3 required">
                                        <label for="no_md" class="control-label font-weight-bolder">Nomor MD <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_md" id="no_md" placeholder="Izin Dalam Negeri" value="<?php //echo $this->input->post('no_md', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="no_ml" class="control-label font-weight-bolder">Nomor ML <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_ml" id="no_ml" placeholder="Izin Luar Negeri" value="<?php //echo $this->input->post('no_ml', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="no_halal" class="control-label font-weight-bolder">Nomor Halal <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_halal" id="no_halal" placeholder="Izin Luar Negeri" value="<?php //echo $this->input->post('no_halal', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="no_merek" class="control-label font-weight-bolder">Nomor Merek <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="no_merek" id="no_merek" placeholder="Izin Luar Negeri" value="<?php //echo $this->input->post('no_merek', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-3 required">
                                        <label for="tahun_mulai_usaha" class="control-label font-weight-bolder">Tahun Berdiri <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="tahun_mulai_usaha" id="tahun_mulai_usaha" placeholder="Tahun Usaha" value="<?php //echo $this->input->post('tahun_mulai_usaha', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="jumlah_produksi" class="control-label font-weight-bolder">Jumlah Produksi <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="jumlah_produksi" id="jumlah_produksi" placeholder="Kg/Ton/Pcs/Org" value="<?php //echo $this->input->post('jumlah_produksi', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="jumlah_penjualan" class="control-label font-weight-bolder">Jumlah Penjualan <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="jumlah_penjualan" id="jumlah_penjualan" placeholder="Penjualan" value="<?php //echo $this->input->post('jumlah_penjualan', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="omset" class="control-label font-weight-bolder">Omset Penjualan <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="omset" id="omset" placeholder="Omset" value="<?php //echo $this->input->post('omset', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="total_asset_lalu" class="control-label font-weight-bolder">Total Asset Tahun Lalu (Diluar tanah dan bangunan) <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="total_asset_lalu" id="total_asset_lalu" placeholder="Total Asset" value="<?php //echo $this->input->post('total_asset_lalu', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="total_asset_sekarang" class="control-label font-weight-bolder">Total Asset Saat Ini (Diluar tanah dan bangunan) <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="total_asset_sekarang" id="total_asset_sekarang" placeholder="Total Asset" value="<?php //echo $this->input->post('total_asset_sekarang', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="bentuk_pemasaran" class="control-label font-weight-bolder"> Bentuk Pemasaran <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control" name="bentuk_pemasaran" id="bentuk_pemasaran" placeholder="Online,Offline,Konvensional,Dll" value="<?php //echo $this->input->post('bentuk_pemasaran', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-4 required">
                                        <label for="jumlah_pekerja" class="control-label font-weight-bolder"> Jumlah Karyawan <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="jumlah_pekerja" id="jumlah_pekerja" placeholder="Total Karyawan" value="<?php //echo $this->input->post('jumlah_pekerja', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-4 required">
                                        <label for="menerima_pinjaman" class="control-label font-weight-bolder">Menerima Pinjaman <span class="text-danger"><small>*</small></span></label>
                                        <?php //echo form_dropdown('menerima_pinjaman', menerima_pinjaman(), $this->input->post('menerima_pinjaman', TRUE), 'class="form-control select-data" id="menerima_pinjaman" style="width:100%" required=""');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-4 required" style="display:none;" id="field_pinjaman">
                                        <label for="jumlah_pinjaman" class="control-label font-weight-bolder"> Jumlah Pinjaman <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="jumlah_pinjaman" id="jumlah_pinjaman" placeholder="Jumlah Pinjaman" value="<?php //echo $this->input->post('jumlah_pinjaman', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="id_skala_usaha" class="control-label font-weight-bolder">Skala Usaha <span class="text-danger"><small>*</small></span></label>
                                        <?php //echo form_dropdown('id_skala_usaha', skala_usaha(), $this->input->post('id_skala_usaha', TRUE), 'class="form-control select-data" id="id_skala_usaha" style="width:100%" required=""');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="modal_awal" class="control-label font-weight-bolder"> Modal Awal <span class="text-danger"><small>*</small></span></label>
                                        <input type="text" class="form-control nominal" name="modal_awal" id="modal_awal" placeholder="Modal Awal" value="<?php //echo $this->input->post('modal_awal', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6">
                                        <label for="media_sosial" class="control-label font-weight-bolder"> Media Sosial</label>
                                        <input type="text" class="form-control" name="media_sosial" id="media_sosial" placeholder="Nama Media Sosial Promosi Usaha" value="<?php //echo $this->input->post('media_sosial', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                        
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="nama_toko_online" class="control-label font-weight-bolder"> Toko Online </label>
                                        <input type="text" class="form-control" name="nama_toko_online" id="nama_toko_online" placeholder="Nama Toko Online Usaha" value="<?php //echo $this->input->post('nama_toko_online', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="media_transaksi_digital" class="control-label font-weight-bolder"> Apa sudah ada media transaksi digital.? <span class="text-danger"><small>*</small></span></label>
                                        <input class="form-control" required name="media_transaksi_digital" id="media_transaksi_digital" rows="1" placeholder="Cth : Gopay,Dana,Ovo,Qris,dll"><?php // echo $this->input->post('media_transaksi_digital', TRUE); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="kendala_usaha" class="control-label font-weight-bolder">Kedala usaha saat ini.? <span class="text-danger"><small>*</small></span></label>
                                        <textarea class="form-control" required name="kendala_usaha" id="kendala_usaha" rows="1" placeholder="Kendala Usaha"><?php // echo $this->input->post('kendala_usaha', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="pelatihan_diinginkan" class="control-label font-weight-bolder">Pelatihan yang diinginkan.? <span class="text-danger"><small>*</small></span></label>
                                        <textarea class="form-control" required name="pelatihan_diinginkan" id="pelatihan_diinginkan" rows="1" placeholder="Pelatihan"><?php // echo $this->input->post('pelatihan_diinginkan', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </d>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnClose"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="save" id="save"><i class="fas fa-check"></i> Submit</button>
            </div>
            <?php //echo form_close(); ?>
        </div>
    </div>
</div> -->