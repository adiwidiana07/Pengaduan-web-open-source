<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Support\AnonymousIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function store(Request $request, Aspiration $aspiration)
    {
        if ($aspiration->isAuthoredBy($request->user())) {
            return back()->with('error', 'Anda tidak dapat melaporkan aspirasi milik sendiri.');
        }

        if (Gate::denies('report', $aspiration)) {
            return back()->with('error', 'Anda sudah melaporkan aspirasi ini.');
        }

        $validated = $request->validateWithBag('report', [
            'alasan' => ['required', Rule::in(array_keys(config('pengaduan.report_reasons')))],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $aspiration->reports()->create([
            'reporter_hash' => AnonymousIdentity::reporterHash($request->user()),
            'alasan' => $validated['alasan'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return back()->with('success', 'Laporan terkirim. Terima kasih sudah membantu menjaga ruang diskusi.');
    }
}
