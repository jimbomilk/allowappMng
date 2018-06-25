@foreach($rhconsents as $key=>$value)
    <a href="" class="btn btn-circle btn-{{$value?'success':'default'}} "><i class="small fa fa-{{$key}}"></i></a>
@endforeach