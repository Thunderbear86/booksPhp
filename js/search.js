$(document).ready(function() {
    // Attach an input event handler to the input
    $('.nameSearch').on('input', function() {

        // Get the search term from the input
        let searchTerm = $(this).val();

        // Don't make an AJAX request for an empty search term
        if (searchTerm.trim() === '') {
            $('.items').empty(); // Clear any previous results
            return;
        }

        // Make an AJAX request to the PHP script
        $.ajax({
            type: "POST",
            url: "api.php",
            data: {
                nameSearch: searchTerm,
            },
            dataType: "json",
            success: function(response) {
                // Display the search results when successful
                displayResults(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors
                console.error("Error: " + textStatus + " " + errorThrown);
            }
        });
    });

    // Function to display the search results
    function displayResults(data) {
        let html = '';

        data.forEach(book => {
            html += `<div class="book">
                        <h3>${book.bookName}</h3>
                        <p>Author: ${book.author}</p>
                        <p>Genre: ${book.genre}</p>
                        <p>Publisher: ${book.publisher}</p>
                        <!-- Add other details as needed -->
                    </div>`;
        });

        $('.items').html(html);
    }
});
