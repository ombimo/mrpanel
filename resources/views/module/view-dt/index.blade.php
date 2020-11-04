@extends('mrpanel::_layout.base')

@section('content')

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    <h2>{{ $table->title }}</h2>
  </div>
</div>

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    {{ mrpanel_get_alert(Session::get('alert')) }}
    <a href="{{ route('mrpanel.module.create', [
      'tableAlias' => $table->alias
    ]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>

  </div>
  <div class="">
    <table class="table" id="data-table">
      <thead class="persist-header">
        <tr>
          @foreach($table->colsView as $col)
            <th>{{ $col->label }}</th>
          @endforeach
          <th width="120px" class="action"></th>
        </tr>
      </thead>
      <tbody>

      @foreach($data as $value)
        <tr>
          @foreach($table->colsView as $col)
            @php
              $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
              $inputClass = new $inputClass();
            @endphp
            <td>{!! $inputClass::view($value->{$col->col_name}, $col) !!}</td>
          @endforeach
          <td>
            <a class="btn btn-primary" title="edit"
              href="{{ mrpanel_url($table->alias.'/update/'.$value->{$table->primary_col}) }}">
                <i class="fa fa-edit fa-lg"></i>
            </a>
            <button type="button" class="btn btn-danger"
              data-toggle="modal" data-target="#modal-delete" data-id="{{ $value->{$table->primary_col} }}">
              <i class="fa fa-lg fa-trash"></i>
            </button>
          </td>
        </tr>
      @endforeach

      </tbody>
    </table>
  </div>
  <div class="card-body">
    <a href="{{ mrpanel_url($table->alias.'/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
  </div>
</div>


<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Yakin akan menghapus data ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="#!" type="button" role="button" class="btn btn-danger" id="modal-delete-button">Hapus</a>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts-bottom')
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data-table').DataTable({
          "columnDefs": [
            { "orderable": false, "targets": "action" }
          ]
      });
    $('#modal-delete').on('show.bs.modal', function(event){
      var id = $(event.relatedTarget).data('id');
      var url = '{{ mrpanel_url($table->alias.'/delete').'/' }}' + id;

      $('#modal-delete-button').attr('href', url);
    });
  });
</script>
@endpush
