
<script type="text/javascript">

  $(document).ready(function() {
      oTable = $('.data-table').DataTable({
          "buttons": [ 'copy', 'excel', 'pdf'],
          "processing": true,
          "serverSide": true,
          ajax: "{{ route('zzperson.index','cwc2020') }}",
          "columns": [
            @foreach($set as $field)
            {data: '{{$field}}', name: '{{$field}}'},
            @endforeach
          ],
          initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            });
          }
      });
      oTable.buttons().container().appendTo( $('.col-sm-6:eq(0)', oTable.table().container() ) );
    });
</script>