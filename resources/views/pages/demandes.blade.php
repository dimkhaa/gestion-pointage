
@extends("master2")

@section("content")
<div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Listes des Demandes</h3>
                </div>
                <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Statut
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ action ('DemandesController@listDemandes')  }}">Tous</a>
                          <a class="dropdown-item" href="{{ action ('DemandesController@listDemandeRefuser')  }}">Refusé</a>
                          <a class="dropdown-item" href="{{ action ('DemandesController@listDemandeEnAttente')  }}">En attente</a>
                          <a class="dropdown-item" href="{{ action ('DemandesController@listDemandeApprouve')  }} ">Approuvé</a>

                        </div>
                </div>
                <div class="col-right">
                      <button type="button" class="btn btn-primary right" data-toggle="modal" data-target="#createDemandeModal" data-whatever="@getbootstrap">Créer une demande</button>
                    <div class="modal fade" id="createDemandeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header container">
                            <h1 class="modal-title" id="exampleModalLabel">Formulaire demande</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- formulaire demandes -->

                        <form action ="{{ action('DemandesController@sendDemande') }} " method= "POST">
                                {{ csrf_field() }}
                          <div class="modal-body">
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label for="prenom" class="col-form-label">Prénom</label>
                                  <input type="text" class="form-control" name="prenom" placeholder="Votre prenom">
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label for="prenom_nom" class="col-form-label"> Nom</label>
                                  <input type="text" class="form-control" name="nom" placeholder="Votre Nom">
                                </div>
                              </div>
                            </div>

                            <div class="input-daterange datepicker row align-items-center">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="dateDebut" class="col-form-label">Date Début</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input class="form-control" name="dateDebut" placeholder="Date départ" type="text" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="dateFin" class="col-form-label">Date Fin</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input class="form-control" name = "dateFin" placeholder="Date de retour" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                    <label for="typeDemande">Type de demandes</label>
                                    <select class="form-control" name="typeDemande">
                                     <option>Choisir le type de demande</option>
                                      <option value="Congés">Congés</option>
                                      <option value="absence">Absence</option>
                                    </select>
                             </div>

                            <div class="form-group">
                                <label for="motif" class="col-form-label" >Motif</label>
                                <textarea class="form-control" name="motif" placeholder="Qu'est ce qui motive votre demande" ></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermé</button>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                    </div>
                    </div>

                    </div>

                    <!-- fin formulaire demandes -->
                </div>
              </div>
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Salarié</th>
                          <th scope="col">Date de Départ</th>
                          <th scope="col">Date de Retour</th>
                          <th scope="col">Statut</th>
                          <th scope="col">Type</th>
                          <th scope="col">Détails</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($demandes as $demande )
                          <?php
                            $url= "/demandes/voir/".$demande->id;
                          ?>
                          <tr class="table-tr" data-url="{{ $url }} ">
                            <th scope="row">
                                <div class="media align-items-center">
                                  <a style='color:#000;' class="avatar rounded-circle mr-3">
                                    {{ strtoupper($demande->user->prenom[0]) }}{{ strtoupper($demande->user->nom[0]) }}
                                  </a>
                                  <div class="media-body">
                                    <span class="mb-0 text-sm">{{ $demande->user->prenom }} {{ $demande->user->nom }}</span>
                                  </div>
                                </div>
                              </th>

                              <td>{{ $demande->dateDebut }}</td>
                              <td>{{ $demande->dateFin }}</td>
                              <td>{{ $demande->status }}</td>
                              <td>{{ $demande->typeDemande }}</td>

                              <td><a href="{{ route('afficherDemande', ['id' => $demande->id]) }}">Voir</a></td>
                          </tr>
                          @endforeach
                         
                      </tbody>
                    </table>
                    <div class="card-footer py-4">
                          <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                              <li class="page-item">
                                  @if($demandes)
                                  {{ $demandes->links() }}
                                  @endif
                              </li>
                            </ul>
                          </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>    
    </div>
@endsection
