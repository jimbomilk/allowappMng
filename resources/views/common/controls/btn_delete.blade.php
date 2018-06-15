@include('adminlte::layouts.partials.modal_delete',['text'=>"¿Confirma el borrado del elemento?"])

<a href="#" class="btn-sm" data-toggle="modal" data-target="#modal" title="{{trans("labels.delete")}}">
    <span>
        <i  style="font-size: 20px" class="glyphicon glyphicon-trash"></i>
    </span>
</a>
