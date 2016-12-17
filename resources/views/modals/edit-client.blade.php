<div id="editClientModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}">
                        <label class="control-label col-sm-2" for="id">ID :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fid" disabled value="{{ Request::old('id') }}">
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('client_name') ? 'has-error' : '' }}">
                        <label class="control-label col-sm-2" for="title">Név:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="t" value="{{ Request::old('client_name') }}">
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                        <label class="control-label col-sm-2" for="description">Cég:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="d" value="{{ Request::old('company_name') }}">
                        </div>
                    </div>
                </form>
                <div class="deleteContent">
                    Biztos, hogy törlöd? <span class="title"></span> ?
                    <span class="hidden id"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class='glyphicon'> </span><span class="text"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </div>
            </div>
        </div>
    </div>
</div>

session::token() }}';
var urlEditUser = '{{ route('editclient') }}';