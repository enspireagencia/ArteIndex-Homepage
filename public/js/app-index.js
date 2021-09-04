function throttle(fn, delay) {
    var last = undefined;
    var timer = undefined;

    return function () {
        var now = +new Date();

        if (last && now < last + delay) {
            clearTimeout(timer);

            timer = setTimeout(function () {
                last = now;
                fn();
            }, delay);
        } else {
            last = now;
            fn();
        }
    };
}

function onScroll() {
    if (window.pageYOffset) {
        $$header.classList.add('is-stick');
    } else {
        $$header.classList.remove('is-stick');
    }
}

var $$header = document.querySelector('#header');

window.addEventListener('scroll', throttle(onScroll, 25));

document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '.splide',{
        arrows: false,
        pagination: false,
        type    : 'loop',
        perPage : 2,
        autoplay: true,
        interval: 2000
    } ).mount();
} );