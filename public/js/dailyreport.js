const jalur = $('#jalur');
const tim = $('#tim');

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

                html = '';
                for (var i = 0; i < d[0].teams.length; i++) {
                    html += '<option value="' + d[0].teams[i].id + '">' + d[0].teams[i].name + ' / ' + d[0].name + '</option>'
                }
                tim.html(html)
            }
        });
    });
});