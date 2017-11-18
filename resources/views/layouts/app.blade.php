<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Feed Reader</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="csrf-token" content="{!! csrf_token() !!}">
</head>
<body >
@yield('content')


<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>

<script type="text/javascript">
    $('.delete-button').click(function () {
        if (window.confirm("Are you sure to delete this item ?") === true) {

            var self = $(this),
                    url = self.attr('data-delete-url');

            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    '_token': $('meta[name=csrf-token]').attr("content")
                },
                error: function (xhr, error) {
                    console.log(error);
                    self.loading = false;
                    location.reload();
                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
</script>

@yield('scripts')
</body>
</html>