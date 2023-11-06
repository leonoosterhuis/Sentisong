<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Loyasoft Company">
    <meta name="author" content="Loyasoft">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
{{--    <meta name="author" content="">--}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autotab/1.9.2/js/jquery.autotab.min.js" integrity="sha512-wKEDUO5yhx+KCNN/Kz6ksfeK00p/76dfENygq3LktbGl5zKSMpSm3zaBO0KFTKxqc689yf7gNUEViXz3c4jBFA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.jqueryui.min.css"/>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.jqueryui.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    @vite($assetsLinks)
</head>
