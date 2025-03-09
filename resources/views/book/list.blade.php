@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Books') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table id="catalog" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Authors</th>
                                <th>ISBN</th>
                                <th>Year</th>
                                <th>Publisher</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet"/>
    @vite('resources/pages/home/styles.css')
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript">
        window.bookDataTableUrl = '{{ route('book.data-table-items') }}';
    </script>
    @vite('resources/pages/home/script.js')
@endpush
