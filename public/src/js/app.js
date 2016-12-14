var userId = 0;
var userLastNameElement = null;
var userFirstNameElement = null;
var userEmailElement = null;
var userAdminElement = null;

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
})


$('.userlist').find('.interaction').find('a').eq(0).on('click', function () {

    $('#newUserModal').modal();
});


$('.userlist').find('.buttonrow').find('.btn').on('click', function (event) {
    event.preventDefault();

    userLastNameElement = event.target.parentNode.parentNode.parentNode.childNodes[1].childNodes[0];
    userFirstNameElement = event.target.parentNode.parentNode.parentNode.childNodes[1].childNodes[1];
    userEmailElement = event.target.parentNode.parentNode.parentNode.childNodes[3];
    userAdminElement = event.target.parentNode.parentNode.parentNode.childNodes[5];
    var userLastName = userLastNameElement.textContent;
    var userFirstName = userFirstNameElement.textContent;
    var userEmail = userEmailElement.textContent;
    var userAdmin = userAdminElement.textContent;
    userId = event.target.parentNode.parentNode.parentNode.childNodes[1].childNodes[0].dataset['userid'];

    $('#last_nameUpdate').val(userLastName);
    $('#first_nameUpdate').val(userFirstName);
    $('#emailUpdate').val(userEmail);
    if(userAdmin.trim() == 'igen'){
        $('#adminUpdate').val(1);
    } else {
        $('#adminUpdate').val(0);
    }
    $('#updateUserModal').modal();
});

$('#user-save').on('click', function () {
    $.ajax({
        method: 'POST',
        url: urlEditUser,
        data: {last_name: $('#last_nameUpdate').val(),
            first_name: $('#first_nameUpdate').val(),
            email: $('#emailUpdate').val(),
            admin: $('#adminUpdate').val(),
            userId: userId,
            _token: token}
    })

        .done(function (msg) {
            $(userLastNameElement).text(msg['new_last_name']);
            $(userFirstNameElement).text(msg['new_first_name']);
            $(userEmailElement).text(msg['new_email']);
            if(msg['new_admin'] == 1){
                $(userAdminElement).text('igen');
            } else {
                $(userAdminElement).text('nem');
            }
            $('#updateUserModal').modal('hide');
        });
});


/* innentől kezdődnek a CRUD-hoz szükséges scriptek*/

$(document).on('click', '.edit-modal', function() {
    $('#footer_action_button').next('span.text').text(" Update");
    $('#footer_action_button').addClass('glyphicon-check');
    $('#footer_action_button').removeClass('glyphicon-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('Edit');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    $('#fid').val($(this).data('id'));
    $('#t').val($(this).data('title'));
    $('#d').val($(this).data('description'));
    $('#editClientModal').modal('show');
});
$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'post',
        url: '/editItem',
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $("#fid").val(),
            'title': $('#t').val(),
            'description': $('#d').val()
        },
        success: function(data) {
            $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.title + "</td><td>" + data.description + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
        }
    });
});
// add function
$("#add").click(function() {
    $.ajax({
        type: 'post',
        url: '/addItem',
        data: {
            '_token': $('input[name=_token]').val(),
            'title': $('input[name=title]').val(),
            'description': $('input[name=description]').val()
        },
        success: function(data) {
            if ((data.errors)) {
                $('.error').removeClass('hidden');
                $('.error').text(data.errors.title);
                $('.error').text(data.errors.description);
            } else {
                $('.error').remove();
                $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.title + "</td><td>" + data.description + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
            }
        },
    });
    $('#title').val('');
    $('#description').val('');
});

//delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').next('span.text').text(" Delete");
    $('#footer_action_button').removeClass('glyphicon-check');
    $('#footer_action_button').addClass('glyphicon-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('Delete');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#editClientModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function() {
    $.ajax({
        type: 'post',
        url: '/deleteItem',
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('.id').text()
        },
        success: function(data) {
            $('.item' + $('.id').text()).remove();
        }
    });
});
