<?php

namespace App\Http\Controllers;

use App\Models\SavedCreator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Lihat saved creators
    public function savedCreators()
    {
        $user = Auth::user();
        
        if (!$user->isCompany()) {
            return redirect()->route('home')->with('error', 'Hanya perusahaan yang dapat mengakses fitur ini');
        }

        $saved = SavedCreator::where('company_id', $user->id)
            ->with('creator')
            ->paginate(12);

        return view('company.saved-creators', compact('saved'));
    }

    // Save creator
    public function saveCreator(User $creator)
    {
        $user = Auth::user();

        if (!$user->isCompany()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($creator->isCompany()) {
            return response()->json(['error' => 'Tidak dapat menyimpan perusahaan lain'], 400);
        }

        $exists = SavedCreator::where('company_id', $user->id)
            ->where('creator_id', $creator->id)
            ->exists();

        if ($exists) {
            SavedCreator::where('company_id', $user->id)
                ->where('creator_id', $creator->id)
                ->delete();
            
            return response()->json(['saved' => false, 'message' => 'Creator dihapus dari daftar']);
        } else {
            SavedCreator::create([
                'company_id' => $user->id,
                'creator_id' => $creator->id,
            ]);
            
            return response()->json(['saved' => true, 'message' => 'Creator disimpan']);
        }
    }

    // Contact creator (simple message)
    public function contactCreator(Request $request, User $creator)
    {
        $user = Auth::user();

        if (!$user->isCompany()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // TODO: Implement proper notification system
        // For now, just create a record
        \Mail::raw(
            "Perusahaan {$user->company_name} ingin menghubungi Anda.\n\nPesan: {$validated['message']}\n\nBalas ke: {$user->email}",
            function ($mail) use ($creator, $user) {
                $mail->to($creator->email)
                    ->subject("Perusahaan {$user->company_name} ingin menghubungi Anda");
            }
        );

        return response()->json(['success' => true, 'message' => 'Pesan terkirim ke creator']);
    }
}
