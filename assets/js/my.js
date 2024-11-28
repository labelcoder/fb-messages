const ajaxSubmitForm = (formId, dataType, callBackFunc) => {
    var formObj = $("#" + formId);
    var formUrl = formObj.attr("action");
    var formMethod = formObj.attr("method");
    var formData = formObj.serialize();
    $.ajax({
        type: formMethod,
        url: formUrl,
        dataType: dataType,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            callBackFunc(data);
        },
    });
    return false;
};
const sweetNotify = (notifyType, message, title, timelimit) => {
    Swal.fire({
        title: title,
        timer: timelimit,
        text: message,
        icon: notifyType,
    });
};
const confirmDelNotify = (dataId, dataUrl, message) => {
    Swal.fire({
        title: "แจ้งเตือน",
        text: message,
        icon: "warning", //
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ตกลง",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: dataUrl,
                dataType: "json",
                data: {
                    del_id: dataId,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    if (data.success) {
                        sweetNotify(
                            "success",
                            "ลบรายการสำเร็จ",
                            "แจ้งแตือน"
                        );
                        setTimeout(() => {
                            location.reload();    
                        }, 2500);
                        // $("#item-" + dataId).remove();
                    } else {
                        sweetNotify(
                            "error",
                            "ลบรายการไม่สำเร็จ",
                            "แจ้งแตือน"
                        );
                    }
                },
            });
        }
    });
};
// function ajaxConfirmDel(_id, _url) {
//     Swal.fire(
//         {
//             title: "แจ้งเตือน",
//             text: "คุณแน่ใจต้องการลบรายการนี้?",
//             type: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#DD6B55",
//             confirmButtonText: "ตกลง",
//             cancelButtonText: "ยกเลิก",
//             closeOnConfirm: false,
//         },
//         function () {
//             $.ajax({
//                 type: "post",
//                 url: _url,
//                 dataType: "json",
//                 data: {
//                     del_id: _id,
//                 },
//                 headers: {
//                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                         "content"
//                     ),
//                 },
//                 success: function (data) {
//                     if (data.status) {
//                         $("#item-" + _id).remove();
//                         ajaxSweetAlert(
//                             "success",
//                             "ลบรายการสำเร็จ",
//                             "แจ้งแตือน"
//                         );
//                     } else {
//                         ajaxSweetAlert(
//                             "error",
//                             "ลบรายการไม่สำเร็จ",
//                             "แจ้งแตือน"
//                         );
//                     }
//                 },
//             });
//         }
//     );
// }
