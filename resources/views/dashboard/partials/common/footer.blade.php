<footer class="mb-3">
      <div class="container">

      </div>
</footer>



<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>


<script>
      function formatNumberWithCommas(x) {
            if (!x) return '';
            // حذف همه غیر عددی‌ها به جز نقطه (اگر بخوایم اعداد اعشاری پشتیبانی بشن)
            x = x.toString().replace(/[^0-9]/g, '');
            return x.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

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

      document.addEventListener('DOMContentLoaded', function() {
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


@if(session('success'))
@include('notifications.successMessage', ['message' => session('success')])
@endif


@if(session('error'))
@include('notifications.errorMessage', ['message' => session('error')])
@endif

</body>

</html>