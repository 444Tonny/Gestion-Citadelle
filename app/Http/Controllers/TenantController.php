<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Tenant;
use App\Models\TenantDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TenantController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage tenant')) {
            $tenants = Tenant::where('parent_id', \Auth::user()->parentId())->get();
            return view('tenant.index', compact('tenants'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('create tenant')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), 0);
            return view('tenant.create', compact('property'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create tenant')) {
            $validator = \Validator::make(
                $request->all(), [
                'first_name' => 'required|regex:/^[\s\w-]*$/',
                'last_name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required',
                'password' => 'required',
                'phone_number' => 'required',
                'family_member' => 'required',
                'country' => 'required|regex:/^[\s\w-]*$/',
                'state' => 'required|regex:/^[\s\w-]*$/',
                'city' => 'required|regex:/^[\s\w-]*$/',
                'zip_code' => 'required|regex:/^[\s\w-]*$/',
                'address' => 'required',
                'property' => 'required',
                'unit' => 'required',
                'lease_start_date' => 'required',
                'lease_end_date' => 'required',
            ], [
                    'regex' => __('The input format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'status' => 'error',
                    'msg' => $messages->first(),
                ]);

            }
            $role_r = Role::findByName('tenant');
            $user=new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = \Hash::make($request->password);
            $user->phone_number = $request->phone_number;
            $user->type = $role_r->name;
            $user->profile = 'avatar.png';
            $user->lang = 'english';
            $user->parent_id = \Auth::user()->parentId();
            $user->save();
            $user->assignRole($role_r);

            if ($request->profile!='undefined') {
                $tenantFilenameWithExt = $request->file('profile')->getClientOriginalName();
                $tenantFilename = pathinfo($tenantFilenameWithExt, PATHINFO_FILENAME);
                $tenantExtension = $request->file('profile')->getClientOriginalExtension();
                $tenantFileName = $tenantFilename . '_' . time() . '.' . $tenantExtension;
                $dir = storage_path('upload/profile');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('profile')->storeAs('upload/profile/', $tenantFileName);
                $user->profile = $tenantFileName;
                $user->save();
            }

            $tenant = new Tenant();
            $tenant->user_id = $user->id;
            $tenant->family_member = $request->family_member;
            $tenant->country = $request->country;
            $tenant->state = $request->state;
            $tenant->city = $request->city;
            $tenant->zip_code = $request->zip_code;
            $tenant->address = $request->address;
            $tenant->property = $request->property;
            $tenant->unit = $request->unit;
            $tenant->lease_start_date = $request->lease_start_date;
            $tenant->lease_end_date = $request->lease_end_date;
            $tenant->parent_id = \Auth::user()->parentId();
            $tenant->save();



            if (!empty($request->tenant_images)) {
                foreach ($request->tenant_images as $file) {
                    $tenantFilenameWithExt = $file->getClientOriginalName();
                    $tenantFilename = pathinfo($tenantFilenameWithExt, PATHINFO_FILENAME);
                    $tenantExtension = $file->getClientOriginalExtension();
                    $tenantFileName = $tenantFilename . '_' . time() . '.' . $tenantExtension;
                    $dir = storage_path('upload/tenant');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $file->storeAs('upload/tenant/', $tenantFileName);

                    $tenantImage = new TenantDocument();
                    $tenantImage->property_id = $request->property;
                    $tenantImage->tenant_id = $tenant->id;
                    $tenantImage->document = $tenantFileName;
                    $tenantImage->parent_id = \Auth::user()->parentId();
                    $tenantImage->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'msg' => __('Tenant successfully created.'),

            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show(Tenant $tenant)
    {
        if (\Auth::user()->can('show tenant')) {
            return view('tenant.show', compact('tenant'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function edit(Tenant $tenant)
    {
        if (\Auth::user()->can('edit tenant')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), 0);

            $user=User::find($tenant->user_id);
            return view('tenant.edit', compact('property', 'tenant','user'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, Tenant $tenant)
    {
        if (\Auth::user()->can('edit tenant')) {
            $validator = \Validator::make(
                $request->all(), [
                'first_name' => 'required|regex:/^[\s\w-]*$/',
                'last_name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required',
                'phone_number' => 'required',
                'family_member' => 'required',
                'country' => 'required|regex:/^[\s\w-]*$/',
                'state' => 'required|regex:/^[\s\w-]*$/',
                'city' => 'required|regex:/^[\s\w-]*$/',
                'zip_code' => 'required|regex:/^[\s\w-]*$/',
                'address' => 'required',
                'property' => 'required',
                'unit' => 'required',
                'lease_start_date' => 'required',
                'lease_end_date' => 'required',
            ], [
                    'regex' => __('The input format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'status' => 'error',
                    'msg' => $messages->first(),

                ]);

            }

            $user=User::find($tenant->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->save();

            if ($request->profile!='') {
                $tenantFilenameWithExt = $request->file('profile')->getClientOriginalName();
                $tenantFilename = pathinfo($tenantFilenameWithExt, PATHINFO_FILENAME);
                $tenantExtension = $request->file('profile')->getClientOriginalExtension();
                $tenantFileName = $tenantFilename . '_' . time() . '.' . $tenantExtension;
                $dir = storage_path('upload/profile');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('profile')->storeAs('upload/profile/', $tenantFileName);
                $user->profile = $tenantFileName;
                $user->save();
            }

            $tenant->family_member = $request->family_member;
            $tenant->country = $request->country;
            $tenant->state = $request->state;
            $tenant->city = $request->city;
            $tenant->zip_code = $request->zip_code;
            $tenant->address = $request->address;
            $tenant->property = $request->property;
            $tenant->unit = $request->unit;
            $tenant->lease_start_date = $request->lease_start_date;
            $tenant->lease_end_date = $request->lease_end_date;
            $tenant->save();



            if (!empty($request->tenant_images)) {
                foreach ($request->tenant_images as $file) {
                    $tenantFilenameWithExt = $file->getClientOriginalName();
                    $tenantFilename = pathinfo($tenantFilenameWithExt, PATHINFO_FILENAME);
                    $tenantExtension = $file->getClientOriginalExtension();
                    $tenantFileName = $tenantFilename . '_' . time() . '.' . $tenantExtension;
                    $dir = storage_path('upload/tenant');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $file->storeAs('upload/tenant/', $tenantFileName);

                    $tenantImage = new TenantDocument();
                    $tenantImage->property_id = $request->property;
                    $tenantImage->tenant_id = $tenant->id;
                    $tenantImage->document = $tenantFileName;
                    $tenantImage->parent_id = \Auth::user()->parentId();
                    $tenantImage->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'msg' => __('Tenant successfully updated.'),
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(Tenant $tenant)
    {
        if (\Auth::user()->can('delete tenant')) {
            $tenant->delete();
            return redirect()->back()->with('success', 'Tenant successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

}
