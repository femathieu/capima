<?php
class HomeSalesController extends ModuleAdminController{


    // public function installTab($parent_class, $class_name, $name)  {
    //     $tab = new Tab();
    //     // Define the title of your tab that will be displayed in BO
    //     $tab->name[$this->context->language->id] = $name; 
    //     // Name of your admin controller 
    //     $tab->class_name = $class_name;
    //     // Id of the controller where the tab will be attached
    //     // If you want to attach it to the root, it will be id 0 (I'll explain it below)
    //     $tab->id_parent = (int) Tab::getIdFromClassName($parent_class);
    //     // Name of your module, if you're not working in a module, just ignore it, it will be set to null in DB
    //     $tab->module = $this->name;
    //     // Other field like the position will be set to the last, if you want to put it to the top you'll have to modify the position fields directly in your DB
    //     return $tab->add();
    // }
   
    // public function install()
    // {
    //     return (parent::install() &&
    //           $this->registerHook('backOfficeHeader') &&
    //           $this->registerHook('displayTopColumn') &&
    //           $this->registerHook('header') &&
    //           // Then call this function here and only after parent::install
    //           // args: parent_classname ; current_classname ; tab_title
    //           // Note that you don't add the "Controller" suffix
    //           // In this example, the tab will be a subtab attached to the Catalog tab, which is attached to Sell, which is attached to the root
    //           $this->installTab('AdminCatalog', 'YourAdminClassName', 'My tab title') &&
    //           Configuration::updateValue('HOMESALES', "HomeSales")
    //     );
    // }
}