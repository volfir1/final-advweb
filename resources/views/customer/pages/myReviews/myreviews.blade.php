@extends('layouts.shop')

@section('body')
    <div class="container">
        <h2 class="page-title">My Reviews</h2>

        <div class="review-status-tabs">
            <div class="tab active" data-status="not_reviewed">Not Reviewed</div>
            <div class="tab" data-status="reviewed">Reviewed</div>
        </div>

        <div class="review-status-sections">
            @foreach (['not_reviewed', 'reviewed'] as $status)
                <div class="review-section" id="review-section-{{ $status }}">
                    <div class="reviews">
                        <!-- Reviews will be dynamically inserted here -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Add Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="product_id" name="product_id">
                        <input type="hidden" id="order_id" name="order_id">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="number" class="form-control" id="rate" name="rate" min="1"
                                max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="reviewForm">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
@endsection