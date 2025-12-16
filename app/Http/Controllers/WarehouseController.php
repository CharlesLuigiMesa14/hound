<?php

namespace App\Http\Controllers;

use App\Models\Warehouse; // Import the Warehouse model
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        // Fetch all warehouse entries with pagination
        $warehouses = Warehouse::paginate(10); // Adjust the number as needed

        // Return the view with warehouse data
        return view('admin.warehouse.index', compact('warehouses'));
    }

    // You can add more methods for creating, updating, and deleting warehouse entries
}