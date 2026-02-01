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
        return $this->service->list();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string'
        ]);

        return $this->service->create($data);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }
}
