<div class="form-group row">
  <div class="col-sm-3">
    <label for="{{ $id }}" class="col-form-label"><b>{{ $col->label }}</b></label>
  </div>
  <div class="col-sm-9">
      <textarea name="{{ $col->col_name }}" class="js-ckeditor form-control">{{ $value }}</textarea>
  </div>
</div>