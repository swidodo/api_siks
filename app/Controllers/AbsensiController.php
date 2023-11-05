<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\AbsensiModel;

class AbsensiController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        
    }
    public function store_absen(){
        $absen = new AbsensiModel;
        $data = [
            'user_id'       => $this->request->getVar('user_id'),
            'id_sekolah'    => $this->request->getVar('id_sekolah'),
            'masuk'         => $this->request->getVar('masuk'),
            'pulang'        => $this->request->getVar('pulang'),
            'tanggal'       => $this->request->getVar('tanggal'),
        ];
        $result = $absen->save($data);
        if($result){
            $res = [
                'success' => true,
                'message' => 'Data berhasil di update.',
            ];
        }else{
            $res = [
                'success' => false,
                'message' => 'Data gagal di update.',
            ];
        }
        return $this->respond(['data' => $res], 200);

    }
    public function history(){
        $user_id = $this->request->getVar('user_id');
        $user    = new UserModel;
        $initial = $user->find($user_id);
        if (isset($initial)) :
            if($initial['initial'] == null){
                $data = $user->join('siswa','siswa.id_siswa=users.id','left') 
                            ->where('users.id',$user_id)
                            ->get()
                            ->getRow();
            }else if($initial['initial'] == "guru"){
                $data = $user->join('guru','guru.id_guru = users.id','left') 
                            ->where('users.id',$user_id)
                            ->get()
                            ->getRow();
            }else{
                $data = null;
            }
            if($data){
                $res = [
                    'data' => $data,
                    'success' => true,
                ];
                return $this->respond(['data' => $res], 200);
            }else{
                $res = [
                    'success' => false,
                    'message' => 'Data gagal diload !',
                ];
                return $this->respond(['data' => $res], 500);
            }
        else :
            $res = [
                'success' => false,
                'message' => 'Data Not Found !',
            ];
            return $this->respond(['data' => $res], 401);
        endif;
    }
}
