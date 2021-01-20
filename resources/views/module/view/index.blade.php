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

  @if($permission->can_create)
    <a href="{{ route('mrpanel.module.create', [
      'tableAlias' => $table->alias
    ]) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
  @endif


  {{-- search start --}}
  @if($table->hasSearchable())
    <div class="box-search mt-2">
      <form action="#!" method="get" class="row">
        <div class="col-12 col-sm-auto mb-2">
          <select name="col" class="form-control form-control-sm">
            <option value="" disabled selected>Kolom</option>
            {{ mrpanel_populate_select($table->searchable(), $searchCol, true, 'col_name', 'label')  }}
          </select>
        </div>
        <div class="col mb-2">
          <input type="text" class="form-control form-control-sm" name="keyword" value="{{ $keyword }}" placeholder="keyword">
        </div>
        <div class="col-12 col-sm-auto mb-2">
          <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Cari</button>
          <a href="{{ mrpanel_url($table->alias.'/view') }}" class="btn btn-sm btn-danger">Reset</a>
        </div>
      </form>
    </div>
  @endif
  {{-- search end --}}

  </div>
  <div class="table-responsive">
    <table class="table table-striped persist-area">
      <thead class="persist-header">
        <tr>
          <th class="number-col">#</th>
          @foreach($table->colsView as $col)
            <th>{{ $col->label }}</th>
          @endforeach
          <th width="120px"></th>
        </tr>
      </thead>
      <tbody>

      @foreach($data as $value)
        <tr>
          <td>{{ $startNum + $loop->iteration }}</td>
          @foreach($table->colsView as $col)
            @php
              $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
              $inputClass = new $inputClass();
            @endphp
            <td>{!! $inputClass::view($value->{$col->col_name}, $col) !!}</td>
          @endforeach
          <td>

            @if($permission->can_update)
            <a class="btn btn-primary mb-1 btn-block btn-sm" title="edit"
              href="{{ mrpanel_url($table->alias.'/update/'.$value->{$table->primary_col}) }}">
                <i class="fas fa-edit fa-xs"></i> Edit
            </a>
            @endif

            @if($permission->can_delete)
            <button type="button" class="btn btn-danger mb-1 btn-block btn-sm"
              data-toggle="modal" data-target="#modal-delete" data-id="{{ $value->{$table->primary_col} }}">
              <i class="fas fa-trash fa-xs"></i> Delete
            </button>
            @endif

          </td>
        </tr>
      @endforeach

      </tbody>
    </table>
  </div>
  <div class="card-body">
    @if($permission->can_create)
      <a href="{{ mrpanel_url($table->alias.'/create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
    @endif
  </div>
</div>
{{-- Pagination --}}
@if($data->lastPage() > 1)
  <div class="card mdc-elevation--z1 pt-3">
    {{ $data->links('mrpanel::vendor.pagination.bootstrap-4') }}
  </div>
@endif

@endsection

@if($permission->can_delete)

  @push('modal')
    <form action="{{ mrpanel_url($table->alias.'/delete') }}" id="form-modal-delete" method="POST">
      @csrf
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-delete">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Hapus Data ?</p>
            </div>
            <div class="modal-footer">
              <input type="hidden" value="" class="in-id" name="id">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  @endpush

  @push('scripts-bottom')
  <script>
    jQuery(function () {
      let elAction = document.getElementById('js-action-delete')

      $('#modal-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.in-id').val(id)
      })
    })
  </script>
  @endpush

@endif
