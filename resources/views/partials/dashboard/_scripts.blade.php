<!-- Backend Bundle JavaScript -->
<script src="{{ asset('js/libs.min.js')}}"></script>
@if(in_array('data-table',$assets ?? []))
    <script src="{{ asset('vendor/datatables/buttons.server-side.js')}}"></script>
@endif
@if(in_array('chart',$assets ?? []))
    <!-- apexchart JavaScript -->
    <script src="{{asset('js/charts/apexcharts.js') }}"></script>
    <!-- widgetchart JavaScript -->
    <script src="{{asset('js/charts/widgetcharts.js') }}"></script>
    <script src="{{asset('js/charts/dashboard.js') }}"></script>
@endif

<!-- mapchart JavaScript -->
<script src="{{asset('vendor/Leaflet/leaflet.js') }} "></script>
<script src="{{asset('js/charts/vectore-chart.js') }}"></script>

<link rel="stylesheet" href="//cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>

<!-- fslightbox JavaScript -->
<script src="{{asset('js/plugins/fslightbox.js')}}"></script>
<script src="{{asset('js/plugins/slider-tabs.js') }}"></script>
<script src="{{asset('js/plugins/form-wizard.js')}}"></script>

<!-- settings JavaScript -->
<script src="{{asset('js/plugins/setting.js')}}"></script>

<script src="{{asset('js/plugins/circle-progress.js') }}"></script>
@if(in_array('animation',$assets ?? []))
    <!--aos javascript-->
    <script src="{{asset('vendor/aos/dist/aos.js')}}"></script>
@endif

@if(in_array('calender',$assets ?? []))
    <script src="{{asset('vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/calender.js')}}"></script>
@endif

<script src="{{ asset('vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('js/plugins/flatpickr.js') }}" defer></script>
{{-- <script src="{{asset('vendor/vanillajs-datepicker/dist/js/datepicker-full.js')}}"></script> --}}

@stack('scripts')

<script src="{{asset('js/plugins/prism.mini.js')}}"></script>

<!-- Custom JavaScript -->
<script src="{{asset('js/hope-ui.js') }}"></script>
<script src="{{asset('js/modelview.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<link rel="stylesheet" href="//cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="//cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>

