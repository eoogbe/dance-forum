@extends('layouts.app')

@section('title')
New Role
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>New Role</h2>

  <form method="post" action="{{ route('admin.roles.store') }}">
    @include('admin.roles.form')
  </form>
</section>
@endsection
