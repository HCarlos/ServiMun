@extends('home')

@section('container')

    @catalogo
    @slot('buttons')
        @include('shared.ui_kit.__menu_denuncia')
    @endslot
    @slot('body_catalogo')
        @include('shared.denuncia.denuncia.__denuncia_list')
    @endslot
    @endcatalogo

@endsection

