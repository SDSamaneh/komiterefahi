<footer class="mb-3">
      <div class="container">

      </div>
</footer>
<div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

@error('success')
@include('notifications.successMessage')
@enderror()

@if(session()->has('error'))
@include('notifications.errorMessage')
@endif




<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.27.3/apexcharts.min.js"></script>
<script src="assets/vendor/overlay-scrollbar/js/OverlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>

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
            ['memberPrice', 'lastSalary', 'finalPrice', 'debt_company', 'debt_madiran', 'debt_fund', 'debt_purchase', 'price'].forEach(function(idOrName) {
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

<script>
      document.querySelectorAll('.debt-input').forEach(function(input) {
            // نمایش جداکننده هزار در حین تایپ
            input.addEventListener('input', function(e) {
                  let value = e.target.value.replace(/,/g, '').replace(/[^\d]/g, '');
                  if (value) {
                        e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  } else {
                        e.target.value = '';
                  }
            });

            // حذف جداکننده هزار قبل از ارسال فرم
            input.form && input.form.addEventListener('submit', function() {
                  input.value = input.value.replace(/,/g, '');
            });
      });
</script>


</body>

</html>