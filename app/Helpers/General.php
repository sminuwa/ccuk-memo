<?php

use App\Models\FuelPrice;
use App\Models\Memo;
use App\Models\Vehicle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleDispatch;
use App\Models\VehicleDispatchForm;
use App\Models\VehicleDriver;
use App\Models\User;
use App\Models\VehicleMaintenance;

/**
 * Created by PhpStorm.
 * User: sunusi
 * Date: 4/14/21
 * Time: 6:14 PM
 * @param null $string
 * @return string
 */

function myAsset($string = null)
{
    /*
     * Change the $public value to resources directory
     * examle: $public = "public/";
     * this will add public/ to all assets
     * */
    $public = null;
    return asset($public . $string);
}

function newId()
{
    return time() . rand(100, 999);
}

function referenceServer(){
	// 1 for local server
	// 2 for remote server
	return true;
}

function getModels()
{
    $path = app_path() . "/Models";
    $out = [];
    $results = scandir($path);
    foreach ($results as $result) {
        if ($result === '.' or $result === '..') continue;
        $model = $result;
        if (is_dir($model)) {
            $out = array_merge($out, getModels($model));
        } else {
            $out[] = substr($model, 0, -4);
        }
    }
    return $out;
}

function listModels(){
    return [
        "AccountCode",
        "Attachement",
        "BankSupplier",
        "Branch",
        "CashBook",
        "Department",
        "Form",
        "FormParticular",
        "Group",
        "Memo",
        "MemoDraft",
        "MemoStatus",
        "Message",
        "Minute",
        "PaymentProcess",
        "Permission",
        "PermissionRole",
        "PermissionUser",
        "Position",
        "Role",
        "RoleUser",
        "User",
        "UserDetail"
    ];
}

function marital_status(){
    return ['Divorced', 'Married', 'Single', 'Widowed', 'Separated'];
}

function staff_status(){
    return ['active', 'fired', 'retired', 'resigned', 'deceased'];
}

function getFuelPrice($fuel_name){
    if($fuel = FuelPrice::where(['date_to'=> null, 'name'=>$fuel_name])->first()) return $fuel;
    return 0;
}

function MemoVehicles(Memo $memo){

}

function vehicleByDispatch(VehicleDispatch $dispatch){
    return Vehicle::find(VehicleDriver::find($dispatch->vehicle_driver_id)->vehicle_id);
}

function driverByDispatch(VehicleDispatch $dispatch){
    return User::find(VehicleDriver::find($dispatch->vehicle_driver_id)->user_id);
}

function vehicleForm(Memo $memo){
    $form = VehicleDispatchForm::where('memo_id', $memo->id)->first();
    $maintenance = VehicleMaintenance::where('memo_id', $memo->id)->first();
    if($form){
        if($form->type == VehicleDispatchForm::TYPE_DISPATCH) return dispatchForm($form, $memo);
        if($form->type == VehicleDispatchForm::TYPE_FUEL) return dispatchForm($form, $memo);
        if($form->type == VehicleDispatchForm::TYPE_CARRIAGE) return dispatchForm($form, $memo);
        if($form->type == VehicleDispatchForm::TYPE_REPAIR) return dispatchForm($form, $memo);
        if($form->type == VehicleDispatchForm::TYPE_FEEDING) return dispatchForm($form, $memo);
        if($form->type == VehicleDispatchForm::TYPE_OTHERS) return dispatchForm($form, $memo);
    }
    if($maintenance){
        return maintenanceForm($maintenance, $memo);
    }
}

function dispatchForm(VehicleDispatchForm $form, Memo $memo){
    $dispatch = VehicleDispatch::find($form->vehicle_dispatch_id);
    $driver = driverByDispatch($dispatch);
    $vehicle = vehicleByDispatch($dispatch);
    $html = $fuel = $commission ='';
    $formData = json_decode($form->data);
    if(isset($formData->commission)){
        $commission = $formData->commission;
    }
    if(isset($formData->fuel_option)){
        $fuel = '
            <h6 class="text-success text-uppercase">Fuel Request</h6>
            <table class="table table-bordered table-sm" style="width:100%">
                <tr><th class="px-3 py-1">Filling Station</th><td class="px-3 py-1">'.$formData->filling_station.'</td></tr>
                <tr><th class="px-3 py-1">Route</th><td class="px-3 py-1">'.$formData->route.' </td></tr>
                <tr><th class="px-3 py-1">Litre</th><td class="px-3 py-1">'.$formData->litre.' </td></tr>
                <tr><th class="px-3 py-1">Rate</th><td class="px-3 py-1">'.$formData->amount_per_litre.' </td></tr>
                <tr><th class="px-3 py-1">Amount</th><td class="px-3 py-1">'.number_format($formData->amount).' </td></tr>
                <tr><th class="px-3 py-1">Amount in Word</th><td class="px-3 py-1">'.numberTowords($formData->amount).' </td></tr>
            </table>
        ';
    }
    $html .= '
        <div>
            <h4 class="text-center"><span style="background: black; color:white;">&nbsp; VEHICLE DISPATCH REQUEST &nbsp;</span></h4>
            '.memoHeader($memo).'
            <table class="mt-lg-3 table table-bordered table-striped" style="width:100%">
                <tr><th class="px-3 py-1">Truck Name</th><td class="px-3 py-1"><a href="'.route('vehicles.show',$vehicle->id).'">'.$vehicle->name.' ('. $vehicle->number .')</a></td></tr>
                <tr><th class="px-3 py-1">Dispatch Number</th><td class="px-3 py-1">'.$dispatch->number.' </td></tr>
                <tr><th class="px-3 py-1">Date & Time</th><td class="px-3 py-1">'.$form->created_at.' </td></tr>
                <tr><th class="px-3 py-1">Truck Code</th><td class="px-3 py-1">'.$vehicle->code.' </td></tr>
                <tr><th class="px-3 py-1">Driver\'s Name</th><td class="px-3 py-1">'.$driver->fullName().' </td></tr>
            </table>
            <h6 class="text-success text-uppercase">Carriage Request</h6>
            <table class="table table-bordered" style="width:100%">
                <tr>
                    <th class="px-3 py-1">Shipped From</th>
                    <td class="px-3 py-1">
                        '.$formData->shipped_from.'
                    </td>
                    <th class="px-3 py-1">Shipped To</th>
                    <td class="px-3 py-1">
                        '.$formData->shipped_to.'
                    </td>
                </tr>
                <tr>
                    <th class="px-3 py-1">Total Cost</th>
                    <td class="px-3 py-1">'.$formData->cost.' </td>
                    <th class="px-3 py-1">Commission</th>
                    <td class="px-3 py-1">'.$commission.' </td>
                </tr>
                <tr>
                    <th class="px-3 py-1">Item & Description</th>
                    <td colspan="3" class="px-3 py-1">'.$formData->item.' </td>
                </tr>
            </table>
            '.$fuel.'
            '.memoApproval($memo, $vehicle).'
        </div>
    ';
    return $html;
}

function maintenanceForm(VehicleMaintenance $form, Memo $memo){
    $html ='';
    $vehicle  = $form->vehicle;
    $html .= '
        <div>
            <h4 class="text-center"><span style="background: black; color:white;">&nbsp; VEHICLE MAINTENANCE REQUEST &nbsp;</span></h4>
            '.memoHeader($memo).'
            <table class="mt-lg-3 table table-bordered table-striped" style="width:100%">
                <tr><th class="px-3 py-1">Truck Name</th><td class="pl-3 pr-3"><a href="'.route('vehicles.show',$vehicle->id).'">'.$vehicle->name.' ('. $vehicle->number .')</a></td></tr>
                <tr><th class="px-3 py-1">Request Number</th><td class="pl-3 pr-3">'.$form->reference.' </td></tr>
                <tr><th class="px-3 py-1">Amount</th><td class="pl-3 pr-3">'.number_format($form->amount).' </td></tr>
                <tr><th class="px-3 py-1">Amount in Word</th><td class="pl-3 pr-3">'.numberTowords($form->amount).' </td></tr>
                <tr><th class="px-3 py-1">Description</th><td class="pl-3 pr-3">'.$form->description.' </td></tr>
                <tr><th class="px-3 py-1">Date & Time</th><td class="pl-3 pr-3">'.$form->created_at.' </td></tr>
            </table>
            '.memoApproval($memo, $vehicle).'
        </div>
    ';
    return $html;
}

function fuelForm(VehicleDispatchForm $form, Memo $memo){
    $dispatch = VehicleDispatch::find($form->vehicle_dispatch_id);
    $driver = driverByDispatch($dispatch);
    $vehicle = vehicleByDispatch($dispatch);
    $html = $approvedBy = $authorizedBy = $verifiedBy = $fuel = '';
    $formData = json_decode($form->data);
    $html .= '
        <div>
            <h4 class="text-center"><span style="background: black; color:white;">&nbsp; VEHICLE FUEL REQUEST &nbsp;</span></h4>
            '.memoHeader($memo).'
            <table class="table table-bordered table-sm" style="width:100%">
                <tr><th class="px-3 py-1">Filling Station</th><td class="px-3 py-1"><a href="'.route('vehicles.show',$vehicle->id).'">'.$vehicle->name.' ('. $vehicle->number .')</a></td></tr>
                <tr><th class="px-3 py-1">Filling Station</th><td class="px-3 py-1"><a href="'.route('vehicles.show',$vehicle->id).'">'.$vehicle->name.' ('. $vehicle->number .')</a></td></tr>
                <tr><th class="px-3 py-1">Route</th><td class="px-3 py-1">'.$dispatch->number.' </td></tr>
                <tr><th class="px-3 py-1">Litre</th><td class="px-3 py-1">'.$form->created_at.' </td></tr>
                <tr><th class="px-3 py-1">Rate</th><td class="px-3 py-1">'.$vehicle->code.' </td></tr>
                <tr><th class="px-3 py-1">Amount</th><td class="px-3 py-1">'.$driver->fullName().' </td></tr>
                <tr><th class="px-3 py-1">Amount in Word</th><td class="px-3 py-1">'.numberTowords($formData->amount).' </td></tr>
            </table>
            '.memoApproval($memo, $vehicle).'
        </div>
    ';
    return $html;
}


function modalAnimation(){
    return 'bounceInDown';
}

function modalPadding(){
    return 'pr-3 pl-3';
}

function modalClasses(){
    return 'modal-lg /*modal-dialog-centered*/ mt-0 mb-0';
}



function thousandsCurrencyFormat($num) {

    if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;
}


function driverPercentage(){
    return  VehicleConfiguration::where(['name'=>'driver-percentage','status'=>'active'])->first();
}

function greetings(){
    /* This sets the $time variable to the current hour in the 24 hour clock format */
    $time = date("H");
    /* Set the $timezone variable to become the current timezone */
    $timezone = date("e");
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        return "Good morning";
    } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            return "Good afternoon";
        } else
            /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
            if ($time >= "17" && $time < "19") {
                return "Good evening";
            } else
                /* Finally, show good night if the time is greater than or equal to 1900 hours */
                if ($time >= "19") {
                    return "Good night";
                }
}


function numberTowords(float $number) {
    $hyphen = '-';
    $conjunction = '  ';
    $separator = ' ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Fourty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
        1000 => 'Thousand',
        1000000 => 'Million',
        1000000000 => 'Billion',
        1000000000000 => 'Trillion',
        1000000000000000 => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . numberTowords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . numberTowords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = numberTowords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= numberTowords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string)$fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function memoHeader(Memo $memo){
    return '<table style="width:100%">
                <tr>
                    <td class="text-right" style="width: 100px;"><strong>From:</strong></td>
                    <td class="text-left">'.$memo->raisedBy->fullName().'</td>
                    <td class="text-right"><strong>To:</strong></td>
                    <td class="text-left">'.$memo->raisedFor->fullName().'</td>
                </tr>
                <tr>
                    <td class="text-right"><strong>Memo No.:</strong></td>
                    <td class="text-left">'.$memo->reference.'</td>
                    <td class="text-right"><strong>Date:</strong></td>
                    <td class="text-left">'.$memo->date_raised.'</td>
                </tr>
            </table>';
}

function memoApproval(Memo $memo, Vehicle $vehicle){
    $approvedBy = $authorizedBy = $verifiedBy = '';
    if($memo->isApproved()){
        $approvedBy = $memo->approval->approvedBy->fullName();
        $approval = '<a href="#" class="btn btn-success btn-sm disabled"><i class="fa fa-check-square-o"></i> Approved</a>';
    }else{
        $approval= '<a href="'.route('memos.approvals', ['approve'=>$memo->id, 'vehicle'=>$vehicle->id]).'" class="btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Approve</a>';
    }
    if($memo->isAuthorized()){
        $authorizedBy = $memo->approval->authorizedBy->fullName();
        $authorization = '<a href="#" class="btn btn-success btn-sm disabled"><i class="fa fa-check-square-o"></i> Authorized</a>';
    }else{
        $authorization= '<a href="'.route('memos.approvals', ['authorize'=>$memo->id, 'vehicle'=>$vehicle->id]).'" class="btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Authorize</a>';
    }
    if($memo->isVerified()){
        $verifiedBy = $memo->approval->verifiedBy->fullName();
        $verification = '<a href="#" class="btn btn-success btn-sm disabled"><i class="fa fa-check-square-o"></i> Verified</a>';
    }else{
        $verification= '<a href="'.route('memos.approvals', ['verify'=>$memo->id, 'vehicle'=>$vehicle->id]).'" class="btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Verify</a>';
    }

    return '
    <table class="table table-bordered">
        <tr><th width="150">Authorized By : </th><td class="px-3">'.$authorizedBy.'</td></tr>
        <tr><th>Verified By : </th><td class="px-3">'.$verifiedBy.'</td></tr>
        <tr><th>Approved By : </th><td class="px-3">'.$approvedBy.'</td></tr>
    </table>
    <div class="text-right">
        <div class="btn-group">
            '. $authorization . $verification . $approval .'
        </div>
    </div>
    ';
}
