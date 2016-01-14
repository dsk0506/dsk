@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">录入分数({{$group_name}})</div>

                <div class="panel-body">
                    <form class="form-inline" role="form" method="POST" action="{{ url('/enterDo') }}">
                        {!! csrf_field() !!}
                          <input type="hidden" name="group_name" value="{{$group_name}}">
                          <input type="hidden" name="group_uid" value="{{$group_uid}}">
                          <input type="hidden" name="active_id" value="{{$active_id}}">
                          <div class="form-group">
                            <input type="number" class="form-control" name="score1" id="score1" placeholder="比分1">
                          </div>
                          <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword3">:</label>
                            <input type="number" class="form-control" name="score2" id="score2" placeholder="比分2">
                          </div>

                           <button type="submit" class="btn btn-default">录入</button>
                    </form>


                </div>
                <div class="panel-body">
                    <ol>
                    @foreach($result as $key=>$value)
                        <li>{{$value->group_name}}      {{$value->score1}}:{{$value->score2}}</li>
                    @endforeach
                    </ol>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
