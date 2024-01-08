<?php

namespace App\Http\Controllers;

use App\Models\Maintainer;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage maintenance request')) {
            if(\Auth::user()->type=='maintainer'){
                $maintenanceRequests = MaintenanceRequest::where('maintainer_id', \Auth::user()->id)->get();
            }else{
                $maintenanceRequests = MaintenanceRequest::where('parent_id', \Auth::user()->parentId())->get();
            }
            return view('maintenance_request.index', compact('maintenanceRequests'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('create maintenance request')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), 0);

            $maintainers = User::where('parent_id', \Auth::user()->parentId())->where('type','maintainer')->get()->pluck("name", 'id');
            $maintainers->prepend(__('Select Maintainer'), 0);

            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'issue')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            $status=MaintenanceRequest::$status;
            return view('maintenance_request.create', compact('property','types','maintainers','status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function store(Request $request)
    {

        if (\Auth::user()->can('create maintenance request')) {
            $validator = \Validator::make(
                $request->all(), [
                'property_id' => 'required',
                'unit_id' => 'required',
                'issue_type' => 'required',
                'maintainer_id' => 'required',
                'request_date' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error',$messages->first());
            }
            $MaintenanceRequest = new MaintenanceRequest();
            $MaintenanceRequest->property_id = $request->property_id;
            $MaintenanceRequest->unit_id = $request->unit_id;
            $MaintenanceRequest->issue_type = $request->issue_type;
            $MaintenanceRequest->maintainer_id = $request->maintainer_id;
            $MaintenanceRequest->status = $request->status;
            $MaintenanceRequest->notes =  $request->notes;
            $MaintenanceRequest->request_date =  $request->request_date;
            $MaintenanceRequest->parent_id = \Auth::user()->parentId();
            $MaintenanceRequest->save();

            if (!empty($request->issue_attachment)) {
                $requestFilenameWithExt = $request->file('issue_attachment')->getClientOriginalName();
                $requestFilename = pathinfo($requestFilenameWithExt, PATHINFO_FILENAME);
                $requestExtension = $request->file('issue_attachment')->getClientOriginalExtension();
                $requestFileName = $requestFilename . '_' . time() . '.' . $requestExtension;
                $dir = storage_path('upload/issue_attachment');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('issue_attachment')->storeAs('upload/issue_attachment/', $requestFileName);
                $MaintenanceRequest->issue_attachment = $requestFileName;
                $MaintenanceRequest->save();
            }

            return redirect()->back()->with('success', 'Maintenance request successfully created.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show(MaintenanceRequest $maintenanceRequest)
    {
        return view('maintenance_request.show', compact('maintenanceRequest'));
    }


    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        if (\Auth::user()->can('edit maintenance request')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), 0);

            $maintainers = User::where('parent_id', \Auth::user()->parentId())->where('type','maintainer')->get()->pluck("name", 'id');
            $maintainers->prepend(__('Select Maintainer'), 0);

            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'issue')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            $status=MaintenanceRequest::$status;

            return view('maintenance_request.edit', compact('property','types','maintainers','maintenanceRequest','status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        if (\Auth::user()->can('edit maintenance request')) {
            $validator = \Validator::make(
                $request->all(), [
                'property_id' => 'required',
                'unit_id' => 'required',
                'issue_type' => 'required',
                'maintainer_id' => 'required',
                'request_date' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error',$messages->first());
            }

            $maintenanceRequest->property_id = $request->property_id;
            $maintenanceRequest->unit_id = $request->unit_id;
            $maintenanceRequest->issue_type = $request->issue_type;
            $maintenanceRequest->maintainer_id = $request->maintainer_id;
            $maintenanceRequest->status = $request->status;
            $maintenanceRequest->notes =  $request->notes;
            $maintenanceRequest->request_date =  $request->request_date;
            $maintenanceRequest->save();

            if (!empty($request->issue_attachment)) {
                $requestFilenameWithExt = $request->file('issue_attachment')->getClientOriginalName();
                $requestFilename = pathinfo($requestFilenameWithExt, PATHINFO_FILENAME);
                $requestExtension = $request->file('issue_attachment')->getClientOriginalExtension();
                $requestFileName = $requestFilename . '_' . time() . '.' . $requestExtension;
                $dir = storage_path('upload/issue_attachment');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('issue_attachment')->storeAs('upload/issue_attachment/', $requestFileName);
                $maintenanceRequest->issue_attachment = $requestFileName;
                $maintenanceRequest->save();
            }

            return redirect()->back()->with('success', 'Maintenance request successfully update.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        if (\Auth::user()->can('delete maintenance request')) {
            $maintenanceRequest->delete();
            return redirect()->back()->with('success', 'Maintenance request successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function action($id){
        $maintenanceRequest=MaintenanceRequest::find($id);
        $status=MaintenanceRequest::$status;
        return view('maintenance_request.action', compact('maintenanceRequest','status'));
    }

    public function actionData(Request $request,$id){
        $validator = \Validator::make(
            $request->all(), [
            'fixed_date' => 'required',
            'status' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error',$messages->first());
        }

        $maintenanceRequest=MaintenanceRequest::find($id);
        $maintenanceRequest->fixed_date = $request->fixed_date;
        $maintenanceRequest->status = $request->status;
        $maintenanceRequest->amount = $request->amount;
        $maintenanceRequest->save();

        if (!empty($request->invoice)) {
            $requestFilenameWithExt = $request->file('invoice')->getClientOriginalName();
            $requestFilename = pathinfo($requestFilenameWithExt, PATHINFO_FILENAME);
            $requestExtension = $request->file('invoice')->getClientOriginalExtension();
            $requestFileName = $requestFilename . '_' . time() . '.' . $requestExtension;
            $dir = storage_path('upload/invoice');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $request->file('invoice')->storeAs('upload/invoice/', $requestFileName);
            $maintenanceRequest->invoice = $requestFileName;
            $maintenanceRequest->save();
        }

        return redirect()->back()->with('success', 'Maintenance request successfully update.');
    }
}
