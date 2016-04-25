@extends('layouts.app')

@section('title')
Manage Roles
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <header>
    <h2>Manage Roles</h2>
    @can('store', App\Role::class)
      <p><a href="{{ route('admin.roles.create') }}">New Role</a></p>
    @endcan
  </header>

  <ul>
    @foreach ($roles as $role)
      <li>
        <a href="{{ route('admin.roles.show', compact('role')) }}">{{ $role->name }}</a>
        <ul>
          @can('update', $role)
            <li><a href="{{ route('admin.roles.edit', compact('role')) }}">edit</a></li>
          @endcan
          @can('destroy', $role)
            <li>
              @include('common.delete', [
                'deletePath' => route('admin.roles.destroy', compact('role')),
              ])
            </li>
          @endcan
        </ul>
      </li>
    @endforeach
  </ul>
</section>
@endsection
