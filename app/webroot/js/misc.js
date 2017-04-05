$(document).ready(function () {
    $('ul.tree.viewTask > li > a').removeClass('btn-xs').addClass('btn-sm');
    $('ul.tree.viewTask li.active > a').removeClass('btn-primary').addClass('btn-info');
    $('ul.tree.tasklist > ul').remove();

    $('form.form-horizontal input[type="text"].form-control').wrap('<div class="col-sm-10"></div>');
    $('form.form-horizontal input[type="number"].form-control').wrap('<div class="col-sm-10"></div>');
    $('form.form-horizontal input[type="password"].form-control').wrap('<div class="col-sm-8"></div>');
    $('table.table').wrap('<div class="table-responsive"></div>');

    $('.datepicker').datepicker({
        autoclose: true,
        language: 'cs',
        weekStart: 1,
        format: 'yyyy-mm-dd'
    });
});