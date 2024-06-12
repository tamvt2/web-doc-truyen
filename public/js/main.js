$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    $(".removeRow").click(function (e) {
        e.preventDefault();
        if (confirm("Xóa mà không thể khôi phục. Bạn có chắc?")) {
            var id = $(this).data("id");
            var url = $(this).data("url");

            var data = {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: id,
            };

            $.ajax({
                url: url,
                type: "DELETE",
                data: data,
                success: function (result) {
                    alert(result.message);
                    if (result.error === false) {
                        location.reload();
                    }
                },
            });
        }
    });
});

$("#upload").change(function () {
    const form = new FormData();
    form.append("file", $(this)[0].files[0]);

    $.ajax({
        processData: false,
        contentType: false,
        type: "POST",
        dataType: "json",
        data: form,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/upload/services",
        success: function (results) {
            if (results.error === false) {
                $("#image_show").html(
                    '<a href="' +
                        results.url +
                        '" target="_blank"><img src="' +
                        results.url +
                        '" width="100px"></a>'
                );
                $("#cover_image").val(results.url);
            } else {
                alert("Upload File Lỗi");
            }
        },
    });
});
