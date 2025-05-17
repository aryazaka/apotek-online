<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        switch (Auth::user()->jabatan) {
            case 'admin':
                return view('be.dashboard.admin',[
                        'title' => 'Dashboard',
                    ]
                );
            case 'karyawan':
                return view('be.dashboard.karyawan',[
                    'title' => 'Dashboard',
                ]
            );
            case 'apoteker':
                return view('be.dashboard.apoteker',[
                    'title' => 'Dashboard',
                ]
            );
            case 'kasir':
                return view('be.dashboard.kasir',[
                    'title' => 'Dashboard',
                ]
            );
            case 'kurir':
                return view('be.dashboard.kurir',[
                    'title' => 'Dashboard',
                ]
            );
            case 'pemilik':
                return view('be.dashboard.pemilik',[
                    'title' => 'Dashboard',
                ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
