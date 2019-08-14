<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_CategoryShowcase_Block_List extends Mage_Core_Block_Template
{
	protected $_config = null;
	protected $_storeId = null;
	protected $_productCollection = null;
	protected $_category = null;
	
	public function __construct($attributes = array()){
		parent::__construct();
		$this->_config = Mage::helper('categoryshowcase/data')->get($attributes);
	}

	public function getConfig($name=null, $value=null){
		if (is_null($this->_config)){
			$this->_config = Mage::helper('categoryshowcase/data')->get(null);
		}
		if (!is_null($name) && !empty($name)){
			$valueRet = isset($this->_config[$name]) ? $this->_config[$name] : $value;
			return $valueRet;
		}
		return $this->_config;
	}
	
	public function setConfig($name, $value=null){
		if (is_null($this->_config)) $this->getConfig();
		if (is_array($name)){
			$this->_config = array_merge($this->_config, $name);
			return;
		}
		if (!empty($name)){
			$this->_config[$name] = $value;
		}
		return true;
	}
	
	protected function _toHtml(){
		$template = $this->getConfig('theme', 'theme1');
		//$template_file = "smartaddons/categoryshowcase/block_template_default.phtml";
		$template_file = 'smartaddons/categoryshowcase/'. $this->_config["theme"].'.phtml';
		$this->setTemplate($template_file);
		return parent::_toHtml();
	}
	
	public function getStoreId(){
		if (is_null($this->_storeId)){
			$this->_storeId = Mage::app()->getStore()->getId();
		}
		return $this->_storeId;
	}
	public function setStoreId($storeId=null){
		$this->_storeId = $storeId;
	}
	
	protected function getProductCollection(){
		// if (is_null($this->_productCollection)){
			// if (!Mage::registry("sm_product_collection")){
				$collection = Mage::getSingleton('catalog/product')->getCollection();
				$collection->addAttributeToSelect('*');
				$collection->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
				$visibility = array(
					Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
					Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
				);
				$collection->addAttributeToFilter('visibility', $visibility);
				
				// add price data
				$collection->addPriceData();
				
				// add category_ids
				//$collection->addCategoryIds();
				
				$this->_addViewsCount($collection);
				$this->_addReviewsCount($collection);
				$this->_addOrderedCount($collection);
		return $collection;		
			//	Mage::register("sm_product_collection", $collection);
			// }
			// $this->_productCollection = Mage::registry("sm_product_collection");
		// }
		//return $this->_productCollection;
	}
	public function setProductCollection($collection=null){
		$this->_productCollection = $collection;
	}
	
	private function _getProducts(){
		$collection = $this->getProductCollection();
		// if ($this->_config['product_source']=='product'){
			// if (is_null($this->_config['product_ids']) || empty($this->_config['product_ids'])){
				// return false;
			// } else {
				// $product_ids = preg_split("/[,\s\D]+/", $this->_config['product_ids']);
				// $collection->addIdFilter($product_ids);
			// }
		// } else if ($this->_config['product_source']=='catalog') {
			if (Mage::registry('current_category')){
				// is category view page.
				$current_category = Mage::registry('current_category');
				$current_category_id = $current_category->getId();
				$product_ids = $current_category->getProductCollection()->getAllIds();
				$collection->addIdFilter($product_ids);
				$category_ids = array();
				$this->_category[$current_category_id] =array(
											'id' 				=> $current_category_id,
											'sub_title'			=> $current_category->getName(),
											'link' 				=> $current_category->getUrl(),
											'thumb_image'		=> $this->_getResizedImage($current_category,$this->_config['category_image_width'],$this->_config['category_image_height'],100),//$image_category,
											'productIds'		=> $product_ids,
											'productList'		=> array()
										);	
			} else {
				// if Mage::registry('product') - is product page or another page.
				$category_ids = preg_split("/[,\s\D]+/", $this->_config['product_category']);
				if (is_array($category_ids)){
					foreach ($category_ids as $i => $id) {
						if (!is_numeric($id)){
							unset($category_ids[$i]);
						}
					}
				}
			}
			if (isset($category_ids) && count($category_ids)>0) $this->_addCategoryFilter2($collection, $category_ids);
								
			// Sort products in collection
			$dir = strtolower( $this->_config['product_order_dir'] );
			if (!in_array($dir, array('asc', 'desc'))){
				$dir = 'asc';
			}
			$attribute_to_sort = $this->_config['product_order_by'];
			switch ($attribute_to_sort){
				case 'name':
				case 'created_at':				
				case 'price':
					$collection->addAttributeToSort($attribute_to_sort, $dir);
					break;
				case 'position':
					break;
				case 'random':
					$collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
					break;
				case 'top_rating':
					$collection->getSelect()->order('sm_rating_summary desc');
					break;
				case 'most_reviewed':
					$collection->getSelect()->order('sm_reviews_count desc');
					break;
				case 'most_viewed':
					$collection->getSelect()->order('sm_views_count desc');
					break;
				case 'best_sales':
					$collection->getSelect()->order('sm_ordered_count desc');
					break;
			}
		//}
		// $product_limitation = intval($this->_config['product_limitation']);
		// if ($product_limitation>0){
			// $collection->setPageSize($product_limitation);
		// }
		return  $collection;
	}
	
	public function getProducts(){
		return $this->_getProducts();
	}
	
	public function getCategory(){
		$products = $this->_getProducts()->getItems();
		$product_limitation = intval($this->_config['product_limitation']);
		foreach( $products as $k => $_product ) {
			$tmp['id'] = $_product->getId();
			//$items[] = $tmp;
			foreach($this->_category as $cat=>$catItem){
				if(in_array($tmp['id'], $catItem['productIds'])){
					$tmp['title'] = $_product->getName();
					//$tmp['sub_title'] = Mage::helper('core/string')->truncate( $tmp['title'] , $this->_config['product_title_max_characters'],'...');
					$tmp['product_sub_title'] =	Mage::helper('core/string')->truncate( $tmp['title'] , $this->_config['product_title_max_characters'],'...');							
					$tmp['img'] = 'media/catalog/product'.$_product->getImage();
					$tmp['small_thumb'] = (string)Mage::helper('catalog/image')->init($_product, 'image')->resize($this->getConfig('product_normal_image_width'), $this->getConfig('product_normal_image_height'));
					$tmp['content'] = $_product->getShortDescription();
					//$tmp['thumb'] = (string)Mage::helper('catalog/image')->init($_product, 'image')->resize($this->getConfig('product_image_width'), $this->getConfig('product_image_height'));										
					$tmp['product_image'] =	(string)Mage::helper('catalog/image')->init($_product, 'image')->resize($this->getConfig('product_image_width'), $this->getConfig('product_image_height'));												
					//$tmp['sub_content'] = Mage::helper('core/string')->truncate( $tmp['content'] , $this->_config['product_description_max_characters'],'...');
					$tmp['product_content'] = Mage::helper('core/string')->truncate( $tmp['content'] , $this->_config['product_description_max_characters'],'...');
					$tmp['product_link'] = $_product->getProductUrl();	//$tmp['link'] = $_product->getProductUrl();
					//$tmp['price'] = $_product->getPrice();
					$tmp['price'] = Mage::helper('core')->currency($_product->getPrice(), true, false);
					$tmp['product_sku'] =""; //$tmp['product_sku'] = $_product->getSku();
					if((count($catItem['productList'])< $product_limitation) OR $product_limitation<=0){
						//Zend_Debug::dump($tmp);
						$this->_category[$cat]['productList'][] =  $tmp;
						//$catItem['productList'][] = $tmp;
					}
				}
			}
		}	
		//echo $this->getSkinUrl('smartaddons/categoryshowcase/images/no_image.gif');die;
		//Zend_Debug::dump($this->_category);die;
		return $this->_category;
	}
	public function getConfigObject(){
		return $this->_config;
		//return (object)$this->getConfig();
	}
	
	public function getScriptTags(){
		$import_str = "";
		$jsHelper = Mage::helper('core/js');
		if (null == Mage::registry('jsmart.jquery')){
			// jquery has not added yet
			if (Mage::getStoreConfigFlag('categoryshowcase_cfg/advanced/include_jquery')){
				// if module allowed jquery.
				$import_str .= $jsHelper->includeSkinScript('smartaddons/categoryshowcase/js/jquery-1.5.min.js');
				Mage::register('jsmart.jquery', 1);
			}
		}
		if (null == Mage::registry('jsmart.jquerynoconfict')){
			// add once noConflict
			$import_str .= $jsHelper->includeSkinScript('smartaddons/categoryshowcase/js/jsmart.noconflict.js');
			Mage::register('jsmart.jquerynoconfict', 1);
		}
		
		if (null == Mage::registry('jsmart.categoryshowcase.js')){
			// add script for this module.
			$import_str .= $jsHelper->includeSkinScript('smartaddons/categoryshowcase/js/jquery.cycle.all.js');
			
			Mage::register('jsmart.categoryshowcase.js', 1);
		}
		return $import_str;
	}
	
	private function _addCategoryFilter(& $collection, $category_ids){
		$category_collection = Mage::getModel('catalog/category')->getCollection();
		$category_collection->addAttributeToSelect('*');
		$category_collection->addIsActiveFilter();
		if (count($category_ids)>0){
			$category_collection->addIdFilter($category_ids);
		}
		$category_collection->getSelect()->group('entity_id');
		$category_products = array();
		foreach ($category_collection as $category){
			$cid = $category->getId();
			if (!array_key_exists( $cid, $category_products)){
				$category_products[$cid] = $category->getProductCollection()->getAllIds();
				//Mage::log("ID: " . $cid );
				//Mage::log("collection->count(): " . count($category_products[$cid]) );
			}			
		}
		$product_ids = array();
		if (count($category_products)){
			foreach ($category_products as $cp) {
				$product_ids = array_merge($product_ids, $cp);
			}
		}
		//Mage::log("merged_count: " . count($product_ids));
		$collection->addIdFilter($product_ids);
	}
	
	private function _addCategoryFilter2(& $collection, $category_ids){
		$category_collection = Mage::getModel('catalog/category')->getCollection();
		$category_collection->addAttributeToSelect('*');
		$category_collection->addIsActiveFilter();
		if (count($category_ids)>0){
			$category_collection->addIdFilter($category_ids);
		}
		$category_collection->getSelect()->group('entity_id');
		$category_products = array();
		$this->_category = array();
		foreach ($category_collection as $category){
			$cid = $category->getId();
			if (!array_key_exists( $cid, $category_products)){
				$category_products[$cid] = $category->getProductCollection()->getAllIds();
				//$image_category = (file_exists($category->getImageUrl()))?$category->getImageUrl():$this->getSkinUrl('smartaddons/categoryshowcase/images/no_image.gif');
				$this->_category[$cid] =array(
											'id' 				=> $cid,
											'sub_title'			=> $category->getName(),
											'link' 				=> $category->getUrl(),
											'thumb_image'		=> $this->_getResizedImage($category,$this->_config['category_image_width'],$this->_config['category_image_height'],100),//$image_category,
											'productIds'		=> $category_products[$cid],
											'productList'		=> array(),
										);
				//Mage::log("ID: " . $cid );
				//Mage::log("collection->count(): " . count($category_products[$cid]) );
			}			
		}
		
		$product_ids = array();
		if (count($category_products)){
			foreach ($category_products as $cp) {
				$product_ids = array_merge($product_ids, $cp);
			}
		}
		
		//Mage::log("merged_count: " . count($product_ids));
		$collection->addIdFilter($product_ids);
	}	
	private function _addViewsCount(& $collection, $views_count_alias="sm_views_count"){
		// add views_count
		$reports_event_table		= Mage::getSingleton('core/resource')->getTableName('reports/event');
		$reports_event_types_table 	= Mage::getSingleton('core/resource')->getTableName('reports/event_type');
		$collection->getSelect()
		->joinLeft(
			array("re_table" => $reports_event_table),
			"e.entity_id = re_table.object_id",
			array(
				$views_count_alias => "COUNT(re_table.event_id)"
			)
		)->joinLeft(
			array("ret_table" => $reports_event_types_table),
			"re_table.event_type_id = ret_table.event_type_id AND ret_table.event_name = 'catalog_product_view'",
			array()
		)->group('e.entity_id');
	}
	private function _addReviewsCount(& $collection, $reviews_count_alias="sm_reviews_count", $rating_summary_alias="sm_rating_summary" ){
		// add reviews_count and rating_summary
		$review_summary_table = Mage::getSingleton('core/resource')->getTableName('review/review_aggregate');
		$collection->getSelect()->joinLeft(
			array("rs_table" => $review_summary_table),
			"e.entity_id = rs_table.entity_pk_value AND rs_table.store_id=" . $this->getStoreId(),
			array(
				$reviews_count_alias  => "rs_table.reviews_count",
				$rating_summary_alias => "rs_table.rating_summary"
			)
		);
	}
	private function _addOrderedCount(& $collection, $ordered_qty_alias="sm_ordered_count"){
		$order_table = Mage::getSingleton('core/resource')->getTableName('sales/order');
		$read = Mage::getSingleton('core/resource')->getConnection ('core_read');
		$orders_active_query = $read->select()->from(array("o_table"=>$order_table), 'o_table.entity_id')->where("o_table.state<>'" . Mage_Sales_Model_Order::STATE_CANCELED . "'");
		
		$order_item_table = Mage::getSingleton('core/resource')->getTableName('sales/order_item');		
		$collection->getSelect()->joinLeft(
			array("oi_table" => $order_item_table),
			"e.entity_id=oi_table.item_id AND oi_table.order_id IN ($orders_active_query)",
			array(
				$ordered_qty_alias => "SUM(oi_table.qty_ordered)"
			)
		);
	}
	private function _getResizedImage($catObj, $width, $height, $quality = 100) {
        if (! $catObj->getImage ())
            return $this->getSkinUrl('smartaddons/categoryshowcase/images/no_image.gif');
        
        $imageUrl = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "category" . DS . $catObj->getImage ();
        if (! is_file ( $imageUrl ))
            return false;
        
        $imageResized = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS . $catObj->getImage ();// Because clean Image cache function works in this folder only
        if (! file_exists ( $imageResized ) && file_exists ( $imageUrl ) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) {
            $imageObj = new Varien_Image ( $imageUrl );
            $imageObj->constrainOnly ( false );
            $imageObj->keepAspectRatio ( false );
            $imageObj->keepFrame ( false );
            $imageObj->quality ( $quality );
            $imageObj->resize ( $width, $height );
            $imageObj->save ( $imageResized );
        }
        
        if(file_exists($imageResized)){
            return Mage::getBaseUrl ( 'media' ) ."/catalog/product/cache/cat_resized/" . $catObj->getImage ();
        }elseif(file_exists($catObj->getImageUrl())){
			return $catObj->getImageUrl();
		}else{
            return $this->getSkinUrl('smartaddons/categoryshowcase/images/no_image.gif');
        }
    
    } 	
}
