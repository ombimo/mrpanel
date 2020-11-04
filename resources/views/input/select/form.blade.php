<div class="form-group row">
  <div class="col-sm-3">
    <label for="{{ $id }}" class="col-form-label"><b>{{ $col->label }}</b></label>
  </div>
  <div class="col-sm-9">
    <select class="form-control" id="{{ $id }}" name="{{ $col->col_name }}">
      
      <option value="" selected {{ ($config->null) ? '' : 'disabled' }}>Pilih {{ $col->label }}</option>

      {!! mrpanel_populate_select($data, $value, true, $config->source->col_id, $config->source->col_value) !!}
    </select>
  </div>
</div>