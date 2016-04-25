@extends('layouts.app')

@section('title')
Edit {{ $role->name }}
@endsection

@section('sidebar')
@include('admin.common.sidebar')
@endsection

@section('content')
<section>
  <h2>Edit {{ $role->name }}</h2>

  <form method="post" action="{{ route('admin.roles.update', compact('role')) }}">
    {!! method_field('PUT') !!}
    @include('admin.roles.form')
  </form>
</section>
@endsection
