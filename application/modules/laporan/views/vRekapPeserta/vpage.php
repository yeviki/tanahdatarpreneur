<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        Rekap Data Total Peserta Per Kabupaten/Kota
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                    </div>
                </div>

                <!-- <div class="col-12 col-mb-12 mb-2">
                    <?php //echo form_open(site_url('#'), array('id' => 'formFilter', 'style' => 'display:;')); ?>
                    <div class="card rgba-grey-slight">
                        <div class="card-body">
                            <div class="form-row mb-3 ">
                                <div class="col-12 col-md-1">
                                    <label for="tahun" class="control-label font-weight-bolder">Tahun</label>
                                    <?php //echo form_dropdown('filter_tahun', array('' => 'Pilih Tahun', '2021' => '2021', '2022' => '2022', '2023' => '2023'), date('Y'), 'class="form-control select-all" name="filter_tahun"  id="filter_tahun" style="width:100%"'); ?>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="group" class="control-label font-weight-bolder">Pilih Kabupaten/Kota</label>
                                    <?php //echo form_dropdown('regency_search', isset($data_regency) ? $data_regency : array('' => 'Pilih Data'), $this->input->post('regency_search', TRUE), 'class="form-control select-all" name="regency_search" style="width:100%"'); ?>
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="tahun" class="control-label font-weight-bolder">Pilih Opsi</label>
                                    <?php //echo form_dropdown('filter_opsi', array('' => 'Pilih Opsi', '1' => 'Rekap Pelatihan', '2' => 'Rekap Peserta'), $this->input->post('filter_opsi', TRUE), 'class="form-control select-all" name="filter_opsi"  id="filter_opsi" style="width:100%"'); ?>
                                </div>

                                <div class="d-flex justify-content-lg-start align-items-center" style="margin-top: 27px;">
                                    <button type="button" class="btn btn-primary waves-effect waves-light px-3 py-2 font-weight-bold" name="cetak" id="cetak"><i class="fas fa-print"></i> Cetak</button>
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="total_peserta" class="control-label font-weight-bolder">Total Seluruh Peserta</label>
                                    <?php
                                    //echo '<input type="text" class="form-control" name="total_peserta" id="total_peserta" readonly placeholder="Total Peserta" value="' . $tot_peserta . '">';
                                    ?>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div> -->
                <div class="card-body mb-0">
                    <div class="table-responsive-md">
                        <table cellspacing="0" class="table table-striped table-borderless table-hover table-sm" id="tblList" width="100%">
                            <thead id="tabelKepala">
                                <?= $tabelKepala ?>
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
            <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/create' : ''), array('id' => 'formEntry', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
            <div class="modal-body">
                <div id="errEntry"></div>
                <?php echo form_hidden('tokenId', ''); ?>
                <div class="form-row mb-3">
                    <div class="col-12 col-md-6 required">
                        <label for="nm_pelatihan" class="control-label font-weight-bolder">Nama Pelatihan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nm_pelatihan" id="nm_pelatihan" placeholder="Nama Pelatihan" value="<?php echo $this->input->post('nm_pelatihan', TRUE); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6 required">
                        <label for="id_kat_urusan" class="control-label font-weight-bolder">Kategori Urusan Pemerintah <span class="text-danger">*</span></label>
                        <?php echo form_dropdown('id_kat_urusan', isset($data_urusan) ? $data_urusan : array('' => 'Pilih Data'), $this->input->post('id_kat_urusan', TRUE), 'class="form-control select-all" id="id_kat_urusan" required="" style="width:100%"'); ?>
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