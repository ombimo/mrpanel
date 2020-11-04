<div class="form-group row">
  <div class="col-sm-3">
    <label for="{{ $id }}" class="col-form-label"><b>{{ $col->label }}</b></label>
  </div>
  <div class="col-sm-9">
    <input type="file" class="form-control js-img-preview"
    id="{{ $id }}" data-target="#img-preview-{{ $id }}"
    name="{{ $col->col_name }}" accept="image/*">
    @if($col->help_text != '')
        <small class="form-text text-muted">{{ $col->help_text }}</small>
    @endif
    <div class="img-preview" id="img-preview-{{ $id }}"><img class="thumb-200" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="preview"></div>
  </div>
</div>
