<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(User $user)
    {
        $inventories = Inventory::where('user_id', $user->id)->latest()->paginate(20);
       
        return view('superadmin.inventory.index',compact('inventories'));
    }
   
}
