<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::latest()->paginate(20);

        return view('backend.license.index', compact('licenses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:191',
            'notes'       => 'nullable|string',
            'is_lifetime' => 'nullable|boolean',
            'expires_at'  => 'nullable|date',
            'max_devices' => 'nullable|integer|min:1|max:999',
        ]);

        $data['is_lifetime'] = (bool) ($data['is_lifetime'] ?? false);

        if ($data['is_lifetime']) {
            $data['expires_at'] = null;
        }

        $data['serial'] = $this->generateUniqueSerial();

        if (!Schema::hasColumn('licenses', 'max_devices')) {
            unset($data['max_devices']);
        }

        $license = License::create($data);

        return response()->json([
            'ok'      => true,
            'license' => method_exists($license, 'toApiArray')
                ? $license->toApiArray()
                : $license->toArray(),
        ], 201);
    }

    public function show(License $license)
    {
        return view('licenses.show', compact('license'));
    }

    public function update(Request $request, License $license)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:191',
            'notes'       => 'nullable|string',
            'is_lifetime' => 'nullable|boolean',
            'expires_at'  => 'nullable|date',
            'max_devices' => 'nullable|integer|min:1|max:999',
        ]);

        $data['is_lifetime'] = (bool) ($data['is_lifetime'] ?? false);

        if ($data['is_lifetime']) {
            $data['expires_at'] = null;
        }

        if (!Schema::hasColumn('licenses', 'max_devices')) {
            unset($data['max_devices']);
        }

        $license->update($data);

        return response()->json([
            'ok'      => true,
            'license' => method_exists($license, 'toApiArray')
                ? $license->fresh()->toApiArray()
                : $license->fresh()->toArray(),
        ]);
    }

    public function destroy(License $license)
    {
        $license->delete();

        return response()->json([
            'ok'         => true,
            'deleted_id' => $license->id,
        ]);
    }

    /**
     * Public API:
     * GET /license/{identifier}
     */
    public function apiGet(Request $request, $identifier)
    {
        $license = $this->findLicenseByIdentifier($identifier);

        if (!$license) {
            return response()->json([
                'ok'      => false,
                'valid'   => false,
                'status'  => 'not_found',
                'message' => 'License not found.',
            ], 404);
        }

        $status = $this->licenseStatus($license);
        $valid  = $status === 'active';

        return response()->json([
            'ok'      => $valid,
            'valid'   => $valid,
            'status'  => $status,
            'message' => $this->licenseStatusMessage($status),
            'data'    => [
                'id'          => $license->id,
                'serial'      => $license->serial,
                'name'        => $license->name,
                'is_lifetime' => (bool) $license->is_lifetime,
                'expires_at'  => $license->expires_at ? $license->expires_at->toDateTimeString() : null,
                'max_devices' => $this->licenseMaxDevices($license),
                'valid'       => $valid,
            ],
        ], $valid ? 200 : 403);
    }

    /**
     * Public API:
     * GET /license/{identifier}/devices/allowed
     */
    public function allowedDevices($identifier)
    {
        $license = $this->findLicenseByIdentifier($identifier);

        if (!$license) {
            return response()->json([
                'ok'      => false,
                'valid'   => false,
                'status'  => 'not_found',
                'message' => 'License not found.',
                'devices' => [],
            ], 404);
        }

        $status = $this->licenseStatus($license);

        if ($status !== 'active') {
            return response()->json([
                'ok'      => false,
                'valid'   => false,
                'status'  => $status,
                'message' => $this->licenseStatusMessage($status),
                'devices' => [],
            ], 403);
        }

        $devices = LicenseDevice::where('license_id', $license->id)
            ->where('status', 'approved')
            ->orderByDesc('approved_at')
            ->get()
            ->map(function (LicenseDevice $device) {
                return [
                    'device_fingerprint' => $device->device_fingerprint,
                    'processor_id'       => $device->processor_id,
                    'device_name'        => $device->device_name,
                    'machine_user'       => $device->machine_user,
                    'os'                 => $device->os,
                    'app_version'        => $device->app_version,
                    'status'             => $device->status,
                    'approved_at'        => $device->approved_at ? $device->approved_at->toDateTimeString() : null,
                    'last_seen_at'       => $device->last_seen_at ? $device->last_seen_at->toDateTimeString() : null,
                ];
            })
            ->values();

        return response()->json([
            'ok'         => true,
            'valid'      => true,
            'status'     => 'active',
            'identifier' => $license->serial,
            'devices'    => $devices,
        ]);
    }

    /**
     * Public API:
     * POST /license/{identifier}/devices/request
     */
    public function requestDevice(Request $request, $identifier)
    {
        $license = $this->findLicenseByIdentifier($identifier);

        if (!$license) {
            return response()->json([
                'ok'      => false,
                'success' => false,
                'status'  => 'not_found',
                'message' => 'License not found.',
            ], 404);
        }

        $status = $this->licenseStatus($license);

        if ($status !== 'active') {
            return response()->json([
                'ok'      => false,
                'success' => false,
                'status'  => $status,
                'message' => $this->licenseStatusMessage($status),
                'license' => $this->licenseResponse($license),
            ], 403);
        }

        $data = $request->validate([
            'device_fingerprint' => 'required|string|max:255',
            'processor_id'       => 'nullable|string|max:255',
            'device_name'        => 'nullable|string|max:255',
            'machine_user'       => 'nullable|string|max:255',
            'os'                 => 'nullable|string|max:255',
            'app_version'        => 'nullable|string|max:100',
        ]);

        $device = LicenseDevice::where('license_id', $license->id)
            ->where('device_fingerprint', $data['device_fingerprint'])
            ->first();

        if ($device && $device->status === 'blocked') {
            $device->update([
                'last_seen_at' => now(),
                'ip_address'   => $request->ip(),
            ]);

            return response()->json([
                'ok'      => false,
                'success' => false,
                'status'  => 'blocked',
                'message' => 'This device is blocked.',
                'license' => $this->licenseResponse($license),
            ], 403);
        }

        if ($device && $device->status === 'approved') {
            $device->update([
                'processor_id' => $data['processor_id'] ?? $device->processor_id,
                'device_name'  => $data['device_name'] ?? $device->device_name,
                'machine_user' => $data['machine_user'] ?? $device->machine_user,
                'os'           => $data['os'] ?? $device->os,
                'app_version'  => $data['app_version'] ?? $device->app_version,
                'ip_address'   => $request->ip(),
                'last_seen_at' => now(),
            ]);

            return response()->json([
                'ok'      => true,
                'success' => true,
                'status'  => 'approved',
                'message' => 'This device is already approved.',
                'license' => $this->licenseResponse($license),
                'device'  => $this->deviceResponse($device->fresh()),
            ]);
        }

        $maxDevices = $this->licenseMaxDevices($license);

        if ($maxDevices > 0) {
            $approvedCount = LicenseDevice::where('license_id', $license->id)
                ->where('status', 'approved')
                ->count();

            if ($approvedCount >= $maxDevices) {
                return response()->json([
                    'ok'      => false,
                    'success' => false,
                    'status'  => 'limit_reached',
                    'message' => 'Maximum allowed devices reached for this license.',
                    'license' => $this->licenseResponse($license),
                ], 403);
            }
        }

        if (!$device) {
            $device = new LicenseDevice();
            $device->license_id = $license->id;
            $device->device_fingerprint = $data['device_fingerprint'];
            $device->requested_at = now();
            $device->status = 'pending';
        }

        $device->processor_id = $data['processor_id'] ?? null;
        $device->device_name  = $data['device_name'] ?? null;
        $device->machine_user = $data['machine_user'] ?? null;
        $device->os           = $data['os'] ?? null;
        $device->app_version  = $data['app_version'] ?? null;
        $device->ip_address   = $request->ip();
        $device->last_seen_at = now();

        if (in_array($device->status, ['rejected', null], true)) {
            $device->status = 'pending';
            $device->requested_at = now();
            $device->rejected_at = null;
        }

        $device->save();

        return response()->json([
            'ok'      => true,
            'success' => true,
            'status'  => $device->status,
            'message' => 'Device activation request submitted. Please wait for approval.',
            'license' => $this->licenseResponse($license),
            'device'  => $this->deviceResponse($device),
        ]);
    }

    /**
     * Dashboard page:
     * GET /dashboard/licenses/{license}/devices
     */
    public function devices(License $license)
    {
        $devices = LicenseDevice::where('license_id', $license->id)
            ->latest()
            ->paginate(20);

        $approvedCount = LicenseDevice::where('license_id', $license->id)
            ->where('status', 'approved')
            ->count();

        return view('backend.license.devices', compact('license', 'devices', 'approvedCount'));
    }

    public function approveDevice(LicenseDevice $device)
    {
        $license = $device->license;

        $maxDevices = $this->licenseMaxDevices($license);

        if ($maxDevices > 0) {
            $approvedCount = LicenseDevice::where('license_id', $license->id)
                ->where('status', 'approved')
                ->where('id', '!=', $device->id)
                ->count();

            if ($approvedCount >= $maxDevices) {
                return back()->with('error', 'Maximum allowed devices reached for this license.');
            }
        }

        $device->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'rejected_at' => null,
            'blocked_at'  => null,
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Device approved successfully.');
    }

    public function rejectDevice(LicenseDevice $device)
    {
        $device->update([
            'status'      => 'rejected',
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Device rejected successfully.');
    }

    public function blockDevice(LicenseDevice $device)
    {
        $device->update([
            'status'     => 'blocked',
            'blocked_at' => now(),
        ]);

        return back()->with('success', 'Device blocked successfully.');
    }

    private function generateUniqueSerial(): string
    {
        do {
            $serial = strtoupper(Str::random(24));
        } while (License::where('serial', $serial)->exists());

        return $serial;
    }

    private function findLicenseByIdentifier($identifier): ?License
    {
        return is_numeric($identifier)
            ? License::find($identifier)
            : License::where('serial', $identifier)->first();
    }

    private function licenseStatus(License $license): string
    {
        if (Schema::hasColumn('licenses', 'is_active') && !$license->is_active) {
            return 'inactive';
        }

        if (method_exists($license, 'isValid') && !$license->isValid()) {
            return 'expired';
        }

        if (!$license->is_lifetime && $license->expires_at && now()->greaterThan($license->expires_at)) {
            return 'expired';
        }

        return 'active';
    }

    private function licenseStatusMessage(string $status): string
    {
        return match ($status) {
            'active'    => 'License is valid.',
            'inactive'  => 'License is inactive.',
            'expired'   => 'License has expired.',
            'not_found' => 'License not found.',
            default     => 'License verification failed.',
        };
    }

    private function licenseMaxDevices(License $license): int
    {
        if (!Schema::hasColumn('licenses', 'max_devices')) {
            return 1;
        }

        return max(1, (int) ($license->max_devices ?? 1));
    }

    private function licenseResponse(License $license): array
    {
        $status = $this->licenseStatus($license);

        return [
            'id'          => $license->id,
            'serial'      => $license->serial,
            'name'        => $license->name,
            'is_lifetime' => (bool) $license->is_lifetime,
            'expires_at'  => $license->expires_at ? $license->expires_at->toDateTimeString() : null,
            'max_devices' => $this->licenseMaxDevices($license),
            'valid'       => $status === 'active',
            'status'      => $status,
        ];
    }

    private function deviceResponse(LicenseDevice $device): array
    {
        return [
            'id'                 => $device->id,
            'device_fingerprint' => $device->device_fingerprint,
            'processor_id'       => $device->processor_id,
            'device_name'        => $device->device_name,
            'machine_user'       => $device->machine_user,
            'os'                 => $device->os,
            'app_version'        => $device->app_version,
            'ip_address'         => $device->ip_address,
            'status'             => $device->status,
            'requested_at'       => $device->requested_at ? $device->requested_at->toDateTimeString() : null,
            'approved_at'        => $device->approved_at ? $device->approved_at->toDateTimeString() : null,
            'last_seen_at'       => $device->last_seen_at ? $device->last_seen_at->toDateTimeString() : null,
        ];
    }
}