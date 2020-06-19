@extends('layouts.app')

@section('content')
<div class="flexDisplay">
    <div class="left">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        @if (auth()->guest())
                            Login/Register to start marking & sharing!
                        @else
                            @include('dashboard.main')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Vue component --}}
    <mapbox class="right"></mapbox>
</div>
@endsection
