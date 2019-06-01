

@extends("master2")

@section("content")
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header"> 
            @if ($demande)

              <div class="row align-items-center">
                <div class="col-8">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('demandes')}}">
                          <i class="ni ni-bold-left text-blue"></i>Retour
                        </a>
                    </li>
                  </ul>
                </div>
                <div class="col-4 text-right">
                  <h3 class="mb-0">Demande de congé</h3>
                  <span class="font-weight-light"> {{ $demande->created_at }}</span>
                </div>
              </div>
              
                 </div>
                    <div class="card-body">
                        <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">Période</h3>                    
                            Du  <span class="font-weight-light"> {{ $demande->dateDebut }} </span> <br>  
                            Au <span class="font-weight-light"> {{ $demande->dateFin }} </span>
                            <hr>
                        </div>

                        <div class="col-sm-6">
                            <label for="nomPrenom">Nom:
                                 {{ $demande->user->nom }}
                            </label>
                                    <br>
                                    <label for="nomPrenom"> Prénom:
                                            {{ $demande->user->prenom}}
                                    </label>
                                    <br>

                            <span>Enteprise & Fonction</span>
                            <br>

                        </div>
                        <div class="col-sm-6">
                                <h3>Etat de la demande</h3>
                                <span>@if ($demande->status == 0)
                                        {{ $demande->user->id }}, en attende</span>

                                        @elseif ($demande->status == 1)
                                        {{ $demande->user->id }}, Demande Approuvé</span>

                                        @else ($demande->status == -1)
                                        {{ $demande->user->id }}, Demande Refusé</span>

                                @endif

                        </div>

                        <div class="col-sm-6">
                            <h3>Motif</h3>
                            <p>{{ $demande->motif }}</p>
                        </div>


                    </div>
                    <div class= "col-sm-12">
                            <a href="{{ route('refuserDemande', ['id' => $demande->id]) }}" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">Refusé la demande </a>
                            <a href="{{ route('approuverDemande', ['id' => $demande->id]) }}" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Approuvée la demane </a>

                    </div>


                  </div>

                  {{-- <div class="row">
                     <div class="col-sm-12 ">
                        <form>
                            <textarea class="form-control" id="commentaire" rows="3" placeholder="Commentaire ..."></textarea>

                        </form>
                    </div>
                    <div class="form-group col-sm-12">
                            <label for="motif" class="col-form-label" >Motif:</label>
                            <textarea class="form-control" name="motif" placeholder="Commentaires ..." ></textarea>
                        </div>
                </div>
                        <div class="row">
                                <div class="col-sm-6 ">
                                        <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Commenter</a>
                                        <a href="/demandes" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">Retour </a>
                                </div>
                        </div> --}}
                    </div>
                   @endif
              </div>
            </div>
        </div>
    </div>

@endsection
