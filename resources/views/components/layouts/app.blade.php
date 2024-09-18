<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Sistem Kasir Sederhana' }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        @livewireStyles
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('transactions.index') }}">Kasir Sederhana</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('livewire.categories') ? 'active' : '' }}" href="{{ route('livewire.categories') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('livewire.products') ? 'active' : '' }}" href="{{ route('livewire.products') }}">Products</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            {{ $slot }}
        </div>
        
        @stack('scripts') <!-- Tambahkan baris ini untuk skrip tambahan -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <!-- Include CKEditor -->
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session()->has('message'))
        <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('message') }}',
                    });
                });
            </script>
        @endif
        @livewireScripts
    </body>
</html>
