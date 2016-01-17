@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">设置裁判---(如果手机在平台存在,密码与昵称的设置将会被忽略)</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{ url('/manage/doSet') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="active_id" value="@if ($active_id){{ $active_id }}@endif">
                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">手机</label>

                                <div class="col-md-6">
                                    <input type="tel" class="form-control" name="mobile" value="{{ old('phone') }}">

                                    @if ($errors->has('mobile'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">密码</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">称呼</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nickname">

                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i>设置
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
