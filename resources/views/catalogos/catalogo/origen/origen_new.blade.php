@extends(Auth::user()->Home)

@section('container')

@home
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Nuevo')
    @slot('contenido')
        <div class="col-md-8">
            @card
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('createOrigen') }}">
                        @csrf
                        @include('shared.catalogo.origen.__origen_new')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcard
        </div>
    @endslot
@endhome

@endsection
