<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')

</head>
<body>


    <div style="display: block">

    @include('partials.nav')

    @yield('body')

    @include('partials.script')
    </div>

</body>
</html>
