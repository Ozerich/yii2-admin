$(function () {
    $('.callout').on('click', function() {
        $(this).fadeOut(500);
    });
});


function toggleSidebar() {
    if ($('body').hasClass('sidebar-collapse')) {
        $('body').removeClass('sidebar-collapse');
    } else {
        $('body').addClass('sidebar-collapse');
    }
    document.cookie = "sidebar="+($('body').hasClass('sidebar-collapse') ? 'collapse' : '')+";path=/";
}