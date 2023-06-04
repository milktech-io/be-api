<?php
$urlImage ='https://global-uploads.webflow.com/';
$urlImage.='61ed0aee3c612f185db2698d/62041b0ba0d17383d9d24537_615b29a11aa455948180682e_grain.gif';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>eon.io</title>
    <link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/css/bootstrap.min.css"
		ntegrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
		crossorigin="anonymous"
	>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700&display=swap" rel="stylesheet">

    <style type="text/css">
    	
    	body{
    		background: white;
    		font-family: 'Syne', sans-serif;
    		text-transform: uppercase;
    	}

    	.logo{
    		padding:6rem 2rem;
    		text-align: center;

    	}

    	.logo img{
    		max-width: 60%;
    		max-width: 200px;
    	}

    	.form-control, .form-control:focus {
		    background: transparent;
		    border: 3px solid rgb(34 42 46);
		    margin-bottom: 20px;
		    color: rgb(157 47 53);
		    height: calc(1.4em + 2rem + 7.4px);
		    padding: 1rem 2.5rem;
		    font-size: 1.05rem;
		    line-height: 1.4;
		    border-radius: 15px;

		}

		.form-control:focus{
			border-color: white;
			outline: none;

		}

		.form-control::placeholder {
		  color: rgb(34 42 46);
		  letter-spacing: 1px;
		}


		.btn-black {
		    background: #222a2e;
		    border-color: #222a2e;
		    font-family: 'Syne', sans-serif !important;
		    text-transform: uppercase;
		    padding: 1rem 2.5rem;
		    font-size: 1.05rem;
		    line-height: 1.7;
		    border-radius: 15px;
		    color: white;
		}

		.btn-cool{
			font-weight: 700;
			letter-spacing: 3px;
			font-size: 16px;
			display: block;
			margin: 50px auto 50px auto;
			color:white;
			padding-bottom:13px;
			padding-top:13px;
			text-decoration:none;
			width:300px;
			border-width:3px;
			border-radius:10px;
			border-style:solid;
			border-color:white;
			background-image: linear-gradient(180deg,rgba(0,0,0,.22), rgba(0,0,0,.22)), url({{$urlImage}});

		}
    </style>
</head>
<body>
	<div class="logo">
		<img alt="logo-eon" src="{{url('/logo.png')}}">
	</div>
	 @yield('content')
</body>
</html>