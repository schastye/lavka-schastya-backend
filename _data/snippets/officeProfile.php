id: 28
source: 1
name: officeProfile
category: Office
properties: 'a:10:{s:10:"tplProfile";a:7:{s:4:"name";s:10:"tplProfile";s:4:"desc";s:22:"office_prop_tplProfile";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:23:"tpl.Office.profile.form";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:11:"tplActivate";a:7:{s:4:"name";s:11:"tplActivate";s:4:"desc";s:23:"office_prop_tplActivate";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:27:"tpl.Office.profile.activate";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:13:"profileFields";a:7:{s:4:"name";s:13:"profileFields";s:4:"desc";s:25:"office_prop_profileFields";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:161:"username:50,email:50,fullname:50,phone:12,mobilephone:12,dob:10,gender,address,country,city,state,zip,fax,photo,comment,website,specifiedpassword,confirmpassword";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:14:"requiredFields";a:7:{s:4:"name";s:14:"requiredFields";s:4:"desc";s:26:"office_prop_requiredFields";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:23:"username,email,fullname";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:10:"HybridAuth";a:7:{s:4:"name";s:10:"HybridAuth";s:4:"desc";s:22:"office_prop_HybridAuth";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:9:"providers";a:7:{s:4:"name";s:9:"providers";s:4:"desc";s:21:"office_prop_providers";s:4:"type";s:0:"";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:11:"providerTpl";a:7:{s:4:"name";s:11:"providerTpl";s:4:"desc";s:23:"office_prop_providerTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:23:"tpl.HybridAuth.provider";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:17:"activeProviderTpl";a:7:{s:4:"name";s:17:"activeProviderTpl";s:4:"desc";s:29:"office_prop_activeProviderTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:30:"tpl.HybridAuth.provider.active";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:12:"avatarParams";a:7:{s:4:"name";s:12:"avatarParams";s:4:"desc";s:24:"office_prop_avatarParams";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:48:"{"w":200,"h":200,"zc":0,"bg":"ffffff","f":"jpg"}";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}s:10:"avatarPath";a:7:{s:4:"name";s:10:"avatarPath";s:4:"desc";s:22:"office_prop_avatarPath";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:13:"images/users/";s:7:"lexicon";s:17:"office:properties";s:4:"area";s:0:"";}}'
static_file: core/components/office/elements/snippets/snippet.office.profile.php

-----

/** @var array $scriptProperties */
$scriptProperties['action'] = 'Profile';

/** @var modSnippet $snippet */
if ($snippet = $modx->getObject('modSnippet', array('name' => 'Office'))) {
	$snippet->_cacheable = false;
	$snippet->_processed = false;

	return $snippet->process($scriptProperties);
}