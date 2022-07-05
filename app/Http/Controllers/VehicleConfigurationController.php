<?php

namespace App\Http\Controllers;

use App\Models\VehicleConfiguration;
use Illuminate\Http\Request;

class VehicleConfigurationController extends Controller
{
    //
    public function index(){
        $configurations = VehicleConfiguration::orderBy('name')->get();
        return view('pages.vehicles.configurations.index',compact('configurations'));
    }

    public function store(Request $request){
        try {
            $configuration_id = $request->configuration_id;
            $config = VehicleConfiguration::find($configuration_id);
            if(!$config)
                $config = new VehicleConfiguration();
            $config->name = $request->name;
            $config->value = $request->value;
            $config->type = $request->type;
            $config->save();
            return back()->with('success', 'Configuration ');
        }catch(\Exception $e){
            return back()->with('error', 'Something happened');
        }
    }

    public function destroy(VehicleConfiguration $configuration){
        try {
            $configuration->delete();
            return back()->with('success', 'Configuration deleted successfully');
        }catch (\Exception $e){
            return back()->with('error', 'Cannot delete this configuration');
        }
    }
}
