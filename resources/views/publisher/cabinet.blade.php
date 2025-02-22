@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ __('API') }}</h5>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col">
                        <label for="token" class="form-label pr-2">{{ __('Token') }}</label>
                        <div class="input-group mb-3">
                            <input id="token" type="text" class="form-control" readonly placeholder="Token API" aria-label="Token API" aria-describedby="button-token-refresh">
                            <button class="btn btn-outline-secondary" type="button" id="button-token-refresh">{{ __('Refresh') }}</button>
                            <button class="btn btn-outline-secondary" type="button">{{ __('Revoke') }}</button>
                            <button class="btn btn-outline-secondary" type="button">{{ __('Copy') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
