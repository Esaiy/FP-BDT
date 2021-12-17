<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/9584882bbe.js" crossorigin="anonymous"></script>

        <title>Portal Berita</title>
    </head>
    <body>
        <!-- navbar -->
        @include('includes.front.header')
        <!-- navbar end -->

        <!-- content -->
        <div class="container">
            @yield('content')
        </div>
        <!-- content end -->

        <!-- pagination -->
        <div class="container mt-2">
            @yield('pagination')
        </div>
        <!-- pagination end -->

        <!-- footer -->
        @include('includes.front.footer')
        <!-- footer end -->

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        @include('includes.front.js')
    </body>
</html>
