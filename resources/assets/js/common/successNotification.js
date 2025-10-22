
document.addEventListener('DOMContentLoaded', function () {
      if (typeof bootstrap !== 'undefined') {
            const successMge = document.getElementById('successMge');
            if (successMge) {
                  const successToast = new bootstrap.Toast(successMge);
                  successToast.show();
            }
      }

});