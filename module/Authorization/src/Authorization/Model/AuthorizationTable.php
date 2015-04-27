<?php
namespace Authorization\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class AuthorizationTable
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
 
    public function getAuthorization($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
 
    public function saveAuthorization(Authorization $authorization) 
    {
        $data = array(
            'login' => $authorization->login,
            'email'  => $authorization->email,
			'pass'  => $authorization->pass,
        );
 
        $id = (int)$authorization->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAuthorization($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
 
    public function deleteAuthorization($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}