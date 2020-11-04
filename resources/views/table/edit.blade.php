@extends('mrpanel::_layout.base')

@section('content')
<form action="#" method="post" id="form-table">
<div class="card mb-3">
  <div class="card-body">
    {{ csrf_field() }}
    {{ mrpanel_get_alert(Session::get('mrpanel.alert')) }}

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Table Name</label>
      </div>
      <div class="col-md-10">
        <p class="form-control-plaintext">{{ $table->name }}</p>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Alias</label>
      </div>
      <div class="col-md-10">
        <input type="text" class="form-control" name="alias" value="{{ $table->alias }}">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Label</label>
      </div>
      <div class="col-md-10">
        <input type="text" class="form-control" name="label" value="{{ $table->label }}">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Primary Col</label>
      </div>
      <div class="col-md-10">
        <select name="primary_col" class="form-control" required>
          <option value="">Pilih Primary Col</option>
          {{ mrpanel_populate_select($cols, $table->primary_col, true, 'Field', 'Field') }}
        </select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Created Col</label>
      </div>
      <div class="col-md-10">
        <select name="created_col" class="form-control">
          <option value="">Tidak Ada</option>
          {{ mrpanel_populate_select($cols, $table->created_col, true, 'Field', 'Field') }}
        </select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Updated Col</label>
      </div>
      <div class="col-md-10">
        <select name="updated_col" class="form-control">
          <option value="">Tidak Ada</option>
          {{ mrpanel_populate_select($cols, $table->updated_col, true, 'Field', 'Field') }}
        </select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2">
        <label class="col-form-label">Publish</label>
      </div>
      <div class="col-md-10">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="fm-publish" name="publish" value="1"
            {{ $table->publish ? 'checked' : '' }}>
          <label class="custom-control-label" for="fm-publish">Publish</label>
        </div>
      </div>
    </div>

  </div>
</div>

  {{-- foreach cols start --}}
  @foreach($table->cols as $col)
    <div class="card mb-2 cols-{{ $col->col_name }}">
      <div class="card-header">{{ $col->col_name }}</div>
      <div class="card-body">

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Label</label>
          </div>
          <div class="col-md-10">
            <input type="text" class="form-control" name="cols[{{ $col->col_name }}][label]" value="{{ $col->label }}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Help Text</label>
          </div>
          <div class="col-md-10">
            <input type="text" class="form-control" name="cols[{{ $col->col_name }}][help_text]" value="{{ $col->help_text }}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Type</label>
          </div>
          <div class="col-md-10">
            <select name="cols[{{ $col->col_name }}][type_id]" class="form-control js-type" data-name="{{ $col->col_name }}">
              <option value="">Pilih Type</option>
              {{ mrpanel_populate_select($type, $col->type_id, true, 'id', 'name') }}
            </select>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">View</label>
          </div>
          <div class="col-md-10">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="fm-view-{{ $col->col_name }}" name="cols[{{ $col->col_name }}][view]" value="1"
              {{ $col->view ? 'checked' : '' }}>
              <label class="custom-control-label" for="fm-view-{{ $col->col_name }}"></label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Form</label>
          </div>
          <div class="col-md-10">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="fm-form-{{ $col->col_name }}" name="cols[{{ $col->col_name }}][form]" value="1"
              {{ $col->form ? 'checked' : '' }}>
              <label class="custom-control-label" for="fm-form-{{ $col->col_name }}"></label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Empty Checker</label>
          </div>
          <div class="col-md-10">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="fm-empty_checker-{{ $col->col_name }}" name="cols[{{ $col->col_name }}][empty_checker]" value="1"
              {{ $col->empty_checker ? 'checked' : '' }}>
              <label class="custom-control-label" for="fm-empty_checker-{{ $col->col_name }}"></label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Searchable</label>
          </div>
          <div class="col-md-10">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="fm-searchable-{{ $col->col_name }}" name="cols[{{ $col->col_name }}][searchable]" value="1"
              {{ $col->searchable ? 'checked' : '' }}>
              <label class="custom-control-label" for="fm-searchable-{{ $col->col_name }}"></label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Posisi View</label>
          </div>
          <div class="col-md-10">
            <input type="number" name="cols[{{ $col->col_name }}][posisi_view]" value="{{ $col->posisi_view }}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-2">
            <label class="col-form-label">Posisi Form</label>
          </div>
          <div class="col-md-10">
            <input type="number" name="cols[{{ $col->col_name }}][posisi_form]" value="{{ $col->posisi_form }}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-12">
            <input type="hidden" id="config-{{ $col->col_name }}" name="cols[{{ $col->col_name }}][config]" value="{{ $col->config_form }}">
            <div id="config-editor-{{ $col->col_name }}"></div>
          </div>
        </div>

      </div>
    </div>
  @endforeach
  {{-- foreach cols end --}}
  <div class="card mb-2">
    <div class="card-header">Tambahan</div>
    <div class="card-body">
      <input type="hidden" id="additional" name="additional">
      <div id="json-editor-additional"></div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </div>

</form>

@endsection

@push('scripts-bottom')
<script type="text/javascript">
  $(document).ready(function () {
    var configEditor = {};

    $('.js-type').each(function () {
      generateEditor($(this));
    }); //end js type each

    $('.js-type').change(function () {
      generateEditor($(this));
    }); //end js-type change

    var element = document.getElementById('json-editor-additional');
    var additionalEditor = new JSONEditor(element, {
            theme: "bootstrap4",
            disable_collapse: true,
            disable_edit_json: true,
            disable_properties: true,
            no_additional_properties: true,
            required_by_default: true,
            startval: {!! $table->additional ?: '[]' !!},
            schema: {
              type: "array",
              title: "Additional",
              format: "table",
              items: {
                type: "object",
                title: "Additional",
                properties: {
                  name: {
                    type: "string"
                  },
                  label: {
                    type: "string"
                  },
                  table: {
                    type: "string"
                  },
                  foreign_key: {
                    type: "string"
                  },
                  reference_key: {
                    type: "string"
                  }
                }
              }
            }
          });

    function generateEditor(e) {
      var type = e.val();
      if (type != '') {
        var name = e.data('name');
        var element = document.getElementById('config-editor-' + name);
        var $input = $('#config-' + name);

        var properties = JSON.parse(document.getElementById('schema-' + type).innerHTML);
        element.innerHTML = '';
        if (properties != JSON.stringify({})) {
          startval = null;
          if ($input.val() != '') {
            startval = JSON.parse($input.val());
          }
          configEditor[name] = new JSONEditor(element, {
            theme: "bootstrap4",
            disable_collapse: true,
            disable_edit_json: true,
            disable_properties: true,
            no_additional_properties: true,
            required_by_default: true,
            startval: startval,
            schema: {
              type: "object",
              title: "Config",
              properties: properties
            }
          });
        }
      }
    } //end generate editor

    $('#form-table').submit(function (event) {

      Object.keys(configEditor).forEach(function (key) {
        var val = configEditor[key].getValue();
        $('#config-' + key).val(JSON.stringify(val));
      });

      var val = additionalEditor.getValue();
      $('#additional').val(JSON.stringify(val));

    });
  });
</script>

@foreach($type as $value)
  <script id="schema-{{ $value->id }}" type="application/json">{!! $value->config !!}</script>
@endforeach

@endpush
