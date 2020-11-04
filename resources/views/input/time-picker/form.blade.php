<div class="form-group row">
  <div class="col-sm-3">
    <label for="{{ $id }}" class="col-form-label"><b>{{ $col->label }}</b></label>
  </div>
  <div class="col-sm-9">
    <input type="text" class="js-time-picker form-control" id="{{ $id }}"
      name="{{ $col->col_name }}" value="{{ $value }}" autocomplete="off">
  
  @if($col->help_text != '')
    <small class="form-text text-muted">{{ $col->help_text }}</small>
  @endif

  </div>
</div>