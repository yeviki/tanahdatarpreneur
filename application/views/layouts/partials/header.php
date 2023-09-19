<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= (isset($page_name) ? $page_name : ''). ' | ' .(isset($app_name) ? $app_name : '');?></title>
<meta name="description" content="<?= (isset($app_descs) ? $app_descs : ''); ?>">
<meta name="author" content="<?= (isset($app_author) ? $app_author : ''); ?>">
<meta name="keywords" content="<?= (isset($app_keys) ? $app_keys : ''); ?>" />
<link rel="icon" type="image/png" href="<?= $this->asset->image_path((isset($app_favico) ? $app_favico : '')); ?>">
<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"> -->
<?= $this->asset->css('fontawesome/css/all.css'); ?>
<!-- Bootstrap core CSS -->
<?= $this->asset->css('themes/bootstrap.min.css'); ?>
<!-- Material Design Bootstrap -->
<?= $this->asset->css('themes/mdb.min.css'); ?>
<!-- Our Custom CSS -->
<?= $this->asset->css('themes/style.css'); ?>
<!-- Datatables CSS-->
<?= $this->asset->css('addons/datatables.min.css'); ?>
<?= $this->asset->css('addons/datatables-select.min.css'); ?>
<!-- NProgress CSS -->
<?= $this->asset->css('plugins/nprogress/nprogress.css'); ?>
<!-- Select2 CSS -->
<?= $this->asset->css('plugins/select2/dist/css/select2.css'); ?>
<!-- Sweet Alert -->
<?= $this->asset->css('plugins/sweetalert2/dist/sweetalert2.min.css'); ?>
<!-- Waitme CSS -->
<?= $this->asset->css('plugins/waitme/waitMe.css'); ?>
<!-- CSS per Page -->
<?= isset($page_css) ? $page_css : ''; ?>
