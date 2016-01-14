@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">配置赛事</div>

                <div class="panel-body">
                    <div>
                        选择类型 具体配置:<br>
                        @foreach ($active_type as $type)
                            {{$type==1?"男单":""}}
                            {{$type==2?"女单":""}}
                            {{$type==3?"男双":""}}
                            {{$type==4?"女双":""}}
                            <a href="{{url("distribution/$active_id/$type")}}">{{$type==5?"混双循环":""}}</a>
                        @endforeach
                    </div>


                    <hr>
                    报名列表:
                    <div>
                    @if (count($result))
                        <ol>
                          @foreach ($result as $item)

                                <li>{{$item->name}}</li>

                          @endforeach
                        </ol>
                    @else
                        还没有人报名哦
                    @endif


                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
