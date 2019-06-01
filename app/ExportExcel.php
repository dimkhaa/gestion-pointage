<?php

    namespace App;
    use App\User;
    use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;
    use Request;
    use App\Repository\TempsPresencesRepository;


    class ExportExcel implements FromView
    {
        private $repository;
        private $date_start;
        private $date_end;

        public function __construct(TempsPresencesRepository $repos,$d1,$d2){
            $this->repository=$repos;
            $this->date_start=$d1;
            $this->date_end=$d2;
        }

        public function view(): View
        {  
            return view('pages/export', [
                'users' => $this->repository->usersExportByDate($this->date_start, $this->date_end, 5)
            ]);
        }
    }