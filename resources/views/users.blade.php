@extends('layouts.master')

@section('title')
    Felhasználók kezelése
@endsection

@section('content')
    @include('includes.message-block')

    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;}
        .tg .tg-yw4l{vertical-align:top}
    </style>
    <article class="userlist">
        <div class="col-md-6">
            <header><h3>Felhasználók</h3></header>
            {{ $users->links() }}
            <table class="tg">
                <col width="200">
                <col width="200">
                <col width="80">
                <tr>
                    <th class="tg-yw4l">Név</th>
                    <th class="tg-yw4l">Email cím</th>
                    <th class="tg-yw4l">Admin jog</th>
                </tr>
                @foreach($users as $user)
                    <article class="userrows">

                            <tr>
                                <td><div data-userid="{{ $user->id }}">{{ $user->last_name }}</div><div> {{ $user->first_name }}</div></td>
                                <td>{{ $user->email }}</td>
                                <td align="center">
                                    @if ($user->admin  == 1)
                                        igen
                                    @else
                                        nem
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.delete', ['user_id' => $user->id]) }}" class="btn btn-primary">Törlés</a> |
                                    <div class="buttonrow">
                                        <a href="#" class="btn btn-primary">Módosítás</a>
                                    </div>
                                </td>
                            </tr>

                    </article>
                @endforeach
            </table>
            {{ $users->links() }}
            <div class="interaction">
                <a href="#" class="btn btn-primary">Új felhaszáló</a>
            </div>
        </div>
    </article>

    @include('modals.new-user')

    @include('modals.edit-user')

@endsection
