/**
 * Created by Abhimanyu Sharma.
 */
$(function () {
    adminImageApprove();
    adminImageDisapprove();
});

function adminImageApprove() {
    $(".admin-image-approve").on("click", function () {
        var c = $(this);
        var b = "id=" + c.attr("id");
        $.ajax({
            type: "POST", url: "../../admin/images/approve", data: b, success: function (a) {
                $.when(c.fadeOut(300).promise()).done(function () {
                    if (c.hasClass("btn")) {
                        c.removeClass("btn-default").addClass("btn-success").text(a).fadeIn();
                        $('.disapprove-' + c.attr("id")).toggle();
                    } else {
                        c.replaceWith('<span class="notice_mid_link">' + a + "</span>")
                    }
                })
            }
        });
        return false;
    })
}

function adminImageDisapprove() {
    $(".admin-image-disapprove").on("click", function () {
        var c = $(this);
        var b = "id=" + c.attr("id");
        $.ajax({
            type: "POST", url: "../../admin/images/disapprove", data: b, success: function (a) {
                $.when(c.fadeOut(300).promise()).done(function () {
                    if (c.hasClass("btn")) {
                        c.removeClass("btn-default").addClass("btn-success").text(a).fadeIn();
                        $('.approve-' + c.attr("id")).toggle();
                    } else {
                        c.replaceWith('<span class="notice_mid_link">' + a + "</span>")
                    }
                })
            }
        });
        return false
    })
}