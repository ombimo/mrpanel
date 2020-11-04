<div class="form-group row">
  <div class="col-sm-3">
    <label for="{{ $id }}" class="col-form-label"><b>{{ $col->label }}</b></label>
  </div>
  <div class="col-sm-9">
    <div class="form-group">
      <div class="input-image-preview mb-2 {{ !empty($value) ? 'show' : '' }}">
        <label class="input-image-preview__label" for="{{ $id }}">
          <div class="input-image-preview__icons">
            <div class=""><i class="fa fa-camera"></i></div>
            <div>{{ $col->label }}</div>
          </div>
          <div class="input-image-preview__image img-fit">
            <img class="input-image-preview-image" src="{{ !empty($value) ? get_thumbnail($value, 400, 400) : '' }}">
          </div>
        </label>
        <div class="input-image-preview__input">
          <input type="file" class="input-image-preview-input" id="{{ $id }}" accept="image/*">
          <input type="hidden" class="input-image-preview-text" name="{{ $col->col_name }}">
        </div>
      </div>
    </div>
        <label class="form-text text-muted small" for="{{ $id }}">* Silahkan klik diatas untuk mengganti {{ $col->label }}</label>
    @if($col->help_text != '')
        <small class="form-text text-muted">{{ $col->help_text }}</small>
    @endif
  </div>
</div>
