@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">我要报名</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/signDo') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="activeId" value="{{$activeId}}">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">赛事名称:</label>
                            <div class="col-md-6">
                                {{$title}}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">赛事描述:</label>
                            <div class="col-md-6">
                                {{ $content }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">活动类型:</label>
                            <div class="col-md-6">

                               @foreach($activeType as $type)
                                    <?php
                                        switch($type){
                                            case 1:
                                                echo "<input type='checkbox' name='active_type[]' value='1'>单打&nbsp&nbsp";
                                                break;
                                            case 2:
                                                echo "<input type='checkbox' name='active_type[]' value='2'>双打&nbsp&nbsp";
                                                break;
                                        }
                                    ?>
                               @endforeach
                            </div>
                        </div>
                        @if(!$isLogin)
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">称呼:</label>
                            <div class="col-md-6">
                                <input type="text" name="name">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">手机号码:</label>
                            <div class="col-md-6">
                                <input type="text" name="phone">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>报名
                                </button>
                            </div>
                        </div>
                        @if($errors)
                            {{$errors->first('active_type')}}
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
