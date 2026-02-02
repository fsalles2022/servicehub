<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $service) {}

    public function index()
    {
        $companies = $this->service->list();

        return response()->json([
            'data' => $companies
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string'
        ]);

        $company = $this->service->create($data);

        return response()->json([
            'data' => $company
        ], 201); // 201 Created
    }

    public function show($id)
    {
        $company = $this->service->show($id);

        return response()->json([
            'data' => $company
        ]);
    }
}
