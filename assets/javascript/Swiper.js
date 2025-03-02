document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            1200: { slidesPerView: 4, spaceBetween: 20 },
            992: { slidesPerView: 3, spaceBetween: 15 },
            768: { slidesPerView: 2, spaceBetween: 10 },
            576: { slidesPerView: 1, spaceBetween: 10 }
        }
    });
});
