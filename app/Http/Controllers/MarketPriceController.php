<?php

namespace App\Http\Controllers;

use App\Models\MarketPrice;
use App\Services\MarketPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarketPriceController extends Controller
{
    protected MarketPriceService $service;

    public function __construct(MarketPriceService $service)
    {
        $this->service = $service;
    }

    /**
     * Tampilkan halaman /market-price
     */
    public function index()
    {
        return view('pages.market_price', [
            'commodities' => MarketPrice::availableCommodities(),
            'regions'     => MarketPrice::availableRegions(),
        ]);
    }

    /**
     * GET /api/market-price?commodity=padi&region=cilacap
     * Return JSON data untuk frontend
     */
    public function getData(Request $request): JsonResponse
    {
        $commodity = $request->input('commodity', 'padi');
        $region    = $request->input('region', 'cilacap');

        // Validasi input
        $validCommodities = array_keys(MarketPrice::availableCommodities());
        $validRegions     = array_keys(MarketPrice::availableRegions());

        if (!in_array($commodity, $validCommodities)) {
            $commodity = 'padi';
        }
        if (!in_array($region, $validRegions)) {
            $region = 'cilacap';
        }

        try {
            $data = $this->service->getMarketData($commodity, $region);

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data harga: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }
}
