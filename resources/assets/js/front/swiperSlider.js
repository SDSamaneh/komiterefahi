document.addEventListener('DOMContentLoaded', function () {
      // Swiper اصلی
      const swiperEl = document.querySelector('.swiper');
      if (swiperEl) {
            const swiper = new Swiper(swiperEl, {
                  slidesOffsetAfter: 2.2,
                  slidesOffsetBefore: 2.2,
                  slidesPerView: 1.3,
                  spaceBetween: 20,
                  loop: true,
                  breakpoints: {
                        768: {
                              slidesPerView: 2.3,
                        }
                  },
                  // pagination, navigation, scrollbar می‌توانید فعال کنید
            });
      }

      // Swiper دسته‌بندی‌ها
      const swiperCatsEl = document.querySelector('.swiper-cats');
      if (swiperCatsEl) {
            const swiper_cats = new Swiper(swiperCatsEl, {
                  slidesOffsetAfter: 0,
                  slidesOffsetBefore: 0,
                  slidesPerView: 2.3,
                  spaceBetween: 10,
                  loop: true,
                  breakpoints: {
                        768: {
                              slidesPerView: 6,
                        }
                  },
            });
      }

      // دسترسی ایمن به #main برای تغییر margin
      const mainEl = document.getElementById('main');
      if (mainEl) {
            document.body.addEventListener('click', function () {
                  mainEl.style.margin = "0";
            }, true);

            window.closedSidebar = function () {
                  mainEl.style.margin = "0";
            };

            window.openedSidebar = function () {
                  const mediaQuery = window.matchMedia('(min-width: 768px)');
                  if (mediaQuery.matches) {
                        mainEl.style.margin = "0 -260px 0 0";
                  } else {
                        mainEl.style.margin = "0 -750px 0 0";
                  }
            };
      }
});
