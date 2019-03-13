<?php
    namespace App\Repository;
    use App\User;
    use Illuminate\Support\Facades\DB;

    class TempsPresencesRepository{

        public function __construct(){
        }
        public function allUsers($id_entrep){
            $users= User::whereHas('service', function($q) use ($id_entrep)
            {
                $q->where('entreprise_id',$id_entrep);
            })->paginate(10);
            return $users;
        }
        public function usersFilterByDate($date_start, $date_end, $id_entrep){
            $d1=date("Y-m-d", strtotime($date_start));
            $d2=date("Y-m-d", strtotime($date_end));
            $users= User::whereHas('service', function($q) use ($id_entrep)
            {
               $q->where('entreprise_id',$id_entrep);
            })->whereHas('pointages', function($q) use ($d1, $d2)
            {
                $q->where("date", ">=", $d1);
                $q->where("date", "<=", $d2);      
            })->paginate(10);
             
            return $users;
        }

        public function getOne($id,$id_entrep){
            $user= User::whereId($id)
            ->whereHas('service', function($q) use ($id_entrep)
            {
                $q->where('entreprise_id',$id_entrep);
            })->first();
            return $user;
        }

        public function usersSearchByName($name,$id_entrep){
            $users= User::whereHas('service', function($q) use ($id_entrep)
            {
               $q->where('entreprise_id',$id_entrep);
            })->where('nom','LIKE', '%'.$name.'%')
            ->orWhere('prenom','LIKE', '%'.$name.'%')
            ->paginate(10);
            return $users;
        }
        
    }

