<?php
namespace Authorization\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Authorization\Model\Authorization;
use Authorization\Form\AuthorizationForm;
 
class AuthorizationController extends AbstractActionController
{
	protected $authorizationTable;
	public function getAuthorizationTable()
    {
        if (!$this->authorizationTable) {
            $sm = $this->getServiceLocator();
            $this->authorizationTable = $sm->get('Authorization\Model\AuthorizationTable');
        }
        return $this->authorizationTable;
    }
    public function addAction()
    {
		$form = new AuthorizationForm();
        $form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
        if ($request->isPost()) {
            $authorization = new Authorization();
            $form->setInputFilter($authorization->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $authorization->exchangeArray($form->getData());
                $this->getAuthorizationTable()->saveAuthorization($authorization);
 
                // Redirect to list of authorizations
                return $this->redirect()->toRoute('authorization');
            }
        }
    }
    public function indexAction()
    {
        $form = new AuthorizationForm();
        //$form->get('submit')->setValue('Add');
 
        return array('form' => $form);		
    }
}