<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceCalculator;
use Illuminate\Support\Facades\Cache;

class PriceCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $priceCalculators = Cache::remember('price_calculator_' . auth()->id(), 60, function () {
            return  PriceCalculator::query()->get();
        });

        return $this->sendSuccess([
            'price_calculator' => $priceCalculators
        ], "price calculator fetched successfully");
    }
}
