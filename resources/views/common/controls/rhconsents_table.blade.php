@foreach($rhconsents as $key=>$value)
    <span>{{$key}}: {{$value?'consiente':'no consiente'}}; </span>
@endforeach