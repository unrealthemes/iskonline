require('./bootstrap');

import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";
import "select2/dist/css/select2.css";
import '@fortawesome/fontawesome-free/js/all.js';

import $ from 'jquery';
import 'slick-carousel';

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

if ($(window).width() < 768) {
  $('.blog__slider-wrapper .blog__list, .contacts-docs__list').slick({
      centerMode: false,
      arrows: false,
      draggable: true,
      infinite: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      touchMove: true,
      variableWidth: true,
  });
}

let headerHeight = $('.header').height();
setHeaderBg(headerHeight);

$(window).on('scroll', function() {
  setHeaderBg(headerHeight);
});

function setHeaderBg(headerBaseHeight) {
  if ($('.header').offset().top > headerBaseHeight) {
    $('.header').addClass('header--bg');
  } else {
    $('.header').removeClass('header--bg');
  }
}

$('.burger').on('click', function () {
  $('.mob-menu').slideDown();
});
$('.mob-menu__close').on('click', function () {
  $('.mob-menu').slideToggle();
});

let pageH1 = $('h1').text();

import checkForms from "./calc/formRenderer";
window.addEventListener('load', () => {
    checkForms();
});

$(document).ready(function() {
    if ($(window).width() < 768) {
        $('.blog__list').slick({
            centerMode: false,
            arrows: false,
            draggable: true,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            touchMove: true,
            variableWidth: true,
        });
    }

    if ($('.blog-author').length) {
      $('.blog-author').appendTo('.row.shadow-top:eq(0) .col-lg-4');
      $('.row.shadow-top:eq(0) .col-lg-4').addClass('d-flex flex-column');
    }

    $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });
});
