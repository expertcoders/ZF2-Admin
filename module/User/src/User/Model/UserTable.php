<?php
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

	public function userUpdate($user){
		$id = (int)$user->id;
		if($id==0){
			$this->tableGateway->insert($user);
			return true;
		}else{
			$this->tableGateway->update((array)$user, array('id' => $id));
			return true;
		}
	
	
	}
	
		
    public function saveUser(User $user,$type='Add')
    {
       if($type=='Update'){
	     $d=(array) $user;  
    	 $data['status']=$d['status'];
		 $data['id']=$d['id'];
         $id = (int)$d->id;
		 
       }else{
        $data = array(
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email_address'  => $user->email_address,
        );
        
        $id = (int)$user->id;
        }
        
        
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update((array)$data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteUser($id)
    {
       if($this->tableGateway->delete(array('id' => $id))){
          return true;
       }else{
          return false;
       }
    }
}
