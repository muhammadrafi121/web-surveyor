const jalur = $('#jalur');
const jalur2 = $('#jalur2');

$(document).ready(function() {

    $('#wilayah').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/inventory/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].locations.length; i++) {
                    html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
                }
                jalur.html(html);
            }
        });
    });

    $('#wilayah2').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/inventory/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].locations.length; i++) {
                    html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
                }
                jalur2.html(html);
            }
        });
    });
});

function edit(data) {
    $.ajax({
        url: APP_URL + '/ajax/inventory/',
        data: {
            id: data.location.inventory_id
        },
        success: function(d) {
            var html = '';
            for (var i = 0; i < d[0].locations.length; i++) {
                html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
            }
            jalur2.html(html);
        }
    });
    $('#form-edit').attr('action', '/tower/' + data.id);
    $('#id-edit').val(data.id);
    $('#wilayah2').val(data.location.inventory_id);
    $('#jalur2').val(data.location_id);
    $('#tapak2').val(data.no);
    $('#lat2').val(data.lat);
    $('#long2').val(data.long);
    $('#type2').val(data.type);
}

function showHistory(id) {
    $('#modal-' + id).modal('hide');
    $('#history-modal-' + id).modal('show');
}