<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Repository\DemandeRepository;
use App\Demande;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DemandesController extends Controller
{
    private $demandeRepository;

    public function __construct(DemandeRepository $demandeRepository)
    {
        $this->middleware('auth');
        $this->demandeRepository = $demandeRepository;
    }
    
    //fonction afficher la liste des demandes
    public function listDemandes(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->getAllDemande(),
            'userLogin'=>Auth::user()
        ]);
    }

    //fonction pour envoyer une nouvelle demande 
    public function sendDemande( Request $request, $user_id){

        $demandes = new Demande ();
        $user = new User();

        $demandes->nom = $request->nom;
        $demandes->prenom = $request->prenom;
        $demandes->dateDebut = date('Y-m-d',strtotime($request->dateDebut));
        $demandes->dateFin = date('Y-m-d',strtotime($request->dateFin));
        $demandes->typeDemande = $request->typeDemande;
        $demandes->motif = $request->motif;

        $users = DB::table('users')->select('name as user_name', 'prenom as user_prenom');

        $this->demandeRepository->createDemande($demandes, $request->user()->user_id);

        return redirect('/demandes')->with('succes', 'données enregistées');
    }

    //Afficher une demande
    public function afficherDemande( $id){
        $demande = Demande::find($id);
        return  view('pages/voirDemande', [
            'demande'=> $demande,
            'userLogin'=>Auth::user()
            ]);
    }

    //fonction pour traitement de la  demande:approuver
    public function approuverDemande($id){
        return  view('pages/voirDemande', [
            'demande' => $this->demandeRepository->approuverUneDemande($id),
            'userLogin'=>Auth::user()
        ]);
    }

    //fonction pour traitement de la demande: refuser
    public function refuserDemande($id){
        return  view('pages/voirDemande', [
        'demande' => $this->demandeRepository->refuserUneDemande($id),
        'userLogin'=>Auth::user(),
        ]);
    }

    //Liste des demande approuvé
    public function listDemandeApprouve(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeApprouve(),
            'userLogin'=>Auth::user()
        ]);
    }

    //Liste des demande Refusé
    public function listDemandeRefuser(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeRefuser(),
            'userLogin'=>Auth::user()
        ]);
    }

    //Liste des demande en attende
    public function listDemandeEnAttente(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeEnAttente(),
            'userLogin'=>Auth::user()
        ]);
    }
}
