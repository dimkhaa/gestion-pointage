@extends("master2")

@section("content")


<div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header">
              
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-3 mb-4 div-border">
                  <div class="row align-items-center">
                    <div class="col-12 mb-xl-0">
                      <form autocomplete="off" action="{{ route('filterByDate.temps-presences') }}" method="get" role="search">
                        {{ csrf_field() }}
                        <div class="input-daterange datepicker row align-items-center">
                          <div class="col-xl-12">
                              <div class="form-group">
                                <div class="input-group input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                  </div>
                                  <input name="date_start"  class="form-control datepicker" value="<?php if (isset($date_start)) echo $date_start ?>" placeholder=" Du" type="text">
                                </div>
                              </div>
                          </div>
                          <div class="col-xl-12">
                              <div class="form-group">
                                  <div class="input-group ">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                      </div>
                                      <input name="date_end" class="form-control datepicker" value="<?php if (isset($date_end)) echo $date_end ?>" placeholder=" Au" type="text">
                                  </div>
                              </div>
                          </div>
                          <div class="col-xl-2">
                              <div class="form-group">
                                <button type="submit" class="btn btn-info">Filtrer</button>
                              </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-xl-9">
                  <form action="{{ route('searchByName.temps-presences') }}" method="get" role="search">
                  {{ csrf_field() }}  
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                            </div>
                            <input name="mc" class="form-control"value="<?php if (isset($mc)) echo $mc ?>" placeholder="Rechercher un salarié" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4">
                        <div class="form-group">
                          <button id="btnsearch" type="submit" class="btn btn-info">Rechercher</button>
                        </div>
                      </div>
                    </div> 
                  </form>
                  <div class="table-responsive">
                    <table id="table-temps-presence" class="table table-flush align-items-center  container">
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
                          <?php
                            $url= route('temps-presences.details',$user->id).
                            '?date_start='.$date_start .'&'.
                            'date_end='.$date_end ;
                           ?>

                          <tr class="table-tr" data-url="{{ $url }} ">
                            <th scope="row">
                              <div class="media align-items-center">
                                <a style='color:#000;' href="{{ route('temps-presences.details',$user->id) }}" class="avatar rounded-circle mr-3">
                                  {{ strtoupper($user->prenom[0]) }}{{ strtoupper($user->nom[0]) }}
                                </a>
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
                    <div class="card-footer py-4">
                      <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                          <li class="page-item">
                            {{ $users->links() }}
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
