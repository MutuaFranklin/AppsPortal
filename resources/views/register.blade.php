@extends('layouts.web')

@section('content')


<!--begin::Body-->
<div class="signup d-flex flex-column-fluid flex-lg-row-auto justify-content-end p-12">
    <!--begin::Wrapper-->
    <div class="d-flex flex-center rounded-4 w-md-800px p-10">
        <!--begin::Content-->
        <div class="w-md-400px w-lg-500px">
            <!--begin::Heading-->
            <div class="mb-11">
                <!--begin::Title-->
                <h1 class="fw-bolder mb-3 fs-2" >Sign Up</h1>
                <!--end::Title-->
                <!--begin::Subtitle-->
                <div class="fw-bolder fs-6">Sign up to add and publish applications.</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->
            <!--begin::Form-->
            <form class="form" action="{{route('postRegister')}}" method="POST" novalidate="novalidate" enctype="multipart/form-data" id="kt_modal_create_status_form">
                <!--begin::Step 1-->
                <div class="current" data-kt-stepper-element="content">
                    <div class="w-lg-450 w-xl-450 row">
                       
                        <!--begin::Input group-->
                        <div class="fv-row mb-10 col-lg-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-5 fw-bolder mb-2">
                                <span class="required fs-6">First Name</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Input your first name"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-lg form-control-solid form-input-style" name="first_name" placeholder="" value="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10 col-lg-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-5 fw-bolder mb-2">
                                <span class="required fs-6">Last Name</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Input your last name"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-lg form-control-solid form-input-style" name="last_name" placeholder="" value="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-5 fw-bolder mb-2">
                                <span class="required fs-6">Email</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Input your email"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-lg form-control-solid form-input-style" name="email" placeholder="" value="" />
                            <!--end::Input-->
                        </div>
                        
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-5 fw-bolder mb-2">
                            <span class="required fs-6">Password</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Input your password"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" class="form-control form-control-lg form-control-solid form-input-style fs-6" name="password" placeholder="" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-5 fw-bolder mb-2">
                            <span class="required fs-6">Confirm Password</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Confirm your password"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" class="form-control form-control-lg form-control-solid form-input-style fs-6" name="password_confirmation" placeholder="" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
        </div>
        <!--end::Step 1-->
        @csrf
        <!--begin::Actions-->
        <div class="pt-10">
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn register-btn">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Sign Up
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                        <span class="svg-icon svg-icon-3 ms-1 me-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon--></span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
        </div>
        <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Body-->

@endsection
@section('pagescripts')
<script>
    "use strict";
    var KTProjectList = {
        init: function() {
            !(function() {
                var t = document.getElementById("apps_by_status_chart");
                if (t) {
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        data: {
                            datasets: [
                            {
                                //ignore
                                data: @json($apps_by_status["data"]),
                                backgroundColor: @json($apps_by_status["colors"]),
                            }, ],
                            labels: @json($apps_by_status["labels"]),
                        },
                        options: {
                            chart: {
                                fontFamily: "inherit"
                            },
                            cutout: "75%",
                            cutoutPercentage: 65,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            title: {
                                display: !1
                            },
                            animation: {
                                animateScale: !0,
                                animateRotate: !0
                            },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0,
                            },
                            plugins: {
                                legend: {
                                    display: !1
                                }
                            },
                        },
                    });
                }
            })();
        },
    };
    KTUtil.onDOMContentLoaded(function() {
        KTProjectList.init();
    });
</script>
@endsection
