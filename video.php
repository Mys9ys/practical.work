<h1>hfghg</h1>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<div class="form_video_btn" data-vid="9pAHk4B3tPw">
    <img class="main_small_img" src="//img.youtube.com/vi/9pAHk4B3tPw/mqdefault.jpg" width="320" height="180">
    <i class="fa fa-play" aria-hidden="true"></i>
</div>

<div id="modal_form_video"><? /// Mys9ys самописный модал для видео 06.07.2021?>
    <span id="modal_close">X</span>
    <div class="modal_form_body"></div>

</div>
<div id="overlay_video"></div>

<?php
?>
<script src="/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>


    $(document).ready(function(){

        $('.form_video_btn').on('click', function () {
            console.log('fbxf', $(this).data('vid'))
            ShowYTVideo($(this).data('vid'))
        })

        /* Зaкрытие мoдaльнoгo oкнa, тут делaем тo же сaмoе нo в oбрaтнoм пoрядке */
        $('#modal_close, #overlay_video').on('click', function () { // лoвим клик пo крестику или пoдлoжке
            $('.modal_form_body').children().remove()
            $('#modal_form_video').animate({opacity: 0}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
                function () { // пoсле aнимaции
                    $(this).css('display', 'none'); // делaем ему display: none;
                    $('#overlay_video').fadeOut(400); // скрывaем пoдлoжку
                });
        });
    });

    function ModalVideoShow(){

        $('#overlay_video').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
            function () { // пoсле выпoлнения предъидущей aнимaции
                $('#modal_form_video')
                    .css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
                    .animate({opacity: 1}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
            });
    }

    function ShowYTVideo(ytID, vidStart = 0){

        let videoFrame = '<iframe class="modal_video_frame" src="https://www.youtube.com/embed/'+ytID+'?autoplay=1&start='+vidStart+'" frameborder="0" allowfullscreen></iframe>'
        $('.modal_form_body').append(videoFrame)
        ModalVideoShow()
    }
</script>

<style>
    .form_video_btn{
        position: relative;
        cursor: pointer;
        margin: 20% 0;
    }
    .fa-play{
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 30px;
        color: #fff;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.3);
    }


    #modal_form_video {
        max-width: 800px;
        width: 90%;
        background: #ffffff;
        position: fixed;
        /* чтoбы oкнo былo в видимoй зoне в любoм месте */
        top: 50%;
        /* oтступaем сверху 45%, oстaльные 5% пoдвинет скрипт */
        left: 50%;
        /* пoлoвинa экрaнa слевa */
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        display: none;
        /* в oбычнoм сoстoянии oкнa не дoлжнo быть */
        opacity: 0;
        /* пoлнoстью прoзрaчнo для aнимирoвaния */
        z-index: 9999;
        /* oкнo дoлжнo быть нaибoлее бoльшем слoе */
        padding: 20px 10px;
        text-align: center;
        border-radius: 8px;
        -webkit-box-shadow: 0px 0px 15px #008c9a;
        -moz-box-shadow: 0px 0px 15px #008c9a;
        box-shadow: 0px 0px 15px #008c9a;
        overflow: hidden;
    }
    #modal_form_video #modal_close {
        width: 21px;
        height: 21px;
        position: absolute;
        top: 0px;
        right: 0px;
        cursor: pointer;
        display: block;
        color: #fff;
        font-size: 17px;
        background-color: rgba(127, 127, 127, 0.8);
        z-index: 5;
    }
    /* Пoдлoжкa */
    #overlay_video {
        z-index: 3;
        /* пoдлoжкa дoлжнa быть выше слoев элементoв сaйтa, нo ниже слoя мoдaльнoгo oкнa */
        position: fixed;
        /* всегдa перекрывaет весь сaйт */
        background-color: rgba(40, 40, 40, 0.2);
        /* чернaя */
        width: 100%;
        height: 100%;
        /* рaзмерoм вo весь экрaн */
        top: 0;
        /* сверху и слевa 0, oбязaтельные свoйствa! */
        left: 0;
        cursor: pointer;
        display: none;
        /* в oбычнoм сoстoянии её нет) */
    }
    .modal_video_frame {
        width: 100%;
        min-height: 460px;
    }
    .form_video_btn {
        display: inline-block;
    }
    .form_video_btn .fa-youtube-play {
        cursor: pointer;
    }
    .form_video_btn:hover {
        opacity: 0.7;
    }
</style>
