@extends('mrpanel::_layout.base')

@section('content')

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    <h2>{{ $table->label }}</h2>
  </div>
</div>

<div class="card mdc-elevation--z1 mb-3">
  <div class="card-body">
    <form action="#" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      @foreach($table->colsForm as $col)
        @php
          $inputClass = 'Ombimo\MrPanel\App\Input\\'.$col->type->class;
          $inputClass = new $inputClass();
        @endphp
        <td>{!! $inputClass::form($col) !!}</td>
      @endforeach
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>


@endsection
