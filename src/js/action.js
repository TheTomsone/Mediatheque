$(document).ready(function () {
    $('form').submit(function(e) {

        $('#grid-movie').load('controller.php', { fonction: 'chooseData'});
        refresh();

    })
})