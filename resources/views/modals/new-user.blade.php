<div class="modal fade" tabindex="-1" role="dialog" id="newUserModal">
    <div class="modal-dialog">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Új Felhasználó</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-xs-offset-1" align="center">
                        <form action="{{ route('signup') }}" method="post">
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">Email cím</label>
                                <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
                            </div>
                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <label for="first_name">Keresztnév</label>
                                <input class="form-control" type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label for="last_name">Családnév</label>
                                <input class="form-control" type="text" name="last_name" id="last_name" value="{{ Request::old('last_name') }}">
                            </div>
                            <div class="form-group {{ $errors->has('admin') ? 'has-error' : '' }}">
                                <label for="admin">Admin</label>
                                <select class="form-control" type="admin" name="admin" id="admin" value="{{ Request::old('admin') }}">
                                    <option value="1">igen</option>
                                    <option value="0">nem</option>
                                </select>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password">Jelszó</label>
                                <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
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