<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Mail\EnvoiCode;
use Illuminate\Validation\Rule;
use App\MonService\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Symfony\Component\Mailer\Exception\TransportException;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */

    // Verifier si la connexion internet est activée
    public function checkInternetConnexion(){
        try{
            $response = Http::timeout(5)->get('http://www.google.com');
            return $response -> successful();
        }catch (\Exception $e){
            return false;
        }
    }
    public function create(array $input): User
    {
        //recuperation de l'email
        $email = $input['email'];

        //on génere le token pour l'activation du compte des users
        $activation_token = md5(uniqid()) . $email . sha1($email);

        $activation_code = "";
        $length_code = 6;

        for ($i = 0; $i < $length_code; $i++) {

            $activation_code .= mt_rand(0, 9); //la fonction mt_rand, nous permet de générer un nombre aléatoire
        }

        //recuperation des données de users
        $name = $input['prenom'] . ' ' . $input['nom'];
        $password = $input['password'];

        // Envoyer une notification par e-mail à utilisateur
        try {
            Mail::to($email)->send(new EnvoiCode($activation_token, $activation_code, $name));
        } catch (TransportException $e) {
            // Annule la transaction en cas d'erreur de connexion
            DB::rollBack();

            // Log the error for debugging
            Log::error('Erreur de connexion lors de l\'envoi de l\'e-mail: ' . $e->getMessage());

            // Retourner une réponse d'erreur personnalisée
            return redirect()->back()->with('danger', 'Erreur de connexion. Veuillez vérifier votre connexion Internet et réessayer.');
        } //envoi de l'email;

        //creation des utilisateurs, ajout dans la base de donnée
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'activation_code' => $activation_code,
            'activation_token' => $activation_token,
        ]);
    }
}
