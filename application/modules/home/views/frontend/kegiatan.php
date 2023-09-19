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
    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"
        integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
</head>

<body x-data="dataKegiatan()">
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
                                    class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Beranda</a>
                            </li>
                            <li>
                                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                    class="flex items-center justify-between w-full py-2 pl-3 pr-4 font-medium text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Informasi
                                    <svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg></button>
                                <!-- Dropdown menu -->
                                <div id="dropdownNavbar"
                                    class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-400"
                                        aria-labelledby="dropdownLargeButton">
                                        <li>
                                            <a href="<?= site_url('cara_daftar') ?>"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cara
                                                Daftar</a>
                                        </li>
                                        <!-- <li>
                                            <a href="./kontak.html"
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
                                    class="block py-2 pl-3 pr-4 text-teal-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-teal-500 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                                    aria-current="page">Kegiatan</a>
                            </li>
                            <a href="<?= site_url('login') ?>"
                                class="text-blue-500 underline hover:text-blue-700"><button class="transform rounded-md bg-teal-500 px-4 py-1 capitalize tracking-wide text-white
                            transition-colors duration-300 hover:bg-orange-500 focus:bg-blue-500 focus:outline-none focus:ring
                            focus:ring-blue-300 focus:ring-opacity-80">Login</button></a>
                            <!-- <button
                            class="transform rounded-md ring-1 ring-teal-500 px-4 py-1 capitalize tracking-wide text-teal-500 
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
                    <a href="#" class="flex items-end">
                        <img src="<?= base_url('assets/frontend/img/sumbar2.png') ?>" class="h-6 mr-2 sm:h-10" alt="Flowbite Logo" />
                        <span
                            class="self-center text-2xl whitespace-nowrap font-bold text-teal-500 dark:text-white">SumbarPreneur</span>
                    </a>

                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-300 sm:mt-0">© Copyright 2021. All Rights
                        Reserved.</p>
                </div>
            </div>
        </footer>

    </main>
</body>

</html>
<script>
    function dataKegiatan(){
        return{
            dataBerita: [],
            init(){
                this.getDataBerita();
            },
            get showBerita() {
                return this.dataBerita;
            },
            async getDataBerita(page) {
                try {
                    const response = await axios.get(
                    'https://sumbarpreneur.sumbarprov.go.id/sumbarmadani/berita/getdataberita/all',
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