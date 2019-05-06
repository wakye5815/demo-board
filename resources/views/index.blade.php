<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" style="height:100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
</head>

<body style="height:100%">
    <div id="app">

    </div>
</body>
<script src="{{ mix('js/main.js') }}"></script>

</html>