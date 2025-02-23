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
                            <input id="token" type="password" class="form-control" readonly placeholder="{{ __('API access token') }}" aria-label="{{ __('API access token') }}" aria-describedby="js-token-refresh" value="{{ $token }}">
                            <button class="btn btn-outline-secondary" type="button" id="js-token-refresh">{{ __('Refresh') }}</button>
                            <button id="js-token-revoke" class="btn btn-outline-secondary" type="button">{{ __('Revoke') }}</button>
                            <button id="js-token-show-btn" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Show or hide the Token" type="button">
                                {{ __('Show') }}
                            </button>
                            <button class="btn btn-outline-secondary js-clipboard-btn" data-clipboard-target="#token" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard">
                                {{ __('Copy') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    @vite('resources/pages/cabinet/styles.css')
    <link href="{{ asset('assets/libs/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
    @vite('resources/pages/cabinet/script.js')
@endpush
