<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
                <h4>Borrar</h4>
            </div>
            <div class="modal-body">
                {{$text}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Cancelar
                </button>

                <a href="{{url("$name/$var->id")}}" class="btn btn-primary" style="margin-left: 5px" title="{{trans("labels.delete")}}" data-method="delete" data-token="{{ csrf_token() }}">Confirmar</a>
            </div>
        </div>
    </div>
</div>