<nav class="navbar fixed-top navbar-dark primary-color double-nav top-nav-collapse">
    <div class="navbar-left">
        <button class="btn btn-title btn-sidebar-toggler" type="button">
            <span class="bar"></span>
        </button>
        <a class="navbar-brand pl-2" href="<?= site_url('home') ?>">
            <?= isset($app_name) ? $app_name : ''; ?>
        </a>
    </div>
    <ul class="navbar-nav ml-auto nav-flex-icons">
        <!-- <li class="nav-item dropdown">
            <a class="nav-link nav-link-lg message-toggle beep waves-effect waves-light" data-toggle="dropdown" aria-expanded="false" id="navbarMessage">
                <i class="far fa-envelope"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-lg-right" aria-labelledby="navbarMessage">
                <div class="dropdown-header">
                    Messages
                    <a href="#">Mark All As Read</a>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle"
                                 alt="avatar image">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello, Bro!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle"
                                 alt="avatar image">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Dedik Sugiharto</b>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle"
                                 alt="avatar image">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Agung Ardiansyah</b>
                            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle"
                                 alt="avatar image">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Ardian Rahardiansyah</b>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                            <div class="time">16 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle"
                                 alt="avatar image">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Alfa Zulkarnain</b>
                            <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> -->
        <!-- <li class="nav-item dropdown">
            <a class="nav-link nav-link-lg notification-toggle beep waves-effect waves-light" data-toggle="dropdown" aria-expanded="false" id="navbarNotification">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" aria-labelledby="navbarNotification">
                <div class="dropdown-header">
                    Notifications
                    <a href="#">Mark All As Read</a>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-success text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Low disk space. Let's clean it!
                            <div class="time">17 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Welcome to Stisla template!
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> -->
        <li class="nav-item dropdown">
            <a class="nav-link nav-link-lg dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false" id="navbarMenuLink">
                <?php echo $this->asset->image('avatar/' . fotoUser(currentFotoUser()), '', array('class' => 'rounded-circle z-depth-0 mr-1', 'height' => '35', 'alt' => 'Foto User')); ?>
                <div class="d-flex d-inline-flex">Hi, <?php echo $this->app_loader->current_name(); ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarMenuLink">
                <div class="dropdown-title">Wellcome</div>
                <!-- <a href="" class="dropdown-item has-icon" data-toggle="modal" data-target="#modalLoginAvatar">
                    Profile
                    <i class="far fa-user"></i>
                </a> -->
                <?php
                if ($this->app_loader->is_peserta()) {
                    echo '<a href="' . site_url('home/profile') . '" class="dropdown-item has-icon">
                            Profile
                            <i class="fas fa-user"></i>';
                    echo '</a>';
                    // echo '<a href="'.site_url('home/history').'" class="dropdown-item has-icon">
                    //     History Pelatihan
                    //     <i class="fas fa-bolt"></i>';
                    // echo '</a>';
                }
                ?>
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#sideModalTR">
                    Konsultasi
                    <i class="fas fa-phone-square-alt"></i>
                </a>
                <a href="<?php echo site_url('home/account'); ?>" class="dropdown-item has-icon">
                    Ubah Password
                    <i class="fas fa-cog"></i>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('auth/signin/logout'); ?>" class="dropdown-item has-icon text-danger">
                    Logout
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Modal: modalPoll -->
<div class="modal fade right" id="sideModalTR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="heading lead">Konsultasi
                </p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <!-- <i class="far fa-file-alt fa-4x mb-3 animated rotateIn"></i> -->
                    <img style="height:100%; width:72%" src="<?php echo base_url('assets/img/konsultasi.svg') ?>">
                    <p>
                        <strong>Selamat Datang di Menu Konsultasi</strong>
                    </p>
                    <p>Apa yang ingin anda tanyakan..?
                        <br><strong>Silahkan klik salah satu opsi dibawah ini, jika ingin konsultasi seputar usaha/umkm..</strong>
                    </p>
                </div>

                <hr>

                <p class="text-center">
                    <strong>Kontak Konsultan Kami</strong>
                </p>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6281268134782" target="_blank">Kelembagaan</a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6285376723685" target="_blank">Produksi</a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6282373705720" target="_blank">SDM</a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6281276518826" target="_blank">Pembiayaan</a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span>Pemasaran
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6281276518826" target="_blank">Kerjasama</a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-phone-square-alt"></i></span><a href="https://api.whatsapp.com/send?phone=6285264028891" target="_blank">Fasilitas IT</a>
                    </li>
                </ul>

                <p class="text-center">
                    <strong>Terima Kasih..</strong>
                </p>

                <!-- <div class="md-form">
          <textarea type="text" id="form79textarea" class="md-textarea form-control" rows="3"></textarea>
          <label for="form79textarea">Your message</label>
        </div> -->

            </div>

            <!-- <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-primary waves-effect waves-light">Send
          <i class="fa fa-paper-plane ml-1"></i>
        </a>
        <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
      </div> -->
        </div>
    </div>
</div>
<!-- Modal: modalPoll -->

<!-- To change the direction of the modal animation change .right class -->
<!-- <div class="modal fade right" id="sideModalTR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side modal-top-right" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Kontak Person Konsultasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="fa-ul">
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6281268134782" target="_blank">Kelembagaan</a></li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6285376723685" target="_blank">Produksi</a></li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6282373705720" target="_blank">SDM</a></li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6281276518826" target="_blank">Pembiayaan</a></li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span>Pemasaran</li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6281276518826" target="_blank">Kerjasama</a></li>
            <li><span class="fa-li"><i class="fas fa-user-graduate"></i></span><a href="https://api.whatsapp.com/send?phone=6285264028891" target="_blank">Fasilitas IT</a></li>
        </ul>
      </div>
    </div>
  </div>
</div> -->
<!-- Side Modal Top Right -->


<!-- Full Height Modal Right -->
<!-- <div class="modal fade left" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php //echo $this->asset->image('avatar/'.currentFotoUser(), '', array('class'=>'rounded-circle img-responsive', 'alt'=>'Foto User')); 
        ?>
      </div>
      <div class="modal-body text-center mb-1">
        <div class="card card-form mt-2 mb-4">
        <div class="table-responsive">
            <table class="table table-condensed">
            <br>
                <p class="h3"><b> D A E R A H </b></p>
                <tbody>
                    <tr>
                    <td class="text-left" width="25%">Provinsi</td>
                    <td width="3%">:</td>
                    <td class="text-left"><strong><?php //echo currentDataPeserta()['province']; 
                                                    ?></strong></td>
                    </tr>
                    <tr>
                    <td class="text-left" width="25%">Kab/Kota</td>
                    <td width="3%">:</td>
                    <td class="text-left"><strong><?php //echo currentDataPeserta()['regency']; 
                                                    ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-condensed">
            <p class="h3"><b>I D E N T I T A S &nbsp;&nbsp; P E S E R T A</b></p>
            <tbody>
                <tr>
                <td class="text-left"  width="25%">Nama Peserta</td>
                <td width="3%">:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['nama_lengkap']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left" width="25%">NIK</td>
                <td width="3%">:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['nik']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Tempat / Tgl Lahir</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['tempat_lhr']; 
                                                ?></strong> / <strong><?php //echo currentDataPeserta()['tanggal_lhr']; 
                                                                        ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Jenis Kelamin</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['gender']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Agama</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['agama']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Pendidikan</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['study']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Pekerjaan</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['pekerjaan']; 
                                                ?></strong></td>
                </tr>
                <tr>
                <td class="text-left">Alamat</td>
                <td>:</td>
                <td class="text-left"><strong><?php //echo currentDataPeserta()['alamat_peserta']; 
                                                ?></strong></td>
                </tr>
            </tbody>
            </table>
            </div>
        </div>
      </div>

    </div>
  </div>
</div> -->