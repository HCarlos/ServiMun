@extends(Auth::user()->Home)

@section('container')

@catalogo
    @slot('buttons')
        @include('shared.ui_kit.__menu_catalogo')
    @endslot
    @slot('body_catalogo')
        <div class="col-md-12">
            @include('shared.catalogo.prioridad.__prioridad_list')
        </div>
    @endslot
@endcatalogo

@endsection
