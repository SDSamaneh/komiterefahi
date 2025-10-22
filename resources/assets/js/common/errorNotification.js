
document.addEventListener('DOMContentLoaded', function () {

      if (typeof bootstrap !== 'undefined') {
            const errorMge = document.getElementById('errorMge');
            if (errorMge) {
                  const errorToast = new bootstrap.Toast(errorMge);
                  errorToast.show();
            }
      }
});