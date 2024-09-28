{{-- {{ dd($settings) }} --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name ?? 'Gallery' }}</title>
    <meta name="description"
        content="{{ $settings->site_description ?? 'Welcome to our wedding website where you can find all the details about our special day.' }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Font CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Sacramento&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS for Modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <script defer src="{{ asset('js/script.js') }}"></script>
</head>

<body id="background">
    <div id="firstContainer" style="display: none" class="container mx-auto mt-10">
        <div class="max-w-6xl mx-auto p-6 rounded-lg shadow-lg">
            <div>
                <div class="text-box">
                    <h2 class="great-vibes-regular font-bold text-center">
                        {{ $settings->site_name ?? 'Welcome to our wedding' }}</h2>
                    <p class="sacramento-regular font-bold text-center">#LoveFromAtoZ</p>
                </div>
                <!-- Upload Button -->
                <div class="text-center mb-6">
                    <button type="button" class="btn-bg" data-bs-toggle="modal" data-bs-target="#uploadModal"
                        id="upload">
                        Upload New File
                    </button>
                </div>
            </div>

            <div id="gallery" class="grid-container">
                @if (isset($uploads) && $uploads->isEmpty())
                    <p class="demo text-white text-center font-bold col-span-full" style="z-index: 1;" id="demo">
                        No uploads yet. Be the first to upload something!
                    </p>
                @else
                    @foreach ($uploads as $upload)
                        @if (strpos($upload->file_type, 'image') !== false)
                            <!-- Display image -->
                            <div class="gallery-item" style="height:250px">
                                <img src="{{ $upload->file_path }}" alt="{{ $upload->file_name }}"
                                    class="w-full h-64 object-cover" style="height: 100%" loading="lazy">
                            </div>
                        @elseif(strpos($upload->file_type, 'video') !== false)
                            <!-- Display video -->
                            <div class="gallery-item">
                                <video width="320" height="240" controls class="w-full h-64 object-cover">
                                    <source src="{{ $upload->file_path }}" type="{{ $upload->file_type }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

        </div>
    </div>

    <div id="secondContainer" class="container mx-auto mt-10">
        <div class="text-box">
            <h2 class="great-vibes-regular font-bold text-center">
                {{ $settings->site_name ?? 'Welcome to our wedding' }}</h2>
            <p class="sacramento-regular font-bold text-center">#LoveFromAtoZ</p>
            <p class="demo text-center font-bold col-span-full" style="z-index: 1;" id="count"></p>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalLabel">Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselGallery" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-black">
                            @foreach ($uploads as $upload)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    @if (strpos($upload->file_type, 'image') !== false)
                                        <img src="{{ $upload->file_path }}" class="d-block"
                                            alt="{{ $upload->file_name }}">
                                    @elseif(strpos($upload->file_type, 'video') !== false)
                                        <video controls class="d-block">
                                            <source src="{{ $upload->file_path }}" type="{{ $upload->file_type }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control carousel-control-prev" type="button"
                            data-bs-target="#carouselGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"><ion-icon
                                    name="chevron-back-outline"></ion-icon></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control carousel-control-next" type="button"
                            data-bs-target="#carouselGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"><ion-icon
                                    name="chevron-forward-outline"></ion-icon></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Photos & Videos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dropzone Upload Form -->
                    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data"
                        class="dropzone" id="uploadDropzone">
                        @csrf
                        <div class="dz-message">
                            Drag & drop files here or click to upload.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <audio id="background-music" loop autoplay>
        <source src="{{ asset('aud/videoplayback_0SQEY1A0.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    {{-- Include Ion icon JS --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Include Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const gallery = document.getElementById("background");

            // Check if settings exist
            const imageUrls = [
                @if (isset($settings->background_image_1) && $settings->background_image_1)
                    'url("{{ asset('storage/' . $settings->background_image_1) }}")',
                @endif
                @if (isset($settings->background_image_2) && $settings->background_image_2)
                    'url("{{ asset('storage/' . $settings->background_image_2) }}")',
                @endif
                @if (isset($settings->background_image_3) && $settings->background_image_3)
                    'url("{{ asset('storage/' . $settings->background_image_3) }}")',
                @endif
            ].filter(Boolean); // Remove any empty values

            console.log("Image URLs:", imageUrls); // Log the image URLs for debugging

            let currentImageIndex = 0;

            function changeBackground() {
                if (imageUrls.length > 0) {
                    gallery.style.backgroundImage = imageUrls[currentImageIndex];
                    currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
                }
            }

            setInterval(changeBackground, 5000);
        });
    </script>

</body>

</html>
