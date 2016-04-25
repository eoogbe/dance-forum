<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>
    @hassection('title')
      @yield('title') | Dance Forum
    @else
      Dance Forum
    @endif
  </title>

  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
  <a href="#main">Skip to main content</a>
  <header>
    <h1><a href="{{ url('/') }}">Dance Forum</a></h1>

    @can('index', App\Board::class)
      <ul>
        <li><a href="{{ url('/admin') }}">Admin</a></li>
      </ul>
    @endcan

    <ul>
      @if (Auth::guest())
        <li><a href="{{ url('/login') }}">login</a></li>
        <li><a href="{{ url('/register') }}">register</a></li>
      @else
        <li><a href="{{ url('/logout') }}">logout</a></li>
      @endif
    </ul>
  </header>

  @yield('sidebar')

  <main id="main">
    @yield('content')
  </main>
</body>
</html>
