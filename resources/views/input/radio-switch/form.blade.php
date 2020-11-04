<div class="form-group row">
  <div class="col-sm-3">
  </div>
  <div class="col-sm-9">
    <div class="mr-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        name="{{ $col->col_name }}" id="switch--{{ $col->col_name }}" {{ $value ? 'checked' : '' }}
        value="1">
        <label class="custom-control-label" for="switch--{{ $col->col_name }}">{{ $col->label }}</label>
      </div>
    </div>
  </div>
</div>
