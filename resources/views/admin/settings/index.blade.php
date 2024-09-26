@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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

        <div class="card">
            <div class="card-header">General Settings</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name"
                            value="{{ $settings->site_name ?? 'Default Site Name' }}">
                    </div>
                    <div class="form-group">
                        <label for="site_description">Site Description</label>
                        <textarea class="form-control" id="site_description" name="site_description">{{ $settings->site_description ?? 'Default Description' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="background_image_1">Background Image 1</label>
                        <input type="file" class="form-control-file" id="background_image_1" name="background_image_1"
                            value="{{ $settings->background_image_1 ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaxpE2FjGO1ZvnvVKz2L84h7cvoWz0PzTxxA&s' }}">
                    </div>
                    <div class="form-group">
                        <label for="background_image_2">Background Image 2</label>
                        <input type="file" class="form-control-file" id="background_image_2" name="background_image_2"
                            value="{{ $settings->background_image_2 ?? 'https://img.freepik.com/free-photo/beautiful-archway-decorated-with-floral-composition-outdoors_8353-10972.jpg' }}">
                    </div>
                    <div class="form-group">
                        <label for="background_image_3">Background Image 3</label>
                        <input type="file" class="form-control-file" id="background_image_3" name="background_image_3"
                            value="{{ $settings->background_image_3 ?? 'https://img.freepik.com/free-photo/stage-with-white-curtain-that-says-pink-white-it_1340-24739.jpg' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
