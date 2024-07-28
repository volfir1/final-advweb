<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.10.5/dist/algoliasearch-lite.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.38.1"></script>
 <script type="module" src="/js/app.js"></script> <!-- Ensure this line is present -->
    <script type="module" src="/js/components/builds/header.js"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/admin/payment.js') }}"></script>
<script src="{{ asset('js/components/builds/header.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/admin/payment.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>


<!--Customer js-->
<script src="{{ asset('js/customer/my-reviews.js') }}"></script>
<!--<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>-->
@vite(['resources/css/app.css', 'public/js/app.js'])