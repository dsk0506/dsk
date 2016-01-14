@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">发布成功</div>

                <div class="panel-body">
                        可以通过分享和扫描以下的地址来实现报名的传播.<br>
                        <hr>
                        报名地址:<a href="{{$url}}">{{$url}}</a><br>
                        报名二维码:<br>

                         <?php echo QrCode::size(250)->color(150,90,10)->generate($url);?>
                         <p>扫描链接分享给好友.</p>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
