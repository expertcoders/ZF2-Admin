<?php namespace Admin\Model;
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
	
	 public function save(User $user)
    {
        $data = array(
            'username' => $user->username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email_address' => $user->email_address,
            'status' => $user->status,
        );

        $id = (int)$user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    
    public function saveUser(User $data)
    {
        $id = (int)$data['id'];
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
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
