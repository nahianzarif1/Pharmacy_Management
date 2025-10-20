<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'required|string',
        ]);

        $setting = Setting::create($validated);
        return response()->json($setting, 201);
    }

    public function show($key)
    {
        $setting = Setting::findOrFail($key);
        return response()->json($setting);
    }

    public function update(Request $request, $key)
    {
        $setting = Setting::findOrFail($key);
        $setting->update($request->all());
        return response()->json($setting);
    }

    public function destroy($key)
    {
        Setting::findOrFail($key)->delete();
        return response()->json(['message' => 'Setting deleted successfully']);
    }
}
