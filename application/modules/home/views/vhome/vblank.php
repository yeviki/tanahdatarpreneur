<section>
    <?= "Selamat Datang Di Digital Talent Provinsi Sumatera Barat"; ?>

    <?php
        if($this->app_loader->is_admin()) {
            echo '<p class="note note-primary mt-3">';
                echo '<span><b> Perhatian :</b> Silahkan unduh panduan pengisian data pelatihan dan peserta <a class="btn purple-gradient btn-sm" target="_blank" href="'.base_url('/repository/Panduan Digitaltalent.pdf').'" >disini....</a>';
                echo '</span>';
            echo '</p>';
        } 
    ?>
</section>