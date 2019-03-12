<table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable " role="grid" aria-describedby="datatable-buttons_info" style="width: 100%; position: relative; z-index:0;" width="100%">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
        <th class="sorting" >FOLIO</th>
        <th class="sorting">RESPUESTA</th>
        <th class="sorting">CIUDADANO</th>
        <th class="sorting">FECHA</th>
        <th class="table-action tbl100W"></th>
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
            <tr>
                <td class="table-user">{{ $item->id }}</td>
                <td class="table-user">
                    <a href="{{route($showEdit,['Id'=>$item->denuncia->id])}}" class="action-icon text-center" @isset($newWindow) target="_blank" @endisset>
                        {{ $item->denuncia->id }}
                    </a>
                </td>
                <td>{{($item->respuesta)}}<br/><small class="text-primary">{{$item->observaciones}}</small></td>
                <td>{{$item->user->FullName}}</td>
                <td>{{($item->fecha)}}</td>
                <td class="table-action tbl100W">
                    <div class="button-list">
                        @include('shared.ui_kit.__edit_item_modal')
                        @include('shared.ui_kit.__remove_item')
                    </div>
                </td>
            </tr>
    @endforeach

    </tbody>
</table>