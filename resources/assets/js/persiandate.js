import $ from 'jquery';
import 'persian-datepicker';

$(function () {
      $('.persian-date').persianDatepicker({
            format: 'YYYY/MM/DD',
            initialValue: false,
            autoClose: true,
            calendar: { persian: { locale: 'fa' } }
      });
});