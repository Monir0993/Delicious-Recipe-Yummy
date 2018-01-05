<!doctype html>
<html class="no-js" lang="">

<head>
    @include('private.asset.css.layout_css')
    @yield('formCSS')
</head>

<body>
@include('private.common.partial.administrative.top_nav')

<section class="food">
    <div class="container">
        <div class="row" style="min-height: 76vh">
            @yield('content')
        </div>
    </div>
</section>

@include('private.home.footer')

@include('private.asset.js.layout_js')
@yield('formJS')

<script>
    $('#searchForm').submit(function(e){
        if($('#srch-term').val() == ''){
            e.preventDefault();
        }
    });
</script>

</body>

</html>