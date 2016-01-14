@extends('layouts.app')

@section('content')
    <p>execute upload </p>

    <form method="post" action="http://up.qiniu.com" enctype="multipart/form-data">
        <input name="token" type="hidden" value="{{ $token }}">
        <input name="file" type="file"/>
        <input type="submit" value="上传"/>
    </form>

@endsection
