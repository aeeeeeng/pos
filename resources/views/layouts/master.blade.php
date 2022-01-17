<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/minia/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Jan 2022 06:27:11 GMT -->
<head>

        <meta charset="utf-8" />
        <title>{{ $setting->nama_perusahaan }} | @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Point Of Sale" name="description" />
        <meta content="Syahril Ardi" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('template/images/favicon.ico')}}">

        <!-- DataTables -->
        <link href="{{asset('template/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('template/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{asset('template/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- preloader css -->
        <link rel="stylesheet" href="{{asset('template/css/preloader.min.css')}}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{asset('template/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('template/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="{{asset('libs/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{asset('libs/snackbar/snackbar.min.css')}}">

        <link rel="stylesheet" href="{{asset('libs/datepicker/css/bootstrap-datepicker.min.css')}}">
        <!-- App Css-->
        <link href="{{asset('template/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <style>
            .help-block {
                display: block;
            }
            .with-errors {
                color: red;
            }
            .select2-container--default .select2-selection--single {
                background-color: unset !important;
                border: 1px solid #ced4da !important;
                border-radius: 3px !important;
                font-size: 12px !important;
            }
            .table-bordered thead tr, .table-hover thead tr {
                background-color: #5156be;
                color: #ffffff;
            }

            body[data-layout-mode=dark] .card, body[data-layout-mode=dark] .card-header, body[data-layout-mode=dark] .modal-content, body[data-layout-mode=dark] .offcanvas, body[data-layout-mode=dark] .card-footer {
                background-color: #313533;
                border-color: #3b403d;
            }

            body[data-layout-mode=dark] .select2-dropdown, body[data-layout-mode=dark] .select2-search--dropdown .select2-search__field {
                background-color: #313533;
                border-color: #ced4da;
                color: #ced4da;
            }
        </style>

        @stack('css')

    </head>

    <body data-sidebar-size="lg">

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            @includeIf('layouts.header')
            @includeIf('layouts.sidebar')




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">@yield('title')</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            @section('breadcrumb')
                                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                                            @show
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @yield('content')

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @includeIf('layouts.footer')

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                    <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Mode</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Width</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Topbar Color</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Direction</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('template/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('template/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('template/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('template/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('template/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('template/libs/feather-icons/feather.min.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>
        <script src="{{asset('libs/snackbar/snackbar.min.js')}}"></script>
        <script src="{{asset('libs/bootbox/bootbox.min.js')}}"></script>
        <script src="{{ asset('js/validator.min.js') }}"></script>

        <!-- pace js -->
        <script src="{{asset('template/libs/pace-js/pace.min.js')}}"></script>

         <!-- Required datatable js -->
         <script src="{{asset('template/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
         <!-- Buttons examples -->
         <script src="{{asset('template/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
         <script src="{{asset('template/libs/jszip/jszip.min.js')}}"></script>
         <script src="{{asset('template/libs/pdfmake/build/pdfmake.min.js')}}"></script>
         <script src="{{asset('template/libs/pdfmake/build/vfs_fonts.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

         <!-- Responsive examples -->
         <script src="{{asset('template/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
         <script src="{{asset('template/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

        <script src="{{asset('libs/datepicker/js/bootstrap-datepicker.min.js')}}"></script>

         <script>
             $("#sidebar-size-default").prop('checked', true).trigger('change');
         </script>

        <script src="{{asset('template/js/app.js')}}"></script>

        <script>

            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const dark_mode = `{{$setting->dark_mode}}`;
                darkModeInitial(dark_mode);
            });

            function setModeDark()
            {
                $.ajax({
                    url: `{{url('setting/set-mode')}}`,
                    method: 'POST'
                }).done(response => {
                    const {dark_mode} = response.data;
                    darkModeInitial(dark_mode);
                });
            }

            function darkModeInitial(mode)
            {
                if(mode == 1) {
                    document.body.setAttribute("data-layout-mode", "dark");
                    document.body.setAttribute("data-topbar", "dark");
                    document.body.setAttribute("data-sidebar", "dark");
                } else {
                    document.body.setAttribute("data-layout-mode", "light");
                    document.body.setAttribute("data-topbar", "light");
                    document.body.setAttribute("data-sidebar", "light");
                }
            }

            function preview(selector, temporaryFile, width = 200)  {
                $(selector).empty();
                $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
            }

            function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",")
            {
                try {
                    decimalCount = Math.abs(decimalCount);
                    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                    const negativeSign = amount < 0 ? "-" : "";

                    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                    let j = (i.length > 3) ? i.length % 3 : 0;

                    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                } catch (e) {
                    console.log(e)
                }
            };

            function showErrorAlert(message)
            {
                Snackbar.show({
                    text: message,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                });
            }

            function showSuccessAlert(message)
            {
                Snackbar.show({
                    text: message,
                    actionTextColor: '#fff',
                    backgroundColor: '#8dbf42'
                });
            }

            function blockLoading()
            {
                bootbox.dialog({
                    message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Sedang Memuat...</div>',
                    closeButton: false,
                    centerVertical: true
                });
            }

            function unBlockLoading()
            {
                bootbox.hideAll();
            }

            function tglIndonesia(dateText)
            {
                if(dateText != '' && dateText != null) {
                    let arrDateText = dateText.split('-');
                    return `${arrDateText[2]}/${month(arrDateText[1])}/${arrDateText[0]}`;
                }
                return '';
            }

            function month(month)
            {
                switch (month) {
                    case '01': return 'Januari';
                    case '02': return 'Februari';
                    case '03': return 'Maret';
                    case '04': return 'April';
                    case '05': return 'Mei';
                    case '06': return 'Juni';
                    case '07': return 'Juli';
                    case '08': return 'Agustus';
                    case '09': return 'September';
                    case '10': return 'Oktober';
                    case '11': return 'November';
                    case '12': return 'Desember';
                }
            }

            function formToJson(element) {
                let formData = element.serializeArray();
                let unindexed_array = formData;
                let indexed_array = {};

                $.map(unindexed_array, function(n, i) {
                    indexed_array[n['name']] = n['value'];
                });

                return JSON.stringify(indexed_array);
            }

            function buttonLoading(button, text = null)
            {
                if(text != null) {
                    button.html(`<i class="fas fa-circle-notch fa-spin"></i>`);
                } else {
                    button.html(`<i class="fas fa-circle-notch fa-spin"></i> Memuat ..`);
                }
                button.attr('disabled', 'disabled');
            }

            function buttonUnloading(button, buttonText)
            {
                button.attr('disabled', false);
                button.html(buttonText);
            }

            function errorInput(errorResponse)
            {
                if(typeof(errorResponse) === 'object') {
                    Object.keys(errorResponse.message).map(function(key, index) {
                        const formGroup = $("#" + key).closest('div.form-group')
                        formGroup.addClass('has-danger');
                        $("#" + key).addClass('is-invalid')
                        const message = `<span class="invalid-feedback">${errorResponse.message[key]}</span>`;
                        formGroup.append(message);
                    });
                } else {
                    showErrorAlert(errorResponse.message)
                }
            }

            function removeErrorInput(form)
            {
                form.find('div.form-group .form-control').removeClass('is-invalid');
                form.find('div.form-group').removeClass('has-danger');
                form.find('div.form-group span.invalid-feedback').remove();
            }

            function labelStatusStok(status)
            {
                switch (status) {
                    case 1 : return `<span class="badge bg-success"> AKTIF </span>`;
                    case 0 : return `<span class="badge bg-danger"> BATAL </span>`;
                    default: return '';
                }
            }

            function formatDateIso(date)
            {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

        </script>
        @stack('scripts')

    </body>

<!-- Mirrored from themesbrand.com/minia/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Jan 2022 06:27:11 GMT -->
</html>

