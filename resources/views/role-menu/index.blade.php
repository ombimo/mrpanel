@extends('mrpanel::_layout.base')

@section('content')

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    <h2>Roles Menu</h2>
  </div>
</div>

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    {{ mrpanel_get_alert(Session::get('alert')) }}
  </div>
  <div class="table-responsive">
    <table class="table table-striped persist-area">
      <thead class="persist-header">
        <tr>
          <th>#</th>
          @foreach($table->colsView as $col)
            <th>{{ $col->label }}</th>
          @endforeach
          <th width="120px"></th>
        </tr>
      </thead>
      <tbody>

      @foreach($data as $value)
        <tr>
          <td>{{ $loop->iteration }}</td>
          @foreach($table->colsView as $col)
            @php
              $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
              $inputClass = new $inputClass();
            @endphp
            <td>{!! $inputClass::view($value->{$col->col_name}, $col) !!}</td>
          @endforeach
          <td>
        @if(!$value->is_superadmin)
            <a class="btn btn-primary" title="edit"
              href="{{ route('mrpanel.role-menu.edit', ['id' => $value->id]) }}">
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
