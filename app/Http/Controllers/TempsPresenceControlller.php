<?php

    namespace App\Http\Controllers;

    use Request;
    use App\Repository\TempsPresencesRepository;
    use Illuminate\Support\Facades\Input;
    use DateTime;
    class TempsPresenceControlller extends Controller
    {
        private $repository;

        public function __construct(TempsPresencesRepository $repos){
            $this->repository=$repos;
            setlocale( LC_ALL, 'en_US');
        }
        public function showAll(){
           
            $date_start = strftime("%d %b %Y",strtotime("-10 month"));
            $date_end = strftime("%d %b %Y",strtotime("0 month"));   
            return view('temps-presences', [
                'users' => $this->repository
                ->usersFilterByDate($date_start, $date_end,5),
                'date_start' =>$date_start,
                'date_end'=>$date_end
            ]);
        }

        public function getDetails($id){
            $heurTot = 0; $heurePo=0; $heureSuppl = 0; $heurePla=0;
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');
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
                ->usersFilterByDate($date_start, $date_end,5),
                'date_start' =>$date_start,
                'date_end'=>$date_end,
                'heurTot'=>$heurTot,
                'heurePo'=>$heurePo,
                'heureSuppl'=>$heureSuppl,
                'heurePla'=>$heurePla,
                ]);
        }

        public function filterByDate(){
            $date_start = Request::get('date_start');
            $date_end = Request::get('date_end');
            return view('temps-presences', [
                'users' => $this->repository
                ->usersFilterByDate($date_start, $date_end,5),
                'date_start' =>$date_start,
                'date_end'=>$date_end
            ]);
        }
        public function searchByName(){
            $mc = Request::get('mc');
            return view('temps-presences', [
                'users' => $this->repository->usersSearchByName($mc,5),
                'mc' =>$mc
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
    }
