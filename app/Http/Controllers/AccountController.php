<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\AccountCancellationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mailer\Exception\TransportException;


class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // Demande de suppression (clic sur "supprimer mon compte")
    public function requestDelection(Request $request){
        $user = auth()->user();

        // Validation
        $request->validate([
            'password' => 'required|string',
            'reasons' => ['array','nullable'],
            'feedback' => ['nullable','string','max:1000'],
        ]);

        // Forcer au moins 2 raisons ou feedback rempli
        if((empty($request->reasons) || count($request->reasons) < 2) && empty(trim($request->feedback))){
            return response()->json(['errors' => ['feedback' => "Vous devez sélectionner au moins 2 raisons ou rédiger un commentaire."]], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $request->expectsJson()
                ? response()->json(['errors' => ['password' => 'Mot de passe incorrect']], 422)
                : back()->withErrors(['password' => 'Mot de passe incorrect']);
        }

        // Stocker feedback
        $user->deletion_reasons = $request->reasons;
        $user->deletion_feedback = $request->feedback;
        $user->is_deactivated = true;
        $user->scheduled_deletion_at = now()->addDays(30);
        $user->cancellation_token = Str::random(60);
        $user->deletion_feedback = [
            'reasons' => $request->reasons ?? [],
            'comment' => $request->feedback ?? ''
        ];
        $user->save();

        // Envoyer email
        try {
            Mail::to($user->email)->send(new AccountCancellationMail($user));
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['mail' => 'Impossible d’envoyer le mail']], 500);
            }
            return back()->withErrors(['mail' => 'Impossible d’envoyer le mail raison connection']);
        }

        auth()->logout();

        // Retour JSON pour Vue
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Votre compte est désactivé. Vous pouvez annuler la suppression via l'email envoyé"
            ]);
        }

        return redirect('/')->with('success', "Votre compte est désactivé. Vous pouvez annuler via l'email.");
    }

    //Annulation via email
    public function cancelDeletion($token){
        $user = User::where('cancellation_token',$token)->where('scheduled_deletion_at','>=',now())->first();
        //si ce n'est pas l'user
        if(!$user){
            return redirect('/')->with('danger','Le lien est invalide ou expiré.');
        }

        $user->is_deactivated = false;
        $user->scheduled_deletion_at = null;
        $user->cancellation_token = null;
        $user->save();

        return redirect('/login')->with('success','Votre compte a été réactivé avec succès.');
    }
}
