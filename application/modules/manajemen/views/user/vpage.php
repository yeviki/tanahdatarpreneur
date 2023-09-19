<section class="mb-5 pb-4 mt-4">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="errSuccess"></div>
    <div class="row" id="formParent">
        <div class="col-xl-12 col-md-12 mb-xl-0 mb-4">
            <div class="card card-cascade narrower z-depth-1">
                <div class="view view-cascade gradient-card-header blue-gradient-rgba narrower py-1 mx-4 d-flex justify-content-between align-items-center">
                    <h5 class="white-text font-weight-normal mt-2">
                        <i class="fas fa-table"></i>
                        List Data User
                    </h5>
                    <div class="clearfix">
                        <a type="button" href="<?php echo site_url(isset($siteUri) ? $siteUri : '#'); ?>" class="btn btn-white btn-rounded waves-effect waves-light px-3 py-2 font-weight-bold" name="button"><i class="fas fa-sync-alt"></i> Refresh Data</a>
                        <button type="button" class="btn btn-success waves-effect waves-light px-3 py-2 font-weight-bold" id="btnAdd"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light px-3 py-2 font-weight-bold" id="btnDelete" style="display:none;"><i class="fa fa-trash-alt"></i> Delete User</button>
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
                            <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:none;')); ?>
                            <div class="card rgba-grey-slight">
                                <div class="card-body">
                                    <div class="form-row mb-3 ">
                                        <div class="col-12 col-md-3">
                                            <label for="fullname" class="control-label font-weight-bolder">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="fullname" placeholder="Nama Lengkap" value="<?php echo $this->input->post('fullname', TRUE); ?>">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="username" class="control-label font-weight-bolder">Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $this->input->post('username', TRUE); ?>">
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="group" class="control-label font-weight-bolder">Group User</label>
                                            <?php echo form_dropdown('group', isset($group_user) ? $group_user : array(''=>'Pilih Group User'), $this->input->post('group', TRUE), 'class="form-control select-all" style="width:100%"');?>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="blokir" class="control-label font-weight-bolder">Blokir</label>
                                            <?php echo form_dropdown('blokir', array(''=>'Pilih Data', 1=>'Blokir', 0=>'Tidak Blokir'), $this->input->post('blokir', TRUE), 'class="form-control select-all" style="width:100%"');?>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="status" class="control-label font-weight-bolder">Status</label>
                                            <?php echo form_dropdown('status', array(''=>'Pilih Status', 1=>'Aktif', 0=>'Tidak Aktif'), $this->input->post('status', TRUE), 'class="form-control select-all" style="width:100%"');?>
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
                                    <th width="3%">
                                        <div class="custom-control custom-checkbox mt-0 pt-0">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label font-weight-bolder" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th width="3%" class="font-weight-bold">#</th>
                                    <th width="30%" class="font-weight-bold">Pengguna</th>
                                    <th width="10%" class="font-weight-bold">Group</th>
                                    <th width="20%" class="font-weight-bold">Instansi</th>
                                    <th width="6%" class="font-weight-bold">Blokir</th>
                                    <th width="10%" class="font-weight-bold">Status</th>
                                    <th width="3%" class="font-weight-bold">Edit</th>
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
                <h4 class="modal-title heading lead white-text font-weight-bold"><i class="fas fa-edit"></i> Form Entri Data User</h4>
                <button type="button" class="close btnClose" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <?php echo form_open(site_url(isset($siteUri) ? $siteUri.'/create' : ''), array('id' => 'formEntry', 'class='=>'needs-validated', 'novalidate'=>'')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 clearfix mb-3">
                        <div class="card rgba-grey-slight">
                            <div class="card-body">
                                    <div id="errEntry"></div>
                                    <?php echo form_hidden('tokenId', ''); ?>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6 required">
                                            <label for="fullname" class="control-label font-weight-bolder">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nama Lengkap" value="<?php echo $this->input->post('fullname', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-6 required">
                                            <label for="username" class="control-label font-weight-bolder">Username <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $this->input->post('username', TRUE); ?>" required>
                                            <div class="invalid-feedback"></div>
                                            <div class="valid-username mt-1" style="font-size:80%;"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="password" class="control-label font-weight-bolder">Password <span class="grey-text" style="font-size: 80%;">(min 8 karakter)</span><span class="lblPass text-danger">*</span></label>
                                            <div class="input-group required">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $this->input->post('password', TRUE); ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="conf_password" class="control-label font-weight-bolder">Konfirmasi Password <span class="lblPass text-danger">*</span></label>
                                            <div class="input-group required">
                                                <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="<?php echo $this->input->post('conf_password', TRUE); ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text showPass"><i class="fa fa-eye"></i></span>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="valid-password mt-1" style="font-size:80%;"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <label for="groupid" class="control-label col-12 col-md-12 font-weight-bolder">Group User <span class="text-danger">*</span></label>
                                        <div class="col-12 col-md-12">
                                            <div class="row">
                                                <?php foreach ((isset($data_group) ? $data_group : array()) as $key => $dg) {
                                                    echo '<div class="col-4">';
                                                        echo '<div class="custom-control custom-checkbox required">';
                                                            echo '<input type="checkbox" class="custom-control-input" name="groupid[]" id="groupid_'.$dg['id_group'].'" value="'.$dg['id_group'].'" '.set_checkbox('groupid[]', $dg['id_group']).' required>';
                                                            echo '<label class="custom-control-label" for="groupid_'.$dg['id_group'].'">'.$dg['nama_group'].'</label>';
                                                            echo '<div class="invalid-feedback"></div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-12 required">
                                            <label for="id_opd" class="control-label font-weight-bolder">Instansi <span class="text-danger">*</span></label>
                                                <?php echo form_dropdown('id_opd', isset($opd_option) ? $opd_option : array(''=>'Pilih Data'), $this->input->post('id_opd', TRUE), 'class="form-control select-all" id="id_opd" required="" style="width:100%"');?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-12 col-md-4 required">
                                            <label for="blokir" class="control-label font-weight-bolder">Blokir <span class="text-danger">*</span></label>
                                            <?php echo form_dropdown('blokir', blokir(), $this->input->post('blokir', TRUE), 'class="form-control select-data" id="blokir" style="width:100%" required=""');?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 col-md-4 required">
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
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
