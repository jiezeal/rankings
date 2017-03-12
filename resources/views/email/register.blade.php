<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel App</title>
</head>
<body>
<h1>Hello Confirm Your Email</h1>
<a href="{{ url('/web/user/verify/'.$confirm_code) }}">Click To Confirm</a>
</body>
</html>