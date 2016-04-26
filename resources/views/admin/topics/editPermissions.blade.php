@extends('layouts.app')

@section('title')
Edit Permissions for {{ $topic->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit Permissions for {{ $topic->name }}</h2>

  <form method="post" action="{{ route('admin.topics.updatePermissions', compact('topic')) }}">
    {!! method_field('PUT') !!}
    {!! csrf_field() !!}

    <table>
      <thead>
        <tr>
          <th scope="col">Role</th>
          <th scope="col">Update</th>
          <th scope="col">Delete</th>
          <th scope="col">All</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($roles as $role)
          <tr class="permission-row">
            <th scope="row">{{ $role->name }}</th>
            <td>
              <input
                  type="checkbox"
                  name="update_roles[]"
                  value="{{ $role->id }}"
                  @if (in_array($role->id, old('update_roles[]', $role->isAllowedTo('update.topic.'.$topic->id) ? [$role->id] : [])))
                    checked
                  @endif
              >
            </td>
            <td>
              <input
                  type="checkbox"
                  name="destroy_roles[]"
                  value="{{ $role->id }}"
                  @if (in_array($role->id, old('destroy_roles[]', $role->isAllowedTo('delete.topic.'.$topic->id) ? [$role->id] : [])))
                    checked
                  @endif
              >
            </td>
            <td><input type="checkbox" class="all-permissions"></td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <button type="submit">Update Permissions</button>
  </form>
</section>
@endsection
