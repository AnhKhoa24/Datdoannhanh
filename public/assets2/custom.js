document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector("#h-header");
    var navigation = document.querySelector("#navigation");
    window.addEventListener("scroll", myfunction);

    var temp;

    function myfunction() {
        temp = header.getBoundingClientRect().top + header.getBoundingClientRect().height;
        if (temp < 0) {
            navigation.style.setProperty("position", "fixed");
            navigation.style.setProperty("top", "0px");
        } else {
            navigation.style.removeProperty("position", "fixed");
            navigation.style.removeProperty("top", "0px");
        }
    }
});

$(document).ready(function () {
    var url = window.location.pathname;
    $('.main-nav a').each(function () {
        if ($(this).attr('href') === url) {
            $(this).closest('li').addClass('active');
        }
    });
});

function xoaMes(id) {
    $.ajax({
        url: "/xoatinnhan",
        type: "post",
        delay: 250,
        dataType: 'json',
        data: {
            "_token": csrfToken,
            id: id
        },
        success: function (data) {
            getMesage();
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    })
}

function xoaAllMes(user_id) {
    $.ajax({
        url: "/xoatinnhan",
        type: "post",
        delay: 250,
        dataType: 'json',
        data: {
            "_token": csrfToken,
            user_id: user_id
        },
        success: function (data) {
           getMesage();
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    })
}

function getMesage() {
    $.ajax({
        url: "/loadtinnhan",
        type: "post",
        delay: 250,
        dataType: 'json',
        data: {
            "_token": csrfToken,
            user_id: user_id,
        },
        success: function (data) {
            if (data != 1) {
                $("#minimes").empty().html(data.data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("loi");
        }
    })
}
