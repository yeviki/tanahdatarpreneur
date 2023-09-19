"use strict";
$(function () {
    $(".message-toggle").parent().on('shown.bs.dropdown', function() {
        $(".dropdown-list-message").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
            cursorwidth: 7
        });
    });
    $(".notification-toggle").parent().on('shown.bs.dropdown', function() {
        $(".dropdown-list-icons").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
            cursorwidth: 7
        });
    });
    $('.btn-sidebar-toggler').on('click',function(){
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
    });
    $('#sidebarCollapse, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });
    let sidebar_nicescroll;
    let update_sidebar_nicescroll = function() {
        let a = setInterval(function() {
            if(sidebar_nicescroll != null)
                sidebar_nicescroll.resize();
        }, 10);
        setTimeout(function() {
            clearInterval(a);
        }, 600);
    }
    $("#sidebar").niceScroll({
        cursoropacitymin: 0,
        cursoropacitymax: .8,
        zindex: "auto"
    });
    let sidebar_dropdown = function() {
        if($("#sidebar").length) {
            sidebar_nicescroll = $("#sidebar").getNiceScroll();
            $(".sidebar-menu a.has-dropdown").off('click').on('click', function() {
                update_sidebar_nicescroll();
            });
        }
    }
    sidebar_dropdown();
    $('body').show();
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 1000);
    /*----- Select2 -----*/
    $(".select-data").select2({
        minimumResultsForSearch: Infinity,
        allowClear: false,
        width: '100%',
        placeholder: "Pilih Data",
    });
    $(".select-all").select2({
        placeholder: "Pilih Data",
        allowClear: true,
        width: '100%',
    });
    /*----- Select2 -----*/
});

let alertMessage = (function() {
    function alertMessage() {}
    alertMessage.prototype.error = function(message) {
        let html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                        '<strong>Error!</strong>'+' '+
                        '<span id="pesanErr">'+message+'</span>'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                    '</div>';
        return html;
    };
    alertMessage.prototype.success = function(message) {
        let html = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                        '<strong>Success!</strong>'+' '+
                        '<span>'+message+'</span>'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                    '</div>';
        return html;
    };
    return alertMessage;
})();