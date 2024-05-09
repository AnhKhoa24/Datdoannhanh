var searchdef ="";
//Lấy data khi thay đổi số trang trên thanh địa chỉ
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
//
$(document).ready(function () {
    $(document).on('click', '.pagination a', function (event) {
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
    });
});


function movePrevious() {

    var currentPage = document.querySelector('.pagination .page-item.active');
    var prevpage = currentPage.previousElementSibling;
    if (!prevpage || prevpage.classList.contains('prev')) {
        return;
    }
    currentPage.classList.remove('active');
    prevpage.classList.add('active');
    var page = prevpage.querySelector('.page-link').innerText;
    getData(page);
};

function moveNext() {
    var currentPage = document.querySelector('.pagination .page-item.active');
    var nextPage = currentPage.nextElementSibling;
    if (!nextPage || nextPage.classList.contains('next')) {
        return;
    }
    currentPage.classList.remove('active');
    nextPage.classList.add('active');
    var page = nextPage.querySelector('.page-link').innerText;
    getData(page);
}

function getData(page) {
    $.ajax({
        url: '/admin/sanpham?page=' + page,
        type: "get",
        datatype: "json",
        data:
        {
            search: searchdef
        }
    })
        .done(function (data) {

            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);

            location.hash = page;
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
}

function search()
{
    var search = document.querySelector('#tags-search').value;
    $.ajax({
        url: '/admin/sanpham?search=' + search,
        type: "get",
        datatype: "json",
    })
        .done(function (data) {
            searchdef = search;
            $("#danhmuc-list").empty().html(data.data);
            $("#danhsachtrang").empty().html(data.paginate);

        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
    
}

//Hàm lấy số trang hiện tại
function laysotrang() {
    var currentPage = document.querySelector('.pagination .page-item.active');
    if (!currentPage) {
        return null;
    }
    var link = currentPage.querySelector('.page-link');
    if (!link) {
        return null;
    }
    var pageNumber = link.innerText;
    return parseInt(pageNumber);
}