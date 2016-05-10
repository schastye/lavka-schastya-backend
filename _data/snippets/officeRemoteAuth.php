id: 30
source: 1
name: officeRemoteAuth
category: Office
properties: 'a:12:{s:8:"tplLogin";a:7:{s:4:"name";s:8:"tplLogin";s:4:"desc";s:20:"office_prop_tplLogin";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:23:"tpl.Office.remote.login";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:9:"tplLogout";a:7:{s:4:"name";s:9:"tplLogout";s:4:"desc";s:21:"office_prop_tplLogout";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:24:"tpl.Office.remote.logout";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:6:"groups";a:7:{s:4:"name";s:6:"groups";s:4:"desc";s:18:"office_prop_groups";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:10:"rememberme";a:7:{s:4:"name";s:10:"rememberme";s:4:"desc";s:22:"office_prop_rememberme";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:12:"loginContext";a:7:{s:4:"name";s:12:"loginContext";s:4:"desc";s:24:"office_prop_loginContext";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:11:"addContexts";a:7:{s:4:"name";s:11:"addContexts";s:4:"desc";s:23:"office_prop_addContexts";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:15:"loginResourceId";a:7:{s:4:"name";s:15:"loginResourceId";s:4:"desc";s:27:"office_prop_loginResourceId";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:16:"logoutResourceId";a:7:{s:4:"name";s:16:"logoutResourceId";s:4:"desc";s:28:"office_prop_logoutResourceId";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:10:"updateUser";a:7:{s:4:"name";s:10:"updateUser";s:4:"desc";s:22:"office_prop_updateUser";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:10:"createUser";a:7:{s:4:"name";s:10:"createUser";s:4:"desc";s:22:"office_prop_createUser";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:6:"remote";a:7:{s:4:"name";s:6:"remote";s:4:"desc";s:18:"office_prop_remote";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:3:"key";a:7:{s:4:"name";s:3:"key";s:4:"desc";s:15:"office_prop_key";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}}'
static_file: core/components/office/elements/snippets/snippet.office.remote_auth.php

-----

/** @var array $scriptProperties */
$scriptProperties['action'] = 'Remote';

/** @var modSnippet $snippet */
if ($snippet = $modx->getObject('modSnippet', array('name' => 'Office'))) {
	$snippet->_cacheable = false;
	$snippet->_processed = false;

	return $snippet->process($scriptProperties);
}