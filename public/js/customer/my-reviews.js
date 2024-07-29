$(document).ready(function() {
    // Set up CSRF token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Fetch and render reviews when the page loads
    fetchReviews();

    function fetchReviews() {
        $.ajax({
            url: "/api/customer/reviews/history", // Ensure this matches the route definition
            type: "GET",
            success: function(response) {
                if (response.reviews) {
                    renderReviews(response.reviews);
                }
            },
            error: function(xhr) {
                console.error("Error fetching reviews:", xhr.responseText);
            }
        });
    }

    function renderReviews(reviews) {
        const reviewTabs = ['not_reviewed', 'reviewed'];
        reviewTabs.forEach(status => {
            const reviewSection = $('#review-section-' + status + ' .reviews');
            reviewSection.empty(); // Clear previous content
            let reviewsExist = false;
            reviews.forEach(review => {
                if (review.status === status) {
                           reviewSection.append(
                        `<div class="review-card" data-review-id="${review.id}">
                            <div class="product-image">
                                <img src="${review.product[0].image_url}" alt="${review.product[0].name}">
                            </div>
                            <div class="review-info">
                                <h4>${review.product[0].name}</h4>
                                <p>${review.product[0].description}</p>
                                ${status === 'not_reviewed' ? 
                                    `<button class="review-button" data-order-id="${review.id}" data-product-id="${review.product[0].id}">Submit Review</button>`
                                 : ''}
                            </div>
                        </div>`
                    );
                }
            });
            if (!reviewsExist) {
                reviewSection.append(`<p class="no-reviews">No reviews found for this status.</p>`);
            }
        });

        // Attach review button click handler
        $('.review-button').on('click', function() {
            const orderId = $(this).data('order-id');
            const productId = $(this).data('product-id');
            $('#reviewForm input[name="order_id"]').val(orderId);
            $('#reviewForm input[name="product_id"]').val(productId);
            $('#reviewModal').modal('show');
        });
    }

    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const formData = new FormData(form[0]);
        $.ajax({
            url: "/api/customer/reviews/store",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Review submitted successfully!');
                $('#reviewModal').modal('hide');

                // Move the review card to the reviewed section
                const reviewId = form.find('input[name="order_id"]').val();
                const reviewCard = $('.review-card[data-review-id="' + reviewId + '"]');

                // Remove the review card from all tabs
                reviewCard.remove();

                // Update the status on the server side
                $.ajax({
                    url: "/api/customer/reviews/update-status",
                    type: "POST",
                    data: {
                        review_id: reviewId,
                        status: 'reviewed'
                    },
                    success: function(response) {
                        if (response.success) {
                            fetchReviews(); // Refresh the reviews
                        }
                    },
                    error: function(xhr) {
                        console.error("Error updating review status:", xhr.responseText);
                    }
                });
            },
            error: function(xhr) {
                console.error("Error submitting review:", xhr.responseText);
            }
        });
    });

    $('.tab').click(function() {
        $('.tab').removeClass('active');
        $(this).addClass('active');

        const status = $(this).data('status');
        $('.review-section').removeClass('active');
        $('#review-section-' + status).addClass('active');

        const targetSection = $('#review-section-' + status);
        if (targetSection.length) {
            $('html, body').animate({
                scrollTop: targetSection.offset().top - 100
            }, 500);
        }
    });

    $('.tab[data-status="not_reviewed"]').click();

    $(document).on('mouseenter', '.review-card', function() {
        $(this).addClass('hover');
    }).on('mouseleave', '.review-card', function() {
        $(this).removeClass('hover');
    });
});
