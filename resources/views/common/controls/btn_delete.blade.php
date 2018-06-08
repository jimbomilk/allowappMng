@include('adminlte::layouts.partials.modal_delete',['text'=>"¿Confirma el borrado del elemento?"])

<a href="#" class="btn-sm" data-toggle="modal" data-target="#modal" title="{{trans("labels.delete")}}">
    <span class="glyphicon glyphicon-trash"></span>
</a>
