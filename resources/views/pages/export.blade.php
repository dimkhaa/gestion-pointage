<table >
                      <thead>
                        <tr>
                          <th >Salarié</th>
                          <th >SERVICE</th>
                          <th> HPO</th>
                          <th>HSUP</th>
                          <th >TOTAL</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)

                          <tr >
                            <th>
                              {{ $user->prenom }} {{ $user->nom }}
                            </th>
                            <td>
                              {{ $user->service->libelleService }}
                            </td>
                            <td>
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
                            </td>
                            <td>
                                {{ round($suppl/3600) }}
                            </td>
                            <td>
                                {{ round($heurTot/3600) }}
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>