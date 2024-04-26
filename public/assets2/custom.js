document.addEventListener("DOMContentLoaded", function() {
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