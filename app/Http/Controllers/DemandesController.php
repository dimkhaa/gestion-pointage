<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Repository\DemandeRepository;
use App\Demande;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;


class DemandesController extends Controller
{
    private $demandeRepository;

    public function __construct(DemandeRepository $demandeRepository)
    {
        $this->demandeRepository = $demandeRepository;
    }

    public function listDemandes(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->getAllDemande()
        ]);
    }

    // public function store(Request $request){
    //     $demandes=$this->demandeRepository->saveDemande($request->all());

    //     return redirect('/demandes')->with('succes', 'donnes enregister');
    // }

     public function sendDemande( Request $request, $user_id){

        // validate($request, [
        //     'dateDebut' => 'required',
        //     'dateFin' => 'required',
        //     'typeDemande' => 'required',
        //     'motif' => 'required',

        // ]);

            $demandes = new Demande ();
            $user = new User();
            // if ($user_id) {
            //     $demandes->user_id = $user_id;
            // }
        $demandes->nom = $request->nom;
        $demandes->prenom = $request->prenom;
        $demandes->dateDebut = date('Y-m-d',strtotime($request->dateDebut));
        $demandes->dateFin = date('Y-m-d',strtotime($request->dateFin));
       // $demandes->dateDebut = $inputs['status'];
        $demandes->typeDemande = $request->typeDemande;
        $demandes->motif = $request->motif;

        $users = DB::table('users')->select('name as user_name', 'prenom as user_prenom');

        $this->demandeRepository->createDemande($demandes, $request->user()->user_id);

         return redirect('/demandes')->with('succes', 'donnes enregister');
    }


    //Afficher une demande

    public function afficherDemande( $id){
           $demande = Demande::find($id);
        return  view('pages/voirDemande')->with('demande', $demande);
    }
    // public function send(Request $request){
    //     $demandes = $this->demandeRepository->saveDemande($request->all());
    // }


    //fonction pour traitement de la  demande:approuvzr
    public function approuverDemande($id){

     return  view('pages/voirDemande', [
        'demande' => $this->demandeRepository->approuverUneDemande($id)

     ]);
 }

 //fonction pour traitement de la  demande: refuser
 public function refuserDemande($id){

    return  view('pages/voirDemande', [
       'demande' => $this->demandeRepository->refuserUneDemande($id)

    ]);
}



    //Liste des demande approuvé
    public function listDemandeApprouve(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeApprouve()
        ]);
    }
    //Liste des demande Refusé
    public function listDemandeRefuser(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeRefuser()
        ]);
    }
    //Liste des demande en attende
    public function listDemandeEnAttente(){
        return view ('pages/demandes', [
            'demandes' => $this->demandeRepository->demandeEnAttente()
        ]);
    }



}
