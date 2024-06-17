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

    const story_id = $("#story_id").val();

    if (story_id) {
        $(".star-rating label").on("click", function () {
            var rating = $(this).prev("input").val();
            $.ajax({
                url: "/rate-story",
                type: "POST",
                data: {
                    _token: $("input[name=_token]").val(),
                    rating: rating,
                    story_id: story_id,
                },
                success: function (response) {
                    if (response.success) {
                        getRating(story_id);
                    } else {
                        resetStars();
                    }
                },
                error: function (response) {
                    alert("Có lỗi xảy ra. Vui lòng thử lại.");
                },
            });
        });
    }

    if (story_id) {
        getRating(story_id);
    }

    $(".toggle-favorite").on("click", function () {
        var storyId = $(this).data("story-id");

        $.ajax({
            url: "/toggle-favorite/" + storyId,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    var isLiked = response.is_liked;
                    if (isLiked) {
                        $(".favorite-text").text("Đã thích");
                        $("button .fa-heart").addClass("active");
                        $(".toggle-favorite").data("liked", true);
                    } else {
                        $(".favorite-text").text("Thích");
                        $("button .fa-heart").removeClass("active");
                        $(".toggle-favorite").data("liked", false);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });

    const story = $(".toggle-favorite").data("story-id");

    if (story) {
        favorite();
    }
    favoriteCount();
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

function getRating(storyId) {
    $.ajax({
        url: "/get-rating/" + storyId,
        type: "GET",
        success: function (response) {
            if (response.rating !== undefined) {
                highlightStars(response.rating);
            }
        },
        error: function (response) {
            alert("Có lỗi xảy ra khi lấy đánh giá.");
        },
    });
}

function highlightStars(rating) {
    resetStars();
    $(".star-rating label").each(function (index) {
        var starValue = $(this).prev("input").val();
        if (starValue <= rating) {
            $(this).css("color", "gold");
        } else {
            $(this).css("color", "gray");
        }
    });
}

function resetStars() {
    $(".star-rating label").css("color", "gray");
}

function favoriteCount() {
    const story_id = $(".favoriteCount").data("story-id");

    $.ajax({
        url: "/favorite-count/" + story_id,
        type: "get",
        success: function (response) {
            if (response.count !== undefined) {
                $(".favoriteCount").text(response.count);
            }
        },
        error: function (response) {
            alert("Có lỗi xảy ra. Vui lòng thử lại.");
        },
    });
}

function favorite() {
    const story_id = $(".toggle-favorite").data("story-id");
    const user_id = $("#profile").data("id");

    $.ajax({
        url: "/favorite",
        type: "get",
        data: { story_id: story_id, user_id: user_id },
        success: function (response) {
            if (response.success) {
                var isLiked = response.is_liked;
                if (isLiked) {
                    $(".favorite-text").text("Đã thích");
                    $("button .fa-heart").addClass("active");
                    $(".toggle-favorite").data("liked", true);
                } else {
                    $(".favorite-text").text("Thích");
                    $("button .fa-heart").removeClass("active");
                    $(".toggle-favorite").data("liked", false);
                }
            }
        },
        error: function (response) {
            alert("Có lỗi xảy ra. Vui lòng thử lại.");
        },
    });
}
