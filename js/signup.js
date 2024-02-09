var swiper = new Swiper(".mySwiper", {
  spaceBetween: 30,
  loop: true,
  centeredSlides: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: " .prev",
    prevEl: " .next",
  },
});

  function removeErrorMessage() {
    var errorMessage = document.getElementById("error-message");
    if (errorMessage) {
      errorMessage.style.display = "none";
    }
  }

  // Remove error message after 10 seconds
  setTimeout(removeErrorMessage, 10000);
