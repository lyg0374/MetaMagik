<?php
namespace Kanboard\Plugin\Metadata\Controller;
use Kanboard\Controller\Base;
/**
 * Metadata
 *
 * @package controller
 * @author  BlueTeck
 */
class Metadata extends Base
{
    public function project()
    {
        $project = $this->getProject();
        
        $metadata = $this->projectMetadata->getAll($project['id']);
        
        $this->response->html($this->helper->layout->project('metadata:project/metadata', array('title' => t('Metadata'), 
                                                                                                 'project' => $project,
                                                                                                 'metadata' => $metadata )));
    }
    
    public function task()
    {
        $project = $this->getProject();
        $task = $this->getTask();
        
        $metadata = $this->taskMetadata->getAll($task['id']);
        
        $this->response->html($this->helper->layout->task('metadata:task/metadata', array('title' => t('Metadata'), 
                                                                                              'task' => $task,  
                                                                                              'project' => $project,
                                                                                              'metadata' => $metadata)));
    }
    
    public function user()
    {
        $user = $this->getUser();
        $metadata = $this->userMetadata->getAll($user['id']);
        
        $this->response->html($this->helper->layout->user('metadata:user/metadata', array('title' => t('Metadata'), 
                                                                                              'user' => $user,
                                                                                              'metadata' => $metadata)));
    }
    
    public function addUser()
    {
        $user = $this->getUser();
        $values = $this->request->getValues();
        
        $this->userMetadata->save($user['id'], [$values['key'] => $values['value']]);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'user', array('plugin' => 'metadata', 'user_id' => $user['id'])), true); 
    }
    
    public function addTask()
    {
        $task = $this->getTask();
        $values = $this->request->getValues();
        
        $this->taskMetadata->save($task['id'], [$values['key'] => $values['value']]);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'task', array('plugin' => 'metadata', 'task_id' => $task['id'], 'project_id' => $task['project_id'])), true);                                                                                              
    }
    
    public function addProject()
    {
        $project = $this->getProject();
        $values = $this->request->getValues();
        
        $this->projectMetadata->save($project['id'], [$values['key'] => $values['value']]);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'project', array('plugin' => 'metadata', 'project_id' => $project['id'])), true);                                                                                              
    }
    
    public function confirmTask()
    {
        $project = $this->getProject();
        $task = $this->getTask();
        $key = $this->request->getStringParam('key');

        $this->response->html($this->template->render('metadata:task/remove', array(
            'task' => $task,  
            'project' => $project,
            'key' => $key,
        )));
    }
    
    public function confirmProject()
    {
        $project = $this->getProject();
        $key = $this->request->getStringParam('key');

        $this->response->html($this->template->render('metadata:project/remove', array(
            'project' => $project,
            'key' => $key,
        )));
    }
    
    public function confirmUser()
    {
        $type = $this->request->getStringParam('type');
        $id = $this->request->getStringParam('id');
        $key = $this->request->getStringParam('key');

        $this->response->html($this->template->render('metadata:user/remove', array(
            'id' => $id,
            'type' => $type,
            'key' => $key,
        )));
    }
    
    public function removeTask()
    {
        $task = $this->getTask();
        $key = $this->request->getStringParam('key');
           
        $this->taskMetadata->remove($task['id'], $key);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'task', array('plugin' => 'metadata', 'task_id' => $task['id'], 'project_id' => $task['project_id'])), true);                                                                                              
    }
    
    public function removeProject()
    {
        $project = $this->getProject();
        $key = $this->request->getStringParam('key');
           
        $this->projectMetadata->remove($project['id'], $key);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'project', array('plugin' => 'metadata', 'project_id' => $project['id'])), true);   
    }
    
    public function removeUser()
    {
        $user = $this->getUser();
        $key = $this->request->getStringParam('key');
           
        $this->userMetadata->remove($user['id'], $key);
        
        return $this->response->redirect($this->helper->url->to('metadata', 'user', array('plugin' => 'metadata', 'user_id' => $user['id'])), true); 
    }
}