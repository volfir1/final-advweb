@extends('layouts.shop')

@section('body')
    <div class="container container-fluid" id="items">
    </div>

    <div id="custom-notifications"></div>

    <!-- Reviews Modal -->
    <div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="reviewsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewsModalLabel">Product Reviews</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Reviews will be appended here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.dispatchEvent(new CustomEvent('search-query', { detail: '' }));
    });
</script>
<script src="{{ asset('js/shop.js') }}"></script>
@endpush
