@extends('layoutWelcome')

@section('content')
    <div class="container">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/home') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="parallax">
                        <h1>Bazaar Leftover Food Data<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Collection System
                        </h1>
                    </div>

                    <div class="long-image-row">
                        <img src="{{ asset('picture/home1.png') }}" alt="Long Image">
                    </div>

                    <div class="button-row">
                        <button><a href="{{ route('register') }}" id="len1" class="hoverable">Sertai Kami</a></button>
                        <button><a href="{{ url('/home') }}" id="len1" class="hoverable" style="color: #2a7cbe">Lanjut</a></button>
                    </div>

                    <div class="content-row">
                        <div class="text-section">
                            <p>Pertubuhan Pemuda GEMA Malaysia (GEMA) adalah sebuah organisasi anak muda yang berusaha
                                menjana perubahan positif dalam kehidupan generasi muda supaya mereka berupaya menjadi ejen
                                perubahan dan menambah nilai kepada pembangunan keluarga, komuniti, masyarakat dan negara.
                            </p>
                            <br>
                            <p>Berdaftar dengan Jabatan Belia & Sukan Malaysia dan telah menerima penarafan 5 bintang pada
                                tahun 2021 dan 2020.</p>
                        </div>
                        <div class="photo-gallery">
                            <div class="gridscroll">
                                <img src="{{ asset('picture/p-gallery1.jpg') }}" alt="Photo 1" style="width: 70vh; height: 30vh;">
                                <img src="{{ asset('picture/p-gallery2.jpg') }}" alt="Photo 2" style="width: 70vh; height: 30vh;">
                                <img src="{{ asset('picture/p-gallery3.jpg') }}" alt="Photo 3" style="width: 70vh; height: 30vh;">
                                <img src="{{ asset('picture/p-gallery4.jpg') }}" alt="Photo 4" style="width: 70vh; height: 30vh;">
                                <img src="{{ asset('picture/p-gallery5.jpg') }}" alt="Photo 5" style="width: 70vh; height: 30vh;">
                            </div>
                        </div>
                    </div>

                    <div class="content-row2">
                        <div class="photo-section">
                            <img src="{{ asset('picture/home2.jpg') }}" alt="Description of the photo" width="700">
                        </div>
                        <div class="text-section2">
                            <div class="text-content">
                                <h2>Matlamat penubuhan</h2>
                                <ol class="spaced-list">
                                    <li>Mengumpulkan anak muda Malaysia di atas dasar perpaduan serta membina keperibadian
                                        diri yang baik, berhemah tinggi, moderat dan progresif.</li>
                                    <li>Meninggikan taraf pendidikan dan sosio-ekonomi anak muda di Malaysia bagi mewujudkan
                                        masyarakat yang makmur dan sejahtera.</li>
                                    <li>Memupuk keadilan dan kesejahteraan sosial serta membenteras kejahilan, kemiskinan
                                        dan keruntuhan moral di kalangan masyarakat.</li>
                                    <li>Menjalinkan hubungan dan kerjasama dengan pihak yang berkongsi aspirasi dan matlamat
                                        GEMA bagi memajukan kepentingan masyarakat dan negara.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .parallax {
            background-image: url('https://pbs.twimg.com/media/Ftj4MvJakAAQdKg?format=jpg&name=large');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .parallax h1 {
            font-size: 5rem;
            color: #fff;
        }

        .long-image-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            /* Adjust the margin as desired */
        }

        .long-image-row img {
            width: 75%;
            /* Adjust the width as needed */
            height: auto;
        }

        .button-row {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            /* Adjust the margin as desired */
        }

        .button-row button {
            margin: 0 10px;
            /* Adjust the margin as desired */
            padding: 5px 70px;
            /* Adjust the padding as desired */
            font-size: 15px;
            /* Adjust the font size as desired */
            border-radius: 5px;
            /* Add rounded corners */
            border: none;
            height: 30px;
        }

        .button-row button:first-child {
            color: #fff;
            background-color: #2a7cbe;
        }

        .button-row button:last-child {
            color: #2a7cbe;
            background-color: #fff;
            border: 2px solid #2a7cbe;
        }

        .content-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            padding: 0 200px;
        }

        .text-section,
        .video-section {
            width: calc(50% - 20px);
            /* Adjust the width and margin as desired */
            margin-bottom: 20px;
            font-size: 15px;
        }

        .content-row2 {
            background-color: #f0f0f0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
            padding: 0 200px;
            border-radius: 5px;
        }

        .text-section2 {
            display: flex;
            align-items: flex-start;
        }

        .text-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .text-content h2 {
            text-align: center;
            margin-top: 40px;
            font-size: 30px;
        }

        .text-section2,
        .photo-section {
            width: calc(50% - 20px);
            /* Adjust the width and margin as desired */
            margin-top: 20px;
            margin-bottom: 20px;
            /* font-size: 15px; */
        }

        .text-section2 h2,
        .photo-section h2 {
            margin-bottom: 10px;
            /* Adjust the margin as desired */
        }

        .photo-section img {
            max-width: 100%;
            /* Adjust the image width as desired */
            height: auto;
            /* Maintain the image aspect ratio */
        }

        ol {
            list-style-type: decimal;
        }

        .text-section ol,
        .text-section2 ol {
            font-size: 15px;
        }

        .spaced-list li {
            margin-bottom: 10px;
        }
    </style>
@endsection
