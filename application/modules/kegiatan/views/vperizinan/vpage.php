<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data Perizinan
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                        <button type="button" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        <button type="button" class="btn btn-warning waves-effect waves-light px-3 py-2 font-weight-bold" id="btnImport"><i class="fas fa-plus-circle"></i> Import Excel</button>
                    </div>
                </div>
                <div class="card-body mb-0">
                    <div class="table-responsive-md">
                        <table cellspacing="0" class="table table-striped table-borderless table-hover table-sm" id="tblList" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%" class="font-weight-bold">#</th>
                                    <th class="font-weight-bold">NIK</th>
                                    <th class="font-weight-bold">NIB</th>
                                    <th class="font-weight-bold">Nama</th>
                                    <th class="font-weight-bold">NPWP</th>
                                    <th class="font-weight-bold">Pelatihan</th>
                                    <th width="7%" class="font-weight-bold">Action</th>
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
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data Perizinan</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <?php echo form_open(site_url(isset($siteUri) ? $siteUri.'/create' : ''), array('id' => 'formEntry', 'class='=>'needs-validated', 'novalidate'=>'')); ?>
                        <div id="errEntry"></div>
                        <?php echo form_hidden('tokenId', ''); ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="nik" class="control-label font-weight-bolder">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control nominal" name="nik" id="nik" placeholder="NIK" value="<?php echo $this->input->post('nik', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="no_nib" class="control-label font-weight-bolder">NIB <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control nominal" name="no_nib" id="no_nib" placeholder="NIB" value="<?php echo $this->input->post('no_nib', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>  
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="id_jenis_kegiatan" class="control-label font-weight-bolder">Jenis Kegiatan<span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_jenis_kegiatan', isset($data_kat) ? $data_kat : array(''=>'Pilih Data'), $this->input->post('id_jenis_kegiatan', TRUE), 'class="form-control select-all" id="id_jenis_kegiatan" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="nama" class="control-label font-weight-bolder">Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $this->input->post('nama', TRUE); ?>" required>
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
                                    <div class="col-12 col-md-6 required">
                                        <label for="alamat" class="control-label font-weight-bolder">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $this->input->post('alamat', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="no_hp" class="control-label font-weight-bolder">No HP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control nominal" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $this->input->post('no_hp', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="npwp" class="control-label font-weight-bolder">NPWP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control nominal" name="npwp" id="npwp" placeholder="No NPWP" value="<?php echo $this->input->post('npwp', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="email" class="control-label font-weight-bolder">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $this->input->post('email', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12 required">
                                        <label for="id_pelatihan" class="control-label font-weight-bolder">Pelatihan <span style="margin-top:6px;font-size:10px;" class="text-danger">Wajib Diisi Jika Perizinan Berkaitan Dengan Pelatihan Yang Dilakukan</span></label>
                                        <?php echo form_dropdown('id_pelatihan', isset($data_pelatihan) ? $data_pelatihan : array(''=>'Pilih Data'), $this->input->post('id_pelatihan', TRUE), 'class="form-control select-all" id="id_pelatihan" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
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

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" id="frmEntry1">
        <div class="modal-content">
            <div class="modal-header aqua-gradient-rgba">
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Import</h4>
                <button type="button" class="close btnCloseImport" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/import_excel' : ''), array('id' => 'formEntryImport', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                <div id="errEntry1"></div>
                <?php echo form_hidden('tokenId', ''); ?>
                <div class="bg-light p-1 mt-3 mb-3">
                    <h4 class="text-center"><i><b>Import Data Perizinan</b></i></h4>
                </div>
                <p class="text-justify">Upload data sesuai dengan template file yang telah ditentukan, tanpa merubah dan memodifikasi judul dan format template. Format file bisa didownload dibawah ini <br>
                    <a class="btn purple-gradient btn-sm" href="<?= base_url('/repository/import_data_perizinan.xlsx') ?>" title="Download Format Excel Import data" style="margin:.375rem 0"><i class="fas fa-file-download"></i> Format file excel</a>
                </p>
                <p class="note note-primary mt-3">
                    <span><b> Petunjuk Upload :</b>
                        Silahkan Pilih Pelatihan Jika Perizinan Diterbitkan Pada Saat Pelatihan Dilakukan.. </a>
                    </span>
                </p>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-12 required">
                        <label for="id_pelatihan_import" class="control-label font-weight-bolder">Pelatihan <span style="margin-top:6px;font-size:10px;" class="text-danger">Wajib Diisi Jika Perizinan Berkaitan Dengan Pelatihan Yang Dilakukan</span></label>
                        <?php echo form_dropdown('id_pelatihan_import', isset($data_pelatihan) ? $data_pelatihan : array(''=>'Pilih Data'), $this->input->post('id_pelatihan_import', TRUE), 'class="form-control select-all" id="id_pelatihan_import" required="" style="width:100%"');?>
                        <div class="invalid-feedback"></div>
                    </div>
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
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnCloseImport"><i class="fas fa-times"></i> Close</button>
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
                    <h4 class="text-center"><i><b>Hasil Import Data Perizinan</b></i></h4>
                </div>
                <!-- <div class="p-3 mb-3">
                    <h4 class="text-center" id="pelatihan_name_to_import_result">Minang deng lakang kinang suang, minang suang lakang kinang neng</h4>
                    <br>
                    <p class="text-center" id="pelatihan_schedule_to_import_result">JV Jarvis</p>
                </div> -->
                <div class="mb-3 table-responsive">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama</th>
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
                <!-- <button type="button" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" onclick="$('#modalImportResult').modal('toggle');"><i class="fas fa-check"></i>Ok</button> -->
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnCloseDetail"><i class="fas fa-times"></i> OK</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->