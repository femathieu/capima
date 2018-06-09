<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class PanamTitre extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'panamtitre';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('Panam Titre');
      $this->description = $this->l('Affiche panam média sur la première page.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:panamtitre/panamtitre.tpl';
   
      if (!Configuration::get('panamtitre'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('panamtitre', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('panamtitre')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'panamtitre_url' => $this->context->link->getPageLink('panamtitre', null, null, null, false, null, true),
        );

        if (!array_key_exists('panamtitre_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['panamtitre_string'] = '';
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
      $this->context->controller->addCSS('modules/panamtitre/'.'style.css');
      $this->context->smarty->assign(
        array(
          'panamtitre' => Configuration::get('panamtitre'),
          'panamtitre_link' => $this->context->link->getModuleLink('panamtitre', 'display')
        )
      );
      return $this->display(__File__, 'panamtitre.tpl');
    }
}