<!-- Sidebar -->
<div id="sidebar">
    <button type="button" id="sidebarCollapse" class="navbar-btn">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="sidebar-header d-flex justify-content-start">
        <?= $this->asset->image((isset($appIcon) ? $appIcon: ''), '', array('alt'=>'logo-provinsi-sumbar', 'class'=>'mr-1 ml-1')); ?>
        <div class="title">
            <h4><?= ' '.(isset($app_name) ? $app_name : ''); ?></h4>
            <p>Tanah Datar</p>
        </div>
    </div>
    <ul class="sidebar-menu list-unstyled" id="navMain">
        <?= $this->app_loader->create_menu(); ?>
    </ul>
</div>
