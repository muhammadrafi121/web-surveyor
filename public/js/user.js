$(document).ready(function() {
    $('#role').on('change', function() {
        if ($(this).val() == 'Surveyor') {
            $.ajax({
                url: APP_URL + '/ajax/team/',
                data: {
                    id: $(this).val()
                },
                success: function(d) {
                    var html = `<select name="team" id="team" class="form-select form-control">`;
                    for (var i = 0; i < d.length; i++) {
                        html += '<option value="' + d[i].id + '">' + d[i].name + ' / ' + d[i].inventory.name + '</option>'
                    }
                    html += `</select>`;
                    $('#team-container').html(html);
                }
            });
        } else {
            $('#team-container').html('');
        }
    });
});

function tambah() {
    $('#exampleModalLabel').html('Form Input Data User');
    $('form').attr('action', '/user');
    $('input[name="_method"]').val('POST');
    $('#exampleModal').modal('show');
}

function edit(data) {
    $('#exampleModalLabel').html('Form Update Data User');
    $('form').attr('action', '/user/' + data.id);
    $('input[name="_method"]').val('PUT');
    $('#exampleModal').modal('show');

    $('#name').val(data.name);
    $('#username').val(data.username);
    $('#role').val(data.role);
    $('#email').val(data.email);

    if (data.role == 'Surveyor') {
        $.ajax({
            url: APP_URL + '/ajax/team/',
            data: {
                id: $('#role').val()
            },
            success: function(d) {
                var html = `<select name="team" id="team" class="form-select form-control">`;
                for (var i = 0; i < d.length; i++) {
                    html += '<option value="' + d[i].id + '">' + d[i].name + ' / ' + d[i].inventory.name + '</option>'
                }
                html += `</select>`;
                $('#team-container').html(html);

                $('#team').val(data.team_id)
            }
        });
    } else {
        $('#team-container').html('');
    }
}