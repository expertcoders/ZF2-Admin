<?php namespace Post\Model;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;

 class CommentTable
 {
     protected $tableGateways;
     
     protected $table='postcomments';
     
     protected $dbAdapter;

     public function __construct(TableGateway $tableGateways)
     {
      $diverArray=array(
                  'driver' => 'Mysqli',
                  'database' => 'zend',
                  'username' => 'root',
                  'password' => 'sparx'
      );
       
      $this->dbAdapter=new Adapter($diverArray);
      $this->tableGateway = $tableGateways;
     }
     
     private function queryRun($select){
         $sql = new Sql($this->dbAdapter);
         $statement = $sql->prepareStatementForSqlObject($select);
         $resultSet = $statement->execute();
         return $resultSet;
        
     }

     public function getAllCommentsOfPost($paginated=false,$id=NULL)
     {
         if ($paginated) {
             // create a new Select object for the table album
             $select = new Select();
             $select->from(array('p' => 'post'))
              ->columns(array('id','title','images','post','status','created'))
              ->join('user', 'user.id=p.user_id',array('user_id'=>'id','first_name','last_name'));
             if($id!=NULL){
               $select->where('p.id <>'.$id);
             }
             $select->order(array('p.id DESC'));
             // create a new result set based on the Album entity
             
             $resultSetPrototype = new ResultSet();
             
             $resultSetPrototype->setArrayObjectPrototype(new Post());
             // create a new pagination adapter object
             $paginatorAdapter = new DbSelect(
                 // our configured select object
                 $select,
                 // the adapter to run it against
                 $this->tableGateway->getAdapter(),
                 // the result set to hydrate
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }else{
            $select = new Select();
            $select->from(array('pc' => 'postcomments'))
            ->columns(array('id','comment','post_id','user_id','created'))
            ->join('user', 'user.id=pc.user_id',array('user_id'=>'id','first_name','last_name'))
            ->join('post', 'post.id=pc.post_id',array('post_id'=>'id'))
            ->where('pc.post_id='.$id);
            $select->order(array('pc.id DESC'));
            //print_r(get_class_methods($select));
            //echo $select->getSqlString();
            //$resultSet = $this->tableGateway->selectWith($select);
            return $this->queryRun($select);
         }
     }

     public function getPost($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }
     
     
     public function savePostComment($post)
     {
         $id = (int) $post['id'];
         if ($id == 0) {
             $this->tableGateway->insert($post);
             //print_r(get_class_methods($this->tableGateway));
             //die;
             return $this->tableGateway->getLastInsertValue();
         } else {
             if ($this->getPost($id)) {
                 $this->tableGateway->update($post, array('id' => $id));
             } else {
                 throw new \Exception('Post id does not exist');
             }
         }
     }

 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ?>
