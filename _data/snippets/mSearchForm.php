id: 36
source: 1
name: mSearchForm
category: mSearch2
properties: 'a:10:{s:6:"pageId";a:7:{s:4:"name";s:6:"pageId";s:4:"desc";s:16:"mse2_prop_pageId";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:7:"tplForm";a:7:{s:4:"name";s:7:"tplForm";s:4:"desc";s:17:"mse2_prop_tplForm";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:17:"tpl.mSearch2.form";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:3:"tpl";a:7:{s:4:"name";s:3:"tpl";s:4:"desc";s:13:"mse2_prop_tpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:15:"tpl.mSearch2.ac";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:7:"element";a:7:{s:4:"name";s:7:"element";s:4:"desc";s:17:"mse2_prop_element";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:8:"mSearch2";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:5:"limit";a:7:{s:4:"name";s:5:"limit";s:4:"desc";s:15:"mse2_prop_limit";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:5;s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:12:"autocomplete";a:7:{s:4:"name";s:12:"autocomplete";s:4:"desc";s:22:"mse2_prop_autocomplete";s:4:"type";s:4:"list";s:7:"options";a:3:{i:0;a:2:{s:4:"text";s:8:"Disabled";s:5:"value";i:0;}i:1;a:2:{s:4:"text";s:7:"Results";s:5:"value";s:7:"results";}i:2;a:2:{s:4:"text";s:7:"Queries";s:5:"value";s:7:"queries";}}s:5:"value";s:7:"results";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:8:"queryVar";a:7:{s:4:"name";s:8:"queryVar";s:4:"desc";s:18:"mse2_prop_queryVar";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:5:"query";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:8:"minQuery";a:7:{s:4:"name";s:8:"minQuery";s:4:"desc";s:18:"mse2_prop_minQuery";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";i:3;s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:6:"fields";a:7:{s:4:"name";s:6:"fields";s:4:"desc";s:16:"mse2_prop_fields";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}s:9:"onlyIndex";a:7:{s:4:"name";s:9:"onlyIndex";s:4:"desc";s:19:"mse2_prop_onlyIndex";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:0;s:7:"lexicon";s:19:"msearch2:properties";s:4:"area";s:0:"";}}'
static_file: core/components/msearch2/elements/snippets/snippet.msearchform.php

-----

/** @var array $scriptProperties */
/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');
$pdoTools->setConfig($scriptProperties);
$pdoTools->addTime('pdoTools loaded.');

/** @var mSearch2 $mSearch2 */
if (!$modx->loadClass('msearch2', MODX_CORE_PATH . 'components/msearch2/model/msearch2/', false, true)) {return false;}
$mSearch2 = new mSearch2($modx, array(), $pdoFetch);
$mSearch2->initialize($modx->context->key);

$config = array(
	'autocomplete' => !empty($autocomplete) ? $autocomplete : '',
	'queryVar' => !empty($queryVar) ? $queryVar : 'query',
	'minQuery' => !empty($minQuery) ? (integer) $minQuery : 3,
	'pageId' => !empty($pageId) ? (integer) $pageId : $modx->resource->id,
);
$scriptProperties = array_merge($scriptProperties, $config);

if (empty($tplForm)) {$tplForm = 'tpl.mSearch2.form';}
$form = $pdoTools->getChunk($tplForm, $scriptProperties);

if (!empty($config['autocomplete'])) {
	$hash = sha1(serialize($scriptProperties));
	$_SESSION['mSearch2'][$hash] = $scriptProperties;

	$form = str_ireplace('<form', '<form data-key="'.$hash.'"', $form);
	// Place for enabled log
	if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
		$form = str_ireplace('</form>', "</form>\n<pre class=\"mSearchFormLog\"></pre>", $form);
	}

	// Setting values for frontend javascript
	$main_config = array(
		'cssUrl' => $mSearch2->config['cssUrl'].'web/',
		'jsUrl' => $mSearch2->config['jsUrl'].'web/',
		'actionUrl' => $mSearch2->config['actionUrl'],
	);

	$modx->regClientStartupScript('
	<script type="text/javascript">
		if (typeof mse2Config == "undefined") {mse2Config = ' . $modx->toJSON($main_config) . ';}
		if (typeof mse2FormConfig == "undefined") {mse2FormConfig = {};}
		mse2FormConfig["' . $hash . '"] = ' . $modx->toJSON($config) . ';
	</script>', true);
	$modx->regClientScript('
	<script type="text/javascript">
		if ($("form.msearch2").length) {
			mSearch2.Form.initialize("form.msearch2");
		}
	</script>', true);
}

return $form;