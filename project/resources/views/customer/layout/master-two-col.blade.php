<!DOCTYPE html>
<html lang="en">
<head>
   @include('customer.layout.head-tag')
   @yield('head-tag')
</head>
<body>
    @include('customer.layout.header')

    <section class="container-xxl body-container">
        @yield('customer.layouts.sidebar')
    </section>

    <main id="main-body-one-col" class="main-body">
    

    @yield('content')

    
    </main>

    @include('customer.layout.footer')
    @include('customer.layout.script')
    @yield('script')
</body>
</html>