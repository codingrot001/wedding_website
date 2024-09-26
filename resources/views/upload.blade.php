<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Photos & Videos</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

    <style>
        /* Custom styling for the dropzone */
        .dropzone {
            border: 2px dashed #4A90E2;
            background-color: #F9FAFB;
            padding: 20px;
            border-radius: 8px;
        }

        .dropzone:hover {
            background-color: #EFF6FF;
        }

        .dropzone .dz-message {
            font-size: 1.2rem;
            color: #6B7280;
        }

        .dz-preview {
            display: inline-block;
            margin: 10px;
            position: relative;
            width: 150px;
        }

        .dz-preview img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dz-filename,
        .dz-size {
            font-size: 12px;
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold mb-4 text-center">Upload Photos & Videos</h2>

            <form action="{{ route('upload.store') }}" method="POST" id="my-dropzone" class="dropzone">
                @csrf
                <div class="dz-message" data-dz-message><span>Drop files here to upload</span></div>
                <!-- Preview Section -->
                <div id="preview-template" style="display: none;">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-details">
                            <img data-dz-thumbnail />
                            <span class="dz-filename"><span data-dz-name></span></span>
                            <span class="dz-size" data-dz-size></span>
                        </div>
                    </div>
                </div>

            </form>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 text-center">
                <label for="manualUpload" class="block text-lg font-semibold text-gray-600 mb-2">Or Select
                    Manually</label>
                <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="manualUpload" class="block w-full text-sm text-gray-500">
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Upload</button>
                </form>

            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('uploads.index') }}" class="text-blue-500 hover:underline">View Uploaded Files</a>
            </div>
        </div>
    </div>

    <!-- Dropzone JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Dropzone.options.myDropzone = {
                url: "{{ route('upload.store') }}",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                maxFilesize: 50, // MB
                addRemoveLinks: true,
                acceptedFiles: 'image/*,video/*',

                init: function() {
                    this.on("error", function(file, response) {
                        console.log("Error uploading file:", response);
                    });
                    this.on("success", function(file, response) {
                        console.log("File uploaded successfully:", response);
                    });
                    this.on("addedfile", function(file) {
                        // Code for additional actions when a file is added
                    });
                }
            };

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progressBar').value = percentComplete;
                }
            });
            xhr.open('POST', '/upload', true);
            xhr.send(formData);
        });
    </script>
</body>

</html>
