id: 31
source: 1
name: officeRemoteServer
category: Office
properties: 'a:3:{s:5:"hosts";a:7:{s:4:"name";s:5:"hosts";s:4:"desc";s:17:"office_prop_hosts";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:3:"key";a:7:{s:4:"name";s:3:"key";s:4:"desc";s:15:"office_prop_key";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:6:"authId";a:7:{s:4:"name";s:6:"authId";s:4:"desc";s:18:"office_prop_authId";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}}'
static_file: core/components/office/elements/snippets/snippet.office.remote_server.php

-----

/** @var array $scriptProperties */
$scriptProperties['action'] = 'Remote/Auth';

/** @var modSnippet $snippet */
if ($snippet = $modx->getObject('modSnippet', array('name' => 'Office'))) {
	$snippet->_cacheable = false;
	$snippet->_processed = false;

	return $snippet->process($scriptProperties);
}