@extends('home')

@section('container')

@home
    @slot('titulo_header','Editando el registro '. $items->id)
    @slot('contenido')
        <div class="col-md-8">
            <!-- Chart-->
            @card
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateTipoasentamiento') }}">
                        @csrf
                        {{method_field('PUT')}}
                        @include('shared.catalogo.domicilio.ta.__ta_edit')
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary float-right">Guardar</button>
                        </div>
                    </form>
                @endslot
            @endcard
        </div>
    @endslot
@endhome

@endsection
