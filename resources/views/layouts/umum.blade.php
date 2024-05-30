<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>

    </title>
    <style>
      th td {
        padding: 5px 5px !important;
        margin: 0px !important;
      }
    </style>
		<!-- Site favicon -->
<link
    rel="apple-touch-icon"
    sizes="180x180"
    href="vendors/images/apple-touch-icon.png"/>
<link
    rel="icon"
    type="image/png"
    sizes="32x32"
    href="vendors/images/favicon-32x32.png"/>
<link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="vendors/images/favicon-16x16.png"/>

<!-- Mobile Specific Metas -->
<meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1"/>

    @include('layouts.header')

	</head>
	<body class="bg-sm body-sm">
        @yield('content')

		@include('layouts.footer')
    @include('sweetalert::alert')
    @yield('myScript')
	</body>
</html>
