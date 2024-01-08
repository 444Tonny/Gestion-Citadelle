<?php

namespace App\Http\Controllers;

use App\Models\Maintainer;
use App\Models\Property;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MaintainerController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage maintainer')) {
            $maintainers = Maintainer::where('parent_id', \Auth::user()->parentId())->get();
            return view('maintainer.index', compact('maintainers'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('create maintainer')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');

            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'maintainer_type')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            return view('maintainer.create', compact('property','types'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function store(Request $request)
    {

        if (\Auth::user()->can('create maintainer')) {
            $validator = \Validator::make(
                $request->all(), [
                'first_name' => 'required|regex:/^[\s\w-]*$/',
                'last_name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required',
                'password' => 'required',
                'phone_number' => 'required',
                'property_id' => 'required',
                'type_id' => 'required',
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error',$messages->first());
            }

            $role_r = Role::findByName('maintainer');
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

            if (!empty($request->profile)) {
                $maintainerFilenameWithExt = $request->file('profile')->getClientOriginalName();
                $maintainerFilename = pathinfo($maintainerFilenameWithExt, PATHINFO_FILENAME);
                $maintainerExtension = $request->file('profile')->getClientOriginalExtension();
                $maintainerFileName = $maintainerFilename . '_' . time() . '.' . $maintainerExtension;
                $dir = storage_path('upload/profile');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('profile')->storeAs('upload/profile/', $maintainerFileName);
                $user->profile = $maintainerFileName;
                $user->save();
            }


            $maintainer = new Maintainer();
            $maintainer->user_id = $user->id;
            $maintainer->property_id = !empty($request->property_id)?implode(',',$request->property_id):0;
            $maintainer->type_id = $request->type_id;
            $maintainer->parent_id = \Auth::user()->parentId();
            $maintainer->save();


            return redirect()->back()->with('success', 'Maintainer successfully created.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show(Maintainer $maintainer)
    {
        //
    }


    public function edit(Maintainer $maintainer)
    {
        if (\Auth::user()->can('edit maintainer')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');

            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'maintainer_type')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');
            $user=User::find($maintainer->user_id);
            return view('maintainer.edit', compact('property','maintainer','types','user'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, Maintainer $maintainer)
    {
        if (\Auth::user()->can('edit maintainer')) {
            $validator = \Validator::make(
                $request->all(), [
                'first_name' => 'required|regex:/^[\s\w-]*$/',
                'last_name' => 'required|regex:/^[\s\w-]*$/',
                'email' => 'required',
                'phone_number' => 'required',
                'property_id' => 'required',
                'type_id' => 'required',
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return response()->json([
                    'status' => 'error',
                    'msg' => $messages->first(),

                ]);

            }

            $user=User::find($maintainer->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->save();

            if (!empty($request->profile)) {
                $maintainerFilenameWithExt = $request->file('profile')->getClientOriginalName();
                $maintainerFilename = pathinfo($maintainerFilenameWithExt, PATHINFO_FILENAME);
                $maintainerExtension = $request->file('profile')->getClientOriginalExtension();
                $maintainerFileName = $maintainerFilename . '_' . time() . '.' . $maintainerExtension;
                $dir = storage_path('upload/profile');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('profile')->storeAs('upload/profile/', $maintainerFileName);
                $user->profile = $maintainerFileName;
                $user->save();
            }

            $maintainer->property_id = !empty($request->property_id)?implode(',',$request->property_id):0;
            $maintainer->type_id = $request->type_id;
            $maintainer->save();



            return redirect()->back()->with('success', 'Maintainer successfully updated.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(Maintainer $maintainer)
    {
        if (\Auth::user()->can('delete maintainer')) {
            $maintainer->delete();
            return redirect()->back()->with('success', 'Maintainer successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
}
