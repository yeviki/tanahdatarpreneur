<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data Berita
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
                                    <th class="font-weight-bold">Judul Berita</th>
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
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data Berita</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open(site_url(isset($siteUri) ? $siteUri.'/create' : ''), array('id' => 'formEntry', 'class='=>'needs-validated', 'novalidate'=>'')); ?>
                <?php echo form_hidden('tokenId', ''); ?>
                <div id="errEntry"></div>
                
                <div class="form-row mb-3">
                    <div class="col-12 col-md-6 required">
                        <label for="judul_berita" class="control-label font-weight-bolder">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_berita" id="judul_berita" placeholder="Judul Berita" value="<?php echo $this->input->post('judul_berita', TRUE); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6 required">
                        <label for="id_pelatihan" class="control-label font-weight-bolder">Pelatihan <span class="text-danger">*</span></label>
                            <?php echo form_dropdown('id_pelatihan', isset($data_pelatihan) ? $data_pelatihan : array(''=>'Pilih Data'), $this->input->post('id_pelatihan', TRUE), 'class="form-control select-all" id="id_pelatihan" required="" style="width:100%"');?>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-6 required">
                        <label for="file_foto" class="control-label font-weight-bolder">Upload Foto</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">File</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_foto" name="file_foto" aria-describedby="inputGroupFileAddon01" value="<?php echo $this->input->post('file_foto', TRUE); ?>">
                                <label class="custom-file-label" for="foto">Choose file</label>
                            </div>
                        </div>
                        <?php echo form_hidden('fileshow', ''); ?>
                    </div>
                    <div class="col-12 col-md-3 required">
                        <label for="kuota" class="control-label font-weight-bolder">Kuota Pelatihan</label>
                        <input type="text" class="form-control" name="kuota" id="kuota" placeholder="" value="<?php echo $this->input->post('kuota', TRUE); ?>" disabled>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-3 required">
                        <label for="link_youtube" class="control-label font-weight-bolder">Url Youtube </label>
                        <input type="text" class="form-control" name="link_youtube" id="link_youtube" placeholder="Url" value="<?php echo $this->input->post('link_youtube', TRUE); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-12 required">
                        <small>
                            <span><b> Catatan :</b>
                            Url Youtube : https://www.youtube.com/watch?v=<span class="text-danger"><b>xxxxxxx</b></span> cukup copy link yang di bold merah saja
                            </span>
                        </small>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-12">
                        <label for="keterangan" class="control-label font-weight-bolder">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="10" placeholder="Keterangan"><?php echo $this->input->post('keterangan', TRUE); ?></textarea>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey waves-effect waves-light px-3 py-2 font-weight-bold btnClose"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="save" id="save"><i class="fas fa-check"></i> Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>