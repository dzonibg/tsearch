<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">Started search!</strong>
            <small>Just now!</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            We've loaded the first page. Now we're fetching the other pages!
        </div>
    </div>
</div>
<script>

    window.addEventListener('started-search', event => {

        const toast = new bootstrap.Toast(liveToast)
        toast.show()
    })

</script>
