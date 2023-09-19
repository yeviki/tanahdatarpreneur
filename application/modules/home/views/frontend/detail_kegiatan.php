<!doctype html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>">
  <title>Sumbarpreneur</title>
  <link href="<?= base_url('assets/frontend/dist/output.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/frontend/dist/styleSlider.css') ?>" rel="stylesheet" />
  <link href="https://cdn.tailwindcss.com" rel="stylesheet" />
  <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
  <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"
    integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
    <main>
    <section class="bg-gray-100 dark:bg-gray-900">
      <nav class="mx-auto px-10 py-2 bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div class="container flex flex-wrap items-center justify-between mx-5">
          <a href="<?= base_url() ?>" class="flex items-end">
            <img src="<?= base_url('assets/frontend/img/sumbar2.png') ?>" class="h-6 mr-2 sm:h-10" alt="Flowbite Logo" />
            <span
              class="self-center text-2xl whitespace-nowrap font-bold text-teal-500 dark:text-white">SumbarPreneur</span>
          </a>

          <button data-collapse-toggle="navbar-dropdown" type="button"
            class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"></path>
            </svg>
          </button>

          <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
              class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-md md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
              <li>
                <a href="<?= base_url() ?>"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                  >Beranda</a>
              </li>
              <li>
                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                  class="flex items-center justify-between w-full py-2 pl-3 pr-4 font-medium text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                  Informasi
                  <svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar"
                  class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-1 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="<?= site_url('cara_daftar') ?>"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cara
                        Daftar</a>
                    </li>
                    <!-- <li>
                      <a href="<?= site_url('kontak') ?>"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Kontak</a>
                    </li> -->
                  </ul>
                </div>
              </li>
              <li>
                <a href="<?= site_url('pelatihan') ?>"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pelatihan</a>
              </li>
              <li>
                <a href="<?= site_url('kegiatan') ?>"
                  class="block py-2 pl-3 pr-4 text-teal-500 bg-white rounded md:bg-transparent md:text-teal-500 md:p-0 md:dark:text-white dark:bg-blue-600 md:dark:bg-transparent" aria-current="page">Kegiatan</a>
              </li>
              <button
                class="transform rounded-md bg-teal-500 px-4 py-1 capitalize text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                <a href="<?= site_url('login') ?>">Daftar</a>
              </button>

              <!-- <button class="transform rounded-md ring-1 ring-teal-500 px-4 py-1 capitalize text-teal-500 
                            transition-colors duration-300 hover:bg-teal-500 hover:text-white focus:bg-blue-500 focus:outline-none focus:ring 
                            focus:ring-blue-300 focus:ring-opacity-80">Masuk</button> -->

            </ul>
          </div>
        </div>
      </nav>
    </section>

        <!-- component -->
        <section class="text-gray-600 body-font">
            <div class="container mx-auto px-6 py-16">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white lg:text-4xl"><?= $berita['judul_berita'] ?></h1>
                    <br>
                    <span class="text-teal-500 font-bold"><?= $berita['nama_opd'] ?></span>
                </div>
                <div class="px-10 mt-10 flex justify-center">
                    <img class="rounded-xl object-cover lg:h-1/2 lg:w-full"
                        src="<?= base_url('repository/foto/').$berita['file_foto'] ?>" />
                </div>
                <div class="px-10">
                    <p class="mt-6 text-gray-500 dark:text-gray-300"><?= $berita['keterangan'] ?>.</p>
                </div>
                <?php
                  if (!$berita['link_youtube'] == null) { ?>
                <div class="relative" style="padding-top: 56.25%">
                  <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube-nocookie.com/embed/<?= $berita['link_youtube'] ?>" frameborder="0" …></iframe>
                </div>
                <?php } else ?>
            </div>
        </section>

        <footer class="bg-white dark:bg-gray-900">
            <div class="container mx-auto px-6 py-12">
                <hr class="my-6 border-gray-200 dark:border-gray-700 md:my-10" />
                <div class="flex flex-col items-center justify-between sm:flex-row">
                <a href="<?= base_url() ?>" class="flex items-end">
                    <img src="<?= base_url('assets/frontend/img/sumbar2.png') ?>" class="h-6 mr-2 sm:h-10" alt="Flowbite Logo" />
                    <span
                    class="self-center text-2xl whitespace-nowrap font-bold text-teal-500 dark:text-white">SumbarPreneur</span>
                </a>

                <p class="mt-4 text-sm text-gray-500 dark:text-gray-300 sm:mt-0">© Copyright 2021. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

    </main>
</body>

</html>