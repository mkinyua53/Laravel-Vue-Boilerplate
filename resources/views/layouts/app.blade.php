<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('_partials.header')

<body>
    @yield('content')
</body>

@include('_partials.scripts')

</html>
