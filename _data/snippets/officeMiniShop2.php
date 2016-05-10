id: 32
source: 1
name: officeMiniShop2
category: Office
properties: 'a:0:{}'
static_file: core/components/office/elements/snippets/snippet.office.minishop2.php

-----

/** @var array $scriptProperties */
$scriptProperties['action'] = 'miniShop2';

/** @var modSnippet $snippet */
if ($snippet = $modx->getObject('modSnippet', array('name' => 'Office'))) {
	$snippet->_cacheable = false;
	$snippet->_processed = false;

	return $snippet->process($scriptProperties);
}