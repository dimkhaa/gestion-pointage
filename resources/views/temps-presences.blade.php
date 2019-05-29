@extends("master2")

@section("content")


<div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header">
              <div class="row">
              <div class="col-xl-10"></div>
              <div class="col-xl-2">
                <a style="font-size:0.9rem;color:#fff"
                   class="btnExport btn-block btn-primary mb-1"
                   data-toggle="modal" data-target="#modal-export">
                   Exporter période</a>

              </div>
              </div>
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
                                <label for="service">Service</label>
                                <select name="service" id="service" class="form-control">
                                  <option value="0">Tout</option>
                                    @foreach($services as $service)
                                      @if(isset($service_courant) && $service_courant==$service->id)
                                        <option value="{{ $service->id }}" selected>
                                          {{ $service->libelleService }}
                                        </option>
                                      @endif
                                      @if(!isset($service_courant))
                                      <option value="{{ $service->id }}">
                                        {{ $service->libelleService }}
                                      </option>
                                      @endif
                                    @endforeach
                                </select>
                              </div>
                          </div>
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
                                      <input name="date_end" class="form-control datepicker"
                                       value="<?php if (isset($date_end)) echo $date_end ?>" placeholder=" Au" type="text">
                                  </div>
                              </div>
                          </div>
                          <div class="col-xl-2">
                              <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary">Filtrer</button>
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
                    <input name="date_start"  class="form-control datepicker"
                         value="<?php if (isset($date_start)) echo $date_start ?>" placeholder=" Du" type="hidden">
                    <input name="date_end" class="form-control datepicker" 
                         value="<?php if (isset($date_end)) echo $date_end ?>" placeholder=" Au" type="hidden">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <div class="input-group mb-4">
                            <input name="mc" class="form-control" 
                             value="<?php if (isset($mc)) echo $mc ?>" placeholder="Rechercher un salarié" type="text">
                              <span class="input-group-prepend">
                                <button id="btnsearch" type="submit" data-toggle="tooltip" 
                                  data-placement="bottom" title="Rechercher"
                                 class="btn btn-outline-primarySearch" >
                                 <i class="fas fa-search"></i>
                                </button>
                              </span>
                          </div>
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
                            'date_end='.$date_end;
                            if(isset($service_courant)){
                              $url=$url.'&'.'service='.$service_courant;                            
                            }
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

  <div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" style="text-align:center" id="modal-title-default">Exporter La Feuille de présences</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
            
       <div class="modal-body">
        <div class="card-body px-lg-1 py-lg-2">
          <form method="post" action="{{ route('temps-presences.export') }}">
            {{ csrf_field() }} 
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start">Du</label>
                  <input id="start" value="<?php if (isset($date_start)) echo $date_start ?>" name="date_start" type="text" class="form-control" disabled >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end">Au</label>
                  <input id="end" value="<?php if (isset($date_end)) echo $date_end ?>" name="date_end" type="text" class="form-control"disabled >
                </div>
              </div>
            </div>
            <input value="<?php if (isset($date_start)) echo $date_start ?>" name="date_start" type="hidden">
            <input value="<?php if (isset($date_end)) echo $date_end ?>" name="date_end" type="hidden">
            <div class="form-group">
              <div class="custom-control custom-radio mb-3">
                <input value="pdf" name="file_type" class="custom-control-input" id="pdf_file" type="radio" checked>
                <label class="custom-control-label" for="pdf_file">Fichier Pdf</label>
              </div>
              <div class="custom-control custom-radio mb-5">
                <input value="excel" name="file_type" class="custom-control-input" id="excel_file" type="radio">
                <label class="custom-control-label" for="excel_file">Fichier Excel</label>
              </div>
            </div>
            <div class="mb-0">
                <button type="submit"
                class="btn btn-primary"
                > Exporter </button>

            </div>
          </form>
        </div>
       </div>
      </div>
    </div>
  </div>
@endsection
