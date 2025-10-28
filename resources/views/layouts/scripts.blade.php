<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll('.resettable-modal');
        modals.forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var forms = this.querySelectorAll('form');
                forms.forEach(function(form) {
                    form.reset();
                });
            });
        });
    });

    $(document).ready(function() {
        $('.resourceTable').DataTable();

        $('.sortOnlyTable').DataTable({
                searching: false, // Disables the search input
                paging: false,    // Disables pagination
                info: false       // Optionally, hides the "Showing X of Y entries" info
            });
        $('.sortSearchTable').DataTable({
                paging: false,    // Disables pagination
                info: false       // Optionally, hides the "Showing X of Y entries" info
            });
    });
</script>