

<div class="position-fixed end-0 p-3" style="z-index: 1055; top: 80px;">
      <div id="successMge"
            class="toast align-items-center text-bg-success border-0"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                  <div class="toast-body">
                        {{ session('success') ?? $message ?? '' }}
                  </div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
      </div>
</div>