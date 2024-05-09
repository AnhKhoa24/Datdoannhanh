var searchdef ="";
document.addEventListener("DOMContentLoaded", function () {
    var scrollingText = document.querySelector(".scrolling-text");
    var span = scrollingText.querySelector("span");

    if (span.offsetWidth < scrollingText.offsetWidth) {
        span.style.animation = "none";
    } else {
        span.style.animation = "marquee 10s linear infinite";
    }
});
$(window).on('hashchange', function () {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getData(page);
        }
    }
});
$(document).ready(function () {
    $(document).on('click', '.store-pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        if (page == 'next') {
            var currentPage = document.querySelector(".store-pagination li.active");
            var nextPage = currentPage.nextElementSibling;
            if (!nextPage || nextPage.classList.contains('next')) {
                return;
            }
            currentPage.classList.remove('active');
            nextPage.classList.add('active');

            var nextPageValue = nextPage.querySelector('a').getAttribute('href').split('=')[1];
            getData(nextPageValue);
            return;
        }
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        getData(page);
    });
});

function getData(page) {
    $.ajax({
        url: '/?page=' + page,
        type: "get",
        datatype: "json",
        data:{
            search: searchdef
        }
    })
        .done(function (data) {
            $("#sanpham-list").empty().html(data.list);
            $("#trang-list").empty().html(data.trang);
            var scrollingText = document.querySelector(".scrolling-text");
            var span = scrollingText.querySelector("span");

            if (span.offsetWidth < scrollingText.offsetWidth) {
                span.style.animation = "none";
            } else {
                span.style.animation = "marquee 10s linear infinite";
            }
            location.hash = page;
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });

}


function addToCart(product_id) {
    $.ajax({
        url: "/check",
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response == 0) {
                window.location.href = "/login";
                return;
            }
            $.ajax({
                url: "/add-to-cart",
                type: 'POST',
                dataType: "json",
                data: {
                    product_id: product_id,
                    "_token": csrfToken,
                },
                success: function (response) {
                   $("#minicart").empty().html(response.giohang);
                   swal("Thành công!", "Bạn đã thêm thành giỏ hàng!", "success")
                }
            })
        }
    })
}
function removeProCart(product_id)
{
    $.ajax({
        url: "/delete-to-cart",
        type: 'POST',
        dataType: "json",
        data: {
            product_id: product_id,
            "_token": csrfToken,
        },
        success: function (response) {
           $("#minicart").empty().html(response.giohang);
        }
    })
}

$(document).ready(function () {

    $(function () {
        $.ajax({
            url: "/get-tag-name",
            type: "get",
            datatype: "json",
            success: function (data) {
                tag(data);
            }
        })

        function tag(availableTags) {
            $("#tags").autocomplete({
                source: availableTags
            });
        }
    });

})

function Search() {
    var input = document.getElementById("tags").value;
    $.ajax({
        url: '/?search=' + input,
        type: "get",
        datatype: "json",
    })
        .done(function (data) {
            searchdef = input;
            $("#sanpham-list").empty().html(data.list);
            $("#trang-list").empty().html(data.trang);
            var scrollingText = document.querySelector(".scrolling-text");
            var span = scrollingText.querySelector("span");

            if (span.offsetWidth < scrollingText.offsetWidth) {
                span.style.animation = "none";
            } else {
                span.style.animation = "marquee 10s linear infinite";
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}