@extends('layouts.web')

@section('content')


<div class="card card-flush h-md-100">
    <!--begin::Body-->
    <div class="card-body pt-6">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row align-middle gs-0 gy-3 my-0">
                <!--begin::Table head-->
                <thead>
                    <tr class="table-header fs-5 fw-bolder" style="color: #4D4D4D;">
                        <th class="p-1 pb-3 max-w-100px text-start">Icon</th>
                        <th class="p-3 pb-3 max-w-100px text-start">Application Name</th>
                        <th class="p-3 pb-3 max-w-100px text-start">Status</th>
                        <th class="p-0 pb-3 max-w-100px text-start"></th>
                        <th class="p-0 pb-3 max-w-100px text-start">Users</th>
                        <th class="p-3 pb-3 max-w-100px text-start">Release Date</th>
                        <th class="p-3 pb-3 max-w-50px text-start">Lead</th>
                        <th class="p-3 pb-3 max-w-50px text-start">Action</th>
                    </tr>
                    
                </thead>
            
                
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                    @foreach ($applications as $app)
                    <tr class="row-border border-bottom-2" style="color: #4D4D4D;">
                        <td>
                            <div class="d-flex align-items-center w-10 ">
                                <div class="symbol symbol-35px me-2">
                                    <img src="assets/media/uploads/{{$app->display_image}}" class="" alt="">
                                </div>
                                
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center w-10 ">
                                <div class="d-flex justify-content-start flex-column w-10 ">
                                    <a href="{{$app->link}}" class="text-gray-800 fw-bold mb-1 fs-5">{{$app->name}}</a>
                                    {{-- <span class="text-gray-400 fw-semibold d-block fs-7">{{$app->short_description}}</span> --}}
                                </div>
                            </div>
                        </td>
                        <td class="text-start">
                            <span class="badge
                    @if ($app->status->id == 1)
                    testing-color
                    @elseif($app->status->id == 2)
                    production-color
                    @else
                        badge-light
                    @endif

                    fs-7 fw-bolder me-auto py-3 rounded-pill ">{{$app->status->name}}</span>
                        
                        </td>
                        <td>
                            @if (isset($app->published_by))
                            <span class="badge badge-primary fw-bolder fs-7 me-auto px-2 py-2 rounded-pill ">Published</span>
                            @else
                            <span class="badge Unpublished fw-bolder me-auto fs-7 px-2 py-2 rounded-pill ">UnPublished</span>
                            @endif
                        </td>
                        <td class="text-start fs-5">
                            <!--begin::Label-->
                            {{$app->internal_users_no+$app->external_users_no}}
                            <!--end::Label-->
                        </td>
                        <td class="text-start">
                            <span class="fw-bold fs-5">{{$app->release_date}}</span>
                        </td>
                        <td class="text-start">
                            <span class="fw-bold fs-5">{{$app->leadDeveloper->first_name.' '.$app->leadDeveloper->last_name}}</span>
                            
                        </td>
                        <td class="">
                               <a href="#" class="btn btn-light btn-active-light-primary btn-sm table-action-btn" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="me-2 fs-5">Actions</span>
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
