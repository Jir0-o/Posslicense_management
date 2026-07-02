@extends('layouts.guest')

@section('content')


<div class="site-section site-section-sm bg-light">
    <div class="container">

        @guest
            {{-- NOT LOGGED IN --}}
            <div class="text-center">
                <h2>Please Login</h2>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Login
                </a>
            </div>
        @endguest

        @auth
            {{-- LOGGED IN --}}
            <script>
                window.location.href = "{{ route('dashboard.index') }}";
            </script>
        @endauth

    </div>
</div>

@endsection
