<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class Home_Expertise extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'home_expertise';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('Home_expertise');
      $this->description = $this->l('Description of home_expertise.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:home_expertise/home_expertise.tpl';
   
      if (!Configuration::get('HOME_EXPERTISE_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('HOME_EXPERTISE_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('HOME_EXPERTISE_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'home_expertise_url' => $this->context->link->getPageLink('home_expertise', null, null, null, false, null, true),
        );

        if (!array_key_exists('home_expertise_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['home_expertise_string'] = '';
        }

        return $widgetVariables;
    }

    public function renderWidget($hookName, array $configuration = []){
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->fetch($this->templateFile);
    }

    public function hookHeader ($params)
    {
    }
    
    
    public function hookDisplayHome($params){
      $this->context->controller->bootstrap=true;
      $this->context->controller->addCSS('modules/home_expertise/'.'style.css');
      $this->context->smarty->assign(
        array(
          'home_expertise' => Configuration::get('home_expertise'),
          'home_expertise_link' => $this->context->link->getModuleLink('home_expertise', 'display')
        )
      );
      return $this->display(__File__, 'home_expertise.tpl');
    }

  // public function hookdisplayHeader($params){
  //   $this->context->controller->registerJavascript('my-module', 'modules/' . $this->name . '/views/js/my-module.js', array(
  //   'position' => 'bottom',
  //    'priority' => 150
  //   ));
  // }
}