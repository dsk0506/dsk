@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">我要发布赛事</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/sendDo') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">标题</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">描述</label>

                            <div class="col-md-6">
                                <textarea  class="form-control" name="content" >{{ old('content') }}</textarea>

                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('active_type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"></label>

                            <div class="col-md-6">
                                <input name="active_type[]" value="1" type="checkbox"> 男单
                                <input name="active_type[]" value="2" type="checkbox"> 女单
                                <input name="active_type[]" value="3" type="checkbox"> 男双
                                <input name="active_type[]" value="4" type="checkbox"> 女双
                                <input name="active_type[]" value="5" type="checkbox"> 混双

                                @if ($errors->has('active_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('expire_time') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">报名结束时间<br>(格式:{{ date("Y-m-d H:i:s") }})</label>

                            <div class="col-md-6">
                                <input type="datetime" class="form-control" name="expire_time" value="{{ old('expire_time') }}">

                                @if ($errors->has('expire_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('expire_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>我要发布
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
