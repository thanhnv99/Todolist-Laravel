@extends('layouts.app')

@section('title')
Todos completed
@endsection

@section('content')
<h1 class="text-center my-5">Danh sách công việc đã hoàn thành của bạn!</h1>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                Việc đã hoàn thành
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($todos as $todo)
                    <li class="list-group-item">
                        @if(!$todo->completed == 0)
                            {{ $todo->name }}
                            <a href="/todos/{{ $todo->id }}" class="btn btn-primary btn-sm float-right mr-2">View</a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            {{$todos->links()}}
        </div>
    </div>
</div>
@endsection
