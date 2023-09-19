$(function () {
    // set date
    const days   = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    let strDay   = new Date();
    /*Default Date Picker*/
    $('.defaultDate').datepicker({
        autoclose: true,
        title: days[strDay.getDay()]+', '+months[strDay.getMonth()]+' '+strDay.getDate()+' '+strDay.getFullYear(),
        format: "dd-mm-yyyy",
        todayHighlight: true,
        clearBtn: true,
        orientation: "auto bottom",
        startView: 'month',
        maxViewMode: 'century',
        templates: {
            leftArrow: '<i class="fas fa-chevron-circle-left"></i>',
            rightArrow: '<i class="fas fa-chevron-circle-right"></i>'
        }
    });
    /*Birth Date Picker*/
    $('.birthDate').datepicker({
        autoclose: true,
        title: days[strDay.getDay()]+', '+months[strDay.getMonth()]+' '+strDay.getDate()+' '+strDay.getFullYear(),
        format: "dd-mm-yyyy",
        todayHighlight: true,
        clearBtn: true,
        orientation: "auto bottom",
        startView: 'month',
        maxViewMode: 'century',
        templates: {
            leftArrow: '<i class="fas fa-chevron-circle-left"></i>',
            rightArrow: '<i class="fas fa-chevron-circle-right"></i>'
        },
        startDate: new Date(1920, 0, 1),
    });
    /*Start Date Range Picker*/
    $(".rangeStartDate").datepicker({
        autoclose: true,
        title: days[strDay.getDay()]+', '+months[strDay.getMonth()]+' '+strDay.getDate()+' '+strDay.getFullYear(),
        format: "dd-mm-yyyy",
        todayHighlight: true,
        clearBtn: true,
        orientation: "auto bottom",
        startView: 'month',
        maxViewMode: 'century',
        templates: {
            leftArrow: '<i class="fas fa-chevron-circle-left"></i>',
            rightArrow: '<i class="fas fa-chevron-circle-right"></i>'
        },
        startDate: new Date(2020, 0, 1),
    }).on('changeDate', function (selected) {
        let minDate = new Date(selected.date.valueOf());
        $('.rangeEndDate').datepicker('setStartDate', minDate);
    }).on('clearDate', function(e) {
        $('.rangeEndDate').datepicker('setStartDate', new Date(2020, 0, 1));
        $('.rangeStartDate').datepicker('hide');
    });
    /*End Date Range Picker*/
    $(".rangeEndDate").datepicker({
        autoclose: true,
        title: days[strDay.getDay()]+', '+months[strDay.getMonth()]+' '+strDay.getDate()+' '+strDay.getFullYear(),
        format: "dd-mm-yyyy",
        todayHighlight: true,
        clearBtn: true,
        orientation: "auto bottom",
        startView: 'month',
        maxViewMode: 'century',
        templates: {
            leftArrow: '<i class="fas fa-chevron-circle-left"></i>',
            rightArrow: '<i class="fas fa-chevron-circle-right"></i>'
        }
    }).on('changeDate', function (selected) {
        let maxDate = new Date(selected.date.valueOf());
        $('.rangeStartDate').datepicker('setEndDate', maxDate);
    }).on('clearDate', function(e) {
        $('.rangeStartDate').datepicker('setEndDate', '');
        $('.rangeEndDate').datepicker('hide');
    });
});