@extends('layouts.master')

@section('title')
    Feladatok
@endsection

@section('content')
    @include('includes.message-block')

    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;}
        .tg .tg-yw4l{vertical-align:top}
        .interaction{margin-top:20px;}
    </style>
    <article class="tasklist">
        <div class="col-md-8">
            <header><h3>Feladatok</h3></header>
            {{ $tasks->links() }}
            <table class="tg">
                <col width="200">
                <col width="200">
                <col width="80">
                <tr>
                    <th class="tg-yw4l">Feladat</th>
                    <th class="tg-yw4l">Leírás</th>
                    <th class="tg-yw4l">Felhasználó</th>
                    <th class="tg-yw4l">Határidő</th>
                    <th class="tg-yw4l">Kezelés</th>
                </tr>
                @foreach($tasks as $task)
                    <article class="taskrows">

                        <tr>
                            <td><div data-taskid="{{ $task->id }}">{{ $task->task_name }}</div><div></div></td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->first_name }}</td>
                            <td>{{ $task->enddate }}</td>
                            <td>
                                <div class="buttonrow">
                                    <a href="{{ route('task.delete', ['id' => $task->id]) }}" class="btn btn-primary">Törlés</a>
                                    {{--<a href="#" class="btn btn-primary" id="editbtn">Módosítás</a>--}}
                                </div>
                            </td>
                        </tr>

                    </article>
                @endforeach
            </table>

            {{ $tasks->links() }}
            <div class="interaction">
                <a href="#" class="btn btn-primary">Feladat hozzáadása</a>
            </div>
        </div>
    </article>

    @include('modals.new-task')

{{--    @include('modals.edit-user')--}}

    <script>
        $('.tasklist').find('.interaction').find('a').eq(0).on('click', function () {

            $('#newTaskModal').modal();
        });


        jQuery(window).load(function() {

            // formats: http://api.jqueryui.com/datepicker/#option-dateFormat
            jQuery(".datepicker").datepicker(
                {
                    "disabled":false,
                    "dateFormat":"yy-mm-dd",
                    "changeMonth": true,
                    "changeYear": true,
                    "firstDay": 1,
                    "showOn":'both'
                }
            ).next('button').button({
                icons: {
                    primary: 'ui-icon-calendar'
                }, text:false
            }).css({'font-size':'80%', 'margin-left':'2px', 'margin-top':'-5px'});

        });
    </script>

@endsection