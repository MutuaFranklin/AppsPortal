<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function baseData()
    {
        $user_base = [];
        foreach (Application::get() as $app) {
            $user_base[] = Application::sum('internal_users_no') + Application::sum('external_users_no');
        }

        $base_colors = [
            "#00A3FF",
            "#50CD89",
            "#E4E6EF",
        ];
        $data = [];
        $colors = [];
        $labels = [];
        $i = 0;
        foreach (Status::get() as $status) {
            $data[] = Application::where('status_id', $status->id)->count();
            $colors[] = $base_colors[$i];
            $labels[] = $status->name;
            $i++;
        }

        return [
            'page_title' => 'Home',
            'page_type' => 'normal',
            'applications' => Application::get(),
            'published_applications' => Application::whereNotNull('published_by')->get(),
            'users_count' => Application::sum('internal_users_no') + Application::sum('external_users_no'),
            'max_users' => !empty($user_base) ? max($user_base) : 0,
            'min_users' => !empty($user_base) ? min($user_base) : 0,
            'developers' => User::get(),
            'status' => Status::get(),
            'roles' => Role::get(),
            'apps_by_status' => ['data' => $data, 'colors' => $colors, 'labels' => $labels],
        ];
    }
    public function createNewApplication(request $form)
    {

        $this->validation($form, 'create_new_application');

        // print_r(isset($application['usage_internal']) ? $application['usage_internal'] : "usage internal not set");
        // print_r(isset($application['usage_external']) ? $application['usage_external'] : "usage external not set");
        $public_path = env('public_path');
        $imageName = time() . '.' . $form->display_image->extension();
        // $form->display_image->move(public_path('assets/media/uploads'), $imageName);
        $form->display_image->move($public_path.'assets/media/uploads', $imageName);

        $application = $form->toArray();
        if (!isset($application['developers'])) {
            $devs = [Auth::user()->id];
        } else {
            $devs = $application['developers'];
            if (!in_array(Auth::user()->id, $devs)) {
                $devs[] = Auth::user()->id;
            }
        }

        $new_app = Application::create([
            'name' => $application['name'],
            'single_name' => strtolower($application['single_name']),
            'description' => $application['description'],
            'short_description' => $application['short_description'],
            'link' => $application['link'],
            'display_image' => $imageName,
            'internal' => isset($application['usage_internal']) ? true : false,
            'external' => isset($application['usage_external']) ? true : false,
            'internal_users_no' => is_null($application['internal_users_no']) ? 0 : $application['internal_users_no'],
            'external_users_no' => is_null($application['external_users_no']) ? 0 : $application['external_users_no'],
            'lead_dev_email' => $application['lead_dev_email'],
            'release_date' => $application['release_date'],
            'status_id' => $application['status_id'],
            'registered_by' => Auth::user()->id,
            'lead_dev' => Auth::user()->id,
        ]);

        if ($new_app) {

            foreach ($devs as $dev) {
                DB::table('application_dev')->insert(
                    [
                        'application_id' => $new_app->id,
                        'user_id' => $dev,
                        'lead' => $dev == Auth::user()->id ? true : false,
                    ]
                );
            }
            return back()->with('success', 'Application Added Successfully');
        } else {
            return back()->with('error', 'Error Adding Application');
        }

    }

    public function editApplication($id, request $form)
    {

        $this->validation($form, 'edit_application');

        // print_r(isset($application['usage_internal']) ? $application['usage_internal'] : "usage internal not set");
        // print_r(isset($application['usage_external']) ? $application['usage_external'] : "usage external not set");

        $public_path = env('public_path');
        $new_details = [];
        $imageName = Application::where('id', $id)->first()->display_image;
        if (isset($form->display_image)) {
            $imageName = time() . '.' . $form->display_image->extension();
            $form->display_image->move(public_path('assets/media/uploads'), $imageName);
            $new_details['display_image'] = $imageName;
        }

        $application = $form->toArray();

        $delete_devs = DB::table('application_dev')->where('application_id', $id)->delete();

        if (!isset($application['developers'])) {
            $devs = [Auth::user()->id];
        } else {
            $devs = $application['developers'];
            if (!in_array(Auth::user()->id, $devs)) {
                $devs[] = Auth::user()->id;
            }
        }

        foreach ($devs as $dev) {
            DB::table('application_dev')->insert(
                [
                    'application_id' => $id,
                    'user_id' => $dev,
                    'lead' => $dev == Auth::user()->id ? true : false,
                ]
            );
        }

        $app_updated = Application::find($id)->update([
            'name' => $application['name'],
            'single_name' => strtolower($application['single_name']),
            'description' => $application['description'],
            'short_description' => $application['short_description'],
            'link' => $application['link'],
            'display_image' => $imageName,
            'internal' => isset($application['usage_internal']) ? true : false,
            'external' => isset($application['usage_external']) ? true : false,
            'internal_users_no' => is_null($application['internal_users_no']) ? 0 : $application['internal_users_no'],
            'external_users_no' => is_null($application['external_users_no']) ? 0 : $application['external_users_no'],
            'lead_dev_email' => $application['lead_dev_email'],
            'release_date' => $application['release_date'],
            'status_id' => $application['status_id'],
            'updated_by' => Auth::user()->id,
            // 'lead_dev' => Auth::user()->id,
        ]);

        if ($app_updated) {
            return back()->with('success', 'Application Updated Successfully');
        } else {
            return back()->with('error', 'Error Updating Application');
        }

    }

    public function updateApplication($id, request $form)
    {
        $this->validation($form, 'create_new_application');

        $application = $form->toArray();

        if (Application::where('id', $id)->update($form)) {
            return back()->with('success', 'Application Updated Successfully');
        } else {
            return back()->with('error', 'Error Updating Application');
        }

    }

    public function publishApp($id)
    {
        if (Auth::user()->role->id !== 1) {
            return back()->with('error', 'Only admins can publish applications');
        } else {
            $app_published = Application::find($id)->update(["published_by" => Auth::user()->id]);
            if ($app_published) {
                return back()->with('success', 'Application Published Successfully');
            } else {
                return back()->with('error', 'Error Publishing Application');
            }
        }
    }

    public function unPublishApp($id)
    {
        if (Auth::user()->role->id !== 1) {
            return back()->with('error', 'Only admins can unpublish applications');
        } else {
            $app_unpublished = Application::find($id)->update(["published_by" => null]);
            if ($app_unpublished) {
                return back()->with('success', 'Application Unpublished Successfully');
            } else {
                return back()->with('error', 'Error Unpublishing Application');
            }
        }
    }

    public function reviewApplications(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Review Apps';
        $data['page_type'] = 'page';
        return view('admin.review')->with($data);
    }

    public function listApplications(request $req)
    {

    }

    public function showApplication(request $req)
    {

    }

    public function deleteApplication($id, request $form)
    {

        if (Application::where('id', $id)->delete()) {
            return back()->with('success', 'Application Deleted Successfully');
        } else {
            return back()->with('error', 'Error Deleting Application');
        }

    }

    public function createNewRole(request $form)
    {
        $this->validation($form, 'create_new_role');

        $role = $form->toArray();

        if (Role::create([
            'name' => $role['name'],
            'description' => $role['description'],
            // 'created_by' => Auth::user()->id,
        ])) {
            return back()->with('success', 'Role Created Successfully');
        } else {
            return back()->with('error', 'Error Creating Role');
        }

    }

    public function updateRole($id, request $form)
    {
        $this->validation($form, 'create_new_role');

        $role = $form->toArray();

        if (Role::where('id', $id)->update([
            'name' => $role['name'],
            'description' => $role['description'],
        ])) {
            return back()->with('success', 'Role Updated Successfully');
        } else {
            return back()->with('error', 'Error Updating Role');
        }

    }

    public function listRole(request $req)
    {

    }

    public function showRole(request $req)
    {

    }

    public function deleteRole($id, request $form)
    {

        if (Role::where('id', $id)->delete()) {
            return back()->with('success', 'Role Deleted Successfully');
        } else {
            return back()->with('error', 'Error Deleting Role');
        }

    }

    public function createNewStatus(request $form)
    {
        $this->validation($form, 'create_new_status');

        $status = $form->toArray();

        if (Status::create([
            'name' => $status['name'],
            'description' => $status['description'],
            'created_by' => Auth::user()->id,
        ])) {
            return back()->with('success', 'Status Created Successfully');
        } else {
            return back()->with('error', 'Error Creating Status');
        }
    }

    public function updateStatus($id, request $form)
    {
        $this->validation($form, 'create_new_status');

        $status = $form->toArray();

        if (Status::where('id', $id)->update([
            'name' => $status['name'],
            'description' => $status['description'],
        ])) {
            return back()->with('success', 'Status Updated Successfully');
        } else {
            return back()->with('error', 'Error Updating Status');
        }

    }

    public function listStatus(request $req)
    {

    }

    public function showStatus(request $req)
    {

    }

    public function deleteStatus($id, request $form)
    {

        if (Status::where('id', $id)->delete()) {
            return back()->with('success', 'Status Deleted Successfully');
        } else {
            return back()->with('error', 'Error Deleting Status');
        }

    }

    public function createNewUser(request $form)
    {
        $this->validation($form, 'create_new_user');

        $user = $form->toArray();
        // $imageName = time() . '.' . $form->display_image->extension();
        // $form->display_image->move(public_path('assets/media/uploads'), $imageName);

        if (User::create([
            'first_name' => $user['first_name'],
            'middle_name' => $user['middle_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'dp_url' => $user['dp_url'],
            'role_id' => $user['role_id'],
            'password' => Hash::make($user['password']),
            'created_by' => Auth::user()->id,
        ])) {
            return back()->with('success', 'User Created Successfully');
        } else {
            return back()->with('error', 'Error Creating User');
        }
    }

    public function updateUser($id, request $form)
    {
        $this->validation($form, 'create_new_user');

        $user = $form->toArray();

        if (User::where('id', $id)->update([
            'first_name' => $user['first_name'],
            'middle_name' => $user['middle_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'dp_url' => $user['dp_url'],
            'role_id' => $user['role_id'],
            'password' => bcrypt($user['password']),
        ])) {
            return back()->with('success', 'User Details Updated Successfully');
        } else {
            return back()->with('error', 'Error Updating User Details');
        }

    }

    public function listUsers(request $req)
    {

    }

    public function showUser(request $req)
    {

    }

    public function deleteUser($id, request $form)
    {

        if (User::where('id', $id)->delete()) {
            return back()->with('success', 'User Deleted Successfully');
        } else {
            return back()->with('error', 'Error Deleting User');
        }

    }

    public function validation($form, $type)
    {
        if ($type == 'create_new_application') {
            return $this->validate($form, [
                'name' => 'required|max:255',
                'single_name' => 'required|max:12',
                'link' => 'required',
                'display_image' => 'required|image|mimes:jpeg,png,jpg',
                'short_description' => 'required|max:255',
                'description' => 'required',
                'release_date' => 'required',
                'status_id' => 'required',
            ]);
        }
        if ($type == 'edit_application') {
            return $this->validate($form, [
                'name' => 'required|max:255',
                'single_name' => 'required|max:12',
                'link' => 'required',
                'short_description' => 'required|max:255',
                'description' => 'required',
                'release_date' => 'required',
                'status_id' => 'required',
            ]);
        }

        if ($type == 'create_new_user') {
            return $this->validate($form, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'required|max:255',
            ]);
        }
        if ($type == 'create_new_role') {
            return $this->validate($form, [
                'name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
        }
        if ($type == 'create_new_status') {
            return $this->validate($form, [
                'name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
        }
    }
}
