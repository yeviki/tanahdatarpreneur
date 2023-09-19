<!DOCTYPE html>
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
  <main x-data="modalFunction()">

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
                  class="block py-2 pl-3 pr-4 text-teal-500 bg-white rounded md:bg-transparent md:text-teal-500 md:p-0 md:dark:text-white dark:bg-blue-600 md:dark:bg-transparent"
                  aria-current="page">Beranda</a>
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
                <a href="https://docs.google.com/forms/d/1rTdtZcsvLtv82m4eYTfW_trtyUg4PprdDfr9bRnaH2w/edit?usp=drivesdk"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent" target="_blank">Daftar BDC WS</a>
              </li>
              <li>
                <a href="<?= site_url('kegiatan') ?>"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Kegiatan</a>
              </li>
              <button
                class="transform rounded-md bg-teal-500 px-4 py-1 capitalize text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                <a href="<?= site_url('login') ?>">Login</a>
              </button>

              <!-- <button class="transform rounded-md ring-1 ring-teal-500 px-4 py-1 capitalize text-teal-500 
                            transition-colors duration-300 hover:bg-teal-500 hover:text-white focus:bg-blue-500 focus:outline-none focus:ring 
                            focus:ring-blue-300 focus:ring-opacity-80">Masuk</button> -->

            </ul>
          </div>
        </div>
      </nav>
    </section>

    <!-- Section Slider Cuk -->
    <section class="px-10 py-2">
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img class="rounded-lg" src="<?= base_url('assets/frontend/img/banner1.png') ?>" />
          </div>
          <div class="swiper-slide">
            <img class="rounded-lg" src="<?= base_url('assets/frontend/img/banner2.png') ?>" />
          </div>
          <div class="swiper-slide">
            <img class="rounded-lg" src="<?= base_url('assets/frontend/img/banner3.png') ?>" />
          </div>
          <div class="swiper-slide">
            <img class="rounded-lg" src="<?= base_url('assets/frontend/img/banner4.png') ?>" />
          </div>
          <div class="swiper-slide">
            <img class="rounded-lg" src="<?= base_url('assets/frontend/img/banner5.png') ?>" />
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
    </section>
    <!-- Section Slider Cuk -->

    <!-- <template x-for="value in colors" :key="value.id">
            <p x-text="value.label"></p>
        </template> -->

    <section class="bg-white dark:bg-gray-900">
      <div class="container mx-auto px-6 py-10">
        <h4 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
          Peserta Tergabung
        </h4>

        <div class="mx-auto mt-3 flex justify-center">
          <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
          <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
          <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
        </div>
        <p class="mx-auto mt-4 max-w-2xl text-center text-gray-500">
          Peserta yang telah bergabung di <span class="text-teal-500 font-bold">SumbarPreneur</span> sampai saat ini
        </p>
        <div class="mx-auto mt-4 max-w-2xl text-center">
          <?php ?>
          <h4 class="text-7xl text-teal-600 mb-2 font-bold uppercase"  x-text="dataStatistic.total_peserta"></h4>
          <!-- <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
          </div> -->
          <button
                class="transform rounded-md bg-teal-500 px-4 py-2 mt-3 capitalize text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                <a href="<?= site_url('/pelatihan') ?>">Daftar Sekarang</a>
              </button>
        </div>

        <p class="mx-auto mt-10 max-w-2xl text-center text-gray-500">
          Di <span class="text-teal-500 font-bold">SumbarPreneur</span>, pemprov Sumbar membuka banyak akses bagi para
          peserta untuk lebih mudah mengembangkan usahanya. Dengan begini semua orang dapat memiliki keterampilan
          berwirausaha dan berkesempatan untuk meraih suksesnya masing - masing.
        </p>

        <!-- component -->
        <div class="mt-2 grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:mt-5 xl:gap-12">

          <div class="w-full my-auto rounded-lg p-8 text-center align-middle dark:border-gray-700">
            <img src="<?= base_url('assets/frontend/img/train.svg') ?>" class="mx-auto" />
            <p class="uppercase text-teal-500 dark:text-gray-300 font-bold">Pelatihan</p>
            <div class="h-20 overflow-auto">
              <p class="text-gray-500 dark:text-gray-300 font-light">
                Pelaku usaha akan diberi pelatihan: Pelatihan tingkat dasar, Pelatihan tingkat lanjutan.
              </p>
            </div>

            <div class="flex justify-center">
              <button @click="setModalOpen('pelatihan')"
                class="text-sm text-teal-500 underline hover:text-teal-400 flex items-center cursor-pointer">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-3 h-3 mt-1 ml-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>

          <div class="w-full my-auto rounded-lg p-8 text-center align-middle dark:border-gray-700">
            <img src="<?= base_url('assets/frontend/img/train.svg') ?>" class="mx-auto" />

            <p class="uppercase text-teal-500 dark:text-gray-300 font-bold">Fasilitas Perizinan</p>
            <div class="h-20 overflow-auto">
              <p class="text-gray-500 dark:text-gray-300 font-light">
                Pelaku usaha akan difasilitasi dokumen perizinan dan/atau nonperizinannya.
              </p>
            </div>

            <div class="flex justify-center">
              <button @click="setModalOpen('perizinan')" class="text-sm text-teal-500 underline
                  hover:text-teal-400 flex items-center cursor-pointer">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-3 h-3 mt-1 ml-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            </div>
          </div>

          <div class="w-full my-auto rounded-lg p-8 text-center dark:border-gray-700">
            <img src="<?= base_url('assets/frontend/img/modal.svg') ?>" class="mx-auto" />

            <p class="uppercase text-teal-500 dark:text-gray-300 font-bold text-xs">
              Bantuan alat / permodalan
            </p>
            <div class="h-20 overflow-auto">
              <p class="text-gray-500 dark:text-gray-300 font-light">
                Kemudahan akses bantuan alat dan permodalan dari perbankan dan/atau Lembaga dan/atau Pihak lainnya.
              </p>
            </div>

            <div class="flex justify-center">
              <button @click="setModalOpen('pemodalan')"
                class="text-sm text-teal-500 underline hover:text-teal-400 flex items-center cursor-pointer">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-3 h-3 mt-1 ml-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>

          <div class="w-full my-auto rounded-lg p-8 text-center dark:border-gray-700">
            <img src="<?= base_url('assets/frontend/img/dam.svg') ?>" class="mx-auto" />

            <p class="uppercase text-teal-500 dark:text-gray-300 font-bold">SMK Preneur</p>
            <div class="h-20 overflow-auto">
              <p class="text-gray-500 dark:text-gray-300 font-light">
                Siswa SMK yang memiliki minat pada bisnis dan usaha.
              </p>
            </div>

            <div class="flex justify-center">
              <button @click="setModalOpen('smkpreneur')"
                class="text-sm text-teal-500 underline hover:text-teal-400 flex items-center cursor-pointer">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-3 h-3 mt-1 ml-2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>

        </div>

      </div>
    </section>

    <section class="bg-white dark:bg-gray-900">
      <div class="container mx-auto px-6 py-10">

        <!-- component -->
        <!-- <div class="lg:col-span-4 md:col-span-4 flex flex-wrap items-center rounded-lg border border-teal-300">
          <div class="w-1/4 px-3 text-center hidden md:block">
            <div class="p-5 xl:px-8 md:py-5">
              <img src="<?= base_url('assets/frontend/img/completed-animate.svg') ?>" class="mx-auto" />
            </div>
          </div>
          <div class="w-full sm:w-1/2 md:w-2/4 px-3 text-center">
            <div class="p-5 xl:px-8 md:py-5">
              <h3 class="text-2xl font-medium mb-2">Total Peserta</h3>
              <h2  class="text-7xl text-teal-600 mb-2 font-bold uppercase" x-text="dataStatistic.total_peserta"></h2>
              <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
                Loading...
              </div>
              <p class="font-medium text-lg text-gray-500">Orang</p>
            </div>
          </div>
          <div class="w-full sm:w-1/2 md:w-1/4 px-3 text-center">
            <div class="p-5 xl:px-8 md:py-5">
              <h1 class="text-center text-2xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
                Statistik Peserta SumbarPreneur
              </h1>

              <p class="mt-4 text-center text-gray-500 dark:text-gray-300 mb-5">
                Peserta yang tergabung di <span class="text-teal-500 font-bold">SumbarPreneur</span> sampai saat ini
              </p>

              <a href="<?= site_url('pelatihan') ?>"><button
                  class="rounded-md border border-teal-500 px-4 py-2 tracking-wide text-teal-500 transition-colors duration-300 hover:bg-teal-600 hover:text-white focus:bg-teal-600 font-medium">
                  Bergabung Sekarang
                </button></a>

            </div>
          </div>
        </div> -->
        <!-- component -->

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-4 xl:mt-2">

          <!-- <div class="lg:col-span-4 md:col-span-4">
            <div class="w-full my-auto rounded-lg bg-teal-500 p-8 text-center md:w-1/2 lg:w-1/2 lg:mx-auto md:mx-auto">
              <p class="font-medium text-xl uppercase text-white">TOTAL PESERTA</p>

              <h2 class="text-5xl font-bold uppercase text-white dark:text-gray-100" x-text="dataStatistic.peserta">
              </h2>

              <p class="font-normal text-gray-200">orang</p>

              <button
                class="mt-8 w-full transform rounded-md bg-white px-4 py-2 capitalize tracking-wide text-teal-500 transition-colors duration-300 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none font-bold focus:ring focus:ring-gray-200 focus:ring-opacity-80">
                Bergabung Sekarang
              </button>

            </div>
          </div> -->
          <div class="w-full my-auto rounded-lg border border-teal-300 p-8 text-center dark:border-gray-700">
            <p class="font-medium uppercase text-gray-700 dark:text-gray-300">TOTAL PESERTA</p>
          
            <h2 x-show="!loadingStatistic" class="text-5xl font-bold uppercase text-teal-600 dark:text-gray-100" x-text="dataStatistic.total_peserta"></h2>
            <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="font-medium text-gray-500 dark:text-gray-300">Orang</p>
            <!-- <button class="mt-10 w-full transform rounded-md bg-green-600 px-4 py-2 capitalize tracking-wide text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">Start Now</button> -->
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-8 text-center dark:border-gray-700">
            <p class="font-medium uppercase text-gray-700 dark:text-gray-300">MILLENIAL ENTREPENEUR</p>
          
            <h2 x-show="!loadingStatistic" class="text-5xl font-bold uppercase text-teal-600 dark:text-gray-100" x-text="dataStatistic.millenial"></h2>
            <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="font-medium text-gray-500 dark:text-gray-300">Orang</p>
            <!-- <button class="mt-10 w-full transform rounded-md bg-green-600 px-4 py-2 capitalize tracking-wide text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">Start Now</button> -->
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-8 text-center dark:border-gray-700">
            <p class="font-medium uppercase text-gray-700 dark:text-gray-300">Woman Enterpreneur</p>
            <h2 x-show="!loadingStatistic" class="text-5xl font-bold uppercase text-teal-600 dark:text-gray-100" x-text="dataStatistic.woman">
            </h2>
            <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="font-medium text-gray-500 dark:text-gray-300">Orang</p>
            <!-- <button class="mt-10 w-full transform rounded-md bg-green-600 px-4 py-2 capitalize tracking-wide text-white transition-colors duration-300 hover:bg-green-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">Start Now</button> -->
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-8 text-center dark:border-gray-700">
            <p class="font-medium uppercase text-gray-700 dark:text-gray-300">Ekonomi Kreatif</p>
            <h2 x-show="!loadingStatistic" class="text-5xl font-bold uppercase text-teal-600 dark:text-gray-100" x-text="dataStatistic.kreatif">
            </h2>
            <div x-show="loadingStatistic" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="font-medium text-gray-500 dark:text-gray-300">Usaha</p>
          </div>
        </div>

        <!-- ini col 4   xl:grid-cols-3 xl:gap-12 -->
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-4 xl:mt-5">

          <div class="w-full my-auto rounded-lg border border-teal-300 p-6 text-center">
            <p class="font-medium text-lg text-gray-800 dark:text-gray-300">Fasilitas Perizinan</p>
            <!-- <h2 x-show="!loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" x-text="3.396"> -->
            <h2 x-show="!loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" x-text="dataStatKat.perizinan">

            </h2>
            <div x-show="loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="mt-2 text-sm tracking-wider text-gray-800 dark:text-text-white">Fasilitas</p>
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-6 text-center">
            <p class="font-medium text-lg text-gray-800 dark:text-gray-300">Bantuan Alat / Permodalan</p>
            <h2 x-show="!loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" x-text="dataStatKat.permodalan">
            </h2>
            <div x-show="loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="mt-2 text-sm tracking-wider text-gray-800 dark:text-white">Bantuan</p>
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-6 text-center">
            <p class="font-medium text-lg text-gray-800 dark:text-gray-300">Peserta Pelatihan</p>
            <h2 x-show="!loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" x-text="dataStatKat.total_pelatihan"></h2>
            <div x-show="loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="mt-2 text-sm tracking-wider text-gray-800 dark:text-blue-400">Total Peserta Pelatihan</p>
          </div>

          <div class="w-full my-auto rounded-lg border border-teal-300 p-6 text-center">
            <p class="font-medium text-lg text-gray-800 dark:text-gray-300">SMK Preneur</p>
            <h2 x-show="!loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" x-text="dataStatKat.smk_preneur"></h2>
            <div x-show="loadingStatisticKategori" class="text-2xl font-semibold capitalize text-teal-500 dark:text-white" >
              Loading...
            </div>
            <p class="mt-2 text-sm tracking-wider text-gray-800 dark:text-white">Peserta</p>
          </div>

        </div>
        <!-- ini col 4-->

      </div>
    </section>
      <section class="text-gray-600 body-font" >
        <h1 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
            Kegiatan</h1>

        <div class="mx-auto mt-6 flex justify-center">
            <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
            <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
            <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
        </div>

        <p class="mx-auto mt-4 max-w-2xl text-center text-gray-500">Berbagai info kegiatan <span
                class="text-teal-500 font-bold">SumbarPreneur</span>.
        </p>

        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-wrap -m-4">
              <template x-for="value in showBerita" :key="value.id_berita">
                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                        <img class="lg:h-48 md:h-36 w-full object-cover object-center scale-110 transition-all duration-400 hover:scale-100"
                            :src="value.file_foto"
                            alt="blog">
                        <div class="p-6">
                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1" x-text="value.nama_opd">
                            </h2>
                            <h1 class="title-font text-lg font-medium text-gray-600 mb-3" x-text="value.judul_berita"></h1>
                            <!-- <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings
                                jianbing microdosing tousled waistcoat.</p> -->
                            <div class="flex items-center flex-wrap ">
                                <a :href="value.detailurl"><button
                                        class="bg-gradient-to-r from-cyan-400 to-blue-400 hover:scale-105 drop-shadow-md  shadow-cla-blue px-4 py-1 rounded-lg">Selengkapnya</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
              </template>
              <!-- <button x-show="previosHidden" x-transition @click="previosGetPelatihan()"
                class="bg-gradient-to-r from-green-400 to-blue-400 hover:scale-105 drop-shadow-md shadow-cla-blue px-10 py-2 rounded-lg mx-auto mt-5">
                Previos
              </button>
              <button @click="nextGetPelatihan()"
                class="bg-gradient-to-r from-green-400 to-blue-400 hover:scale-105 drop-shadow-md shadow-cla-blue px-10 py-2 rounded-lg mx-auto mt-5">
                Next
              </button> -->
            </div>
        </div>
      </section>
      <section class="text-gray-600 body-font" >
        <h1 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
            Video Kegiatan</h1>

        <div class="mx-auto mt-6 flex justify-center">
            <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
            <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
            <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
        </div>

        <p class="mx-auto mt-4 max-w-2xl text-center text-gray-500">Berbagai Video Kegiatan <span
                class="text-teal-500 font-bold">SumbarPreneur</span>.
        </p>

        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-wrap-m-4">

                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/1KRcEJ81WMU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"  class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/MPUAdSWeiVY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
                 <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/6SbOGZJOeB8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
             <div class="flex flex-wrap-m-4">

                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/-FQtEFojzrc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"  class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/aZjXtW9InsM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
                 <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <iframe src="https://www.youtube.com/embed/vzZX-9Mq8KM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="lg:h-48 md:h-36 w-full object-cover object-center" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            
        </div>
      </section>

      <section class="text-gray-600 body-font" >
        <h1 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
            Instagram</h1>

        <div class="mx-auto mt-6 flex justify-center">
            <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
            <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
            <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
        </div>

        <!-- <p class="mx-auto mt-4 max-w-2xl text-center text-gray-500">Berbagai Kegiatan  <span
                class="text-teal-500 font-bold">SumbarPreneur</span>.
        </p> -->

        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-wrap-m-4">

                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                      <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/CtmIOFmJ54z/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/reel/CtmIOFmJ54z/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">Lihat postingan ini di Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/reel/CtmIOFmJ54z/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">Sebuah kiriman dibagikan oleh Disperindag Sumbar (@disperindag_sumbar)</a></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                </div>
                <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                        <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CtdgTdtJQBz/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/CtdgTdtJQBz/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">Lihat postingan ini di Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CtdgTdtJQBz/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">Sebuah kiriman dibagikan oleh Disperindag Sumbar (@disperindag_sumbar)</a></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                </div>
                 <div class="p-4 md:w-1/3">
                    <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                          <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/CtagIk7JjJJ/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/CtagIk7JjJJ/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">Lihat postingan ini di Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CtagIk7JjJJ/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">Sebuah kiriman dibagikan oleh Disperindag Sumbar (@disperindag_sumbar)</a></p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                </div>
            </div>
            
            
        </div>
      </section>

    <!-- iko modal ygy -->
    <div x-cloak x-show="modelOpen" :class="modelOpen ? 'fixed inset-0 z-50 overflow-y-auto' : ''" aria-labelledby="modal-title"
      role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        <div x-cloak x-transition:enter="transition ease-out duration-300 transform"
          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
          x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
          :class="modelOpen ? 'fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40' : ''" aria-hidden="true">
        </div>

        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="transition ease-in duration-200 transform"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          class="inline-block w-full max-w-4xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
          <div class="flex items-center justify-between text-center space-x-4">
            <h1 class="text-xl font-bold text-teal-500 uppercase" x-text="titleModal"></h1>

            <button @click="modelOpen = false" class="text-teal-500 focus:outline-none hover:text-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </button>
          </div>

          <div class="mt-5 space-y-3">
            <div>
              <div class="p-2 flex flex-col md:flex-row lg:flex-row bg-teal-50 shadow-sm mb-5">
                <p class="w-2"></p>
                <div x-cloak class="text-sm text-gary-700 font-semibold" x-html="showContent"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- iko modal ygy -->



    <!-- <section class="bg-gray-100 dark:bg-gray-900 py-10">
            <div class="container mx-auto px-6">
                <h1 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
                    Para Peserta</h1>

                <div class="mx-auto mt-4 flex justify-center">
                    <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
                    <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
                    <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
                </div>

                <p class="py-4 text-center text-gray-500 dark:text-gray-300">Para Peserta yang telah bergabung di
                    <span class="text-teal-500 font-bold">SumbarPreneur</span>
                </p>
            </div>

            <div class="p-10">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="rounded-lg" src="img/peserta1.png" />
                        </div>
                        <div class="swiper-slide">
                            <img class="rounded-lg" src="img/pesertaa.png" />
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

        </section> -->

    <!-- <section class="bg-white dark:bg-gray-900">
            <div class="container mx-auto px-6 py-10">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">Kisah
                        Inspiratif</h1>

                    <p class="mx-auto mt-4 max-w-lg text-gray-500">Simak Kisah Inspiratif Dari Para Peserta</p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-8 md:mt-16 md:grid-cols-3">
                    <div>
                        <div class="relative">

                            <iframe class="rounded-lg" width="480" height="315"
                                src="https://www.youtube.com/embed/X0Vyl9IDVOU" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>

                        <h1 class="mt-6 text-xl font-semibold text-gray-800 dark:text-white">What do you want to know
                            about UI</h1>

                        <hr class="my-6 w-32 text-teal-500" />

                        <p class="text-sm text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Blanditiis fugit dolorum amet dolores praesentium, alias nam? Tempore</p>

                        <a href="#" class="mt-4 inline-block text-teal-500 underline hover:text-teal-400">Read more</a>
                    </div>

                    <div>
                        <div class="relative">
                            <iframe class="rounded-lg" width="480" height="315"
                                src="https://www.youtube.com/embed/CZk3PgTAYKs" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>

                        <h1 class="mt-6 text-xl font-semibold text-gray-800 dark:text-white">All the features you want
                            to know</h1>

                        <hr class="my-6 w-32 text-teal-500" />

                        <p class="text-sm text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Blanditiis fugit dolorum amet dolores praesentium, alias nam? Tempore</p>

                        <a href="#" class="mt-4 inline-block text-teal-500 underline hover:text-teal-400">Read more</a>
                    </div>

                    <div>
                        <div class="relative">
                            <iframe class="rounded-lg" width="480" height="315"
                                src="https://www.youtube.com/embed/gyLq2poxK-k" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>

                        <h1 class="mt-6 text-xl font-semibold text-gray-800 dark:text-white">Which services you get from
                            Meraki UI</h1>

                        <hr class="my-6 w-32 text-teal-500" />

                        <p class="text-sm text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Blanditiis fugit dolorum amet dolores praesentium, alias nam? Tempore</p>

                        <a href="#" class="mt-4 inline-block text-teal-500 underline hover:text-teal-400">Read more</a>
                    </div>
                </div>
            </div>
        </section> -->

    <footer class="bg-white dark:bg-gray-900">
      <div class="container mx-auto px-6 py-12">

        <!-- <div class="md:-mx-3 md:flex md:items-center md:justify-between">
                    <h1 class="text-3xl font-semibold tracking-tight text-teal-500 dark:text-white md:mx-3 xl:text-4xl">
                        Subscribe our newsletter to get update.</h1>

                    <div class="mt-6 shrink-0 md:mx-3 md:mt-0 md:w-auto">
                        <a href="#"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-teal-500 px-4 py-2 text-sm text-white duration-300 hover:bg-gray-700 focus:ring focus:ring-gray-300 focus:ring-opacity-80">
                            <span class="mx-2">Sign Up Now</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="mx-2 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700 md:my-10" />

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-white">Quick Link</p>

                        <div class="mt-5 flex flex-col items-start space-y-2">
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Home</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Who
                                We Are</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Our
                                Philosophy</a>
                        </div>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-800 dark:text-white">Industries</p>

                        <div class="mt-5 flex flex-col items-start space-y-2">
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Retail
                                & E-Commerce</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Information
                                Technology</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Finance
                                & Insurance</a>
                        </div>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-800 dark:text-white">Services</p>

                        <div class="mt-5 flex flex-col items-start space-y-2">
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Translation</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Proofreading
                                & Editing</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">Content
                                Creation</a>
                        </div>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-800 dark:text-white">Contact Us</p>

                        <div class="mt-5 flex flex-col items-start space-y-2">
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">+880
                                768 473 4978</a>
                            <a href="#"
                                class="text-gray-600 transition-colors duration-300 hover:text-blue-500 hover:underline dark:text-gray-300 dark:hover:text-blue-400">info@merakiui.com</a>
                        </div>
                    </div>
                </div> -->

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

  <script src="<?= base_url('assets/frontend/dist/swiper.js') ?>"></script>

  <script>
    function modalFunction() {
      return {
        dataBerita: [],
        dataStatistic: {},
        dataStatKat: {},
        loadingStatistic: true,
        loadingStatisticKategori: true,
        modelOpen: false,
        showContent: '',
        titleModal: '',
        colors: [{
            id: 1,
            label: 'Red',
          },
          {
            id: 2,
            label: 'Orange',
          },
          {
            id: 3,
            label: 'Yellow',
          },
        ],
        setModalOpen(type) {
          this.modelOpen = true;
          this.titleModal = type === 'pemodalan' ? 'PELAPORAN KEUANGAN & FASILITAS PEMODALAN' : type;
          this.showContent = this.dataContent[type];
        },
        dataContent: {
          pelatihan: `<p>
                                    <span>Pelaku usaha akan diberi pelatihan:</span>
                                        <br>
                                        <span>A. Pelatihan tingkat dasar; dan</span>
                                        <br>
                                        <span>B. Pelatihan tingkat lanjutan</span>
                                        <br>
                                        <br>
                                        <span>Pelatihan tingkat dasar dan tingkat lanjutan itu meliputi:</span>
                                        <br>
                                        <span>A. Pelatihan teknis (pelatihan mengenai teknis produksi &amp; pengembangan
                                            produk); dan</span>
                                        <br>
                                        <span>B. Pelatihan nonteknis (pelatihan untuk menumbuhkan jiwa kewirausahaan dan
                                            manajemen usaha, promosi, dan pemasaran produk)</span>
                                    </p>`,
          smkpreneur: `<p>
                                        <span>Siswa SMK yang memiliki minat pada bisnis dan usaha.</span>
                                    </p>`,
          perizinan: `<p>
                                    <span>Pelaku usaha akan difasilitasi dokumen perizinan dan/atau nonperizinannya, dapat dilakukan perorangan atau kolektif oleh Perangkat Daerah Penyelenggara Sumbarpreneur berkoordinasi dengan Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPM – PTSP) Pronvinsi Sumbar.</span>
                                </p>`,
          pemasaran: `<p>
                                    Pemasaran produk pelaku usaha oleh Perangkat Daerah Penyelenggara SumbarPreneur secara mandiri paling sedikit dilakukan 12 (dua belas) kali dalam satu tahun melalui penyelenggaraan pameran wirausaha, baik lokal, nasional maupun internasional.
                                </p><br>
                                <p>
                                    Sementara pemasaran oleh penyelenggaraan pameran wirausaha lokal, nasional maupun internasional dilakukan minimal 4 kali. Fasilitas pemasaran produk pelaku usaha SumbarPreneur dapat dilakukan melalui penjualan langsung atau penjualan melalui sistem perdagangan berbasis elektronik dan/atau dalam jaringan (daring) yang dikelola oleh Perangkat Daerah Penyelenggara SumbarPreneur, Lembaga dan/atau pihak lainnya.
                                </p>`,
          pemodalan: `<p>
                                    Pelaporan keuangan usaha berbasis aplikasi. Aplikasi pelaporan keuangan ini bermanfaat untuk memudahkan pemenuhan persyaratan akses permodalan, dengan aplikasi tersebut dapat berasal dari Pemprov Sumbar, maupun kerja sama/kolaborasi Pemprov Sumbar dengan pihak lainnya.
                                </p><br>
                                <p>
                                    Pelaku usaha SumbarPreneur yang telah memiliki izin usaha ataupun belum memiliki, difasilitasi untuk mendapatkan <strong>kemudahan akses permodalan dari perbankan dan/atau Lembaga dan/atau Pihak lainnya</strong>.
                                </p><br>
                                <p>
                                    Salah satu bentuknya ialah kolaborasi Pemprov Sumbar dengan perbankan dan/atau lembaga lainnya berupa pengenaan peryaratan kredit yang lebih ringan misalnya kredit untuk usaha yang baru berjalan kurang dari 6 bulan.
                                </p>`,
        },
        init() {
          this.getDataStatKategori();
          this.getDataStatistik();
          this.getDataBerita();

        },
        get showBerita() {
          return this.dataBerita;
        },
        async getDataStatistik() {
          try {
            const response = await axios.get(
              'https://sumbarpreneur.sumbarprov.go.id/sumbarmadani/statistic/newGetData');
            // console.log('Sukses get statistic ', response);
            // bg viki ni bos
            this.dataStatistic = response.data.data;
            this.loadingStatistic = false;
          } catch (error) {
            this.loadingStatistic = false;
            // console.log('error get statistic');
          }
        },
        async getDataStatKategori() {
          try {
            const response = await axios.get(
              'https://sumbarpreneur.sumbarprov.go.id/sumbarmadani/statistic/newStatKategori');
            // console.log('Sukses get stat kategori ', response);
            // bg viki ni bos
            this.dataStatKat = response.data.data;
            this.loadingStatisticKategori = false;
          } catch (error) {
            // console.log('error get stat kategori');
            this.loadingStatisticKategori = false;
          }
        },
        async getDataBerita(page) {
          try {
            const response = await axios.get(
              'https://sumbarpreneur.sumbarprov.go.id/sumbarmadani/berita/getdataberita/3',
            );
            console.log('response berita', response.data);
            this.dataBerita = response.data.data;
          } catch (error) {
            console.log('errr', error);
          }
        },
      };
    }
  </script>

</body>

</html>