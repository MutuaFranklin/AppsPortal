@extends('layouts.web')

@section('content')


<!--begin::Body-->
<div class="login d-flex flex-column-fluid flex-lg-row-auto justify-content-end p-10">
    <!--begin::Wrapper-->
    <div class="d-flex flex-center rounded-4 w-md-800px p-10">
        <!--begin::Content-->
        <div class="w-md-400px">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="login" method="POST">
                <!--begin::Heading-->
                <div class=" mb-11">
                    <!--begin::Title-->
                    <p class="fw-bolder mb-3 fs-2">Login</p>
                    <!--end::Title-->
                    <!--begin::Subtitle-->
                    <div class="fw-bolder fs-6">Welcome back! Please enter your details.</div>
                    <!--end::Subtitle=-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-4 fw-bolder mb-2">
                        <span class="required fs-6">Email</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fill in your email"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" class="form-control form-control-lg form-control-solid form-input-style" name="email" placeholder="" value="" />

                    {{-- <input type="email" class="form-control form-control-lg form-control-solid" name="email" placeholder="" value="" style="border-radius: 20px; border: 1px solid #4D4D4D;" /> --}}
                    <!--end::Input-->
                </div>
                @csrf
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-4 fw-bolder mb-2">
                        <span class="required fs-6">Password</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fill in your password"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password" class="form-control form-control-lg form-control-solid form-input-style" name="password" placeholder="" value=""  />
                    <!--end::Input-->
                </div>
                <!--end::Input group=-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-bolder mb-8">
                    <div></div>
                    <!--begin::Link-->
                    <a href={{url('forgot-password')}} class="forgot-password">Forgot Password ?</a>
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn login-btn">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">Login</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                </div>
                <!--end::Submit button-->
                <!--begin::Sign up-->
                <div class=" text-center fw-bolder fs-6">Don’t have an account?
                    <a href={{url('register')}} class="forgot-password">Sign Up</a></div>
                <!--end::Sign up-->
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
