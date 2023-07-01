@extends('layouts.web')

@section('content')
<div class="btn-row" >
    
</div>
<div class="form-container">
    <form action="" method="get" action="{{route('index')}}">
        <button type="submit" class="status-btn btn fw-bolder fs-6" style="background-color: rgb(0, 159, 227, 0.2); border-radius: 5px;" name="status" value="2">In Production</button>

        <button type="submit" class="status-btn btn fw-bolder fs-6" style="background-color: #FBDDA4; border-radius: 5px;" name="status" value="1">In Testing</button>
    
        <button type="submit" class="status-btn btn fw-bolder fs-6" style="background-color:  #CCCCCC; border-radius: 5px;" name="status" value="all">All Environments</button>

    </form>
    
</div>
{{-- <div class="btn-container" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    <a href="#" class="btn fw-bolder custom-btn">
        <span class="filter-text" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Filter</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="24px" height="24px">
            <path d="M7 10l5 5 5-5z" />
            <path d="M0 0h24v24H0z" fill="none" />
        </svg>
    </a>
</div> --}}


<!--begin::Menu 1-->
    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_624448b7ac77c">
        <!--begin::Header-->
        <div class="m-3">
            <div class="fs-6 text-dark fw-bolder">Filter Options</div>
        </div>
        <!--end::Header-->
        <!--begin::Menu separator-->
        <div class="separator border-gray-200"></div>
        <!--end::Menu separator-->
        <!--begin::Form-->
        <form action="" method="get" action="{{route('index')}}">
            <div class="px-7 py-5" >
                <!--begin::Input group-->
                <div class="mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold">Status:</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div>
                        
                        <select class="form-select form-select-solid" name="status" id="status" >
                            <option></option>
                            @foreach ($status as $s)
                            <option value="{{ $s->id }}" {{ request('status') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
            
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold">Audience:</label>
                    <!--end::Label-->
                    <!--begin::Options-->
                    <div class="d-flex">
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                            <input class="form-check-input" type="checkbox" id="internal" name="internal" value="1" {{ request('internal') ? 'checked' : '' }} />
                            <span class="form-check-label">Internal</span>
                        </label>
                        <!--end::Options-->
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" id="external" name="external" value="1" {{ request('external') ? 'checked' : '' }}/>
                            <span class="form-check-label">External</span>
                        </label>
                        <!--end::Options-->
                    </div>
                    <!--end::Options-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="d-flex justify-content-end">
                    <a href="{{url('/')}}" class="btn btn-sm btn-light btn-active-light-primary me-2" id="reset-btn">Reset</a>
                    <button type="submit" class="btn btn-sm apply-btn" data-kt-menu-dismiss="true">Apply</button>
                </div>
                <!--end::Actions-->
            </div>
        </form>
        <!--end::Form-->
    </div>

@auth

<!--begin::Stats-->
<div class="row g-6 g-xl-9">
    <div class="col-lg-4 col-xxl-4">
        <!--begin::Card-->
        <div class="card h-100">
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Heading-->
                <div class="w-100 d-flex flex-shrink-0 align-items-center justify-content-between">
                    <div class="fs-2hx fw-bolder">{{$applications->count()}}</div>
                </div>

                <div class="fs-5 fw-bold mb-7"  style="color: #4D4D4D;">Current Applications</div>
                <!--end::Heading-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-wrap">
                    <!--begin::Chart-->
                    <div class="d-flex flex-center h-100px w-100px me-9 mb-5">
                        <canvas id="apps_by_status_chart"></canvas>
                    </div>
                    <!--end::Chart-->
                    <!--begin::Labels-->
                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                        <?php $i=0; ?>
                        @foreach ($apps_by_status['labels'] as $sname)
                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                            <div class="bullet me-3" style="background-color:{{$apps_by_status['colors'][$i]}} !important;"></div>
                            <div class=""  style="color: #4D4D4D;">{{$sname}}</div>
                            <div class="ms-auto fw-bolder"  style="color: #4D4D4D;">{{$apps_by_status['data'][$i]}}</div>
                        </div>
                        <!--end::Label-->
                        <?php $i++; ?>
                        @endforeach
                    </div>
                    <!--end::Labels-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-4 col-xxl-4">
        <!--begin::Budget-->
        <div class="card h-100">
            <div class="card-body p-9">
                <div class="fs-2hx fw-bolder">{{$users_count}}</div>
                <div class="fs-5 fw-bold mb-7"  style="color: #4D4D4D;">Users</div>
                <div class="fs-6 d-flex justify-content-between mb-4">
                    <div class="fw-bold">Avg. Application Users</div>
                    <div class="d-flex fw-bolder">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
                        <span class="svg-icon svg-icon-3 me-1 svg-icon-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z" fill="currentColor" />
                                <path opacity="0.3" d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->{{$applications->count() == 0?0:floor($users_count/$applications->count())}}
                    </div>
                </div>
                <div class="separator separator-dashed"></div>
                <div class="fs-6 d-flex justify-content-between my-4">
                    <div class="fw-bold">Least Users</div>
                    <div class="d-flex fw-bolder">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr006.svg-->
                        <span class="svg-icon svg-icon-3 me-1 svg-icon-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.4 14.8L5.3 6.69999C4.9 6.29999 4.9 5.7 5.3 5.3C5.7 4.9 6.29999 4.9 6.69999 5.3L14.8 13.4L13.4 14.8Z" fill="currentColor" />
                                <path opacity="0.3" d="M19.8 8.5L8.5 19.8H18.8C19.4 19.8 19.8 19.4 19.8 18.8V8.5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->{{$min_users}}
                    </div>
                </div>
                <div class="separator separator-dashed"></div>
                <div class="fs-6 d-flex justify-content-between mt-4">
                    <div class="fw-bold">Most Users</div>
                    <div class="d-flex fw-bolder">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
                        <span class="svg-icon svg-icon-3 me-1 svg-icon-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z" fill="currentColor" />
                                <path opacity="0.3" d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->{{$max_users}}
                    </div>
                </div>
            </div>
        </div>
        <!--end::Budget-->
    </div>
    <div class="col-lg-4 col-xxl-4">
        <!--begin::Clients-->
        <div class="card h-100">
            <div class="card-body p-9">
                <!--begin::Heading-->
                <div class="fs-2hx fw-bolder">{{$developers->count()}}</div>
                <div class="fs-5 fw-bold mb-7"  style="color: #4D4D4D;">Developers (and Admins)</div>
                <!--end::Heading-->
                <!--begin::Users group-->
                <div class="symbol-group symbol-hover mb-9">
                    @foreach ($developers as $dev)
                    @if (!empty($dev->dp_url))
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$dev->first_name.' '.$dev->last_name}}">
                        <img alt="Pic" src="{{$dev->dp_url}}" />
                    </div>
                    @else
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$dev->first_name.' '.$dev->last_name}}">
                        <span class="symbol-label bg-info text-inverse-info fw-bolder">{{strtoupper(substr($dev->first_name, 0, 1));}}</span>
                    </div>
                    @endif

                    @endforeach

                    {{-- <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                        <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bolder">+42</span>
                    </a> --}}
                </div>
                <!--end::Users group-->
                <!--begin::Actions-->
                <div class="d-flex">
                    {{-- data-bs-toggle="modal" data-bs-target="#kt_modal_view_users" --}}
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_view_users" class="btn btn-primary btn-sm me-3">All Developers</a>
                    @auth
                    <a href="#" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_create_user" id="kt_toolbar_primary_button">Register New</a>
                    @endauth
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Clients-->
    </div>
</div>
<!--end::Stats-->

@endauth


@if (count($published_applications) == 0)
No Applications published
@else


<!--begin::Toolbar-->
<div class="d-flex flex-wrap flex-stack my-2">
    <!--begin::Heading-->
    <h2 class="fs-5 fw-bold my-2">Applications
        <span class="fs-4 ms-1" style="color: #636060;">by Status</span>
    </h2>
    <!--end::Heading-->
    <!--begin::Controls-->
    <div class="d-flex flex-wrap my-1">
        <!--begin::Select wrapper-->
       
        <!--end::Select wrapper-->
    </div>
    <!--end::Controls-->
</div>
<!--end::Toolbar-->
<!--begin::Row-->
<div class="row g-6 g-xl-9">

    @foreach ($published_applications as $app)
    <!--begin::Col-->
    <div class="col-md-6 col-xl-2">
        <!--begin::Card-->
        <a target="_blank" href="{{$app->link}}" class="card border-hover-primary">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card Title-->
                <div class="card-title m-0">
                    <!--begin::Avatar-->
                    <div class="">
                        <img src="assets/media/uploads/{{$app->display_image}}" alt="image" class=" rounded-circle"  style="height: 45px; Width:45px"/>
                    </div>
                    
                    <!--end::Avatar-->
                </div>
                <!--end::Car Title-->
                <!--begin::Card toolbar-->
                
                <!--end::Card toolbar-->
            </div>
            <!--end:: Card header-->
            <!--begin:: Card body-->
            <div class="card-body">
                <!--begin::Name-->
                <div class="fs-5 fw-bolder" style="color: #4D4D4D;">{{$app->name}}</div>
                <!--end::Name-->
                <!--begin::Description-->
                <p class="fs-8 mt-1 mb-7" style="color: #4D4D4D;">{{$app->short_description}}</p>
                <!--end::Description-->
                           
        

                <div class="card-header border-0 p-0 m-0">
                    <!--begin::Card Title-->
                    <div class="card-title p-0 m-0">
                        <!--begin::Users-->
                        {{-- <div class="symbol-group symbol-hover">

                            @foreach ($app->developers as $dev)
                            @if (!empty($dev->dp_url))
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$dev->first_name.' '.$dev->last_name}}">
                                <img alt="Pic" src="{{$dev->dp_url}}" />
                            </div>
                            @else
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{$dev->first_name.' '.$dev->last_name}}">
                                <span class="symbol-label bg-info text-inverse-info fw-bolder">{{strtoupper(substr($dev->first_name, 0, 1));}}</span>
                            </div>
                            @endif
                            @endforeach

                        </div> --}}
                        <div class="card-toolbar">
                            <span class="badge
                            @if ($app->status->id == 1)
                            testing-color
                            @elseif($app->status->id == 2)
                            production-color
                            @else
                                badge-light
                            @endif
        
                            fs-7 fw-bolder me-auto px-4 py-3">{{$app->status->name}}</span>
                        </div>
                        <!--end::Users-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar p-0 m-2">
                        <img src="{{asset('/assets/media/icons/Arrow.png')}}" alt="img" />
                        {{-- {{$app->link}} --}}
                       
                    </div>
                    <!--end::Card toolbar-->
                </div>
                @auth
                <!--begin::Info-->
                <div class="d-flex flex-wrap flex-nowrap">
            
                    <div class="border border-gray-300 border-dashed rounded min-w-50px py-3 px-4 me-5 mb-0">
                        <div class="fs-9 fw-bolder" style="color: #4D4D4D;">Release Date</div>
                        <div class="fs-9 fw-bolder" style="color: #4D4D4D;">{{$app->release_date}}</div>

                    </div>
                   
                    <div class="border border-gray-300 border-dashed rounded min-w-50px py-3 px-4 mb-0">
                        <div class="fs-9 fw-bolder" style="color: #4D4D4D;">Users</div>
                        <div class="fs-9 fw-bolder" style="color: #4D4D4D;">{{$app->internal_users_no+$app->external_users_no}}</div>
                    </div>
                </div>
                @endauth





                {{-- <a href="{{$app->link}}" class="btn
                @if ($app->status->id == 1)
                btn-success
                @elseif($app->status->id == 2)
                btn-primary
                @else
                btn-light
                @endif
                btn-sm me-3">Visit
        </a> --}}


    </div>
    </a>
    <!--end::Card-->
</div>
<!--end::Col-->
@endforeach
</div>
<!--end::Row-->
<!--begin::Pagination-->
<div class="d-flex flex-stack flex-wrap pt-10">
    <div class="fs-7 fw-bold text-gray-700">{{ 'Showing ' . $published_applications->firstItem() . ' to ' . $published_applications->lastItem() . ' of ' . $published_applications->total() . ' entries' }}
    </div>
    <!--begin::Pages-->
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($published_applications->onFirstPage())
            <li class="disabled page-item"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $published_applications->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif
    
        {{-- Pagination Elements --}}
        @for ($i = 1; $i <= $published_applications->lastPage(); $i++)
            @if ($i == $published_applications->currentPage())
                <li class="page-item fs-7 active"><span class="page-link">{{ $i }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $published_applications->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor
    
        {{-- Next Page Link --}}
        @if ($published_applications->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $published_applications->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled page-item"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
    
    <!--end::Pages-->
</div>
<!--end::Pagination-->
@endif

<!--begin::Modals-->

<!--end::Modals-->

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
