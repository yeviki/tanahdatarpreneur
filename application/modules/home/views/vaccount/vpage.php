<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card p-3 shadow-lg rounded">
                <div class="card-body mb-0">
                    <div class="row">
                        <div class="ol-12 col-sm-6 col-lg-5">
                            <img style="width: 100%; height: 100%;" src="<?php echo site_url('assets/img/aut.png') ?>" alt="" class="img-fluid mb-5">
                        </div>
                        <div class="col-6 col-lg-7" style="margin-top : 80px">
                            <?php echo form_open(site_url(isset($siteUri) ? $siteUri . '/update' : ''), array('id' => 'formEntry', 'class=' => 'needs-validated', 'novalidate' => '')); ?>
                            <div id="errEntry"></div>
                            <div class="form-group">
                                <label for="password" class="control-label font-weight-bolder">Password Lama<span class="lblPass text-danger">*</span></label>
                                <div class="input-group required">
                                    <input type="password" style="border-radius: 20px;" class="form-control" name="oldpass" id="passwordlama" placeholder="Password" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label font-weight-bolder">Password <span class="grey-text" style="font-size: 80%;">(min 8 karakter)</span><span class="lblPass text-danger">*</span></label>
                                <div class="input-group required">
                                    <input type="password" style="border-radius: 20px;" class="form-control" name="newpass" id="passwordbaru" placeholder="Password" required>

                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="conf_password" class="control-label font-weight-bolder">Konfirmasi Password <span class="lblPass text-danger">*</span></label>
                                <div class="input-group required">
                                    <input type="password" style="border-radius: 20px;" class="form-control" name="confpass" id="conf_password" placeholder="Konfirmasi Password" required>

                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="valid-password mt-1" style="font-size:80%;"></div>
                            </div>
                            <button style="border-radius: 20px;" type="submit" class="btn btn-primary mx-auto d-block waves-effect waves-light  font-weight-bold" name="save" id="save"><i class="fas fa-check"></i> Submit</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>