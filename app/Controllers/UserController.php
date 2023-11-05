<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\SiswaModel;

class UserController extends BaseController
{
    use ResponseTrait;
     
    public function index()
    {

        $users = new UserModel;
        $id = $this->request->getVar('user_id');
        
        $usr = $users->where('id',$id)->get()->getRow();
        if ($usr != null){
            if ($usr->initial == "guru"){
                $data = $users->join('data_guru','data_guru.user_id = users.id','left')
                            ->find($id);
                if($data){
                    $res = [
                        'success' => true,
                        'data'    => $data
                    ];
                    return $this->respond(['data' => $res], 200);
                }else{
                    $res = [
                        'success' => false,
                        'message'    => 'Data Not Found !'
                    ];
                    return $this->respond(['data' => $res], 401);
                }
            }else{
                $data = $users->join('siswa','siswa.user_id = users.id','left')
                              ->find($id);
                if($data){
                    $res = [
                        'success' => true,
                        'data'    => $data
                    ];
                    return $this->respond(['data' => $res], 200);
                }else{
                    $res = [
                        'success' => false,
                        'message'    => 'Data Not Found !'
                    ];
                    return $this->respond(['data' => $res], 401);
                }
            }
        }else{
            $res = [
                'success' => false,
                'message'    => 'Data Not Found !'
            ];
            return $this->respond(['data' => $res], 401);
        }
    }
    public function update_profile(){
        $users  = new UserModel;
        $id     = $this->request->getVar('user_id');
        $user   = $users->find($id);

        if ($user['initial'] =="guru"){
            $guru       = new GuruModel;
            $id_guru    = $this->request->getVar('id_guru');
            $data = [
                'nama_guru'     => $this->request->getVar('nama_guru'),
                'nip'           => $this->request->getVar('nip'),
                'jk'            => $this->request->getVar('jk'),
                'alamat_guru'   => $this->request->getVar('alamat_guru'),
                'telpon_guru'   => $this->request->getVar('telpon_guru'),
                'email'         => $this->request->getVar('email'),
            ];
            $result = $guru->where('id_guru',$id_guru)->update($data);
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
        }else if ($user['initial'] == null){
            $siswa      = new SiswaModel;
            $id_siswa   = $this->request->getVar('id_siswa');
            $data = [
                'nama'              => $this->request->getVar('nama'),
                'jk'                => $this->request->getVar('jk'),
                'tempat_lahir'      => $this->request->getVar('tmpt_lahir'),
                'tgl_lahir'         => $this->request->getVar('tgl_lahir'),
                'anak_ke'           => $this->request->getVar('anak_ke'),
                'status_dlm_kel'    => $this->request->getVar('status_dlm_kel'),
                'agama'             => $this->request->getVar('agama'),
                'alamat'            => $this->request->getVar('alamat'),
                'hp'                => $this->request->getVar('hp'),
                'nama_ayah'         => $this->request->getVar('nama_ayah'),
                'kerja_ayah'        => $this->request->getVar('kerja_ayah'),
                'nama_ibu'          => $this->request->getVar('nama_ibu'),
                'kerja_ibu'         => $this->request->getVar('kerja_ibu'),
                'hp_ortu'           => $this->request->getVar('hp_ortu'),
                'nama_wali'         => $this->request->getVar('nama_wali'),
                'alamat_wali'       => $this->request->getVar('alamat_wali'),
                'hp_wali'           => $this->request->getVar('hp_wali'),
                'hp_wali'           => $this->request->getVar('hp_wali'),
                'kerja_wali'        => $this->request->getVar('kerja_wali'),
                'email'             => $this->request->getVar('email'),
            ];
            $result = $siswa->where('id_siswa',$id_siswa)->update($data);
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
        }else{
            $res = [
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ];
            return $this->respond(['data' => $res], 401);
        }
    }
    
}
