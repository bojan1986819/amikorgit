@extends('layouts.master')

@section('title')
    Főoldal
@endsection

@section('content')

    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;}
        .tg .tg-yw4l{vertical-align:top}
    </style>

    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Üdv {{ $user->first_name }}!!</h3></header>
        </div>
    </section>
    <section class="row new-post">
    <div class="col-md-8 col-sm-offset-3">
        <br>
        <p>Válassz az oldalsó menüből!</p>
    </div>
    </section>
    <section class="row new-post">
        <article class="tasklist">
            <div class="col-md-8 col-sm-offset-3">
                <header><h3>Feladataim</h3></header>
            </div>
            <div class="col-md-8 col-sm-offset-1">
            <table class="tg">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <tr>
                        <th class="tg-yw4l">Feladat</th>
                        <th class="tg-yw4l">Leírás</th>
                        <th class="tg-yw4l">Határidő</th>
                    </tr>
                    @foreach($tasks as $task)
                        <article class="taskrows">

                            <tr>
                                <td><div data-taskid="{{ $task->id }}">{{ $task->task_name }}</div><div></div></td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->enddate }}</td>
                            </tr>

                        </article>
                    @endforeach
                </table>
            </div>
        </article>
    </section>
@endsection