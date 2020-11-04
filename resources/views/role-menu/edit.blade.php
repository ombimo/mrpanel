@extends('mrpanel::_layout.base')

@section('content')

<div class="card mb-3">
  <div class="card-body">
    <h2>Edit Menu {{ $role->name }}</h2>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    {{ mrpanel_get_alert(Session::get('alert')) }}

    <table class="table table-striped table-bordered table-full" id="data-table">
      <thead>
        <tr>
          <th>Pages</th>
          <th class="action">Can See</th>
        </tr>
      </thead>
      <tbody>

      @foreach($role->menus as $value)
        <tr>
          <td>
            {{ mrpanel_back_ref($role->menus, $value->name, $value->parent_id) }}
          </td>
          <td>
            <div class="mr-switch">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input js-menu-switch"
                id="switch--{{ $value->pivot->id }}" value="1" data-id="{{ $value->pivot->id }}"
                {{ $value->pivot->active ? 'checked' : '' }} >
                <label class="custom-control-label" for="switch--{{ $value->pivot->id }}"></label>
              </div>
          </td>
        </tr>
      @endforeach

      </tbody>
    </table>
  </div>
</div>

@endsection

@push('scripts-bottom')

<script type="text/javascript">
    $(document).ready(function() {
      var table = $('#data-table').DataTable({
          "columnDefs": [
            { "orderable": false, "targets": "action" }
          ]
      });

      $('#data-table').on('change', '.js-menu-switch', function() {
        var id = $(this).data('id');
        var status = $(this).prop('checked');
        var data = {
          id : id,
          status : status
        };
        axios.post(MRPANEL_URL + '/role-menu/edit', data)
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });

      });

    });//end ready
</script>

@endpush
