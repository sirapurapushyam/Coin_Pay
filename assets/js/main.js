// MAIN PAGE JS
(function() {
  "use strict";
  // this function is responsible for header scroller

  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  // this is responsible for slider  functionality
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  let homeCarouselIndicators = select("#home-carousel-indicators")
  let homeCarouselItems = select('#homeCarousel .carousel-item', true)

  homeCarouselItems.forEach((item, index) => {
    (index === 0) ?
    homeCarouselIndicators.innerHTML += "<li data-bs-target='#homeCarousel' data-bs-slide-to='" + index + "' class='active'></li>":
      homeCarouselIndicators.innerHTML += "<li data-bs-target='#homeCarousel' data-bs-slide-to='" + index + "'></li>"
  });

  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

})()
