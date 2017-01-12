<div class="modal fade" tabindex="-1" role="dialog" id="newTaskModal">
    <div class="modal-dialog">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Feladat léterhozása</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-xs-offset-1" align="center">
                        <form action="{{ route('addtask') }}" method="post">
                            <div class="form-group {{ $errors->has('task_name') ? 'has-error' : '' }}">
                                <label for="email">Feladat</label>
                                <input class="form-control" type="text" name="task_name" id="task_name" value="{{ Request::old('task_name') }}">
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="first_name">Leírás</label>
                                <input class="form-control" type="text" name="description" id="description" value="{{ Request::old('description') }}">
                            </div>
                            <div class="form-group {{ $errors->has('userid') ? 'has-error' : '' }}">
                                <label for="last_name">Felhasználó</label>
                                <select class="form-control" type="text" name="userid" id="userid" value="{{ Request::old('userid') }}">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                @endforeach
                                </select>
                                {{--<input class="form-control" type="text" name="userid" id="userid" value="{{ Request::old('userid') }}">--}}
                            </div>
                            <div class="form-group {{ $errors->has('enddate') ? 'has-error' : '' }}">
                                <label for="last_name">Határidő</label>
                                <input class="datepicker" type="text" name="enddate" id="enddate" value="{{ Request::old('enddate') }}">
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                            <button type="submit" class="btn btn-primary">Hozzáadás</button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->