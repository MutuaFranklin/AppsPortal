@extends('layouts.web')

@section('content')


<div class="card card-flush h-md-100">
    <!--begin::Body-->
    <div class="card-body pt-6">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                <!--begin::Table head-->
                <thead>
                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                        <th class="p-0 pb-3 max-w-50px text-start">APP</th>
                        <th class="p-0 pb-3 min-w-100px text-center">STATUS</th>
                        <th class="p-0 pb-3 min-w-100px text-center">USERS</th>
                        <th class="p-0 pb-3 min-w-100px text-center">RELEASE DATE</th>
                        <th class="p-0 pb-3 w-100px text-center">LEAD</th>
                        <th class="p-0 pb-3 w-50px text-center">ACTION</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                    @foreach ($applications as $app)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center w-10 ">
                                <div class="symbol symbol-50px me-2">
                                    <img src="/assets/media/uploads/{{$app->display_image}}" class="" alt="">
                                </div>
                                <div class="d-flex justify-content-start flex-column w-10 ">
                                    <a href="{{$app->link}}" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$app->name}}</a>
                                    <span class="text-gray-400 fw-semibold d-block fs-7">{{$app->short_description}}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge
                    @if ($app->status->id == 1)
                        badge-light-success
                    @elseif($app->status->id == 2)
                        badge-light-primary
                    @else
                        badge-light
                    @endif

                     fw-bolder me-auto px-4 py-3">{{$app->status->name}}</span>

                            @if (isset($app->published_by))
                            <span class="badge badge-primary fw-bolder me-auto px-2 py-2">Published</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!--begin::Label-->
                            {{$app->internal_users_no+$app->external_users_no}}
                            <!--end::Label-->
                        </td>
                        <td class="text-center">
                            <span class="text-gray-600 fw-bold fs-6">{{$app->release_date}}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-gray-600 fw-bold fs-6">{{$app->lead_dev_email}}</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon--></a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                @if (Auth::user()->role_id == 1)
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    @if (isset($app->published_by))
                                    <a href="unpublish/{{$app->id}}" class="menu-link px-3">Unpublish</a>
                                    @else
                                    <a href="publish/{{$app->id}}" class="menu-link px-3">Publish</a>
                                    @endif
                                </div>
                                <!--end::Menu item-->
                                @endif

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="edit/{{$app->id}}" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                @if (Auth::user()->role_id == 1)
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end: Card Body-->
</div>

@endsection
@section('pagescripts')
<script>
</script>
@endsection
