@if ($create)

<div class="py-1">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary" type="button" onclick="createRecord()">
                <i class="fa-solid fa-circle-plus"></i> Nuevo
            </button>
        </div>
    </div>
</div>
@endif
<div class="py-3">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    @foreach ($model->display_names as $item)
                        <th>{{ $item }}</th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach ($info as $row)
                        <tr>
                            @foreach ($model->display_names as $key => $value)
                                @php
                                    $key = explode('.',$key);
                                @endphp
                                 @if (count($key)==1 )
                                 <td>{{$row[$key[0]]}}</td>
                                 @else
                                 <td>{{$row[$key[0]][$key[1]]}}</td>
                                @endif
                            @endforeach
                            <td>
                                @if ($update)
                                    <x-table-button class="fa-pen-to-square" onclick="editRecord({{$row->id}})"></x-table-button>
                                @endif

                                @if ($delete)
                                    <x-table-button class="fa-trash-can" onclick="confirmDelete({{$row->id}})"></x-table-button>
                                @endif
                                {{$options??''}}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $info->links() }}


        </div>
    </div>
</div>
