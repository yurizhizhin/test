$(function () {
    function fetchUserList() {
        $.ajax({
            type: 'POST',
            url: '/site/user-list',
            success: function (response) {
                $('#user_list_content').html('');
                $('#user_list_content').html(response);
            }
        });
    }

    $('#user_list_modal_btn').click(function () {
        fetchUserList();
    });

    $(document).on('click', '#user_save_btn', function (e) {
        $.ajax({
            type: 'POST',
            url: '/site/create-user',
            data: $('#user_form').serialize(),
            success: function (response) {
                let data = JSON.parse(response);

                if (!data.success) {
                    $('#alert').html(alert(data.message, 'warning'));
                } else {
                    location.reload();
                }
            }
        });
    });

    function alert(message, type) {
        return '<div class="alert alert-'+ type +' alert-dismissible fade show" role="alert">\n' +
            message + '\n' +
            '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>\n' +
            '</div>'
    }

    $(document).on('click', '.user-delete', function (e) {
        let current = $(e.currentTarget);

        $.ajax({
            type: 'POST',
            url: '/site/delete-user',
            data: {
                userID: current.attr('data-field')
            },
            success: function (response) {
                let data = JSON.parse(response);

                if (data.success) {
                    location.reload();
                } else {
                    $('#alert').html(alert(data.message, 'warning'));
                }
            }
        });
    });
});