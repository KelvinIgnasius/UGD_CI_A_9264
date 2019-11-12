<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class sparepartmodel extends CI_Model
{
    private $table = 'sparepart';
    public $id;
    public $name;
    public $merk;
    public $amount;
    public $create_at;
    public $rule = [
 [
 'field' => 'name',
 'label' => 'name',
 'rules' => 'required'
 ],
 ];
 public function Rules() { return $this->rule; }

 public function getAll() { return
 $this->db->get('sparepart')->result();
 }
 public function store($request) {
 $this->name = $request->name;
 $this->merk = $request->merk;
 $this->amount = $request->amount;
 $this->create_at = $request->create_at;
 if($this->db->insert($this->table, $this)){
    return ['msg'=>'Berhasil','error'=>false];
   }
   return ['msg'=>'Gagal','error'=>true];
}
 public function update($request,$id) {
$updateData = ['name' =>$request->name];
if($this->db->where('id',$id)->update($this->table, $updateData)){
return ['msg'=>'Berhasil','error'=>false];
}
return ['msg'=>'Gagal','error'=>true];
}
public function destroy($id){
if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) return ['msg'=>'Id tidak ditemukan','error'=>true];
if($this->db->delete($this->table, array('id' => $id))){
return ['msg'=>'Berhasil','error'=>false];
}
return ['msg'=>'Gagal','error'=>true];
}
}
?>