require('./bootstrap');

import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";
import "select2/dist/css/select2.css";
import '@fortawesome/fontawesome-free/js/all.js';

import $ from 'jquery';
import 'slick-carousel';
import {checkDoveer} from './checkdoveer/index';
// Default SortableJS
import Sortable from 'sortablejs';
import Swal from 'sweetalert2';
import 'select2';

window.jQuery = window.$ = $;

jQuery(function($){
    $("[type=tel]").mask("+7 (999) 999-99-99");
 });

 jQuery(function($){
    $("[type=passport]").mask("9999 999999");
 });

 $('.slider').slick({
    speed: 300,
    slidesToShow: 1,
    centerMode: true,
    arrows: false,
    infinite: false,
    variableWidth: true
});

import checkForms from "./calc/formRenderer";
window.addEventListener('load', () => {
    checkForms();
});

$(document).ready(function() {
    $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });

    if ($(window).width() < 768) {
        $('.blog__list').slick({
            centerMode: false,
            //    autoplay: false,
            //    autoplaySpeed: 3000,
            arrows: false,
            //    dots: false,
            draggable: true,
            //    fade: false,
            infinite: false,
            //    pauseOnFocus: true,
            //    pauseOnHover: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            //    speed: 300,
            touchMove: true,
            variableWidth: true,
            /*responsive: [
              {
                breakpoint: 480,
                settings: {
                  lazyLoad: 'onDemand'
                }
                  }
              ]
            });*/
        });
    }
});



// $('.slider').slick();
// console.log($('.slider'));


// Make read only
// pad.setReadOnly(true);