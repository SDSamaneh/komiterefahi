@include('dashboard.partials.common.header')
<!--Header START -->
@include('dashboard.partials.common.topNav')

@include('dashboard.partials.common.sidebar')

<!-- MAIN CONTENT START -->
@yield('content')
<!-- MAIN CONTENT END -->
@include('dashboard.partials.common.footer')