@include('adminlte::layouts.partials.modal_delete',['text'=>"¿Confirma el borrado del elemento?",'var'=>$var])

<a href="#" class="btn-sm" data-toggle="modal" data-target="#modal{{$var->id}}" title="{{trans("labels.delete")}}">
    <span>
        <i  style="font-size: 20px;color:red;" class="glyphicon glyphicon-trash"></i>
    </span>
</a>
