@include('adminlte::layouts.partials.modal_delete',['text'=>"¿Confirma el borrado del elemento?",'var'=>$var])

<a href="#" class="btn" data-toggle="modal" data-target="#modal{{$var->id}}" title="{{trans("labels.delete")}}">
    <span>
        <i class="glyphicon glyphicon-trash"></i>
    </span>
</a>
