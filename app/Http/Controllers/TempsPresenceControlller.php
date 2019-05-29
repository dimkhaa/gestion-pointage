<?php

    namespace App\Http\Controllers;
    use App\ExportExcel;
    use Request;
    use App\Repository\TempsPresencesRepository;
    use Illuminate\Support\Facades\Input;
    use DateTime;
    use Excel;
    use PDF;
    use App\User;
    use Illuminate\Contracts\View\View;

    class TempsPresenceControlller extends Controller
    {
        private $tolerance;
        private $repository;
        private $services;
        public function __construct(TempsPresencesRepository $repos){
            $this->tolerance=900;
            $this->repository=$repos;
            $this->services=$this->repository->allService(5);
            setlocale( LC_ALL, 'en_US');
        }
        public function showAll(){
            $date_start = strftime("%d %b %Y",strtotime("-10 month"));
            $date_end = strftime("%d %b %Y",strtotime("0 month"));  
            $service="0";
            return view('temps-presences', [
                'users' => $this->repository
                ->usersFilterByDate($date_start, $date_end,$service,5),
                'date_start' =>$date_start,
                'date_end'=>$date_end,
                'date_end'=>$date_end,
                'services'=>$this->services,
            ]);
        }

        public function getDetails($id){
            $heurTot = 0; $heurePo=0; $heureSuppl = 0; $heurePla=0;
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');
            $s=Request::get('service');
            $service = isset($s) ? $s : '0';
            if(!isset($date_start)){
                $date_start = strftime("%d %b %Y",strtotime("-1 month"));
                $date_end = strftime("%d %b %Y",strtotime("0 month"));   
            }

            $user=$this->repository->getOne($id,5);
            foreach($user->pointages as $pointage){
                if($pointage->type==="arrivee"){
                    foreach($user->pointages as $point){
                        if($point->type==="depart" &&
                            date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date))
                            && !isset($date_start)){
                            $heurePla+= abs(strtotime($user->horaire->heureFin) - strtotime($user->horaire->heureDebut));
                            $dateTime = new DateTime($point->date);
                            $heurTot+= abs(strtotime($point->date) - strtotime($pointage->date));
                                                   
                            if(strtotime($dateTime->format("H:i:s")) > strtotime($user->horaire->heureFin)){
                                $heureSuppl+= abs(strtotime($dateTime->format("H:i:s")) - strtotime($user->horaire->heureFin));
                            }
                        }

                        if($point->type==="depart"
                            && date("Y-m-d", strtotime($pointage->date))===date("Y-m-d", strtotime($point->date))
                            && isset($date_start) && date("Y-m-d", strtotime($pointage->date))>=date("Y-m-d", strtotime($date_start))
                            && date("Y-m-d", strtotime($pointage->date))<=date("Y-m-d", strtotime($date_end))){
                            $heurePla+= abs(strtotime($user->horaire->heureFin) - strtotime($user->horaire->heureDebut));
                            $dateTime = new DateTime($point->date);
                            $heurTot+= abs(strtotime($point->date) - strtotime($pointage->date));
                    
                            if(strtotime($dateTime->format("H:i:s")) > strtotime($user->horaire->heureFin)){
                                $heureSuppl+= abs(strtotime($dateTime->format("H:i:s")) - strtotime($user->horaire->heureFin));

                            }
                        }
                    }
                }
            }

            $heurePo=$heurTot - $heureSuppl;
            return view('presences-details', [
                'user' => $user,
                'users' => $this->repository
                ->usersFilterByDate($date_start, $date_end, $service, 5),
                'date_start' =>$date_start,
                'date_end'=>$date_end,
                'heurTot'=>$heurTot,
                'heurePo'=>$heurePo,
                'heureSuppl'=>$heureSuppl,
                'heurePla'=>$heurePla,
                'service_courant'=>$s,
                ]);
        }

        public function filterByDate(){
            $service = Request::get('service');
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');
                return view('temps-presences', [
                    'users' => $this->repository
                    ->usersFilterByDate($date_start, $date_end,$service,5),
                    'date_start' =>$date_start,
                    'date_end'=>$date_end,
                    'services'=>$this->services,
                    'service_courant'=>$service
                ]);
         
         
        }
        public function searchByName(){
            $mc = Request::get('mc');
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');
            return view('temps-presences', [
                'users' => $this->repository->
                           usersSearchByName($mc,$date_start,$date_end,5),
                'mc' =>$mc,
                'date_start' =>$date_start,
                'date_end'=>$date_end,
                'services'=>$this->services,
            ]);
        }
        public function filterByDateDP($id){
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');  
            if(!isset($date_start)){
                $date_start = date('Y-m-d',("+0 day"));
                $date_end = date('Y-m-d',strtotime("-1 month"));   
            }
            return view('presences-details', [
                'user' => $this->repository->getOne($id,5),
                'date_start' =>$date_start,
                'date_end'=>$date_end,
                'users' => $this->repository->allUsers(5)
            ]);
        }

        public function exportUsers(Request $request){
            $type=Input::post('file_type');
            $date_start=Input::post('date_start');
            $date_end=Input::post('date_end');
            if($type==="pdf"){
                $users= $this->repository->usersExportByDate($date_start, $date_end, 5);
                $pdf = PDF::loadView('generatePdf', compact('users'));
                return $pdf->download('liste_users_du_'.$date_start.'_au_'.$date_end.'.pdf');
            }else{
                //return $this->viewExcel($date_start, $date_end);
                return Excel::download(new ExportExcel($this->repository,
                                                      $date_start, $date_end),
                                                     'liste_users_du_'.$date_start.'_au_'.$date_end.'.xlsx');
            }            
        }
    }
