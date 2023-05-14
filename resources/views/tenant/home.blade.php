@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <example-component 
                        tenant="{{ $tenant_id }}" 
                        message="Welcome to tenant {{ $tenant_id }} welcome page"
                    ></example-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
