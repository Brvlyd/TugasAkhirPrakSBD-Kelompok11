<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Pemerintah Kota Pekalongan</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://www.zabuto.com/dev/calendar/dist/zabuto_calendar.min.css">
    <!-- jQuery (necessary for Zabuto Calendar) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Zabuto Calendar JS -->
    <script src="https://www.zabuto.com/dev/calendar/dist/zabuto_calendar.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<style>
#map {
    height: 400px;
}

#focusButton {
    position: absolute;
    bottom: 10px;
    left: 10px;
    z-index: 1000;
    background-color: #fbbf24;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.cursor-grabbing {
    cursor: grabbing;
}

.cursor-grab {
    cursor: grab;
}

</style>

<body class="flex flex-col min-h-screen bg-white">
    @include('layouts.navbarhome')

    <main class="flex-1 relative z-0 pt-16">
        <div class="flex flex-col lg:flex-row min-h-screen">
            <!-- Left side (yellow section) -->
            <div
                class="relative lg:w-5/12 bg-yellow-500 text-white p-8 md:p-12 lg:p-16 flex flex-col justify-center items-center text-center">
                <div class="transform scale-100 md:scale-110 lg:scale-125">
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4">Welcome to<br>PNS News</h1>
                    <p class="text-lg md:text-xl lg:text-2xl">World City of Batik</p>
                </div>
            </div>

            <!-- Right side (image) -->
            <div class="relative lg:w-7/12">
                <img src="{{ asset('img/PNS_News.jpg') }}" alt="foto wali dan walikota pekalongan"
                    class="w-full h-full object-cover min-h-[50vh] lg:min-h-screen">
            </div>
        </div>
        
<!-- Berita & Pengumuman -->
<div class="relative h-screen">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 bg-cover bg-center h-full"
                style="background-image: url('https://asset.kompas.com/crops/AsZwJgbHv7GOQqeOdxo1cCZ64Ak=/167x95:965x627/750x500/data/photo/2022/10/01/633807f7d7d67.png');">
                <div class="absolute inset-0 bg-gray-500 opacity-60"></div>
            </div>
            <!-- Content Container -->
            <div class="container mx-auto py-8 px-4 h-full relative z-10">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 h-full px-4 md:px-20">
                    <!-- Berita Section -->
                    <div class="w-3/4 bg-transparent rounded-lg p-4 h-full flex flex-col">
                        <div class="flex items-center justify-between border-b-2 border-gray-300 mb-4">
                            <h2 class="text-2xl md:text-3xl font-semibold text-white">Berita Kota</h2>
                            <a href="{{ route('berita.list') }}" class="text-sm text-white hover:text-blue-400">Lihat
                                Semua</a>
                        </div>
                        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                            <!-- Image Box -->
                            <div
                                class="flex flex-col md:flex-row flex-wrap md:flex-nowrap space-y-4 md:space-y-0 md:space-x-4 mb-4">
                                @foreach ($headlineBerita->take(2) as $berita)
                                <!-- Each image box taking up half the space -->
                                <a href="{{ route('content.show', ['type' => 'berita', 'id' => $berita->id]) }}"
                                    class="block no-underline text-black w-full md:w-1/2">
                                    <div
                                        class="w-full h-64 rounded-lg shadow overflow-hidden relative transform hover:scale-90 hover:brightness-75 transition-transform duration-700">
                                        <img class="w-full h-full object-cover"
                                            src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}">
                                        <div
                                            class="absolute bottom-0 w-full p-2 bg-black bg-opacity-50 text-white text-center">
                                            <h3
                                                class="text-lg font-bold hover:text-gray-400 transition-colors duration-300">
                                                {{ mb_substr($berita->title,0,50) }}...
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-4 flex-1">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold text-black">Berita Lainnya</span>
                            </div>
                            <div class="overflow-y-auto max-h-32">
                                <ul class="space-y-2">
                                    @foreach ($otherBerita as $berita)
                                    <li class="flex justify-between text-sm border-b border-gray-300 pb-2 mr-2">
                                        <a href="{{ route('content.show', ['type' => 'berita', 'id' => $berita->id]) }}"
                                            class="flex justify-between w-full no-underline">
                                            <span
                                                class="hover:text-yellow-500 truncate max-w-xs">{{ $berita->title }}</span>
                                            <span class="text-gray-500">| {{ $berita->formatted_date }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Pengumuman Section -->
                    <div class="w-1/4 bg-transparent rounded-lg p-4 h-full flex flex-col">
                        <div class="flex justify-between items-center mb-4 border-b-2 border-gray-300">
                            <h2 class="text-2xl md:text-3xl font-semibold text-left text-white">Pengumuman</h2>
                            <a href="{{ route('pengumuman.list') }}"
                                class="text-sm text-white hover:text-blue-400">Lihat Semua</a>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-4 overflow-y-auto flex-1">
                            <ul class="space-y-2">
                                @foreach ($pengumuman as $item)
                                <li class="flex justify-between text-sm border-b border-gray-300 pb-2">
                                    <a href="{{ route('content.show', ['type' => 'pengumuman', 'id' => $item->id]) }}"
                                        class="flex justify-between w-full no-underline">
                                        <span class="hover:text-yellow-500 truncate max-w-xs">{{ $item->judul }}</span>
                                        <span class="text-gray-500 text-right"> | {{ $item->formatted_date }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Galeri -->
<div class=" mx-16  mt-10 mb-24">
        <div class="container mx-auto py-8 px-4">
            <h1 class="text-2xl font-bold mb-6 text-black">Galeri Kota Pekalongan</h1>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($galleries as $gallery)
                    <div class="swiper-slide">
                        <div class="relative group rounded-lg overflow-hidden shadow-md">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}"
                                class="w-full h-32 object-cover">
                            <div
                                class="absolute inset-0 bg-yellow-500 opacity-70 group-hover:opacity-0 transition-opacity duration-300">
                            </div>
                            <div
                                class="absolute inset-0 flex items-center justify-center text-white font-bold text-center">
                                {{ $gallery->title }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>

<!-- Include Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 2,
            spaceBetween: 10,
            slidesPerGroup: 2,
            loop: true,
            loopFillGroupWithBlank: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    slidesPerGroup: 3,
                    spaceBetween: 20
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 4,
                    slidesPerGroup: 4,
                    spaceBetween: 30
                }
            }
        });
        </script>


       
    <!-- Kalender Acara -->
<div class="container mx-auto p-2 lg:p-4 relative mt-8 mb-6">
    <div class="flex flex-col lg:flex-row lg:space-x-4">
        <!-- Background Half -->
        <div class="absolute top-0 left-0 w-full h-2/3 bg-yellow-500 bg-opacity-75 rounded-lg z-0"></div>

        <!-- Left Column -->
        <div class="flex flex-col lg:w-1/2 space-y-4 relative z-10">
            <!-- Kalender Text -->
            <div class="text-2xl font-bold text-gray-700">Kalender Acara</div>
            <!-- Calendar Section -->
            <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 mt-2">
                <div class="flex items-center justify-between mb-2">
                    <button class="focus:outline-none">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h2 class="text-lg font-bold text-gray-700">April 2024</h2>
                    <button class="focus:outline-none">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-gray-700">
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                    <div>Sun</div>
                    <!-- Repeat for days of the month -->
                    <div class="col-span-7 border-t border-gray-300"></div>
                    <div class="py-1">1</div>
                    <div class="py-1">2</div>
                    <div class="py-1">3</div>
                    <div class="py-1">4</div>
                    <div class="py-1">5</div>
                    <div class="py-1">6</div>
                    <div class="py-1">7</div>
                    <div class="py-1">8</div>
                    <div class="py-1">9</div>
                    <div class="py-1">10</div>
                    <div class="py-1 bg-yellow-300 rounded-full">11</div>
                    <div class="py-1">12</div>
                    <div class="py-1">13</div>
                    <div class="py-1">14</div>
                    <div class="py-1">15</div>
                    <div class="py-1">16</div>
                    <div class="py-1">17</div>
                    <div class="py-1">18</div>
                    <div class="py-1">19</div>
                    <div class="py-1">20</div>
                    <div class="py-1">21</div>
                    <div class="py-1">22</div>
                    <div class="py-1 bg-yellow-300 rounded-full">23</div>
                    <div class="py-1 bg-yellow-300 rounded-full">24</div>
                    <div class="py-1">25</div>
                    <div class="py-1 bg-yellow-300 rounded-full">26</div>
                    <div class="py-1">27</div>
                    <div class="py-1">28</div>
                    <div class="py-1">29</div>
                    <div class="py-1 bg-yellow-300 rounded-full">30</div>
                </div>
            </div>

                        <!-- Events Section -->
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 mt-2">
                            <ul class="space-y-2">
                                <?php foreach ($events as $event): ?>
                                <li class="flex items-start space-x-2">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="bg-black text-white rounded-lg w-12 h-12 flex flex-col items-center justify-center">
                                            <span
                                                class="text-lg font-bold"><?= \Carbon\Carbon::parse($event['event_date'])->format('d') ?></span>
                                            <span
                                                class="text-xs"><?= strtoupper(\Carbon\Carbon::parse($event['event_date'])->format('M')) ?></span>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-md font-semibold"><?= $event['title'] ?></h3>
                                        <p class="text-gray-600 text-sm"><?= $event['description'] ?></p>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div id="right-column" class="lg:w-1/2 mt-8 lg:mt-0 lg:flex lg:flex-col">
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 flex-grow z-10">
                        <img src="{{ asset('img/PNS_News.jpg') }}" alt="Event Image"
                                class="w-full h-64 object-cover rounded-md mb-4 event-image">
                            <h2 class="text-xl font-bold mb-2 event-title">Upacara CPNS Nasional</h2>
                            <p class="text-gray-700 text-sm mb-2 event-date">Kamis, 12 April 2025</p>
                            <p class="text-gray-700 text-sm mb-2 event-location">Lapangan Tembak Senayan, Jakarta</p>
                            <p class="text-gray-700 text-sm mb-2 event-description">Upacara CPNS Nasional adalah kegiatan resmi yang menandai pengangkatan Calon Pegawai Negeri Sipil (CPNS) menjadi Pegawai Negeri Sipil (PNS). Upacara ini dilaksanakan sebagai bentuk pengesahan status kepegawaian, peneguhan komitmen pelayanan publik, serta penanaman nilai-nilai integritas dan profesionalisme dalam birokrasi pemerintahan.</p>
                            <a href="#" class="text-blue-500 text-sm hover:underline event-link">Selengkapnya...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Pass PHP events to JavaScript
        var events = <?php echo json_encode($events); ?>;

        $(document).ready(function() {
            // Format events for Zabuto Calendar
            var calendarEvents = events.map(function(event) {
                return {
                    date: event.event_date,
                    badge: true,
                    title: event.title,
                    body: event.description
                };
            });

            // Debug: Log formatted events to the console
            console.log(calendarEvents);

            // Initialize Zabuto Calendar
            $("#demo-calendar-apppearance").zabuto_calendar({
                header_format: '[year] // [month]',
                week_starts: 'sunday',
                show_days: true,
                today_markup: '<span class="bg-blue-500 text-white rounded-full px-2 py-1">[day]</span>',
                navigation_markup: {
                    prev: '<i class="fas fa-chevron-circle-left text-gray-600 hover:text-gray-800"></i>',
                    next: '<i class="fas fa-chevron-circle-right text-gray-600 hover:text-gray-800"></i>'
                },
                data: calendarEvents,
                action: function() {
                    var date = $(this).data("date");
                    var hasEvent = $(this).data("hasEvent");
                    if (hasEvent) {
                        alert("You clicked on a date with events: " + date);
                    } else {
                        alert("You clicked on a date with no events: " + date);
                    }

                    // Toggle clicked date color
                    $(".zabuto_calendar .day").removeClass("clicked-date");
                    $(this).closest('.day').addClass("clicked-date");
                }
            });
        });
        </script>

        <style>
        .clicked-date {
            background-color: #ffeb3b !important;
        }

        .badge-day {
            background-color: #ffeb3b !important;
            border-radius: 50%;
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1em;
            text-align: center;
        }
        </style>

        <!-- Layanan Kota Pekalongan -->
        <div class="mx-10 mt-12 mb-20">
            <div class="container mx-auto py-8 px-4">
                <h1 class="text-2xl font-bold mb-6 text-black">Layanan Kota Pekalongan</h1>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($layanans as $layanan)
                        <div class="swiper-slide bg-white">
                            <!-- Modified section: Added border styles -->
                            <div
                                class="w-full max-w-md rounded overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 hover:border-yellow-500 border-2 border-gray-100 h-64 flex flex-col">
                                <img class="w-16 h-16 mt-4 ml-4 object-contain"
                                    src="{{ asset('storage/' . $layanan->image) }}" alt="{{ $layanan->title }}">
                                <div class="px-6 py-4 flex flex-col justify-between flex-grow">
                                    <div>
                                        <div class="font-bold text-xl mb-2">{{ $layanan->title }}
                                        </div>
                                        <p class="text-gray-700 text-base">{!! $layanan->description
                                            !!}</p>
                                    </div>
                                    <a href="{{ $layanan->link }}"
                                        class="text-blue-500 hover:underline mt-2 inline-block">Selengkapnya..</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper JS -->
        <sc src="https://unpkg.com/swiper/swiper-bundle.min.js"></sc>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,

                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                },
            });
        });
        </script>

        <div
            class="container mx-auto p-4 flex flex-col lg:flex-row lg:justify-between space-y-8 lg:space-y-0 lg:space-x-8 mb-2">
            <!-- Kominfo widget on the left -->
            <div class="flex flex-col space-y-4 w-full lg:w-1/3">
                <div class="flex items-center justify-center h-full">
                    <div id="gpr-kominfo-widget-container" class="w-full"></div>
                    <script src="https://widget.kominfo.go.id/gpr-widget-kominfo.min.js" async>
                    </script>
                </div>
            </div>

            <!-- Container for Twitter widgets -->
            <div class="flex flex-wrap lg:flex-nowrap space-y-4 lg:space-y-0 lg:space-x-4 w-full lg:w-2/3">
                <!-- Twitter feed for @pemkotpkl -->
                <div class="flex flex-col space-y-4 w-full lg:w-1/2">
                    <div class="font-bold mb-4 text-left">Postingan dari @pemkotpkl</div>
                    <a class="twitter-timeline" href="https://twitter.com/pemkotpkl" data-tweet-limit="5"
                        data-height="550" data-width="100%">Tweets by Pemkot Pekalongan</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>

                <!-- Twitter feed for @officialbatiktv -->
                <div class="flex flex-col space-y-4 w-full lg:w-1/2">
                    <div class="font-bold mb-4 text-left">Postingan dari @officialbatiktv</div>
                    <a class="twitter-timeline" href="https://twitter.com/officialbatiktv" data-tweet-limit="5"
                        data-height="550" data-width="100%">Tweets by BATIK
                        TV</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8">
                    </script>
                </div>
            </div>
        </div>

        <!-- Peta Kota -->
        <div class=" mx-16 mb-12">
            <div class="container mx-auto py-8 px-4 mb-6">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex flex-col md:flex-row">
                        <div id="map" class="h-64 md:h-72 w-full md:w-1/2 relative z-0">
                            <button id="focusButton">Fokus ke Pekalongan</button>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-center md:w-1/2">
                            <img src="img/logopkl.png" alt="Image beside the map" class="w-20 mb-4">
                            <h2 class="text-lg font-semibold mb-2 text-black">Kota Pekalongan</h2>
                            <p class="text-gray-600 text-justify text-sm">Kota Pekalongan adalah
                                salah satu kota di
                                pesisir
                                pantai
                                utara Provinsi Jawa Tengah. Kota ini berbatasan dengan laut Jawa di
                                utara, Kabupaten
                                Pekalongan di
                                sebelah selatan dan barat dan Kabupaten Batang di timur. Kota
                                Pekalongan terdiri
                                atas 4 kecamatan, yakni Pekalongan Utara, Pekalongan Barat,
                                Pekalongan Selatan dan
                                Pekalongan
                                Timur. Kota Pekalongan terletak di antara 6°50’42” - 6°55’44” LS dan
                                109°37’55” -
                                109°42’19” BT. Jarak Kota Pekalongan ke ibukota Provinsi Jawa Tengah
                                sekitar 100 km
                                sebelah
                                barat Semarang. Kota Pekalongan mendapat julukan kota batik. Hal ini
                                tidak terlepas
                                dari
                                sejarah
                                bahwa sejak puluhan dan ratusan tahun lampau hingga sekarang,
                                sebagian besar proses
                                produksi
                                batik Indonesia dihasilkan di kota Pekalongan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
        const map = L.map('map').setView([-6.8883, 109.6753], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan marker pada peta
        L.marker([-6.8883, 109.6753]).addTo(map)
            .bindPopup('Kota Pekalongan')
            .openPopup();


        document.getElementById('focusButton').addEventListener('click', () => {
            map.setView([-6.8883, 109.6753], 13);
        });
        </script>

    </main>

<!-- footer -->
<footer class="bg-yellow-500 py-4 relative z-50">
    <div class="container mx-auto px-2">
        <!-- Upper Section with Logos -->
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center justify-center md:justify-start mb-4 md:mb-0">
                <img src="{{ asset('img/pklbunga.png') }}" alt="Logo" class="h-36 max-w-full">
            </div>
            <div class="flex items-center space-x-2 justify-center md:justify-end">
                <img src="https://pekalongankota.go.id/template/frontend/img/widget/logo-evp.png" alt="Logo EVP" class="h-16 max-w-full">
                <img src="https://pekalongankota.go.id/template/frontend/img/widget/logo-berakhlak.png" alt="Logo Berakhlak" class="h-16 max-w-full">
                <img src="https://api-pse.layanan.go.id/storage/badge/badge_643.png" alt="Logo Kominfo" class="h-16 max-w-full">
            </div>
        </div>
        <!-- Middle Section with Address and Contact Info -->
        <div class="pt-4">
            <div class="flex flex-col md:flex-row justify-between">
                <!-- Address Section -->
                <div class="text-center md:text-left mb-4 md:mb-0 order-2 md:order-none w-full md:w-1/2">
                    <h2 class="text-lg font-semibold mb-2">DISKOMINFO Kota Pekalongan</h2>
                    <ul class="space-y-1">
                        <li class="text-black flex items-center justify-center md:justify-start">
                            <img src="{{ asset('img/alamat.png') }}" alt="Alamat" class="h-3 mr-1">
                            Jl. Mataram No.1, Podosugih, Kec. Pekalongan Bar., Kota Pekalongan, Jawa Tengah 51111
                        </li>
                        <li class="text-black flex items-center justify-center md:justify-start">
                            <img src="{{ asset('img/telp.png') }}" alt="Telepon" class="h-3 mr-1"> (0285) 421093
                        </li>
                        <li class="text-black flex items-center justify-center md:justify-start">
                            <img src="{{ asset('img/pesan.png') }}" alt="Email" class="h-3 mr-1">
                            <a href="mailto:setda@pekalongankota.go.id" class="hover:text-gray-300">setda@pekalongankota.go.id</a>
                        </li>
                    </ul>
                    <!-- Social Media Icons -->
                    <div class="flex justify-center md:justify-start space-x-2 mt-2">
                        <a href="#"><img src="{{ asset('img/fb.png') }}" alt="Facebook" class="h-8"></a>
                        <a href="#"><img src="{{ asset('img/twt.png') }}" alt="Twitter" class="h-8"></a>
                        <a href="#"><img src="{{ asset('img/yt.png') }}" alt="YouTube" class="h-8"></a>
                        <a href="#"><img src="{{ asset('img/ig.png') }}" alt="Instagram" class="h-8"></a>
                    </div>
                </div>
                <!-- Link Terkait Section -->
                <div class="text-center md:text-right order-1 md:order-none w-full md:w-1/2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-4">
                        <h2 class="text-black font-semibold mb-4 text-xl col-span-1 sm:col-span-2">Link Terkait</h2>
                        <ul class="space-y-1">
                            <li><a href="https://www.menpan.go.id/site/" class="text-black hover:text-gray-300">KEMENPAN</a></li>
                            <li><a href="https://www.kemendagri.go.id/" class="text-black hover:text-gray-300">KEMENDAGRI</a></li>
                            <li><a href="https://jatengprov.go.id/" class="text-black hover:text-gray-300">PEMPROV JATENG</a></li>
                        </ul>
                        <ul class="space-y-1">
                            <li><a href="http://kipjateng.jatengprov.go.id/" class="text-black hover:text-gray-300">KIP JATENG</a></li>
                            <li><a href="https://data.go.id/" class="text-black hover:text-gray-300">PORTAL SATU DATA</a></li>
                            <li><a href="https://pekalongankota.go.id/halaman/kebijakan-privasi.html" class="text-black hover:text-gray-300">KEBIJAKAN PRIVASI</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Diskominfo Section -->
        <div class="mt-4 text-center">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Pekalongan. All Rights Reserved.</p>
        </div>
    </div>
</footer>
</body>
<script>
window.onload = function() {
        // Function to adjust height
        function adjustHeight() {
            var rightHeight = document.getElementById('rightSection').clientHeight;
            var leftSection = document.getElementById('leftSection');
            leftSection.style.minHeight = rightHeight + 'px';
        }

        // Call adjustHeight on page load
        adjustHeight();

        // Optional: Adjust height on window resize to remain responsive
        window.onresize = adjustHeight;
    }
</script>

</html>