<?php
/**
 * @package ImpressPages

 *
 */
namespace Ip\Module\Content\Widget;




class IpSeparator extends \Ip\Module\Content\Widget{


    public function getTitle() {
        global $parametersMod;
        return __('Separator', 'ipAdmin');
    }
    
}