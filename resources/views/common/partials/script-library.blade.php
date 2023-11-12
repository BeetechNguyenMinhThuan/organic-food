@if (isset($datepicker) && $datepicker)
    <script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js')}}"></script>
@endif
@if (isset($select2) && $select2)
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
@endif

@if (isset($swal) && $swal)
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@endif

@if (isset($toastr) && $toastr)
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
@endif

@if (isset($datetimepicker) && $datetimepicker)
    <script src="{{asset('plugins/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js')}}"></script>
@endif
@if (isset($mdeditor) && $mdeditor)
    <script src="{{asset('plugins/editor.md/editormd.min.js')}}"></script>
    <script src="{{asset('plugins/editor.md/languages/en.js')}}"></script>
    <script src="{{asset('plugins/editor.md/lib/marked.min.js')}}"></script>
    <script src="{{asset('plugins/editor.md/lib/prettify.min.js')}}"></script>
@endif
@if (isset($clockpicker) && $clockpicker)
    <script src="{{asset('plugins/clockpicker-seconds/src/clockpicker.js')}}"></script>
@endif
