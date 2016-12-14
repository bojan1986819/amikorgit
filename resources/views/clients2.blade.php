

    <div class="row">
        <div class="col-md-12">
            <h1>Kliensek  kezelése</h1>
        </div>

    </div>

    <div class="form-group row add">
        <div class="col-md-5">
            <input type="text" class="form-control" id="title" name="title"
                   placeholder="Vezetéknév" required>
            <p class="error text-center alert alert-danger hidden"></p>
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" id="description" name="description"
                   placeholder="Keresztnév" required>
            <p class="error text-center alert alert-danger hidden"></p>
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning" type="submit" id="add">
                <span class="glyphicon glyphicon-plus"></span> Hozzáadás
            </button>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            {!! $clients->links() !!}
            <table class="table table-borderless" id="table">
                <tr>
                    <th>ID</th>
                    <th>
                        {!! Form::open(['method'=>'GET', 'url'=>'client',
                        'class'=>'navbar-form navbar-left','role'=>'search'])!!}
                        <div class="input-group custom-search-form">
                            <input type="text" name="search" class="form-control" placeholder="Keresés...">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default-sm">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </th>
                    <th>
                        {!! Form::open(['method'=>'GET', 'url'=>'client',
                        'class'=>'navbar-form navbar-left','role'=>'search'])!!}
                        <div class="input-group custom-search-form">
                            <input type="text" name="search" class="form-control" placeholder="Keresés...">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default-sm">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                    </th>
                    <th>Gombok</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Vezetéknév</th>
                    <th>Keresztnév</th>
                    <th>Gombok</th>
                </tr>
                {{ csrf_field() }}


                @foreach($clients as $client)
                    <tr class="item{{$client->id}}">
                        <td>{{$client->id}}</td>
                        <td>{{$client->last_name}}</td>
                        <td>{{$client->first_name}}</td>
                        <td>
                            <button class="edit-modal btn btn-primary" data-id="{{$client->id}}" data-title="{{$client->last_name}}" data-description="{{$client->first_name}}">
                                <span class="glyphicon glyphicon-edit"></span> Módosítás
                            </button>
                            <button class="delete-modal btn btn-danger" data-id="{{$client->id}}" data-title="{{$client->last_name}}" data-description="{{$client->first_name}}">
                                <span class="glyphicon glyphicon-trash"></span> Törlés
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>


            {!! $clients->links() !!}

        </div>
    </div>

    @include('modals.edit-client')
