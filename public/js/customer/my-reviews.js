$(document).ready(function() {
    function fetchReviews() {
        $.ajax({
            url: "/api/customer/reviews/fetch-completed-orders",
            type: "GET",
            success: function(response) {
                console.log("API Response:", response);  // Log the response
                if (response.reviewed && response.not_reviewed) {
                    renderReviews(response.not_reviewed, 'not_reviewed');
                    renderReviews(response.reviewed, 'reviewed');
                } else {
                    renderNoReviewsFound('not_reviewed');
                    renderNoReviewsFound('reviewed');
                }
            },
            error: function(xhr) {
                console.error("Error fetching reviews:", xhr.responseText);
            }
        });
    }

    function renderReviews(orders, status) {
        const sectionSelector = `#review-section-${status} .reviews`;
        $(sectionSelector).empty();
        if (orders.length > 0) {
            orders.forEach(order => {
                order.products.forEach(product => {
                    $(sectionSelector).append(`
                        <div class="review-card" data-order-id="${order.id}">
                            <div class="product-image">
                                <img src="${product.image_url}" alt="${product.name}">
                            </div>
                            <div class="review-info">
                                <h4>Product: ${product.name}</h4>
                                <p>${product.description}</p>
                                ${status === 'not_reviewed' ? 
                                    `<button class="review-button" data-toggle="modal" data-target="#reviewModal" data-product-id="${product.id}" data-order-id="${order.id}">Add Review</button>` : 
                                    '<span class="reviewed-tag">Reviewed</span>'}
                            </div>
                        </div>
                    `);
                });
            });
        } else {
            renderNoReviewsFound(status);
        }
    }

    function renderNoReviewsFound(status) {
        const sectionSelector = `#review-section-${status} .reviews`;
        $(sectionSelector).empty();
        $(sectionSelector).append('<p class="no-reviews">No reviews found for this status.</p>');
    }

    $('.tab').click(function() {
        $('.tab').removeClass('active');
        $(this).addClass('active');

        var status = $(this).data('status');
        $(".review-section").hide();
        $(`#review-section-${status}`).show();
    });

    // Initially show the 'Not Reviewed' tab
    $('.tab[data-status="not_reviewed"]').addClass('active');
    $("#review-section-reviewed").hide();
    fetchReviews();

    $('#reviewModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('product-id');
        var orderId = button.data('order-id');
        
        var modal = $(this);
        modal.find('#product_id').val(productId);
        modal.find('#order_id').val(orderId);
        modal.find('#customer_id').val($('#customer_id').val());
    });

    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/api/customer/reviews',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#reviewModal').modal('hide');
                alert('Review submitted successfully!');
                // Refresh reviews
                fetchReviews();
            },
            error: function(xhr) {
                console.error("Error submitting review:", xhr.responseText);        
                alert('Error submitting review.');
            }
        });
    });
});
