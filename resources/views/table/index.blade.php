@extends('mrpanel::_layout.base')

@section('content')

<div class="card">
  <div class="card-body">
    <table id="data-table" class="table table-striped table-bordered table-full">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Publish</th>
          <th class="action"></th>
        </tr>
      </thead>
      <tbody>

      @foreach($tables as $table)
        <tr>
          <td>{{ $table }}</td>
          <td>
            @if($tbzTable[$table]['publish'])
              <div class="text-success"><i class="fa fa-check"></i></div>
            @else
              <div class="text-danger"><i class="fa fa-times"></i></div>
            @endif
          </td>
          <td>
          @if(isset($tbzTable[$table]))
            <a class="btn btn-primary" href="{{ route('mrpanel.table.edit', ['tableAlias' => $tbzTable[$table]['alias']]) }}">
              <i class="fa fa-edit fa-lg"></i>
            </a>
          @endif
          </td>
        </tr>
      @endforeach

      </tbody>
    </table>
  </div>
</div>

@endsection

@push('scripts-bottom')

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').DataTable({
          "columnDefs": [
            { "orderable": false, "targets": "action" }
          ]
        });
    });
</script>

@endpush
