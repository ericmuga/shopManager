<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
  public function index()
        {
            $salesToday =10; // Logic to get sales today data
            $topTenItems =10; // Logic to get top 10 items data
            $topTenCustomers =10; // Logic to get top 10 customers data
            $setups ='Here'; // Logic to get setups data

            return inertia('Sales/SalesSummary', compact('salesToday', 'topTenItems', 'topTenCustomers', 'setups'));
        }
}
