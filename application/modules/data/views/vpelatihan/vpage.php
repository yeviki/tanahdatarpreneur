<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data Pelatihan
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                        <?php
                        if (!$this->app_loader->is_peserta()) {
                            echo '<button type="button" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Tambah Baru</button>';
                            echo '<a href="' . base_url('/repository/import_data_peserta.xlsx') . '" class="btn btn-warning waves-effect waves-light px-3 py-2 font-weight-bold" title="Download Format Excel Import data" style="margin:.375rem 0"><i class="fas fa-file-download"></i> Format file import</a></p>';
                        } else
                        ?>
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
                                        <div class="col-12 col-md-2">
                                            <label for="filter_tahun" class="control-label font-weight-bolder">Tahun</label>
                                            <?php echo form_dropdown('filter_tahun', array('' => 'Pilih Tahun', '2021' => '2021', '2022' => '2022', '2023' => '2023'), '', 'class="form-control select-all" name="filter_tahun"  id="filter_tahun" style="width:100%"'); ?>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="group" class="control-label font-weight-bolder">Pilih OPD</label>
                                            <?php echo form_dropdown('opd_search', isset($data_opd) ? $data_opd : array('' => 'Pilih Data'), $this->input->post('opd_search', TRUE), 'class="form-control select-all" name="opd_search" style="width:100%"'); ?>
                                        </div>
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
                                    <th width="3%" class="font-weight-bold">No</th>
                                    <th width="50%" class="font-weight-bold">Judul</th>
                                    <th width="10%" class="font-weight-bold">Kategori Pelatihan</th>
                                    <th width="7%" class="font-weight-bold">Status</th>
                                    <th width="5%" class="font-weight-bold">Action</th>
                                    <th width="2%" class="font-weight-bold">ID</th>
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
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data Pelatihan</h4>
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
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="id_jadwal" class="control-label font-weight-bolder">Jadwal <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                        <?php echo form_dropdown('id_jadwal', isset($data_jadwal) ? $data_jadwal : array('' => 'Pilih Data'), $this->input->post('id_jadwal', TRUE), 'class="form-control select-all" id="id_jadwal" required="" style="width:100%"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="nm_pelatihan" class="control-label font-weight-bolder">Nama Pelatihan </label>
                                        <input type="text" class="form-control" name="nm_pelatihan" id="nm_pelatihan" placeholder="" value="<?php echo $this->input->post('nm_pelatihan', TRUE); ?>" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="nm_jenis_kegiatan" class="control-label font-weight-bolder">Jenis Pelatihan </label>
                                        <input type="text" class="form-control" name="nm_jenis_kegiatan" id="nm_jenis_kegiatan" placeholder="" value="<?php echo $this->input->post('nm_jenis_kegiatan', TRUE); ?>" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="id_sumber" class="control-label font-weight-bolder">Sumber Dana <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                        <?php echo form_dropdown('id_sumber', isset($sumber_dana) ? $sumber_dana : array('' => 'Pilih Data'), $this->input->post('id_sumber', TRUE), 'class="form-control select-all" id="id_sumber" required="" style="width:100%"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="pagu_anggaran" class="control-label font-weight-bolder">Pagu Anggaran </label>
                                        <input type="text" class="form-control" name="pagu_anggaran" id="pagu_anggaran" placeholder="" value="<?php echo $this->input->post('pagu_anggaran', TRUE); ?>" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="nm_sub_kegiatan" class="control-label font-weight-bolder">Nama Sub Anggaran DPA </label>
                                        <input type="text" class="form-control" name="nm_sub_kegiatan" id="nm_sub_kegiatan" placeholder="" value="<?php echo $this->input->post('nm_sub_kegiatan', TRUE); ?>" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-3 required">
                                        <label for="tanggal_pelatihan" class="control-label font-weight-bolder">Tanggal Pelatihan </label>
                                        <input placeholder="Select date" type="date" id="tanggal_pelatihan" name="tanggal_pelatihan" class="form-control" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="daterange" class="control-label font-weight-bolder">Mulai & Akhir Registrasi </label>
                                        <input type="text" placeholder="Select date" class="form-control" id="daterange" name="daterange" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 required">
                                        <label for="kuota" class="control-label font-weight-bolder">Kuota <span style="margin-top:6px;font-size:12px;" class="text-danger"><small>Wajib Isi</small></span></label>
                                        <input type="number" class="form-control nominal" name="kuota" id="kuota" placeholder="Kuota Pelatihan" value="<?php echo $this->input->post('kuota', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="upload_brosur" class="control-label font-weight-bolder">Upload Brosur</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">File</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload_brosur" name="upload_brosur" aria-describedby="inputGroupFileAddon01" value="<?php echo $this->input->post('upload_brosur', TRUE); ?>">
                                                <label class="custom-file-label" for="foto">Choose file</label>
                                            </div>
                                        </div>
                                        <?php echo form_hidden('fileshow', ''); ?>
                                    </div>

                                </div>


                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12">
                                        <label for="tempat_pelatihan" class="control-label font-weight-bolder">Tempat Pelatihan</label>
                                        <textarea disabled class="form-control" name="tempat_pelatihan" id="tempat_pelatihan" rows="3" placeholder="Alamat Pelatihan"><?php echo $this->input->post('tempat_pelatihan', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="id_metode_pelatihan" class="control-label font-weight-bolder">Metode Pelatihan <span class="text-danger">*</span></label>
                                        <?php echo form_dropdown('id_metode_pelatihan', metode_pel(), $this->input->post('id_metode_pelatihan', TRUE), 'class="form-control select-data" id="id_metode_pelatihan" style="width:100%" required=""'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <label for="groupid" class="control-label col-12 col-md-12 font-weight-bolder">Syarat Pelatihan <span class="text-danger">*</span></label>
                                    <div class="col-12 col-md-12 required">
                                        <?php echo form_multiselect('syarat_id[]', isset($data_syarat) ? $data_syarat : array('' => 'Pilih Data'), $this->input->post('syarat_id[]', TRUE), 'class="form-control select-all" data-placeholder="Pilih Data" required="" style="width:100%;"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <label for="groupid" class="control-label col-12 col-md-12 font-weight-bolder">Syarat Tambahan</label>
                                    <div class="col-12 col-md-11 required">
                                        <?php echo form_multiselect('syarat_dinamis_id[]', isset($data_syarat_dinamis) ? $data_syarat_dinamis : array('' => 'Optional'), $this->input->post('syarat_dinamis_id[]', TRUE), 'class="form-control select-all" data-placeholder="Optional" id="syarat_dinamis_id" required="" style="width:100%;"'); ?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <button type="button" class="btn btn-default waves-effect waves-light px-2 py-1 font-weight-bold" id="btnTambahSyarat"><i class="fas fa-plus-circle"></i></button>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12">
                                        <label for="keterangan" class="control-label font-weight-bolder">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="10" placeholder="Keterangan"><?php echo $this->input->post('keterangan', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="blockquote-footer">
                                        <span>
                                            <b>Note:</b> Pada form keterangan jika pelatihan bisa diikuti oleh disabilitas silahkan diberi keterangan, serta hari dan waktu pelatihan
                                        </span>
                                    </div>
                                </div>

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
        </div>
    </div>
</div>


<div class="modal fade" id="modalViewPelatihan" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <button type="button" class="close btnCloseView" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart(site_url(isset($siteUri) ? $siteUri . '/daftar' : ''), array('id' => 'formDaftarPeserta', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                <?php echo form_hidden('tokenId', ''); ?>
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <div id="errDaftar"></div>
                        <div class="card border-primary mb-12">
                            <div class="card gradient-card">
                                <div class="card-image" style="background-image: url(https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Work/4-col/img%20%2814%29.jpg)">
                                    <a href="#!">
                                        <div class="text-white d-flex h-100 mask blue-gradient-rgba">
                                            <div class="first-content align-self-center p-3">
                                                <h3 class="card-title" id="judul_show">Judul</h3>
                                                <p class="lead mb-0"><i class="fas fa-clock"></i> Registrasi : <strong class="text-warning" id="mulai_registrasi_show"></strong> - <strong class="text-warning" id="akhir_registrasi_show"></strong> &nbsp;&nbsp; <i class="fas fa-users"></i> Kuota : <strong class="text-info" id="kuota_show"></strong></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body white">
                                    <div class="alert alert-primary" role="alert" id="id_metode_pelatihan_show">
                                    </div>
                                    <h4 class="text-uppercase font-weight-bold my-4">Keterangan</h4>
                                    <p class="text-muted" align="justify" id="keterangan_show"></p>

                                    <h4 class="text-uppercase font-weight-bold my-4">Syarat Ketentuan :</h4>
                                    <div class="row" id="tampil"></div>


                                    <div id="syarat_tambahan" style="display:none;">
                                        <h4 class="text-uppercase font-weight-bold my-4">Syarat Tambahan :</h4>
                                        <table class="table table-striped table-bordered table-hover table-sm" cellspacing="0" id="tblSyaratPeserta" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="font-weight-bold text-center">#</th>
                                                    <th class="font-weight-bold">Syarat</th>
                                                    <th class="font-weight-bold">Upload</th>
                                                    <th class="font-weight-bold">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="blockquote-footer">
                                            <span>
                                                <b>Note:</b> <strong class="text-danger"><b>Format file harus pdf</b></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <br>
                                    <li class="list-group-item">
                                        <div class="md-v-line"></div><i class="fas fa-map-marker-alt mr-4 pr-3"> Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <a id="alamat_show"></a></i>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="md-v-line"></div><i class="fas fa-clock mr-5"> Jadwal Pelatihan : <a id="jadwal_pelatihan_show"></a></i>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php echo form_hidden('tokenView', ''); ?>
            <?php echo form_hidden('pelatihanId', ''); ?>
            <?php echo form_hidden('statusId', ''); ?>
            <div class="alert alert-danger hide" role="alert" id="pemberitahuan">
                Tombol daftar aktif apabila semua persyaratan telah dipenuhi oleh peserta, silahkan update data usaha anda. <a href="<?php echo base_url('home/profile'); ?>" class="alert-link">klik disini</a>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold btnDaftar" name="save" id="daftar"><i class="fas fa-check-circle"></i> Daftar</button>
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 mx-0 font-weight-bold btnCloseView"><i class="fas fa-times"></i> Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalListPesertaPelatihan" tabindex="-1" role="dialog" aria-labelledby="modalListPesertaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" id="frmListPeserta">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-list"></i> List Pendaftar</h4>
                <button type="button" class="close btnCloseListPeserta" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <div class="float-right" style="display: none;" id="eventList">
                            <button class="btn btn-danger waves-effect waves-light px-3 py-2 mx-0 font-weight-bold" type="button" id="btnTolakPeserta" disabled=""><i class="fas fa-window-close"></i> Tolak</button>
                            <button class="btn btn-info waves-effect waves-light px-3 py-2 mx-0 font-weight-bold" type="button" id="btnTerimaPeserta" disabled=""><i class="fas fa-check"></i> Terima</button>
                            <button class="btn btn-orange waves-effect waves-light px-3 py-2 mx-0 font-weight-bold" type="button" id="btnSelesaiPelatihan" disabled=""><i class="fas fa-graduation-cap"></i> Lulus/Selesai</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div id="errList"></div>
                    </div>
                    <div class="col-12 col-md-12 clearfix mb-3" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Form Entry Rules </span></h5>
                                <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/list-pendaftar' : ''), array('id' => 'formViews', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                                <?php echo form_hidden('tokenPelatihan', ''); ?>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive-md">
                    <h5 class="heading font-weight-bold"><i class="fas fa-list"></i> Daftar Peserta <span class="lblMod"></span></h5>
                    <table cellspacing="0" class="table table-striped table-borderless table-hover table-sm" id="tblListPendaftar" width="100%">
                        <thead>
                            <tr>
                                <th width="2%" class="text-center">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th width="3%" class="font-weight-bold text-center">No.</th>
                                <th class="font-weight-bold">NIK</th>
                                <th class="font-weight-bold text-left">Nama Lengkap</th>
                                <th class="font-weight-bold text-left">Provinsi</th>
                                <th class="font-weight-bold text-left">Kab/Kota</th>
                                <th class="font-weight-bold text-center">Status</th>
                                <th class="font-weight-bold text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 mx-0 font-weight-bold btnCloseListPeserta"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Syarat Tambahan -->
<div class="modal fade" id="modalListSyaratTambahan" tabindex="-1" role="dialog" aria-labelledby="modalListSyaratTambahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmSyarat">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-list-alt"></i> Data Syarat Tambahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div id="errSyaratT"></div>
                    </div>
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="heading font-weight-bolder mb-3"><i class="fas fa-pencil-alt"></i> Form Syarat Tambahan</h5>
                                <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/add-syarat' : ''), array('id' => 'formSyaratTambahan', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                                <div class="form-row mb-3 ">
                                    <div class="col-12 col-md-9 required">
                                        <label for="nm_syarat_dinamis" class="control-label font-weight-bolder">Syarat Tambahan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nm_syarat_dinamis" id="nm_syarat_dinamis" placeholder="Nama Syarat Tambahan" value="<?php echo $this->input->post('nm_syarat_dinamis', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-3 my-4 pt-1">
                                        <label for=""></label>
                                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light px-3" id="saveSyarat" name="saveSyarat"><i class="fas fa-check"></i> Submit</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-sm" cellspacing="0" id="tblSyaratTambahan" width="100%">
                    <thead>
                        <tr>
                            <th width="5%" class="font-weight-bold text-center">#</th>
                            <th class="font-weight-bold">Nama Syarat</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 mx-0 font-weight-bold btnCloseSyaratTambahan" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Syarat Tambahan -->
<div class="modal fade" id="modalProfilePesertaPelatihan" tabindex="-1" role="dialog" aria-labelledby="modalProfilePesertaPelatihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmSyarat">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-list-alt"></i> Data Peserta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div id="errSyaratT"></div>
                    </div>
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <div class="card-up indigo lighten-1"></div>
                        <div style="text-align:center;" class="avatar mx-auto white">
                            <img id="imagesPeserta" class="rounded-circle img" style="width:200px" alt="woman avatar">
                        </div>
                        <!-- <div class="card-body">
                            <h4 style="text-align:center;" class="card-title"><strong id="namaPeserta">Alison Belmont</strong></h4>
                        </div> -->
                    </div>
                </div>

                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne1">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                <h5 class="mb-0">
                                    Data Pribadi <i class="fas fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                            <div class="card-body">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="30%">NIK</td>
                                            <td>: <strong id="nikpeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Peserta</td>
                                            <td>: <strong id="namaPeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tempat / Tgl lahir</td>
                                            <td>: <strong id="tempatLhr"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat KTP</td>
                                            <td>: <strong id="alamatPeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>: <strong id="genderPeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan</td>
                                            <td>: <strong id="studyPeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Agama</td>
                                            <td>: <strong id="agamaPeserta"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Pekerjaan</td>
                                            <td>: <strong id="pekerjaanPeserta"></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- <div class="card" style="display:none;" id="field_usaha">
                        <div class="card-header" role="tab" id="headingTwo2">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                                <h5 class="mb-0">
                                    Data Usaha <i class="fas fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>
                        <div id="collapseTwo2" class="collapse show" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                            <div class="card-body">
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="30%">Nama Pemilik</td>
                                            <td>: <strong id="nmPemilik"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Usaha</td>
                                            <td>: <strong id="nmUsaha"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat Usaha</td>
                                            <td>: <strong id="alamatUsaha"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>No Telp</td>
                                            <td>: <strong id="telpUsaha"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>WhatsApp</td>
                                            <td>: <strong id="waUsaha"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Bidang Usaha</td>
                                            <td>: <strong id="bidangUsaha"></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Usaha</td>
                                            <td>: <strong id="jenisUsaha"></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="card">
                        <div class="card-header" role="tab" id="headingThree3">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
                            aria-expanded="false" aria-controls="collapseThree3">
                            <h5 class="mb-0">
                                Collapsible Group Item #3 <i class="fas fa-angle-down rotate-icon"></i>
                            </h5>
                            </a>
                        </div>
                        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                            <div class="card-body">
                            
                            </div>
                        </div>
                    </div> -->
                </div>
                <br>
                <table class="table table-striped table-bordered table-hover table-sm" style="display:none;" cellspacing="0" id="tblViewSyarat" width="100%">
                    <thead>
                        <tr>
                            <th width="5%" class="font-weight-bold text-center">#</th>
                            <th width="5%" class="font-weight-bold">Nama Syarat</th>
                            <th width="5%" class="font-weight-bold text-center">Status</th>
                            <th width="15%" class="font-weight-bold text-center">File</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/list-pendaftar' : ''), array('id' => 'formViews', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                <?php echo form_hidden('tokenPeserta', ''); ?>
                <?php echo form_close(); ?>
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 mx-0 font-weight-bold btnCloseDetailPeserta" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLihatBerkas" tabindex="-1" role="dialog" aria-labelledby="modalLihatBerkasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmSyarat">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-list-alt"></i> Berkas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe style="width:100%;height:500px;" class="embed-responsive-item" id="frameShow" src="" allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 mx-0 font-weight-bold btnCloseFile" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry1">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Import</h4>
                <button type="button" class="close btnCloseImport" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/import_excel' : ''), array('id' => 'formEntryImport', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
            <div class="modal-body">
                <div id="errEntry1"></div>
                <?= form_hidden('id_pelatihan'); ?>
                <?= form_hidden('id_opd'); ?>
                <?= form_hidden('regis'); ?>
                <div class="bg-light p-1 mt-3 mb-3">
                    <h4 class="text-center"><i><b>Import Data Peserta</b></i></h4>
                </div>
                <div class="p-3 mb-3">
                    <h4 class="text-center" id="pelatihan_name_to_import">Minang deng lakang kinang suang, minang suang lakang kinang neng</h4>
                    <br>
                    <p class="text-center" id="pelatihan_schedule_to_import">JV Jarvis</p>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-12">
                        <label for="file_name" class="control-label font-weight-bolder">Import File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file_name" id="file_name" placeholder="Import File" value="<?php echo $this->input->post('file_name', TRUE); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#modalImport').modal('hide');" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnCloseImport"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="importNow" id="importNow"><i class="fas fa-check"></i> Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modalImportResult" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry1">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Hasil Import Data</h4>
                <button type="button" class="close" aria-label="Close" onclick="$('#modalImportResult').modal('toggle');">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="errEntry1"></div>
                <div class="bg-light p-1 mt-3 mb-3">
                    <h4 class="text-center"><i><b>Hasil Import Data Peserta</b></i></h4>
                </div>
                <div class="p-3 mb-3">
                    <h4 class="text-center" id="pelatihan_name_to_import_result">Minang deng lakang kinang suang, minang suang lakang kinang neng</h4>
                    <br>
                    <p class="text-center" id="pelatihan_schedule_to_import_result">JV Jarvis</p>
                </div>
                <div class="mb-3 table-responsive">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Peserta</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="importResultTable">
                            <tr>
                                <td colspan="4" class="text-center">No Data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#modalImportResult').modal('toggle');" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold"><i class="fas fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" onclick="$('#modalImportResult').modal('toggle');"><i class="fas fa-check"></i> Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->