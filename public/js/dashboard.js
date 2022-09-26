const jalur = $('#jalur');

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
});

function edit(data) {
    $('#form-edit').attr('action', '/location/' + data.id);
    $('#id-edit').val(data.id);
    $('#wilayah2').val(data.inventory_id);
    $('#name2').val(data.name);
}