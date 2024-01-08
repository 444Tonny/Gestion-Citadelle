<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage property')) {
            $properties = Property::where('parent_id', \Auth::user()->parentId())->get();
            return view('property.index', compact('properties'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('create property')) {
            $types = Property::$Type;
            return view('property.create', compact('types'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create property')) {
            $validator = \Validator::make(
                $request->all(), [
                'name' => 'required|regex:/^[\s\w-]*$/',
                'description' => 'required',
                'type' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
                'address' => 'required',
                'thumbnail' => 'required',
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

            $property = new Property();
            $property->name = $request->name;
            $property->description = $request->description;
            $property->type = $request->type;
            $property->country = $request->country;
            $property->state = $request->state;
            $property->city = $request->city;
            $property->zip_code = $request->zip_code;
            $property->address = $request->address;
            $property->parent_id = \Auth::user()->parentId();
            $property->save();

            if (!empty($request->thumbnail)) {
                $thumbnailFilenameWithExt = $request->file('thumbnail')->getClientOriginalName();
                $thumbnailFilename = pathinfo($thumbnailFilenameWithExt, PATHINFO_FILENAME);
                $thumbnailExtension = $request->file('thumbnail')->getClientOriginalExtension();
                $thumbnailFileName = $thumbnailFilename . '_' . time() . '.' . $thumbnailExtension;
                $dir = storage_path('upload/thumbnail');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('thumbnail')->storeAs('upload/thumbnail/', $thumbnailFileName);
                $thumbnail = new PropertyImage();
                $thumbnail->property_id = $property->id;
                $thumbnail->image = $thumbnailFileName;
                $thumbnail->type = 'thumbnail';
                $thumbnail->save();
            }

            if (!empty($request->property_images)) {
                foreach ($request->property_images as $file) {
                    $propertyFilenameWithExt = $file->getClientOriginalName();
                    $propertyFilename = pathinfo($propertyFilenameWithExt, PATHINFO_FILENAME);
                    $propertyExtension = $file->getClientOriginalExtension();
                    $propertyFileName = $propertyFilename . '_' . time() . '.' . $propertyExtension;
                    $dir = storage_path('upload/property');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $file->storeAs('upload/property/', $propertyFileName);

                    $propertyImage = new PropertyImage();
                    $propertyImage->property_id = $property->id;
                    $propertyImage->image = $propertyFileName;
                    $propertyImage->type = 'extra';
                    $propertyImage->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'msg' => __('Property successfully created.'),
                'id' => $property->id,
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }


    public function show(Property $property)
    {
        if (\Auth::user()->can('show property')) {
            $units = PropertyUnit::where('property_id', $property->id)->orderBy('id', 'desc')->get();
            return view('property.show', compact('property', 'units'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function edit(Property $property)
    {
        if (\Auth::user()->can('edit property')) {
            $types = Property::$Type;
            return view('property.edit', compact('types', 'property'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, Property $property)
    {
        if (\Auth::user()->can('edit property')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|regex:/^[\s\w-]*$/',
                    'description' => 'required',
                    'type' => 'required',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'zip_code' => 'required',
                    'address' => 'required',

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

            $property->name = $request->name;
            $property->description = $request->description;
            $property->type = $request->type;
            $property->country = $request->country;
            $property->state = $request->state;
            $property->city = $request->city;
            $property->zip_code = $request->zip_code;
            $property->address = $request->address;
            $property->save();

            if (!empty($request->thumbnail)) {
                $image_path = "storage/upload/thumbnail/" . !empty($property->thumbnail) ? $property->thumbnail->image : '';

                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $thumbnailFilenameWithExt = $request->file('thumbnail')->getClientOriginalName();
                $thumbnailFilename = pathinfo($thumbnailFilenameWithExt, PATHINFO_FILENAME);
                $thumbnailExtension = $request->file('thumbnail')->getClientOriginalExtension();
                $thumbnailFileName = $thumbnailFilename . '_' . time() . '.' . $thumbnailExtension;
                $dir = storage_path('upload/thumbnail');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('thumbnail')->storeAs('upload/thumbnail/', $thumbnailFileName);
                $thumbnail = new PropertyImage();
                $thumbnail->property_id = $property->id;
                $thumbnail->image = $thumbnailFileName;
                $thumbnail->type = 'thumbnail';
                $thumbnail->save();
            }

            if (!empty($request->property_images)) {
                foreach ($request->property_images as $file) {
                    $propertyFilenameWithExt = $file->getClientOriginalName();
                    $propertyFilename = pathinfo($propertyFilenameWithExt, PATHINFO_FILENAME);
                    $propertyExtension = $file->getClientOriginalExtension();
                    $propertyFileName = $propertyFilename . '_' . time() . '.' . $propertyExtension;
                    $dir = storage_path('upload/property');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $file->storeAs('upload/property/', $propertyFileName);

                    $propertyImage = new PropertyImage();
                    $propertyImage->property_id = $property->id;
                    $propertyImage->image = $propertyFileName;
                    $propertyImage->type = 'extra';
                    $propertyImage->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'msg' => __('Property successfully updated.'),
                'id' => $property->id,
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(Property $property)
    {
        if (\Auth::user()->can('delete property')) {
            $property->delete();
            return redirect()->back()->with('success', 'Property successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }


    public function unitCreate($property_id)
    {
        $types = PropertyUnit::$Types;
        $rentTypes = PropertyUnit::$rentTypes;
        return view('unit.create', compact('types', 'property_id', 'rentTypes'));
    }

    public function unitStore(Request $request, $property_id)
    {
        if (\Auth::user()->can('create unit')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|regex:/^[\s\w-]*$/',
                    'bedroom' => 'required',
                    'kitchen' => 'required',
                    'baths' => 'required',
                    'rent' => 'required',
                    'rent_type' => 'required',
                    'deposit_type' => 'required',
                    'deposit_amount' => 'required',
                    'late_fee_type' => 'required',
                    'late_fee_amount' => 'required',
                    'incident_receipt_amount' => 'required',
                ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $unit = new PropertyUnit();
            $unit->name = $request->name;
            $unit->bedroom = $request->bedroom;
            $unit->kitchen = $request->kitchen;
            $unit->baths = $request->baths;
            $unit->rent = $request->rent;
            $unit->rent_type = $request->rent_type;
            if ($request->rent_type == 'custom') {
                $unit->start_date = $request->start_date;
                $unit->end_date = $request->end_date;
                $unit->payment_due_date = $request->payment_due_date;
            } else {
                $unit->rent_duration = $request->rent_duration;
            }

            $unit->deposit_type = $request->deposit_type;
            $unit->deposit_amount = $request->deposit_amount;
            $unit->late_fee_type = $request->late_fee_type;
            $unit->late_fee_amount = $request->late_fee_amount;
            $unit->incident_receipt_amount = $request->incident_receipt_amount;
            $unit->notes = $request->notes;
            $unit->property_id = $property_id;
            $unit->parent_id = \Auth::user()->parentId();
            $unit->save();
            return redirect()->back()->with('success', __('Unit successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function unitEdit($property_id, $unit_id)
    {
        $unit = PropertyUnit::find($unit_id);
        $types = PropertyUnit::$Types;
        $rentTypes = PropertyUnit::$rentTypes;
        return view('unit.edit', compact('types', 'property_id', 'rentTypes', 'unit'));
    }

    public function unitUpdate(Request $request, $property_id, $unit_id)
    {
        if (\Auth::user()->can('edit unit')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|regex:/^[\s\w-]*$/',
                    'bedroom' => 'required',
                    'kitchen' => 'required',
                    'baths' => 'required',
                    'rent' => 'required',
                    'rent_type' => 'required',
                    'deposit_type' => 'required',
                    'deposit_amount' => 'required',
                    'late_fee_type' => 'required',
                    'late_fee_amount' => 'required',
                    'incident_receipt_amount' => 'required',
                ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $unit = PropertyUnit::find($unit_id);
            $unit->name = $request->name;
            $unit->bedroom = $request->bedroom;
            $unit->kitchen = $request->kitchen;
            $unit->baths = $request->baths;
            $unit->rent = $request->rent;
            $unit->rent_type = $request->rent_type;
            if ($request->rent_type == 'custom') {
                $unit->start_date = $request->start_date;
                $unit->end_date = $request->end_date;
                $unit->payment_due_date = $request->payment_due_date;
            } else {
                $unit->rent_duration = $request->rent_duration;
            }

            $unit->deposit_type = $request->deposit_type;
            $unit->deposit_amount = $request->deposit_amount;
            $unit->late_fee_type = $request->late_fee_type;
            $unit->late_fee_amount = $request->late_fee_amount;
            $unit->incident_receipt_amount = $request->incident_receipt_amount;
            $unit->notes = $request->notes;
            $unit->save();
            return redirect()->back()->with('success', __('Unit successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function unitDestroy($property_id, $unit_id)
    {
        if (\Auth::user()->can('delete unit')) {
            $unit = PropertyUnit::find($unit_id);
            $unit->delete();
            return redirect()->back()->with('success', 'Unit successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function getPropertyUnit($property_id)
    {
        $units = PropertyUnit::where('property_id', $property_id)->get()->pluck('name', 'id');
        return response()->json($units);
    }
}
