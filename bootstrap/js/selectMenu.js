$(function () {
    $('#sf36').change(function () {
        $('#priceInput').val($('#sf36 option:selected').attr('data-date'));
    });
});