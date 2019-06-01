
  <link href="/css/style.css" rel="stylesheet">
  <link href="/js/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="/js/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link type="text/css" href="/css/argon.css?v=1.0.0" rel="stylesheet">
  
    <table class="table table-flush align-items-center  container">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Salarié</th>
                          <th scope="col">SERVICE</th>
                          <th scope="col" data-toggle="tooltip" 
                           data-placement="top" title="Heures pointées"> HPO</th>
                          <th scope="col" data-toggle="tooltip" 
                           data-placement="top" title="Heures supplémentaires">HSUP</th>
                          <th scope="col">TOTAL</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                          <tr class="table-tr">
                            <th scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="mb-0 text-sm">{{ $user->prenom }} {{ $user->nom }}</span>
                                </div>
                              </div>
                            </th>
                            <td>
                              {{ $user->service->libelleService }}
                            </td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                <i class="bg-warning"></i>
                                <?php $heurTot = 0; $heurePo=0; $suppl = 0; ?>
                                @foreach( $user->pointages as $pointage)
                                  @if($pointage->type==="arrivee")
                                    @foreach( $user->pointages as $point)
                                                                
                                      @if($point->type==="depart"
                                        && date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date))
                                        && isset($date_start) && date("Y-m-d", strtotime($pointage->date))>=date("Y-m-d", strtotime($date_start))
                                        && date("Y-m-d", strtotime($pointage->date))<=date("Y-m-d", strtotime($date_end)))
                                        <?php 
                                          $dateTime = new DateTime($point->date);
                                          $heurTot+= abs(strtotime($point->date) - strtotime($pointage->date))
                                        ?>
                                        @if(strtotime($dateTime->format("H:i:s")) > strtotime($user->horaire->heureFin))
                                          <?php 
                                            $suppl+= abs(strtotime($dateTime->format("H:i:s")) - strtotime($user->horaire->heureFin));
                                          ?>
                                        @endif
                                      @endif

                                      @if($point->type==="depart"
                                        && date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date))
                                        && !isset($date_start))
                                        <?php 
                                          $dateTime = new DateTime($point->date);
                                          $heurTot+= abs(strtotime($point->date) - strtotime($pointage->date))
                                        ?>
                                        @if(strtotime($dateTime->format("H:i:s")) > strtotime($user->horaire->heureFin))
                                          <?php 
                                            $suppl+= abs(strtotime($dateTime->format("H:i:s")) - strtotime($user->horaire->heureFin));
                                          ?>
                                        @endif
                                      @endif
                                    @endforeach
                                  @endif
                                @endforeach
                                <?php
                                  $heurePo=$heurTot - $suppl;
                                ?>
                                {{ round($heurePo/3600) }} 
                              </span>
                            </td>
                            <td>
                              <span class="badge badge-dot mr-4">
                                {{ round($suppl/3600) }}
                              </span>
                            </td>
                            <td>
                              <span>
                                {{ round($heurTot/3600) }}
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>