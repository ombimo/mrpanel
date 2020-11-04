@extends('mrpanel::_layout.base')

@section('content')

<div class="card mb-3">
  <div class="card-body">
    <h2>
      {{ $role->name }}
      <div class="small text-muted">Edit Permission</div>
    </h2>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    {{ mrpanel_get_alert(Session::get('alert')) }}

    <table class="table table-striped table-bordered table-full" id="data-table">
      <thead>
        <tr>
          <th>Table</th>
          <th class="action"></th>
        </tr>
      </thead>
      <tbody>

      @foreach($role->permissions as $permission)
        <tr>
          <td>
            {{ $permission->table->name }}
          </td>
          <td>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" class="custom-control-input js-permission-switch"
              id="switch--{{ $permission->id }}--create" value="1" data-id="{{ $permission->id }}"
              {{ $permission->can_create ? 'checked' : '' }} data-action="can_create">
              <label class="custom-control-label" for="switch--{{ $permission->id }}--create">Create</label>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" class="custom-control-input js-permission-switch"
              id="switch--{{ $permission->id }}--read" value="1" data-id="{{ $permission->id }}"
              {{ $permission->can_read ? 'checked' : '' }} data-action="can_read">
              <label class="custom-control-label" for="switch--{{ $permission->id }}--read">Read</label>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" class="custom-control-input js-permission-switch"
              id="switch--{{ $permission->id }}--update" value="1" data-id="{{ $permission->id }}"
              {{ $permission->can_update ? 'checked' : '' }} data-action="can_update">
              <label class="custom-control-label" for="switch--{{ $permission->id }}--update">Update</label>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" class="custom-control-input js-permission-switch"
              id="switch--{{ $permission->id }}--delete" value="1" data-id="{{ $permission->id }}"
              {{ $permission->can_delete ? 'checked' : '' }} data-action="can_delete">
              <label class="custom-control-label" for="switch--{{ $permission->id }}--delete">Delete</label>
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

      $('#data-table').on('change', '.js-permission-switch', function() {
        var id = $(this).data('id');
        var status = $(this).prop('checked');
        var action = $(this).data('action');
        var data = {
          id : id,
          status : status,
          action: action
        };
        axios.post(MRPANEL_URL + '/role-permission/edit', data)
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
