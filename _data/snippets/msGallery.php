id: 22
source: 1
name: msGallery
category: miniShop2
properties: 'a:14:{s:7:"product";a:7:{s:4:"name";s:7:"product";s:4:"desc";s:16:"ms2_prop_product";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:6:"tplRow";a:7:{s:4:"name";s:6:"tplRow";s:4:"desc";s:15:"ms2_prop_tplRow";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:17:"tpl.msGallery.row";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:8:"tplOuter";a:7:{s:4:"name";s:8:"tplOuter";s:4:"desc";s:17:"ms2_prop_tplOuter";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:19:"tpl.msGallery.outer";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:8:"tplEmpty";a:7:{s:4:"name";s:8:"tplEmpty";s:4:"desc";s:17:"ms2_prop_tplEmpty";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:19:"tpl.msGallery.empty";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:9:"tplSingle";a:7:{s:4:"name";s:9:"tplSingle";s:4:"desc";s:18:"ms2_prop_tplSingle";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:5:"limit";a:7:{s:4:"name";s:5:"limit";s:4:"desc";s:14:"ms2_prop_limit";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:100;s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:6:"offset";a:7:{s:4:"name";s:6:"offset";s:4:"desc";s:15:"ms2_prop_offset";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:6:"sortby";a:7:{s:4:"name";s:6:"sortby";s:4:"desc";s:15:"ms2_prop_sortby";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:4:"rank";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:7:"sortdir";a:7:{s:4:"name";s:7:"sortdir";s:4:"desc";s:16:"ms2_prop_sortdir";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"text";s:3:"ASC";s:5:"value";s:3:"ASC";}i:1;a:2:{s:4:"text";s:4:"DESC";s:5:"value";s:4:"DESC";}}s:5:"value";s:3:"ASC";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:13:"toPlaceholder";a:7:{s:4:"name";s:13:"toPlaceholder";s:4:"desc";s:22:"ms2_prop_toPlaceholder";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:22:"toSeparatePlaceholders";a:7:{s:4:"name";s:22:"toSeparatePlaceholders";s:4:"desc";s:31:"ms2_prop_toSeparatePlaceholders";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:7:"showLog";a:7:{s:4:"name";s:7:"showLog";s:4:"desc";s:16:"ms2_prop_showLog";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:5:"where";a:7:{s:4:"name";s:5:"where";s:4:"desc";s:14:"ms2_prop_where";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}s:8:"filetype";a:7:{s:4:"name";s:8:"filetype";s:4:"desc";s:17:"ms2_prop_filetype";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}}'
static: 1
static_file: core/components/minishop2/elements/snippets/snippet.ms_gallery.php

-----

/** @var array $scriptProperties */
/** @var miniShop2 $miniShop2 */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->initialize($modx->context->key);
/** @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$extensionsDir = $modx->getOption('extensionsDir', $scriptProperties, 'components/minishop2/img/mgr/extensions/', true);

/** @var msProduct $product */
$product = (!empty($product) && $product != $modx->resource->id)
	? $modx->getObject('msProduct', $product)
	: $modx->resource;
if (!$product || !($product instanceof msProduct)) {return 'This resource is not instance of msProduct class.';}

/** @var msProductData $data */
$resolution = array();
if ($data = $product->getOne('Data')) {
	$data->initializeMediaSource();
	$properties = $data->mediaSource->getProperties();
	if (isset($properties['thumbnails']['value'])) {
		$fileTypes = json_decode($properties['thumbnails']['value'], true);
		foreach ($fileTypes as $v) {
			$resolution[] = $v['w'].'x'.$v['h'];
		}
	}
}

if (empty($limit)) {$limit = 100;}
$where = array(
	'product_id' => $product->get('id'),
	'parent' => 0,
);
if (!empty($filetype)) {
	$where['type:IN'] = array_map('trim', explode(',', $filetype));
}
// processing additional query params
if (!empty($scriptProperties['where'])) {
	$tmp = json_decode($scriptProperties['where'], true);
	if (is_array($tmp) && !empty($tmp)) {
		$where = array_merge($where, $tmp);
	}
}
unset($scriptProperties['where']);

// Default parameters
$default = array(
	'class' => 'msProductFile'
	,'where' => json_encode($where)
	,'select' => '{"msProductFile":"all"}'
	,'limit' => $limit
	,'sortby' => 'rank'
	,'sortdir' => 'ASC'
	,'fastMode' => false
	,'return' => 'data'
	,'nestedChunkPrefix' => 'minishop2_'
);

// Merge all properties and run!
$scriptProperties['tpl'] = !empty($tplRow) ? $tplRow : '';
$pdoFetch->setConfig(array_merge($default, $scriptProperties));
$rows = $pdoFetch->run();

// Processing rows
$output = null; $images = array();

$pdoFetch->addTime('Fetching thumbnails');
foreach ($rows as $k => $row) {
	$row['idx'] = $pdoFetch->idx++;
	$images[$row['id']] = $row;

	if (isset($row['type']) && $row['type'] == 'image') {
		$q = $modx->newQuery('msProductFile', array('parent' => $row['id']));
		$q->select('url');
		if ($q->prepare() && $q->stmt->execute()) {
			while ($url = $q->stmt->fetch(PDO::FETCH_COLUMN)) {
				$tmp = parse_url($url);
				if (preg_match('/((?:\d{1,4}|)x(?:\d{1,4}|))/', $tmp['path'], $size)) {
					$images[$row['id']][$size[0]] = $url;
				}
			}
		}
	}
	elseif (isset($row['type'])) {
		$row['thumbnail'] = $row['url'] =  (file_exists(MODX_ASSETS_PATH . $extensionsDir . $row['type'] . '.png'))
			? MODX_ASSETS_URL . $extensionsDir . $row['type'].'.png'
			: MODX_ASSETS_URL . $extensionsDir . 'other.png';
		foreach ($resolution as $v) {
			$images[$row['id']][$v] = $row['thumbnail'];
		}
	}
}

// Processing chunks
$pdoFetch->addTime('Processing chunks');
$output = array();
foreach ($images as $row) {
	$tpl = $pdoFetch->defineChunk($row);
	$output[] = empty($tpl)
		? $pdoFetch->getChunk('', $row)
		: $pdoFetch->getChunk($tpl, $row, $pdoFetch->config['fastMode']);
}
$pdoFetch->addTime('Returning processed chunks');

// Return output
$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$log .= '<pre class="msGalleryLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

if (!empty($toSeparatePlaceholders)) {
	$output['log'] = $log;
	$modx->setPlaceholders($output, $toSeparatePlaceholders);
}
else {
	if (count($output) === 1 && !empty($tplSingle)) {
		$output = $pdoFetch->getChunk($tplSingle, array_shift($images));
	}
	else {
		if (empty($outputSeparator)) {$outputSeparator = "\n";}
		$output = implode($outputSeparator, $output);

		if (!empty($tplOuter) && !empty($output)) {
			$arr = array_shift($images);
			$arr['rows'] = $output;
			$output = $pdoFetch->getChunk($tplOuter, $arr);
		}
		elseif (empty($output)) {
			$output = !empty($tplEmpty)
				? $pdoFetch->getChunk($tplEmpty)
				: '';
		}
	}

	$output .= $log;
	if (!empty($toPlaceholder)) {
		$modx->setPlaceholder($toPlaceholder, $output);
	}
	else {
		return $output;
	}
}