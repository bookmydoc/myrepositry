<?php
/*------------------------------------------------------------------------
# com_ajax_dockcart - AJAX Dock Cart for VirtueMart
# ------------------------------------------------------------------------
# author    Balint Polgarfi, Ernest Marcinko
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('dockCartControl')) {
  define("dockCartControl", null);
  class dockCartControl {
  
    var $cart; 
    
    function dockCartControl() {
      $this->cart = VirtueMartCart::getCart(false,false);
    }
    
    function add_item() {
      $mainframe = JFactory::getApplication();
      if ($this->cart->add()) {
        $out = $this->getDockCartContent($_REQUEST['img'], $_REQUEST['size'], true);
        $out['succ'] = 1;
      } else $out['succ'] = 0;
      if(!version_compare(JVERSION,'1.6.0','ge')) {
        if (isset($mainframe->_messageQueue[0]))
         $out['message'] = JText::_($mainframe->_messageQueue[0]['message']);
      } else {
        $messageq = $mainframe->getMessageQueue();
        if (is_array($messageq))
          $out['message'] = JText::_($messageq[count($messageq)-1]['message']);
      }
      echo json_encode($out); 
    }
    
    function remove_item($m, $size, $id=0) {
      if ($this->cart->removeProductCart($id)) {
        $out = $this->getDockCartContent($m, $size, true);
        $out['succ'] = 1;
      } else $out['succ'] = 0;
      echo json_encode($out); 
    }
    
    function empty_cart() {
      foreach ($this->cart->products as $id => $product)
        $this->cart->removeProductCart($id);
      $this->cart->removeCartFromSession();
      $this->cart->prepareAjaxData();
      echo $this->cart->data->billTotal;  
    }     
    
    function getDockCartContent($m, $size, $incall = false) {
      $data = $this->cart->prepareAjaxData();
      $lang = JFactory::getLanguage();
      $extension = 'com_virtuemart';	
      $icon = new IconGenerator(JPATH_ROOT.'/modules/mod_ajax_dockcart/cache', $size, dirname(__FILE__).'/imgs/'.$m.'.png');
      $cart = $this->cart;
    	$out['products'] = array();
    	if ($data->totalProduct>0) {
    		$products = &$out['products'];
    		$path = JPATH_ROOT.'/modules/mod_ajax_dockcart/cache/';
    		$root = JURI::root(false);	
    		$i = 0;
    		foreach ($cart->products as $pid => $product) {
          $prod = &$products[$i];
    			$url = "?option=com_virtuemart&view=productdetails&virtuemart_product_id={$product->virtuemart_product_id}&virtuemart_category_id={$product->virtuemart_category_id}";
    			$prod['product_page'] = mb_convert_encoding($url, 'UTF-8', 'HTML-ENTITIES');
    			$prod['product_id'] = $pid;
    			$prod['product_name'] =  strip_tags($product->product_name);//$product->product_name;
				$prod['product_name'] = html_entity_decode($prod['product_name'], ENT_NOQUOTES, 'UTF-8');
    			$prod['description'] =$this->getDescription($i);
    			$prod['price'] = number_format($cart->data->products[$i]['subtotal_with_tax'], 2);
				$prod['quantity']=$product->quantity;
    			$prod_add = $this->getImage((isset($product->virtuemart_media_id[0])?$product->virtuemart_media_id[0]:-1));
    			if ($prod_add!=-1) {
       			$prod['product_full_image'] = $prod_add[0]['file_url'];
      			$prod['product_thumb_image'] = $prod_add[0]['file_url_thumb'];
      			$s = $prod['product_full_image']? $prod['product_full_image'] : $prod['product_thumb_image'];
      			if ($s) {
              if (!stristr($s, 'http')) $s = dirname(__FILE__).'/../../'.$s;
              $prod['product_thumb_image'] = $root.'modules/mod_ajax_dockcart/cache/'.$icon->get($s);
            }  
          } else $prod['product_full_image'] = "";
          $i++;			
        }
        $icon->destroy();
    	}
		
		/// add code for currect total price. 22 Oct 2012
		$cart123 = VirtueMartCart::getCart();
		$totle_price = $cart123->getCartPrices();	  
	    $out['sum'] = "$".number_format($totle_price['salesPrice'], 2, '.', ',');
		///end code
	   
     // $out['sum'] = $cart->data->billTotal;
      if ($incall) return $out;
    	else return json_encode($out);
    } 
    
    private function getImage($id) {
      if ($id<0) return -1;
      $db =& JFactory::getDBO();
      $q = "SELECT file_url, file_url_thumb  FROM #__virtuemart_medias WHERE virtuemart_media_id=".$id;
    	$db->setQuery($q);
    	return $db->loadAssocList();  
    } 
    
    private function getDescription($i) {
      $desc = "";
      if (isset($this->cart->prepareAjaxData()->products[$i]['product_attributes'])) {
        $desc = str_replace("<span>", "##", $this->cart->prepareAjaxData()->products[$i]['product_attributes']);
        $desc = substr(str_replace("##", "; ", trim(strip_tags($desc, "<img>"))), 2);
      }      
      return $desc;     
    } 
  }
}

?>