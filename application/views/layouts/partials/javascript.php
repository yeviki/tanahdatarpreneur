<!-- jQuery CDN - min version -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script> -->
<!-- Bootstrap tooltips -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script> -->
<!-- Bootstrap core JavaScript -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
<!-- MDB core JavaScript -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/js/mdb.min.js"></script> -->
<!-- jQuery Custom Scroller CDN -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script> -->

<!-- JS CDNJS Offline -->
<?= $this->asset->js('cdnjs/jquery-3.5.1.js'); ?>
<?= $this->asset->js('cdnjs/popper.min.js'); ?>
<?= $this->asset->js('cdnjs/bootstrap.min.js'); ?>
<?= $this->asset->js('cdnjs/mdb.min.js'); ?>
<?= $this->asset->js('cdnjs/jquery.nicescroll.min.js'); ?>


<!-- Datatables JS -->
<?= $this->asset->js('addons/datatables.min.js'); ?>
<?= $this->asset->js('addons/datatables-select.min.js'); ?>
<!-- NProgress JS -->
<?= $this->asset->js('plugins/nprogress/nprogress.js'); ?>
<!-- Select2 JS -->
<?= $this->asset->js('plugins/select2/dist/js/select2.min.js'); ?>
<!-- Sweet Alert -->
<?= $this->asset->js('plugins/sweetalert2/dist/sweetalert2.min.js'); ?>
<!-- Waitme JS -->
<?= $this->asset->js('plugins/waitme/waitMe.js'); ?>
<!-- Our Custom JS -->
<?= $this->asset->js('themes/scripts.js'); ?>
<!-- JS per Page -->
<!-- tinymce -->
<?= $this->asset->js('plugins/tinymce/tinymce.min.js'); ?>
<?= $this->asset->js('addons/setting.tinymce.js'); ?>

<?= isset($page_js) ? $page_js : ''; ?>