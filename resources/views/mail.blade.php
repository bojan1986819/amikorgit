@extends('layouts.master')

@section('title')
    Email küldése
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Email küldése</h1>
            <hr>
            <form action="{{ url('postemail') }}" method="POST">
                <div class="form-group">
                    <label name="email">Feladó:</label>
                    <input id="email" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label name="email">Feladó neve:</label>
                    <input id="emailname" name="emailname" class="form-control">
                </div>

                <div class="form-group">
                    <label name="subject">Téma:</label>
                    <input id="subject" name="subject" class="form-control">
                </div>

                <div class="form-group">
                    <label name="message">Üzenet:</label>
                    <textarea id="message" name="message" class="form-control" placeholder="Ide írd az üzeneted"></textarea>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">

                <input type="submit" value="Üzenet küldése" class="btn btn-success">
            </form>
        </div>
    </div>
    <script>
        var editor_config = {
            path_absolute : "localhost/amikor/public/vendor/",
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            language: "hu_HU",
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
//            file_browser_callback : function(field_name, url, type, win) {
//                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
//                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
//
//                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
//                if (type == 'image') {
//                    cmsURL = cmsURL + "&type=Images";
//                } else {
//                    cmsURL = cmsURL + "&type=Files";
//                }
//
//                tinyMCE.activeEditor.windowManager.open({
//                    file : cmsURL,
//                    title : 'Filemanager',
//                    width : x * 0.8,
//                    height : y * 0.8,
//                    resizable : "yes",
//                    close_previous : "no"
//                });
//            }
        };

        tinymce.init(editor_config);
    </script>

@endsection
