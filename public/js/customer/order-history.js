$(document).ready(function() {
    function fetchOrders(status) {
        $.ajax({
            url: "/api/customer/orders/history",
            type: "GET",
            data: { status: status },
            success: function(response) {
                console.log("API Response:", response);  // Log the response
                if (response.orders && response.orders.length > 0) {
                    renderOrders(response.orders, status);
                } else {
                    console.log("No orders found in the response.");
                    renderNoOrdersFound(status);
                }
            },
            error: function(xhr) {
                console.error("Error fetching orders:", xhr.responseText);
            }
        });
    }

    function renderOrders(orders, status) {
        const sectionSelector = (status === 'all') ? '#order-section-all .orders' : `#order-section-${status} .orders`;
        $(sectionSelector).empty();
        let ordersExist = false;

        orders.forEach(order => {
            if (status === 'all' || order.status === status) {
                ordersExist = true;
                const orderSection = (status === 'all') ? $('#order-section-all .orders') : $(`#order-section-${order.status} .orders`);
                console.log("Rendering order:", order);  // Log each order being rendered
                orderSection.append(`
                    <div class="order-card" data-order-id="${order.id}">
                        <div class="product-image">
                            <img src="${order.products[0].image_url}" alt="${order.products[0].name}">
                        </div>
                        <div class="order-info">
                            <h4>Order #${order.id}</h4>
                            <div class="order-status-display">${capitalizeFirstLetter(order.status)}</div>
                            ${order.products.map(product => `
                                <p>${product.name} - Quantity: ${product.pivot.quantity}</p>
                            `).join('')}
                            <p>Total Price: ₱${order.products.reduce((sum, product) => sum + product.price * product.pivot.quantity, 0).toFixed(2)}</p>
                            ${order.status === 'completed' ? '<button class="review-button">Review</button>' : ''}
                        </div>
                    </div>
                `);
            }
        });

        if (!ordersExist) {
            renderNoOrdersFound(status);
        }

        $('.order-section').hide();
        $('#order-section-' + status).show();
    }

    function renderNoOrdersFound(status) {
        const sectionSelector = (status === 'all') ? '#order-section-all .orders' : `#order-section-${status} .orders`;
        $(sectionSelector).empty();
        $(sectionSelector).append('<p class="no-orders">No orders found for this status.</p>');
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $('.tab').click(function() {
        $('.tab').removeClass('active');
        $(this).addClass('active');

        var status = $(this).data('status');
        fetchOrders(status);
    });

    // Initially show the 'All' tab
    $('.tab[data-status="all"]').addClass('active');
    fetchOrders('all');

    $(document).on('mouseenter', '.order-card', function() {
        $(this).addClass('hover');  
    }).on('mouseleave', '.order-card', function() {
        $(this).removeClass('hover');
    });

    $(document).on('click', '.review-button', function() {
        alert('Review functionality to be implemented');
    });
});
