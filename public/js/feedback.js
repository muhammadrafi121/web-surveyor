const jalur = $('#jalur');

$(document).ready(function() {
});

function admcontact() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Isi Form Berikut untuk Mengontak Admin');
    $('#subject-title').text('Subjek Kasus');
    $('#subject-subtitle').text('Mohon isi subjek kasus yang akan Anda laporkan');
    $('#desc-title').text('Deskripsi Kasus');
    $('#desc-subtitle').text('Jelaskan secara rinci kasus yang ingin ditanyakan atau diatasi');
    $('#target').val('admin');
}

function feedback() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Isi untuk Memulai Feedback Forum');
    $('#subject-title').text('Judul');
    $('#subject-subtitle').text('Silakan isi judul forum');
    $('#desc-title').text('Isi Bahasan');
    $('#desc-subtitle').text('Sampaikan isi bahasan yang akan dibahas');
    $('#target').val('all');
}