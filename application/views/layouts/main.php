<!DOCTYPE html>
<html lang="in">
    <head>
        <?= isset($template['partials']['header']) ? $template['partials']['header'] : ''; ?>
    </head>
    <body style="display:none;" class="white-skin">
        <!-- Dark Overlay element -->
        <div class="overlay"></div>
        <!------------------------- Header  ------------------------>
        <header>
            <!-- Title -->
            <?= isset($template['partials']['title']) ? $template['partials']['title'] : ''; ?>
            <!-- Title -->
            <!-- Navigation -->
            <?= isset($template['partials']['navigation']) ? $template['partials']['navigation'] : ''; ?>
            <!-- Navigation -->
        </header>
        <!----------------------- Header End ----------------------->
        <main class="pt-5 pb-3 mx-lg-3">
            <div class="container-fluid mt-5 mb-5">
                <section class="page-header">
                    <h1><?= isset($page_name) ? $page_name : ''; ?></h1>
                    <!-- Breadcrumb -->
                    <div class="page-header-breadcrumb">
                        <?= $this->breadcrumb->output(); ?>
                    </div>
                    <!-- Breadcrumb -->
                </section>
                <!-- Content Wrapper. Contains page content -->
                <?= isset($template['body']) ? $template['body'] : ''; ?>
            </div>
        </main>
        <!------------------------- Footer  ------------------------>
        <!-- page-content -->
        <?= isset($template['partials']['footer']) ? $template['partials']['footer'] : ''; ?>
        <!------------------------- Footer  ------------------------>
        <?= isset($template['partials']['javascript']) ? $template['partials']['javascript'] : ''; ?>
    </body>
</html>
