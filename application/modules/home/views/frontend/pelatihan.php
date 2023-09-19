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
  <!-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" /> -->
  <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"
    integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
  <main x-data="pelatihanRendered()">
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
                  class="block py-2 pl-3 pr-4 text-teal-500 bg-teal-500 rounded md:bg-transparent md:text-teal-500 md:p-0 md:dark:text-white dark:bg-blue-600 md:dark:bg-transparent">Pelatihan</a>
              </li>
              <li>
                <a href="https://docs.google.com/forms/d/1rTdtZcsvLtv82m4eYTfW_trtyUg4PprdDfr9bRnaH2w/edit?usp=drivesdk"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent" target="_blank">Daftar BDC WS</a>
              </li>
              <li>
                <a href="<?= site_url('kegiatan') ?>"
                  class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Kegiatan</a>
              </li>
              <a href="<?= site_url('login') ?>"
                class="text-blue-500 underline hover:text-blue-700"><button
                  class="transform rounded-md bg-teal-500 px-4 py-1 capitalize text-white transition-colors duration-300 hover:bg-orange-500 focus:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                  Login
                </button></a>
              <!-- <button class="transform rounded-md ring-1 ring-teal-500 px-4 py-1 capitalize tracking-wide text-teal-500 
                            transition-colors duration-300 hover:bg-teal-500 hover:text-white focus:bg-blue-500 focus:outline-none focus:ring 
                            focus:ring-blue-300 focus:ring-opacity-80">Masuk</button> -->
            </ul>
          </div>
        </div>
      </nav>
    </section>

    <!-- component -->
    <section class="text-gray-600 body-font">
      <h1 class="text-center text-3xl font-semibold capitalize text-gray-800 dark:text-white lg:text-4xl">
        Pelatihan
      </h1>

      <div class="mx-auto mt-6 flex justify-center">
        <span class="inline-block h-1 w-40 rounded-full bg-teal-500"></span>
        <span class="mx-1 inline-block h-1 w-3 rounded-full bg-teal-500"></span>
        <span class="inline-block h-1 w-1 rounded-full bg-teal-500"></span>
      </div>

      <p class="mx-auto mt-4 max-w-2xl text-center text-gray-500">
        Cek jadwal pelatihan untuk kembangkan usaha di <span class="text-teal-500 font-bold">SumbarPreneur</span>.
      </p>

      <!-- component -->
      <!-- <div class="relative flex flex-col justify-center overflow-hidden p-6 sm:py-12">
          <div
            class="relative rounded-2xl bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:px-10"
          >
            <div class="mx-auto max-w-md">
              <form action="" class="relative mx-auto w-max">
                <input
                  type="search"
                  placeholder="cari jadwalmu di sini"
                  class="peer cursor-pointer relative z-10 h-12 w-12 rounded-full border bg-transparent pl-12 outline-none focus:w-full focus:cursor-text focus:border-teal-500 focus:pl-16 focus:pr-4"
                />
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="absolute inset-y-0 my-auto h-8 w-12 border-r border-transparent stroke-gray-500 px-3.5 peer-focus:border-teal-500 peer-focus:stroke-teal-500"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  />
                </svg>
              </form>
            </div>
          </div>
        </div> -->
    </section>

    <section class="bg-white dark:bg-gray-900 flex flex-col">
      <div class="container px-5 py-10 mx-auto">
        <div class="flex flex-wrap -m-4">
          <template x-for="value in showPelatihan" :key="value.token">
            <div class="p-4 md:w-1/3">
              <div class="h-full rounded-xl shadow-cla-blue bg-gradient-to-r from-indigo-50 to-blue-50 overflow-hidden">
                <img
                  class="lg:h-48 md:h-36 w-full object-cover object-center scale-110 transition-all duration-400 hover:scale-100"
                  src="<?= base_url('assets/frontend/img/prenur.jpeg') ?>" alt="blog" />
                <div class="p-6">
                  <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1" x-text="value.nama_opd">
                  </h2>

                  <h1 class="title-font text-lg font-medium mb-2 text-gray-600" x-text="value.nm_pelatihan"></h1>

                  <h2 class="tracking-widest text-xs title-font font-medium text-gray-400"
                    x-text="value.nm_jenis_kegiatan"></h2>
                  <p class="leading-relaxed mb-3" x-text="value.registrasi"></p>
                  <div class="flex items-center flex-wrap">
                    <button
                      class="bg-gradient-to-r from-cyan-400 to-blue-400 hover:scale-105 drop-shadow-md shadow-cla-blue px-4 py-1 rounded-lg"
                      x-text="value.status_pelatihan">
                      Selengkapnya
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </template>
          <button x-show="previosHidden" x-transition @click="previosGetPelatihan()"
            class="bg-gradient-to-r from-green-400 to-blue-400 hover:scale-105 drop-shadow-md shadow-cla-blue px-10 py-2 rounded-lg mx-auto mt-5">
            Previos
          </button>
          <button @click="nextGetPelatihan()"
            class="bg-gradient-to-r from-green-400 to-blue-400 hover:scale-105 drop-shadow-md shadow-cla-blue px-10 py-2 rounded-lg mx-auto mt-5">
            Next
          </button>
        </div>
      </div>
    </section>

    <footer class="bg-white dark:bg-gray-900">
      <div class="container mx-auto px-6 py-12">
        <hr class="my-6 border-gray-200 dark:border-gray-700 md:my-10" />

        <div class="flex flex-col items-center justify-center sm:flex-row mb-5">
          <a href="<?= base_url() ?>" class="flex items-end">
            <img src="<?= base_url('assets/frontend/img/sumbar2.png') ?>" class="h-6 mr-2 sm:h-10" alt="Flowbite Logo" />
            <span
              class="self-center text-2xl whitespace-nowrap font-bold text-teal-500 dark:text-white">SumbarPreneur</span>
          </a>
        </div>
        <p class="text-center top-10 text-sm text-gray-500 dark:text-gray-300 sm:mt-0">
          © Copyright 2021. All Rights Reserved.
        </p>
      </div>
    </footer>
  </main>

  <script>
    function pelatihanRendered() {
      return {
        dataPelatihan: [],
        previosHidden: false,
        paging: {
          page: 1,
        },

        init() {
          this.getDataPelatihan(this.paging.page);
        },
        get showPelatihan() {
          return this.dataPelatihan;
        },
        async getDataPelatihan(page) {
          try {
            let formData = new FormData();
            formData.append('page', page);
            const response = await axios.post(
              'https://sumbarpreneur.sumbarprov.go.id/sumbarmadani/pelatihan/listdata/all',
              formData,
            );
            console.log('response pelatihan', response.data);
            this.dataPelatihan = response.data.data;

            this.dataPelatihan.concat(response.data.data);
          } catch (error) {
            console.log('errr', error);
          }
        },
        nextGetPelatihan() {
          this.previosHidden = true;
          this.paging.page++;
          this.getDataPelatihan(this.paging.page);
        },
        previosGetPelatihan() {
          this.previosHidden = false;
          if (this.paging.page > 1) {
            this.previosHidden = true;
            this.paging.page--;
            this.getDataPelatihan(this.paging.page);
          }
        },
      };
    }
  </script>
</body>

</html>