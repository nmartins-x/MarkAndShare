@extends('layouts.app')

@section('content')
<div class="flexDisplay">
    <div class="left">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Vue component --}}
    <mapbox class="right"></mapbox>
</div>
@endsection
