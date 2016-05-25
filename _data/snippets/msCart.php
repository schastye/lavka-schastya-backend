id: 20
source: 1
name: msCart
category: miniShop2
properties: 'a:5:{s:6:"tplRow";a:7:{s:4:"name";s:6:"tplRow";s:4:"desc";s:15:"ms2_prop_tplRow";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:14:"tpl.msCart.row";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:8:"tplOuter";a:7:{s:4:"name";s:8:"tplOuter";s:4:"desc";s:17:"ms2_prop_tplOuter";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:16:"tpl.msCart.outer";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:8:"tplEmpty";a:7:{s:4:"name";s:8:"tplEmpty";s:4:"desc";s:17:"ms2_prop_tplEmpty";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:16:"tpl.msCart.empty";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:10:"includeTVs";a:7:{s:4:"name";s:10:"includeTVs";s:4:"desc";s:19:"ms2_prop_includeTVs";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:13:"includeThumbs";a:7:{s:4:"name";s:13:"includeThumbs";s:4:"desc";s:22:"ms2_prop_includeThumbs";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}}'
static: 1
static_file: core/components/minishop2/elements/snippets/snippet.ms_cart.php

-----

/** @var array $scriptProperties */
/** @var miniShop2 $miniShop2 */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->initialize($modx->context->key);
/** @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$cart = $miniShop2->cart->get();
$status = $miniShop2->cart->status();
if (!empty($_GET['msorder'])) {
	return '';
}
elseif (empty($status['total_count'])) {
	return !empty($tplEmpty) ? $pdoFetch->getChunk($tplEmpty) : '';
}

// Include Thumbnails
$thumbsLeftJoin = '';
$thumbsSelect = array();
if (!empty($includeThumbs)) {
	$thumbs = array_map('trim',explode(',',$includeThumbs));
	if(!empty($thumbs[0])){
		foreach ($thumbs as $thumb) {
			$thumbsLeftJoin .= ',{"class":"msProductFile","alias":"'.$thumb.'","on":"'.$thumb.'.product_id = msProduct.id AND '.$thumb.'.parent != 0 AND '.$thumb.'.path LIKE \'%/'.$thumb.'/\'"}';
			$thumbsSelect[] = ' "'.$thumb.'":"'.$thumb.'.url as '.$thumb.'" ';
		}
		$pdoFetch->addTime('Included list of thumbnails: <b>'.implode(', ',$thumbs).'</b>.');
	}
}
// End of including Thumbnails

// Fields to select
$resourceColumns = !empty($includeContent) ?  $modx->getSelectColumns('msProduct', 'msProduct') : $modx->getSelectColumns('msProduct', 'msProduct', '', array('content'), true);
$dataColumns = $modx->getSelectColumns('msProductData', 'Data', '', array('id'), true);
$vendorColumns = $modx->getSelectColumns('msVendor', 'Vendor', 'vendor.', array('id'), true);

// Tables for joining
$leftJoin = '{"class":"msProductData","alias":"Data","on":"msProduct.id=Data.id"},{"class":"msVendor","alias":"Vendor","on":"Data.vendor=Vendor.id"}';
if (!empty($thumbsLeftJoin)) {$leftJoin .= $thumbsLeftJoin;}
$select = '"msProduct":"'.$resourceColumns.'","Data":"'.$dataColumns.'","Vendor":"'.$vendorColumns.'"';
if (!empty($thumbsSelect)) {$select .= ','.implode(',', $thumbsSelect);}
$pdoFetch->addTime('Query parameters are prepared.');

$scriptProperties['tpl'] = $scriptProperties['tplRow'];
$pdoFetch->setConfig($scriptProperties);

// Working
$outer = array('goods' => '', 'total_count' => 0, 'total_weight' => 0, 'total_cost' => 0);
foreach ($cart as $k => $v) {

	$default = array(
		'class' => 'msProduct'
		,'where' => '{"msProduct.id":"'.$v['id'].'","class_key":"msProduct"}'
		,'leftJoin' => '['.$leftJoin.']'
		,'select' => '{'.$select.'}'
		,'sortby' => 'id'
		,'sortdir' => 'ASC'
		,'groupby' => 'msProduct.id'
		,'fastMode' => false
		,'limit' => 0
		,'return' => 'data'
		,'nestedChunkPrefix' => 'minishop2_'
	);
	// Merge all properties and run!
	$pdoFetch->config = array_merge($pdoFetch->config, $default, $scriptProperties);
	$rows = $pdoFetch->run();

	// If not empty and relevant to the context, then show
	if (!empty($rows[0]) && (empty($v['ctx']) || $v['ctx'] == $modx->context->key)) {
		$row = $rows[0];
		$row['key'] = $k;
		$row['count'] = $v['count'];
		$row['old_price'] = $miniShop2->formatPrice(
			$row['price'] != $v['price']
				? $row['price']
				: $row['old_price']
		);
		$row['price'] = $miniShop2->formatPrice($v['price']);
		$row['weight'] = $miniShop2->formatWeight($v['weight']);
		$row['cost'] = $miniShop2->formatPrice($v['count'] * $v['price']);

		// Additional properties of product
		if (!empty($v['options']) && is_array($v['options'])) {
			foreach ($v['options'] as $key => $value) {
				$row['option.'.$key] = $value;
			}
		}
		unset($v['options']);

        // Add option values
        $options = $modx->call('msProductData', 'loadOptions', array(&$modx, $row['id']));
        $row = array_merge($row, $options);

		$row['idx'] = $pdoFetch->idx++;
		$tplRow = $pdoFetch->defineChunk($row);
		$outer['goods'] .= empty($tplRow)
			? $pdoFetch->getChunk('', $row)
			: $pdoFetch->getChunk($tplRow, $row, $pdoFetch->config['fastMode']);

		$outer['total_count'] += $v['count'];
		$outer['total_cost'] +=  $v['count'] * $v['price'];
		$outer['total_weight'] += $v['count'] * $v['weight'];
	}
}

$outer['total_cost'] = $miniShop2->formatPrice($outer['total_cost']);
$outer['total_weight'] = $miniShop2->formatWeight($outer['total_weight']);

return empty($tplOuter)
	? $pdoFetch->getChunk('', $outer)
	: $pdoFetch->getChunk($tplOuter, $outer, $pdoFetch->config['fastMode']);