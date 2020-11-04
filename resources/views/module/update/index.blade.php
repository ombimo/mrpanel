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
    <form action="#" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      @foreach($table->colsForm as $col)
        @php
          $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
          $inputClass = new $inputClass();
        @endphp
        <td>{!! $inputClass::form($col, $data->{$col->col_name}) !!}</td>
      @endforeach
      <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- additional data start --}}
@php
  $additional = json_decode($table->additional);
@endphp

@if(!empty($additional))
  <div class="card mdc-elevation--z1 mb-3">
    <div class="card-body">
      <h3>Additional</h3>
    </div>
  </div>
  @foreach($additional as $value)
    @php
      $addTable = Ombimo\MrPanel\Models\Table::with('colsView.type', 'colsForm.type')->where('name', $value->table)->first();
    @endphp
    <div class="card mdc-elevation--z1 mb-3">
    <div class="card-header"><h4>{{ $value->label }}</h4></div>
    <div class="card-body">
      <table class="table w-100" id="table-additional-{{ $value->name }}">
      <thead>
        <tr>
          @foreach($addTable->colsView as $col)
            @if($col->col_name != $value->foreign_key)
              <th>{{ $col->label }}</th>
            @endif
          @endforeach
          <th width="120px" class="action"></th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-{{ $value->name }}">Tambah {{ $value->label }}</button>

    </div>
  </div>

  @push('modal')
  <form method="post" action="{{ mrpanel_url($addTable->alias.'/create') }}" enctype="multipart/form-data">
    <div class="modal fade" id="modal-add-{{ $value->name }}" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah {{ $value->label }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            @foreach($addTable->colsForm as $col)
              @php
                $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
                $inputClass = new $inputClass();
              @endphp
              <td>{!! $inputClass::form($col, '') !!}</td>
            @endforeach
            <input type="hidden" name="{{ $value->foreign_key }}" value="{{ $id }}">
            <input type="hidden" name="mrpanel_red" value="{{ url()->full() }}">
            <input type="hidden" name="mrpanel_from" value="{{ $table->alias }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  @endpush

  @push('scripts-bottom')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#table-additional-{{ $value->name }}').DataTable( {
        ajax: {
          url: MRPANEL_URL + '/datatables/{{ $addTable->alias }}',
          data : {
            search : '{{ $value->foreign_key }}',
            keyword: '{{ $id }}',
            strict: 1
          },
          dataSrc: 'data'
        },
        columns: [

        @foreach($addTable->colsView as $col)
          @if($col->col_name != $value->foreign_key)
            @if($col->type->class === 'Select' || $col->type->class === 'Select2')
            { data : '{{ $col->col_name.'__value' }}' },
            @else
            { data : '{{ $col->col_name }}' },
            @endif

          @endif
        @endforeach



        {
          render : function (data, type, row) {
            return '<a href="{{ mrpanel_url($addTable->alias.'/update') }}/'+ row.id +'" class="btn btn-primary mr-1"><i class="fa fa-lg fa-edit"></i></a><button type="button" class="btn btn-danger"' +
              'data-toggle="modal" data-target="#modal-delete" data-id="'+ row.id +'"' +
              'data-alias="{{ $addTable->alias }}">'+
              '<i class="fa fa-lg fa-trash"></i>' +
            '</button>';
          }
        }

        ],
        columnDefs: [
            { "orderable": false, "targets": "action" }
          ]
      });
    });
  </script>
  @endpush

  @endforeach
@endif
{{-- additional data end --}}

{{-- addon start --}}
@foreach($dataAddon as $addon)
  @include('mrpanel::addon.' . $addon->name . '.form')
@endforeach
{{-- addon --}}

@endsection

@push('modal')
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
@endpush

@push('scripts-bottom')
<script type="text/javascript">
  $(document).ready(function(){
    $('#modal-delete').on('show.bs.modal', function(event) {
      var id = $(event.relatedTarget).data('id');
      var alias = $(event.relatedTarget).data('alias');
      var url = MRPANEL_URL + '/' + alias + '/delete/' + id;
      url = url + '?red={{ url()->full() }}';

      $('#modal-delete-button').attr('href', url);
    });
  });
</script>
@endpush
