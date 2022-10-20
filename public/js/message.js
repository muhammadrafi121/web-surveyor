const jalur = $('#jalur');

$(document).ready(function() {
});

function admcontact() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Input Balasan Pesan Admin');
    $('#url').val(location.href);
    $('#target').val('admin');
}

function feedback() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Input Balasan Feedback Forum');
    $('#url').val(location.href);
    $('#target').val('all');
}