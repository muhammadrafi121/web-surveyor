const jalur = $('#jalur');
const tim = $('#tim');

let report = null;

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

function tambah() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Input Data Daily Report');
    $('#pilihan').html('');
    $('#form-action').attr('action', '/dailyreport/');
    $('input[name="_method"]').val('POST');
    report = null;
}

function edit(data) {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Update Data Daily Report');

    $.ajax({
        url: APP_URL + '/ajax/dailyreport/',
        data: {
            id: data.id
        },
        success: function(d) {
            var elements = $('#wilayah option');
            for (var i = 0; i < elements.length; i++) {
                // console.log(elements[i].value == d.location.inventory.id);
                if (elements[i].value == d.location.inventory.id) elements[i].setAttribute('selected', true);
            }

            elements = $('#jalur option');
            for (var i = 0; i < elements.length; i++) {
                // console.log(elements[i].value == d.location.inventory.id);
                if (elements[i].value == d.location.id) elements[i].setAttribute('selected', true);
            }

            elements = $('#tim option');
            for (var i = 0; i < elements.length; i++) {
                if (elements[i].value == d.team.id) elements[i].setAttribute('selected', true);
            }
            
            report = d;
        }
    });

    $('#form-action').attr('action', '/dailyreport/' + data.id);
    $('#id-edit').val(data.id);
    $('input[name="_method"]').val('PUT');
    
}

function saveData() {
    $('#jalur-id').val($('#jalur').val());
    $('#tim-id').val($('#tim').val());

    $('#data-jalur').html('JALUR : ' + $('#jalur option:selected').text());
    $('#data-tim').html('TIM : ' + $('#tim option:selected').text());

    if (report) {
        report.manpowers[0].status == 1 ? $('#koordinator').attr('checked', true) : $('#koordinator').removeAttr('checked');
        $('#koord-id').val(report.manpowers[0].id);
        report.manpowers[1].status == 1 ? $('#surveyor1').attr('checked', true) : $('#surveyor1').removeAttr('checked');
        $('#surveyor1-id').val(report.manpowers[1].id);
        report.manpowers[2].status == 1 ? $('#surveyor2').attr('checked', true) : $('#surveyor2').removeAttr('checked');
        $('#surveyor2-id').val(report.manpowers[2].id);
        report.manpowers[3].status == 1 ? $('#admin1').attr('checked', true) : $('#admin1').removeAttr('checked');
        $('#admin1-id').val(report.manpowers[3].id);
        report.manpowers[4].status == 1 ? $('#admin2').attr('checked', true) : $('#admin2').removeAttr('checked');
        $('#admin2-id').val(report.manpowers[4].id);
        report.manpowers[5].status == 1 ? $('#driver').attr('checked', true) : $('#driver').removeAttr('checked');
        $('#driver-id').val(report.manpowers[5].id);

        report.facilities[0].status == 1 ? $('#gps').attr('checked', true) : $('#gps').removeAttr('checked');
        $('#gps-id').val(report.facilities[0].id);
        report.facilities[1].status == 1 ? $('#laptop').attr('checked', true) : $('#laptop').removeAttr('checked');
        $('#laptop-id').val(report.facilities[1].id);
        report.facilities[2].status == 1 ? $('#printer').attr('checked', true) : $('#printer').removeAttr('checked');
        $('#printer-id').val(report.facilities[2].id);
        report.facilities[3].status == 1 ? $('#kamera').attr('checked', true) : $('#kamera').removeAttr('checked');
        $('#kamera-id').val(report.facilities[3].id);
        report.facilities[4].status == 1 ? $('#scanner').attr('checked', true) : $('#scanner').removeAttr('checked');
        $('#scanner-id').val(report.facilities[4].id);
        report.facilities[5].status == 1 ? $('#mobil').attr('checked', true) : $('#mobil').removeAttr('checked');
        $('#mobil-id').val(report.facilities[5].id);
        report.facilities[6].status == 1 ? $('#motor').attr('checked', true) : $('#motor').removeAttr('checked');
        $('#motor-id').val(report.facilities[6].id);
        report.facilities[7].status == 1 ? $('#apd').attr('checked', true) : $('#apd').removeAttr('checked');
        $('#apd-id').val(report.facilities[7].id);
        report.facilities[8].status == 1 ? $('#atk').attr('checked', true) : $('#atk').removeAttr('checked');
        $('#atk-id').val(report.facilities[8].id);
        report.facilities[9].status == 1 ? $('#cat').attr('checked', true) : $('#cat').removeAttr('checked');
        $('#cat-id').val(report.facilities[9].id);

        $('#id-edit').val(report.id);

        $('#tanggal').val(report.date);
        $('#cuaca').val(report.weather);
        $('#waktum').val(report.time_start);
        $('#waktus').val(report.time_end);
        $('#kegiatan').val(report.activities[0].activity);
        $('#kegiatan-id').val(report.activities[0].id);
    } else {
        $('input[type="checkbox"]').each(function() {
            $(this).removeAttr('checked')
        });

        $('#id-edit').val(null);

        $('#tanggal').val(null);
        $('#cuaca').val(null);
        $('#waktum').val(null);
        $('#waktus').val(null);
        $('#kegiatan').val(null);

        $('#koord-id').val(null);
        $('#surveyor1-id').val(null);
        $('#surveyor2-id').val(null);
        $('#admin1-id').val(null);
        $('#admin2-id').val(null);
        $('#driver-id').val(null);

        $('#gps-id').val(null);
        $('#laptop-id').val(null);
        $('#printer-id').val(null);
        $('#kamera-id').val(null);
        $('#scanner-id').val(null);
        $('#mobil-id').val(null);
        $('#motor-id').val(null);
        $('#apd-id').val(null);
        $('#atk-id').val(null);
        $('#cat-id').val(null);
        $('#kegiatan-id').val(null);
    }
}

function showHistory(id) {
    $('#report-modal-' + id).modal('hide');
    $('#history-modal-' + id).modal('show');
}