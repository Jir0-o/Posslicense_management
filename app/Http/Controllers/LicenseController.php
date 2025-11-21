<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LicenseController extends Controller
{
    // Apply auth middleware for web CRUD routes in web.php routes file
    public function index()
    {
        $licenses = License::latest()->paginate(20);
        return view('backend.license.index', compact('licenses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'notes' => 'nullable|string',
            'is_lifetime' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $data['is_lifetime'] = (bool) ($data['is_lifetime'] ?? false);
        if ($data['is_lifetime']) {
            $data['expires_at'] = null;
        }

        $data['serial'] = strtoupper(Str::random(24)); // simple serial generation

        $license = License::create($data);

        return response()->json(['ok' => true, 'license' => $license->toApiArray()], 201);
    }

    public function show(License $license)
    {
        return view('licenses.show', compact('license'));
    }

    public function update(Request $request, License $license)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'notes' => 'nullable|string',
            'is_lifetime' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $data['is_lifetime'] = (bool) ($data['is_lifetime'] ?? false);
        if ($data['is_lifetime']) {
            $data['expires_at'] = null;
        }

        $license->update($data);

        return response()->json(['ok' => true, 'license' => $license->toApiArray()]);
    }

    public function destroy(License $license)
    {
        $license->delete();
        return response()->json(['ok' => true, 'deleted_id' => $license->id]);
    }

    // Public API: return license info by id or serial without auth
    // Place this method in a controller exposed from routes/api.php
    public function apiGet(Request $request, $identifier)
    {
        $license = is_numeric($identifier)
            ? License::find($identifier)
            : License::where('serial', $identifier)->first();

        if (! $license) {
            return response()->json(['ok' => false, 'message' => 'License not found'], 404);
        }

        // Minimal response per your request
        return response()->json([
            'ok' => true,
            'data' => [
                'is_lifetime' => (bool) $license->is_lifetime,
                'expires_at'  => $license->expires_at ? $license->expires_at->toDateTimeString() : null,
                'valid'       => $license->isValid(),
            ],
        ]);
    }
}
