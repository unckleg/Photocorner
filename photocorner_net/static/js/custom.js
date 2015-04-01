$(function () {
    favorite();
    var displayImage = $('img.display-image');
    displayImage.lazyload({threshold: 200});
    deleteComment();
    followUnFollow();
    deleteReply();
    reply();
    keyboardNavigation();
    var time = $('abbr.timeago');
    time.timeago();
    $('div.flash_message').not('.flash_important').delay(2000).slideUp();
    $("[data-toggle='tooltip']").tooltip();
    $('#dp1').datepicker({
        format: 'yyyy-mm-dd'
    });
});

$(function() {
	//make menus drop automatically
	$('ul.nav li.dropdown').hover(function() {
		$('.dropdown-menu', this).fadeIn();
	}, function() {
		$('.dropdown-menu', this).fadeOut('fast');
	});//hover
	
}); //jQuery is loaded

	//disable right click on photos
$('img').live('contextmenu', function(e){
    return false;
}); //jQuery is loaded


function colorChange() {
    var myImage = $(".mainImage");
    var colorThief = new ColorThief();
    var cp = colorThief.getPalette(myImage[0], 6);
    for (var i = 0; i < cp.length; i++) {
        $('.colorPalettes').append('<div class="colorPalette" style="background-color:rgb(' + cp[i][0] + ',' + cp[i][1] + ',' + cp[i][2] + ')"></div>');
    }
}

$(window).bind("load", function () {
    if ($('.mainImage').length) {
        colorChange();
    }
});

function reply() {
    var c = $(".replybutton");
    var b = $(".closebutton");
    var a = $(".replytext");
    c.on("click", function () {
        var d = $(this).attr("id");
        $(this).hide();
        $("#open" + d).show();
        a.focus()
    });
    b.on("click", function () {
        var d = $(this).attr("id");
        $("#open" + d).hide();
        c.show()
    });
    $(".replyMainButton").click(function () {
        var e = $(this).attr("id");
        var f = $("#textboxcontent" + e).val();
        var d = "textcontent=" + f + "&reply_msgid=" + e;
        if (f === "") {
            a.stop().css("background-color", "#FFFF9C")
        } else {
            $.ajax({
                type: "POST",
                url: "../../reply",
                data: d,
                success: function (h) {
                    var transform = [
                        {"tag": "hr", "html": ""},
                        {
                            "tag": "div", "class": "media", "children": [
                            {
                                "tag": "a", "class": "pull-left", "href": "${profile_link}", "children": [
                                {"tag": "img", "class": "media-object img-circle", "src": "${profile_avatar}", "alt": "${fullname}", "html": ""}
                            ]
                            },
                            {
                                "tag": "div", "class": "media-body", "children": [
                                {
                                    "tag": "h4", "class": "media-heading", "children": [
                                    {"tag": "a", "href": "${profile_link}", "html": "${fullname}"},
                                    {
                                        "tag": "span", "class": "pull-right", "children": [
                                        {"tag": "i", "class": "comment-time fa fa-clock-o fa-fw", "html": ""},
                                        {"tag": "abbr", "class": "timeago comment-time", "title": "${time}", "html": "${time}"}
                                    ]
                                    }
                                ]
                                },
                                {"tag": "p", "html": "${reply}"}
                            ]
                            }
                        ]
                        }
                    ];
                    var data = [h];
                    $(".reply-add-" + e).json2html(data, transform);
                    $("#openbox-" + e).hide(300);

                }
            })
        }
        return false
    })
}

function followUnFollow() {
    $(".follow").on("click", function () {
        var c = $(this);
        var b = "id=" + c.attr("id");
        $.ajax({
            type: "POST", url: "../../follow", data: b, success: function (a) {
                $.when(c.fadeOut(300).promise()).done(function () {
                    if (c.hasClass("btn")) {
                        c.removeClass("btn-default").addClass("btn-success").text(a).fadeIn()
                    } else {
                        c.replaceWith('<span class="notice_mid_link">' + a + "</span>")
                    }
                })
            }
        });
        return false
    })
}

function deleteComment() {
    var a = $("button.delete-comment");
    a.on("click", function () {
        var c = $(this);
        var e = c.attr("data-content");
        var b = "id=" + e;
        $.ajax({
            type: "POST", url: "../../deletecomment", data: b, success: function (d) {
                $("#comment-" + e).hide(500)
            }
        })
    })
}

function deleteReply() {
    var a = $("button.delete-reply");
    a.on("click", function () {
        var c = $(this);
        var e = c.attr("data-content");
        var b = "id=" + e;
        $.ajax({
            type: "POST", url: "../../deletereply", data: b, success: function (d) {
                $("#reply-" + e).hide(500)
            }
        })
    })
}

function favorite() {
    $(".favoritebtn").on("click", function () {
        var c = $(this);
        var b = "id=" + c.attr("id");
        $.ajax({
            type: "POST", url: "../../favorite", data: b, success: function (a) {
                $.when(c.fadeOut(300).promise()).done(function () {
                    if (c.hasClass("btn")) {
                        c.removeClass("btn-default").addClass("btn-success").text(a).fadeIn()
                    } else {
                        c.replaceWith('<span class="notice_mid_link">' + a + "</span>")
                    }
                })
            }
        });
        return false
    })
}


function keyboardNavigation() {
    $(document).keydown(function (e) {
        if (e.keyCode == 37) {
            if ($("div.controlArrow a.fa-chevron-left:first-child").attr("href").length) {
                window.location = $("div.controlArrow a.fa-chevron-left:first-child").attr("href");
            }
        }
        else if (e.keyCode == 39) {
            if ($("div.controlArrow a.fa-chevron-right:first-child").attr("href")) {
                window.location = $("div.controlArrow a.fa-chevron-right:first-child").attr("href");
            }
        }
    });
}


function run_pinmarklet() {
    var e = document.createElement('script');
    e.setAttribute('type', 'text/javascript');
    e.setAttribute('charset', 'UTF-8');
    e.setAttribute('src', 'http://assets.pinterest.com/js/pinmarklet.js?r=' + Math.random() * 99999999);
    document.body.appendChild(e);
}

