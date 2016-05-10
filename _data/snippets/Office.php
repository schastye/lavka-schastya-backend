id: 27
source: 1
name: Office
category: Office
properties: 'a:1:{s:6:"action";a:7:{s:4:"name";s:6:"action";s:4:"desc";s:18:"office_prop_action";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:4:"Auth";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}}'
static_file: core/components/office/elements/snippets/snippet.office.php

-----

/** @var array $scriptProperties */
/** @var Office $Office */
$Office = $modx->getService('office', 'Office', MODX_CORE_PATH . 'components/office/model/office/', $scriptProperties);

$output = null;
// We can change action to received via $_GET only if snippet was called with the same controller
if (!empty($_GET['action']) && !empty($action)) {
	$request = explode('/', strtolower(trim($_GET['action'])));
	$default = explode('/', strtolower(trim($action)));
	if ($request[0] == $default[0]) {
		$action = $_GET['action'];
		$scriptProperties = array_merge($_REQUEST, $scriptProperties);
	}
}

if (!empty($action)) {
	$Office->initialize($modx->context->key, $scriptProperties);
	$output = $Office->loadAction($action, $scriptProperties);
}

return $output;