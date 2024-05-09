
@extends('layouts.adminlayout')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Email Template</title>
</head>
<body>
    <h1>Hello, {{ $username }}</h1>
    <p>This is the content of your email.</p>
</body>
</html>
@endsection

