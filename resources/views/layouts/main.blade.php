
<!doctype html>
<html lang="en">

<head>
	<title>
		Aplikasi Perizinan Kegiatan Ormawa | @yield("title")
	</title>
	<link rel="icon" type="image/png" href="{{ url('/images/logo-polindra.png') }}" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
	@include("layouts.css.style_css")

	@yield("css")
	
</head>

<body>
	<div id="wrapper">

		@include("layouts.header")
		
		@include("layouts.sidebar")
			
		@yield("content")
		
		<div class="clearfix"></div>
		
		@include("layouts.footer")
		
	</div>
	
	@include("layouts.javascript.style_javascript")

	@yield("javascript")
	
</body>

</html>
