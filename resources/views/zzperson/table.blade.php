<table class="table table-bordered data-table">
    
    <thead>
        <tr>
        @foreach($set as $field)
        <th>{{trans($field)}}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
        @foreach($set as $field)
        <th>{{trans($field)}}</th>
        @endforeach
        </tr>
</tfoot>
</table>

