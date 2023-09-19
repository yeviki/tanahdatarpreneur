<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data Jadwal
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                        <button type="button" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                    </div>
                </div>
                <div class="card-body mb-0">
                    <div class="table-responsive-md">
                        <table cellspacing="0" class="table table-striped table-borderless table-hover table-sm" id="tblList" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%" class="font-weight-bold">#</th>
                                    <th class="font-weight-bold">Nama Pelatihan</th>
                                    <th class="font-weight-bold">Tanggal Pelatihan</th>
                                    <th class="font-weight-bold">Registrasi</th>
                                    <th class="font-weight-bold">Pagu Anggaran</th>
                                    <th class="font-weight-bold">Sub Kegiatan DPA</th>
                                    <th class="font-weight-bold">ID</th>
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
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data Master Pelatihan</h4>
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
                                    <div class="col-12 col-md-8 required">
                                        <label for="id_master_pelatihan" class="control-label font-weight-bolder">Pelatihan <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_master_pelatihan', isset($data_pelatihan) ? $data_pelatihan : array(''=>'Pilih Data'), $this->input->post('id_master_pelatihan', TRUE), 'class="form-control select-all" id="id_master_pelatihan" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-4 required">
                                        <label for="id_jenis_kegiatan" class="control-label font-weight-bolder">Jenis Kegiatan <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('id_jenis_kegiatan', isset($data_jenkeg) ? $data_jenkeg : array(''=>'Pilih Data'), $this->input->post('id_jenis_kegiatan', TRUE), 'class="form-control select-all" id="id_jenis_kegiatan" required="" style="width:100%"');?>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-4 required">
                                        <label for="nm_pelatihan" class="control-label font-weight-bolder">Mulai & Akhir Registrasi <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Select date" class="form-control" id="daterange" name="daterange" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12 col-md-4 required">
                                        <label for="nm_pelatihan" class="control-label font-weight-bolder">Mulai & Akhir Pelatihan <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Select date" class="form-control" id="daterange1" name="daterange1" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-6 required">
                                        <label for="pagu_anggaran" class="control-label font-weight-bolder">Pagu Anggaran <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pagu_anggaran" id="pagu_anggaran" placeholder="Pagu Anggaran Pelatihan" value="<?php echo $this->input->post('pagu_anggaran', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6 required">
                                        <label for="nm_sub_kegiatan" class="control-label font-weight-bolder">Nama Sub Kegiatan DPA <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nm_sub_kegiatan" id="nm_sub_kegiatan" placeholder="Sub Kegiatan" value="<?php echo $this->input->post('nm_sub_kegiatan', TRUE); ?>" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-12">
                                        <label for="tempat_pelatihan" class="control-label font-weight-bolder">Tempat Pelatihan</label>
                                        <textarea class="form-control" name="tempat_pelatihan" id="tempat_pelatihan" rows="3" placeholder="Alamat Pelatihan"><?php echo $this->input->post('tempat_pelatihan', TRUE); ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-12 col-md-3 required">
                                        <label for="status" class="control-label font-weight-bolder">Status <span class="text-danger">*</span></label>
                                        <?php echo form_dropdown('status', status(), $this->input->post('status', TRUE), 'class="form-control select-data" id="status" style="width:100%" required=""');?>
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