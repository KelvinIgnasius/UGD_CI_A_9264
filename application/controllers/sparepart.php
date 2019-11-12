<?php
use Restserver \Libraries\REST_Controller ;
Class sparepart extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, ContentLength, Accept-Encoding");
        parent::__construct();
        $this->load->model('sparepartmodel');
        $this->load->library('form_validation');
        }
        public function index_get(){
        return $this->returnData($this->db->get('sparepart')->result(), false);
        }
        public function index_post($id = null){
        $validation = $this->form_validation;
        $rule = $this->sparepartmodel->rules();
        if($id == null){
        array_push($rule,[
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required'
            ],
            [
            'field' => 'merk',
            'label' => 'merk',
            'rules' => 'required'
            ],
                [
                    'field' => 'amount',
                    'label' => 'amount',
                    'rules' => 'required'
                    ],
                    [
                        'field' => 'create_at',
                        'label' => 'create_at',
                        'rules' => 'required'
                        ]
            );
        }
            else{
                array_push($rule,
                [
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required'
                ]
                );
        }
        $validation->set_rules($rule);
        if (!$validation->run()) {
        return $this->returnData($this->form_validation->error_array(), true);
        }
        $sparepart = new sparepartData();
        $sparepart->name = $this->post('name');
        $sparepart->merk = $this->post('merk');
        $sparepart->amount = $this->post('amount');
        $sparepart->create_at = $this->post('create_at');
        if($id == null){
        $response = $this->sparepartmodel->store($sparepart);
    }else{
        $response = $this->sparepartmodel->update($sparepart,$id);
        }
        return $this->returnData($response['msg'], $response['error']);
        }
        public function index_delete($id = null){
        if($id == null){
        return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->sparepartmodel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
        }
        public function returnData($msg,$error){
        $response['error']=$error;
        $response['message']=$msg;
        return $this->response($response);
        }
       }
       Class sparepartData{
        public $name;
        public $merk;
        public $amount;
        public $create_at;
       }