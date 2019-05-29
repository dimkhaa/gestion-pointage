
@extends("master2")

@section("content")
<?php 
    setlocale( LC_ALL, 'fr_FR');
 ?>
<div class="container-fluid mt--7">
    <div class="card shadow">
        <div class="row">
            <div class="col">
                <div class="card-header">
                    
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 mb-4 div-border">
                            <div class="table-responsive mb-4 ">
                                <table id="table-temps-presence" class="table table-bordered align-items-center  containe" >
                                    <thead >
                                        <tr>
                                            <th scope="col">Salariés</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color:#f8f9fe">    
                                        @foreach( $users as $u)
                                            <?php
                                                $url= route('temps-presences.details',$u->id).
                                                '?date_start='.$date_start .'&'.
                                                'date_end='.$date_end;
                                                if(isset($service_courant)){
                                                    $url=$url.'&'.'service='.$service_courant;                            
                                                  }
                                            ?>

                                            <tr class="table-tr" data-url="{{ $url }}">
                                                <th scope="row">
                                                    <div class="media align-items-center">
                                                        <a style='color:#000;' href="{{ route('temps-presences.details',$u->id) }}" class="avatar rounded-circle mr-3">
                                                            {{ strtoupper($u->prenom[0]) }}{{ strtoupper($u->nom[0]) }}
                                                        </a>
                                                        <div class="media-body">
                                                            <span class="mb-0 text-sm">{{ $u->prenom }} {{ $u->nom }}</span>
                                                        </div>
                                                    </div>
                                                </th>
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

                        <div class="col-xl-9 ">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('temps-presences')}}">
                                        <i class="ni ni-bold-left text-blue"></i>Retour
                                    </a>
                                </li>
                            </ul>

                            <form autocomplete="off" action="{{ route('temps-presences.details', $user->id) }}" method="get" role="search">
                                {{ csrf_field() }}
                                <div class="input-daterange datepicker row align-items-center">
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input  name="date_start" class="form-control datepicker" value="<?php if (isset($date_start)) echo $date_start ?>" placeholder=" Du" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5" >
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
                                        <button type="submit" class="btn btn-outline-primarySearch">Filtrer</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                            <h1>{{ $user->prenom }} {{ $user->nom }}</h1>


                            <div class="table-responsive mb-4 " style="max-width:50%">
                                <table id="table-temps-presence" class="table table-bordered  align-items-center  containe" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
             
                                     <tr>
                                            <td scope="row">Heures Planifiées</td>
                                            <td>{{ round($heurePla/3600) }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                Heures Pointées
                                            </td>
                                            <td>{{ round($heurePo/3600) }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">
                                                Heures Supplémentaires
                                            </td>
                                            <td>{{ round($heureSuppl/3600) }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table  class="table align-items-center table-flush container">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Plages horaires</th>
                                            <th scope="col">Entrée</th>
                                            <th scope="col">Sortie</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $totaux=0;
                                        ?>
                                        @foreach( $user->pointages as $pointage)
                                            @foreach( $user->pointages as $point)
                                                @if(!isset($date_start))
                                                    @if($pointage->type==="arrivee" && $point->type==="depart" 
                                                    && date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date)))
                                                        <tr>
                                                            <th scope="row">
                                                                {{ strtoupper(strftime("%a %d %b", strtotime($point->date))) }}
                                                            </th>
                                                            <td>
                                                                <span class="badge badge-dot mr-4">
                                                                    {{ $user->horaire->heureDebut }} {{ $user->horaire->heureFin }}
                                                                </span> 
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $dateArr = (new DateTime($pointage->date))->format("H:i:s");
                                                                    $dateSort = (new DateTime($point->date))->format("H:i:s");
                                                                    $heurTot= (strtotime($dateSort) - strtotime($dateArr));
                                                                    $totaux+=$heurTot;
                                                                    if((strtotime($dateArr) - strtotime($user->horaire->heureDebut)) >= 900){
                                                                        $classEtatArr="bg-warning";
                                                                    }else{
                                                                        $classEtatArr="bg-success";
                                                                    }
                                                                    if((strtotime($user->horaire->heureFin) - strtotime($dateSort)) >= 900){
                                                                        $classEtatSort="bg-warning";
                                                                    }else{
                                                                        $classEtatSort="bg-success";
                                                                    }
                                                                ?>
                                                              
                                                              <span class="badge badge-dot mr-4">
                                                                    <i class="{{$classEtatArr}}"></i>
                                                                    {{ $dateArr }}
                                                                </span> 
                                                            </td>
                                                            <td>                                                            
                                                                <span class="badge badge-dot mr-4">
                                                                    <i class="{{$classEtatSort}}"></i>
                                                                    {{ $dateSort }}
                                                                </span>    
                                                            </td>
                                                            <td>
                                                                {{ Date('H:i',$heurTot) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                                @if(isset($date_start))
                                                    @if($pointage->type==="arrivee" && $point->type==="depart" 
                                                    && date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date))
                                                    && date("Y-m-d", strtotime($pointage->date))>=date("Y-m-d", strtotime($date_start))
                                                    && date("Y-m-d", strtotime($pointage->date))<=date("Y-m-d", strtotime($date_end)))
                                                        <tr>
                                                            <th scope="row">
                                                                {{ strtoupper(strftime("%a %d %b", strtotime($point->date)))}}
                                                            </th>
                                                            <td>
                                                                <span class="badge badge-dot mr-4">
                                                                    {{ $user->horaire->heureDebut }} {{ $user->horaire->heureFin }}
                                                                </span> 
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $dateArr = (new DateTime($pointage->date))->format("H:i:s");
                                                                    $dateSort = (new DateTime($point->date))->format("H:i:s");
                                                                    $heurTot= (strtotime($dateSort) - strtotime($dateArr));
                                                                    $totaux+=$heurTot;
                                                                    if((strtotime($dateArr) - strtotime($user->horaire->heureDebut)) >= 900){
                                                                        $classEtatArr="bg-warning";
                                                                    }else{
                                                                        $classEtatArr="bg-success";
                                                                    }
                                                                    if((strtotime($user->horaire->heureFin) - strtotime($dateSort)) >= 900){
                                                                        $classEtatSort="bg-warning";
                                                                    }else{
                                                                        $classEtatSort="bg-success";
                                                                    }
                                                                ?>
                                                                <span class="badge badge-dot mr-4">
                                                                    <i class="{{$classEtatArr}}"></i>
                                                                    {{ $dateArr }}
                                                                </span> 
                                                            </td>
                                                            <td>                                                            
                                                                <span class="badge badge-dot mr-4">
                                                                    <i class="{{$classEtatSort}}"></i>
                                                                    {{ $dateSort }}
                                                                </span>    
                                                            </td>
                                                            <td>
                                                                {{ Date('H:i',$heurTot) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                               
                                            @endforeach
                                        @endforeach
                                        <tr scope="col">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th scope="row">TOTAL</th>
                                            <td>{{ Date('H:i',$totaux) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
