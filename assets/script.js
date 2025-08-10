jQuery(document).ready(function($) {
    $('#pswi-search').on('keyup', function() {
        let keyword = $(this).val();
        if (keyword.length < 2) {
            $('#pswi-results').empty();
            return;
        }

        $.ajax({
            url: pswi_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'pswi_search',
                keyword: keyword
            },
            success: function(response) {
                let output = '<ul class="pswi-results-list">';
                if (response.length > 0) {
                    response.forEach(item => {
                        output += `
                            <li>
                                <a href="${item.url}">
                                    <img src="${item.image}" alt="${item.title}">
                                    <span>${item.title}</span>
                                    <span class="price">${item.price}</span>
                                </a>
                            </li>
                        `;
                    });
                } else {
                    output += '<li>No products found</li>';
                }
                output += '</ul>';
                $('#pswi-results').html(output);
            }
        });
    });
});
