$(document).ready(function() {
    "use strict";
    select2();
    datatable();
});


$(document).on('click', '.customModal', function () {
    "use strict";
    var title = $(this).data('title');
    var url = $(this).data('url');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    $("#customModal .modal-title").html(title);
    $("#customModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            $('#customModal .body').html(data);
            $("#customModal").modal('show');
            select2();

        },
        error: function (data) {
            data = data.responseJSON;
            console.log(data)
        }
    });

});

// basic message
$(document).on('click', '.confirm_dialog', function(e) {
    "use strict";
    var form = $(this).closest("form");

    Swal.fire({
        title: 'Are you sure you want to delete this record ?',
        text: "This record can not be restore after delete. Do you want to confirm?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});


$(document).on('click', '.fc-day-grid-event', function (e) {
    "use strict";
    e.preventDefault();
    var event = $(this);
    var title = $(this).find('.fc-content .fc-title').html();
    var size = 'md';
    var url = $(this).attr('href');
    $("#customModal .modal-title").html(title);
    $("#customModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            $('#customModal .modal-body').html(data);
            $("#customModal").modal('show');

        },
        error: function (data) {
            data = data.responseJSON;
            $.NotificationApp.send("Error", data.error, "top-right", "rgba(0,0,0,0.2)", "error");
        }
    });
});


function toastrs(title, message, status) {
    "use strict";
    if(status=='success'){
        var msg_status='primary';
    }else{
        var msg_status='danger';
    }
    $.notify(
        {
            title: '',
            message: message,
            icon: '',
            url: '',
            target: '_blank'
        },
        {
            element: 'body',
            type: msg_status,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 3300,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
}

function convertArrayToJson(form) {
    "use strict";
    var data = $(form).serializeArray();
    var indexed_array = {};

    $.map(data, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function select2(){
    "use strict";
    $('.basic-select').select2();
    $('.hidesearch').select2({
        minimumResultsForSearch: -1
    });
}

function datatable(){
    "use strict";
    //Local Datatable JS
    $('.basicdata-tbl').DataTable({
        "scrollX": true,
    });


    //Advance Datatable
    $('.datatbl-advance').DataTable({
        "scrollX": true,
        stateSave: false,
        dom: 'Bfrtip',
        buttons: [
            'print','excel','pdf', 'csv', 'copy',
        ]
    });
}
