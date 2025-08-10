<!-- Footer START -->
<footer class="mb-3">
      <div class="container">

      </div>
</footer>
<!-- Footer END -->

<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

@error('success')
@include('notifications.successMessage')
@enderror()

@if(session()->has('error'))
@include('notifications.errorMessage')
@endif

<!-- Vendors -->
<<<<<<< HEAD
=======
<script>
      document.getElementById('priceInput').addEventListener('input', function(e) {
            let value = e.target.value.replace(/,/g, ''); // حذف کاماهای قبلی
            if (!isNaN(value) && value !== '') {
                  e.target.value = Number(value).toLocaleString(); // فرمت با کاما
            } else {
                  e.target.value = '';
            }
      });
</script>

<script>
      function formatNumberWithCommas(x) {
            if (!x) return '';
            // حذف همه غیر عددی‌ها به جز نقطه (اگر بخوایم اعداد اعشاری پشتیبانی بشن)
            x = x.toString().replace(/[^0-9]/g, '');
            return x.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      // فرمت کردن مقادیر اولیه
      document.addEventListener('DOMContentLoaded', function() {
            ['memberPrice', 'lastSalary', 'debt', 'price'].forEach(function(idOrName) {
                  let input = document.querySelector(`input[name="${idOrName}"]`);
                  if (input && input.value) {
                        input.value = formatNumberWithCommas(input.value);
                  }

                  // اضافه کردن event برای فرمت هنگام تایپ
                  if (input) {
                        input.addEventListener('input', function(e) {
                              // حذف کاما ها و گرفتن مقدار خام
                              let rawValue = e.target.value.replace(/,/g, '');
                              // اعمال فرمت کاما به عدد
                              e.target.value = formatNumberWithCommas(rawValue);
                        });
                  }
            });
      });
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

<script>
      $(document).ready(function() {
            $('.persian-date').persianDatepicker({
                  format: 'YYYY/MM/DD',
                  initialValue: false,
                  autoClose: true,
                  calendar: {
                        persian: {
                              locale: 'fa'
                        }
                  }
            });
      });
</script>



>>>>>>> 26b23e8 (final)
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.27.3/apexcharts.min.js"></script>
<script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
</body>

</html>