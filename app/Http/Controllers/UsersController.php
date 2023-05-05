<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
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
        // get the search value from the request
        $search = request('search');

        // get the status value from the request
        $status = request('status');

        $internal = request('internal');
        $external = request('external');

        return [
            'page_title' => 'Home',
            'page_type' => 'normal',
            'applications' => Application::get(),
            'published_applications' => Application::when(request('status'), function($query) {
                return $query->where('status_id', request('status'));
            })
            ->when(request('search'), function($query) {
                $search = request('search');
                return $query->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%')
                          ->orWhere('description', 'LIKE', '%'.$search.'%');
                });
            })
            ->when($internal, function($query) {
                return $query->where('internal', 1);
            })
            ->when($external, function($query) {
                return $query->where('internal', 0);
            })
            ->whereNotNull('published_by')
            ->paginate(4),               
            // 'published_applications' => Application::whereNotNull('published_by')->paginate(4),
            'users_count' => Application::sum('internal_users_no') + Application::sum('external_users_no'),
            'max_users' => !empty($user_base) ? max($user_base) : 0,
            'min_users' => !empty($user_base) ? min($user_base) : 0,
            'developers' => User::get(),
            'status' => Status::get(),
            'roles' => Role::get(),
            'apps_by_status' => ['data' => $data, 'colors' => $colors, 'labels' => $labels],
        ];
    }
    public function index(request $req)
    {
        return view('index')->with($this->baseData());
    }

    

    public function postLogin(request $req)
    {
        $this->validation($req, 'login');

        $user = User::where('email', $req['email'])->first();

        if (auth()->attempt([
            'email' => $req['email'],
            'password' => $req['password'],
        ])) {
            $data = $this->baseData();
            return redirect('/')->with('success', 'Logged In Successfully')->with($data);
        } else {
            return back()->with('error', 'Wrong email or password');
        }
    }

    public function userProfile(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Profile';
        $data['page_type'] = 'auth';

        return view('user.profile')->with($data);
    }

    public function userApplications(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'My Apps';
        $data['page_type'] = 'page';
        $data['user_applications'] = Application::where('registered_by', Auth::user()->id)->get();
        return view('user.applications')->with($data);

    }

    public function searchApp(request $req)
    {
        $search = $req->input('term');
        $data = $this->baseData();
        $data['applications'] = Application::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->get();
        $data['page_title'] = 'Applications';
        $data['page_type'] = 'normal';
        return view('index')->with($data);
    }

    public function createNewApplication(request $form)
    {
        $this->validation($form, 'create_new_application');

        $app = $form->toArray();

        if (User::create([
            'name' => $app['name'],
            'description' => $app['description'],
            'short_description' => $app['short_description'],
            'link' => $app['link'],
            'logo_url' => $app['logo_url'],
            'internal' => $app['internal'],
            'external' => $app['external'],
            'users_no' => $app['users_no'],
            'lead_dev_email' => $app['lead_dev_email'],
            'release_date' => $app['release_date'],
            'status_id' => $app['status_id'],
            'registered_by' => Auth::user()->id,
        ])) {
            return back()->with('success', 'Application Created Successfully');
        } else {
            return back()->with('error', 'Error Creating Application');
        }
    }

    public function postRegister(request $form)
    {
        $this->validation($form, 'register');
        $user_images_path = 'assets/media/uploads/user_images/';
        $user = $form->toArray();
        $imageName = time() . '.' . $form->profile_image->extension();
        $form->profile_image->move(public_path($user_images_path), $imageName);
        $new_user = User::create([
            'first_name' => $user['first_name'],
            'middle_name' => $user['middle_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'dp_url' => $user_images_path . $imageName,
            // Developer role by default
            'role_id' => 2,
            'password' => Hash::make($user['password']),
            // 'created_by' => Auth::user()->id,
        ]);
        if ($new_user) {
            Auth::loginUsingId($new_user->id);

            return redirect('/')->with('success', 'Registered Successfully');
        } else {
            return back()->with('error', 'Error Registering');
        }
    }

    public function updateProfile(request $form)
    {
        $this->validation($form, 'update_profile');

        $user = User::find(Auth::user()->id);

        if (isset($form->password) && isset($form->password_confirmation)) {
            if ($form->password == $form->password_confirmation) {
                $user->password = Hash::make($form->password);
                $user->save();
            } else {
                return back()->with('error', 'Password and Confirm Password do not match');
            }
        }

        if (isset($form->profile_image)) {
            $user_images_path = 'assets/media/uploads/user_images/';
            $imageName = time() . '.' . $form->profile_image->extension();
            $form->profile_image->move(public_path($user_images_path), $imageName);
            $user->dp_url = $user_images_path . $imageName;
            $user->save();
        }

        $profile_updated = User::find(Auth::user()->id)->update([
            'first_name' => $form->first_name,
            'middle_name' => $form->middle_name,
            'last_name' => $form->last_name,
            'email' => $form->email,
        ]);
        if ($profile_updated) {
            return back()->with('success', 'Profile Updated Successfully');
        } else {
            return back()->with('error', 'Error Registering');
        }
    }

    public function redirectToApp($app)
    {
        $app = Application::where('single_name', $app)->first();
        if ($app) {
            return Redirect::away($app->link);
        } else {
            //Create a 404 page and redirect to it
            return redirect('/')->with('error', 'App not found');
        }

    }

    public function editApp($id)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Edit app';
        $data['app'] = Application::find($id);
        $data['page_type'] = 'auth';

        return view('app.edit')->with($data);
    }

    public function logout()
    {
        Auth::logout();

        return back()->with('success', 'Logged out Successfully');

    }

    public function validation($form, $type)
    {
        if ($type == 'login') {
            return $this->validate($form, [
                'email' => 'required|max:255',
                'password' => 'required|max:255',
            ]);
        }

        if ($type == 'create_new_application') {
            return $this->validate($form, [
                'name' => 'required|max:255',
                'description' => 'required',
                'short_description' => 'required|max:255',
                'link' => 'required',
                'logo_url' => 'required',
                'internal',
                'external',
                'users_no' => 'required|number',
                'lead_dev_email' => 'required|max:255',
                'release_date' => 'required|date',
                'status_id' => 'required',
            ]);
        }

        if ($type == 'register') {
            return $this->validate($form, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'profile_image' => 'required|mimes:png,jpg,jpeg',
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'required|min:6',
            ]);
        }

        if ($type == 'update_profile') {
            return $this->validate($form, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                // 'profile_image' => 'required|mimes:png,jpg,jpeg',
                // 'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                // 'password_confirmation' => 'required|min:6',
            ]);
        }

    }

    public function showLogin(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Login';
        $data['page_type'] = 'auth';

        return view('login')->with($data);
    }

    public function showRegister(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Register';
        $data['page_type'] = 'auth';

        return view('register')->with($data);
    }

    public function showForgotPassword(request $req)
    {
        $data = $this->baseData();
        $data['page_title'] = 'Forgot Password';
        $data['page_type'] = 'auth';

        return view('forgot-password')->with($data);
    }

}
