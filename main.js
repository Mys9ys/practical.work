"use strict";

jQuery(function (i) {


    $(".js-spiker-slider").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow: $('.prev1'),
        nextArrow: $('.next1'),
        responsive: [{
            breakpoint: 700,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 540,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 460,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }]
    });



    i(".toggle_menu").click(function () {
        return i(".menu").toggleClass("active"), i("body").toggleClass("deactive"), !1
    }), i(".close_menu").click(function (e) {
        console.log(e)
        return i(".menu").removeClass("active"), i("body").removeClass("deactive"), !1
    }), i(".btn_filter").click(function () {
        return i(".filters").addClass("active"), i("body").addClass("_deactive"), !1
    }), i(".сlose_filter").click(function () {
        return i(".filters").removeClass("active"), i("body").removeClass("_deactive"), !1
    }),
        i(".carousel_head").slick({
            dots: !0,
            arrows: !1,
            infinite: !0,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: !0,
            autoplaySpeed: 6e3,
            speed: 1500,
            fade: !0,
            adaptiveHeight: true
        }), i(".carousel_about, .main-reviews__carousel").slick({
            dots: !1,
            arrows: !0,
            infinite: !0,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        }), i(".js-carousel-speakers").slick({
            dots: !1,
            arrows: !0,
            infinite: !0,
            slidesToShow: 5,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        }), i(".carousel_reviews").slick({
            dots: !1,
            arrows: !0,
            infinite: !1,
            slidesToShow: 1,
            slidesToScroll: 1
        }), i(".carousel_news").slick({
            dots: !1,
            arrows: !0,
            infinite: !1,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [{
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 459,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
        }), i(".carousel_partner").slick({
            dots: !1,
            arrows: !0,
            infinite: !0,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                breakpoint: 540,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 460,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }]
        }),
        i(".team_photo").slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: ".team_text",
            dots: !1,
            centerMode: !1,
            focusOnSelect: !0,
            infinite: !1,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }]
        }), i(".team_text").slick({
            adaptiveHeight: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: !1,
            fade: !0,
            asNavFor: ".team_photo"
        }),
        i("a[href='#callback'], a[href='#mailing'], a[href='#video'], a.video-play").magnificPopup({
            mainClass: "my-mfp-zoom-in",
            removalDelay: 300,
            closeOnBgClick: false,
            type: "inline",
            closeMarkup: "<button title=\"%title%\" type=\"button\" class=\"mfp-close\">" +
                "<svg class=\"svg __svg__close\"><use xlink:href=\"/local/templates/eurokappa_versality/assets/icons.svg?#svg-close\"></use></svg>" +
                "</button>",
            callbacks: {
                open: function (modal) {
                    var magnificPopup = $.magnificPopup.instance
                    var magnificPopupContent = magnificPopup.content[0]
                    var magnificPopupJSvideoYoutube = magnificPopupContent.querySelector('iframe')

                    $(magnificPopup.content).find('.mfp-close').on('click', function () {
                        magnificPopup.close()
                    })

                    $(magnificPopup.wrap).on('mousedown', function (evt) {
                        if (!$(magnificPopup.content).is(evt.target) && $(magnificPopup.content).has(evt.target).length === 0) {
                            magnificPopup.close()
                        }
                    })

                    if (magnificPopupJSvideoYoutube !== null) {
                        var src = magnificPopupJSvideoYoutube.getAttribute('src')
                        magnificPopupJSvideoYoutube.setAttribute('src', src + '?autoplay=1')
                    }
                },
                beforeClose: function (modal) {
                    var magnificPopup = $.magnificPopup.instance
                    var magnificPopupContent = magnificPopup.content[0]
                    var magnificPopupJSvideoYoutube = magnificPopupContent.querySelector('iframe')

                    if (magnificPopupJSvideoYoutube !== null) {
                        var src = magnificPopupJSvideoYoutube.getAttribute('src')
                        magnificPopupJSvideoYoutube.remove()
                    }
                },
            }
        }), i(".tabs_courses .tab").on("click", function () {
            var e = i(".tabs_courses .tab"),
                a = i(".content_courses .wrap_courses");
            return e.removeClass("active"), a.removeClass("active"), i(this).addClass("active"), a.eq(i(this).index()).addClass("active"), !1
        }), i(".tabs_review .tab").on("click", function () {
            var e = i(".tabs_review .tab"),
                a = i(".content_review .wrap_review");
            return e.removeClass("active"), a.removeClass("active"), i(this).addClass("active"), a.eq(i(this).index()).addClass("active"), !1
        }), i(".expand_text").click(function () {
            return i(this).hide(), i(this).parent().find(".item_text").slideDown(), !1
        }), i(".mfp_gallery").each(function () {
            i(this).magnificPopup({
                delegate: "a",
                mainClass: "mfp-zoom-in",
                type: "image",
                tLoading: "",
                closeOnBgClick: false,
                showCloseBtn: true,
                gallery: {
                    enabled: !0
                },
                removalDelay: 300,
                closeMarkup: "<button title=\"%title%\" type=\"button\" class=\"mfp-close\">" +
                    "<svg class=\"svg __svg__close\"><use xlink:href=\"/local/templates/eurokappa_versality/assets/icons.svg?#svg-close\"></use></svg>" +
                    "</button>",
                callbacks: {
                    beforeChange: function () {
                        this.items[0].src = this.items[0].src + "?=" + Math.random()
                    },
                    open: function () {
                        i(document).on('click', function (e) {
                            if (!((i(e.target).closest(".mfp_gallery, .mfp-arrow, .mfp-content, a").length > 0))) {
                                $.magnificPopup.proto.close.call(this);
                                console.warn('Popup closed');
                            }
                        });

                        i.magnificPopup.instance.container.find('.mfp-close').on('click', function () {
                            $.magnificPopup.proto.close.call(this)
                        })
                        i.magnificPopup.instance.next = function () {
                            var e = this;
                            e.wrap.removeClass("mfp-image-loaded"), setTimeout(function () {
                                i.magnificPopup.proto.next.call(e)
                            }, 120)
                        }, i.magnificPopup.instance.prev = function () {
                            var e = this;
                            e.wrap.removeClass("mfp-image-loaded"), setTimeout(function () {
                                i.magnificPopup.proto.prev.call(e)
                            }, 120)
                        }
                    },
                    imageLoadComplete: function () {
                        var e = this;
                        setTimeout(function () {
                            e.wrap.addClass("mfp-image-loaded")
                        }, 16)
                    }
                }
            })
        }), i("body").on("click", ".btn_top", function (e) {
            e.preventDefault(), i("html, body").animate({
                scrollTop: 0
            }, 1e3)
        }), i(".wrap_cost #filter_range").slider({
            min: 0,
            max: 29900,
            values: [0, 29900],
            range: !0,
            stop: function (e, a) {
                i(".wrap_cost input#priceMin").val(i(".wrap_cost #filter_range").slider("values", 0)), i(".wrap_cost input#priceMax").val(i(".wrap_cost #filter_range").slider("values", 1)), i(".wrap_cost .price_range_min.value").html(i(".wrap_cost #filter_range").slider("values", 0)), i(".wrap_cost .price_range_max.value").html(i(".wrap_cost #filter_range").slider("values", 1))
            },
            slide: function (e, a) {
                i(".wrap_cost input#priceMin").val(i(".wrap_cost #filter_range").slider("values", 0)), i(".wrap_cost input#priceMax").val(i(".wrap_cost #filter_range").slider("values", 1)), i(".wrap_cost .price_range_min.value").html(i(".wrap_cost #filter_range").slider("values", 0)), i(".wrap_cost .price_range_max.value").html(i(".wrap_cost #filter_range").slider("values", 1))
            }
        }), i(".wrap_cost input#priceMin").on("change", function () {
            var e = i(".wrap_cost input#priceMin").val(),
                a = i(".wrap_cost input#priceMax").val();
            parseInt(e) > parseInt(a) && (e = a, i(".wrap_cost input#priceMin").val(e), i(".wrap_cost .price_range_min.value").html(e)), i(".wrap_cost #filter_range").slider("values", 0, e), i(".wrap_cost .price_range_min.value").html(e)
        }), i(".wrap_cost input#priceMax").on("change", function () {
            var e = i(".wrap_cost input#priceMin").val(),
                a = i(".wrap_cost input#priceMax").val();
            29900 < a && (a = 29900, i(".wrap_cost input#priceMax").val(35e3)), parseInt(e) > parseInt(a) && (a = e, i(".wrap_cost input#priceMax").val(a), i(".wrap_cost .price_range_max.value").html(a)), i(".wrap_cost #filter_range").slider("values", 1, a), i(".wrap_cost .price_range_max.value").html(a)
        }), i(".wrap_cost .ui-slider-handle:eq(0)").append('<span class="price_range_min value">' + i("#filter_range").slider("values", 0) + "</span>"), i(".wrap_cost .ui-slider-handle:eq(1)").append('<span class="price_range_max value">' + i("#filter_range").slider("values", 1) + "</span>"), i(".wrap_duration #filter_range_1").slider({
            min: 0,
            max: 8,
            values: [0, 8],
            range: !0,
            stop: function (e, a) {
                i(".wrap_duration input#priceMin_1").val(i(".wrap_duration #filter_range_1").slider("values", 0)), i(".wrap_duration input#priceMax_1").val(i(".wrap_duration #filter_range_1").slider("values", 1)), i(".wrap_duration .price_range_min.value").html(i(".wrap_duration #filter_range_1").slider("values", 0)), i(".wrap_duration .price_range_max.value").html(i(".wrap_duration #filter_range_1").slider("values", 1))
            },
            slide: function (e, a) {
                i(".wrap_duration input#priceMin_1").val(i(".wrap_duration #filter_range_1").slider("values", 0)), i(".wrap_duration input#priceMax_1").val(i(".wrap_duration #filter_range_1").slider("values", 1)), i(".wrap_duration .price_range_min.value").html(i(".wrap_duration #filter_range_1").slider("values", 0)), i(".wrap_duration .price_range_max.value").html(i(".wrap_duration #filter_range_1").slider("values", 1))
            }
        }), i(".wrap_duration input#priceMin_1").on("change", function () {
            var e = i(".wrap_duration input#priceMin_1").val(),
                a = i(".wrap_duration input#priceMax_1").val();
            parseInt(e) > parseInt(a) && (e = a, i(".wrap_duration input#priceMin_1").val(e), i(".wrap_duration .price_range_min.value").html(e)), i(".wrap_duration #filter_range_1").slider("values", 0, e), i(".wrap_duration .price_range_min.value").html(e)
        }), i(".wrap_duration input#priceMax_1").on("change", function () {
            var e = i(".wrap_duration input#priceMin_1").val(),
                a = i(".wrap_duration input#priceMax_1").val();
            8 < a && (a = 8, i(".wrap_duration input#priceMax_1").val(35e3)), parseInt(e) > parseInt(a) && (a = e, i(".wrap_duration input#priceMax_1").val(a), i(".wrap_duration .price_range_max.value").html(a)), i(".wrap_duration #filter_range_1").slider("values", 1, a), i(".wrap_duration .price_range_max.value").html(a)
        }), i(".wrap_duration .ui-slider-handle:eq(0)").append('<span class="price_range_min value">' + i("#filter_range_1").slider("values", 0) + "</span>"), i(".wrap_duration .ui-slider-handle:eq(1)").append('<span class="price_range_max value">' + i("#filter_range_1").slider("values", 1) + "</span>")
});

$(document).ready(function () {
    const mainVideo = document.getElementById('js-main-video');

    if (mainVideo) {
        setTimeout(() => {
            mainVideo.play();
        }, 5000)
    }

    new Swiper(".js-swiper-cards", {
        slidesPerView: 1,
        spaceBetween: 15,
        loop: true,
        autoplay: {
            delay: 3000,
        }
    });
});

$(window).scroll(function () {
    660 < $(this).scrollTop() ? $(".fix_mailing").addClass("active") : $(".fix_mailing").removeClass("active")
});

$(function () {

    // Polyfill SVG Elements
    svg4everybody({
        nosvg: true, polyfill: true
    })

    // WOW initialized
    new WOW().init();

    //
    var header = document.querySelector(".main_head"), body = document.querySelector("body"), headerHeight;
    if (header) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > headerHeight) {
                header.classList.add("scroll")
                setTimeout(function () {
                    header.classList.add("animation")
                }, 100)
                body.style.paddingTop = headerHeight + "px"
            } else {
                header.classList.remove("animation")
                header.classList.remove("scroll")
                body.style.paddingTop = 0 + "px"
                onHeaderHeight()
            }
        })
    }

    function getElemOuterHeight(node) {
        var height = 0, styles = ["height", "margin-top", "margin-bottom"]
        for (var position in styles) {
            height += parseInt(window.getComputedStyle(node)[styles[position]])
        }
        return height
    }
    function onHeaderHeight() {
        if (!header.classList.contains('scroll')) headerHeight = getElemOuterHeight(header)
    }
    window.addEventListener("resize", onHeaderHeight)
    //

    function formHandler(form) {
        form.addClass('form-checking');
        var data = form.serialize();
        var customText = form.attr('data-text');
        data['TITLE'] = form.attr('data-title');
        if ($('.form-checking input:invalid').length > 0) {
            alert('Пожалуйста, проверьте правильность заполнения полей')
        } else {
            $.ajax({
                type: "POST",
                url: "/ajax/form-handler.php", // Адрес обработчика
                data: data,
                error: function () {
                    alert('Произошла ошибка! Повторите попытку позже')
                },
                success: function (result) {
                    $('body').append(result);
                    $.magnificPopup.close();
                    if (customText) $('.order-access-text').html(customText);
                    $('.thanks-modal').css('display', 'flex');
                    /*setTimeout(function () {
                        $('.thanks-modal').css('display','none');
                    }, 5000);*/
                    if (form.attr('data-file')) setTimeout(function () { window.open(form.attr('data-file'), '_blank'); }, 1000)
                }


            });
        }
        form.removeClass('form-checking ')
    }

    $('.item_review').addClass('inited');

    if ($('.text_review').length) {
        $('.tab:nth-child(2)').click(function () {
            setTimeout(function () {
                $(".inner_review").dotdotdot({
                    callback: dotdotdotCallback
                });
                $(".expand_review").on('click', function () {
                    $(this).addClass('cur-btn');
                    if (!$(this).hasClass('open')) {
                        var div = $(this).prev();
                        div.trigger('destroy');
                        div.css('max-height', '100%');
                        div.css('height', 'auto');
                        $('.cur-btn span').html('Свернуть')
                    } else {
                        $(this).prev().css("height", "90px")
                        $(this).prev().css("max-height", "90px").dotdotdot({ callback: dotdotdotCallback });
                        $('.cur-btn span').html('Развернуть');
                    }
                    $(this).removeClass('cur-btn');
                    $(this).toggleClass('open');
                });
                function dotdotdotCallback(isTruncated, originalContent) {
                    if (!isTruncated) {
                        $(this).parent().addClass('current-dot');
                        $('.current-dot .expand_review').remove();
                    }
                }
            }, 500)
        });
    }

    $('.submit').click(function () {
        formHandler($(this).closest('form'));
    })

    $('.name_course, .item_course p').dotdotdot();

    $('.tab').click(function () {
        $('.name_course, .item_course p').dotdotdot();
    });

    $('.close-modal').click(function () {
        $('.thanks-modal').css('display', 'none');
    });

    var nav = document.querySelector(".mynav")
    if (nav !== null) {
        var target = document.querySelector(".target")
        var links = document.querySelectorAll(".mynav a")
        var colors = "#63c3d1";

        function resizeFunc() {
            var active = document.querySelector(".mynav li.active");

            if (active) {
                var left = active.getBoundingClientRect().left + window.pageXOffset;
                var top = active.getBoundingClientRect().top + window.pageYOffset;
                var width = active.getBoundingClientRect().width;
                var height = active.getBoundingClientRect().height;
                var color = colors;

                target.style.width = `${width}px`;
                target.style.height = `${height}px`;
                target.style.left = `${left}px`;
                target.style.top = `${top}px`;
                target.style.background = color;
                target.style.borderRadius = '10px';
                target.style.transform = "none";
                target.style.boxShadow = "0 20px 17.04px 6.96px rgba(89,196,191,.21)";
            }

            nav.classList.add('--load')
        }

        function mouseenterFunc() {
            if (!this.parentNode.classList.contains("active")) {
                for (let i = 0; i < links.length; i++) {
                    if (links[i].parentNode.classList.contains("active")) {
                        links[i].parentNode.classList.remove("active");
                    }
                }

                this.parentNode.classList.add("active");

                var width = this.getBoundingClientRect().width;
                var height = this.getBoundingClientRect().height;
                var left = this.getBoundingClientRect().left + window.pageXOffset;
                var top = this.getBoundingClientRect().top + window.pageYOffset;
                var color = colors;

                target.style.width = `${width}px`;
                target.style.height = `${height}px`;
                target.style.left = `${left}px`;
                target.style.top = `${top}px`;
                target.style.background = color;
                target.style.borderRadius = '10px';
                target.style.transform = "none";
                target.style.boxShadow = "0 20px 17.04px 6.96px rgba(89,196,191,.21)";
            }
        }

        for (let i = 0; i < links.length; i++) {
            //links[i].addEventListener("click", function(e) { e.preventDefault() });
            links[i].addEventListener("resize", mouseenterFunc);
            links[i].addEventListener("click", mouseenterFunc);
        }

        setTimeout(function () {
            resizeFunc()
        }, 1100)

        window.addEventListener("resize", resizeFunc);
    }

    $('.statistik').viewportChecker({
        callbackFunction: function (elem, action) {
            document.querySelectorAll('.js-animate-num').forEach(function (elem) {
                if (elem.getAttribute('animate-num') !== null)
                    $(elem).animateNumber({
                        number: elem.getAttribute('animate-num'),
                        numberStep: function (now, tween) {
                            var floored_number = Math.floor(now),
                                target = $(tween.elem)
                            target.text(floored_number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "))
                        }
                    }, 5000)
            })
        }
    });
})
