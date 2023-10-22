export function initializeSearch() {
    $(document).ready(function() {
        $('.nameSearch').on('input', function() {
            filterBooks($(this).val().trim());
        });
    });

    function filterBooks(query) {
        if (!query) {
            $(".col-sm-6.col-md-3.col-lg-3.g-4").show();
            return;
        }

        $(".col-sm-6.col-md-3.col-lg-3.g-4").each(function() {
            if ($(this).find('.card-title').text().toLowerCase().includes(query.toLowerCase())) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
}
