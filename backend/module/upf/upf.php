<?php

namespace app\module\upf;
use yii\base\Module;

class upf extends Module
{
	
	private $_assetsUrl;
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\module\upf\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
    
    /**
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'upf.models.*',
			'upf.components.*',
		));
	}
    


	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
		$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.upf.assets'));
		return $this->_assetsUrl;
	}
	
	public function setAssetsUrl($value)
	{
		$this->_assetsUrl=$value;
	} 
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
        }
    }
    **/
}
