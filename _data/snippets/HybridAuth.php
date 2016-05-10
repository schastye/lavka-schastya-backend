id: 33
source: 1
name: HybridAuth
description: 'Social authorization'
category: HybridAuth
properties: 'a:12:{s:9:"providers";a:7:{s:4:"name";s:9:"providers";s:4:"desc";s:12:"ha.providers";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:10:"rememberme";a:7:{s:4:"name";s:10:"rememberme";s:4:"desc";s:13:"ha.rememberme";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:8:"loginTpl";a:7:{s:4:"name";s:8:"loginTpl";s:4:"desc";s:11:"ha.loginTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:20:"tpl.HybridAuth.login";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:9:"logoutTpl";a:7:{s:4:"name";s:9:"logoutTpl";s:4:"desc";s:12:"ha.logoutTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:21:"tpl.HybridAuth.logout";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:11:"providerTpl";a:7:{s:4:"name";s:11:"providerTpl";s:4:"desc";s:14:"ha.providerTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:23:"tpl.HybridAuth.provider";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:17:"activeProviderTpl";a:7:{s:4:"name";s:17:"activeProviderTpl";s:4:"desc";s:20:"ha.activeProviderTpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:30:"tpl.HybridAuth.provider.active";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:6:"groups";a:7:{s:4:"name";s:6:"groups";s:4:"desc";s:9:"ha.groups";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:12:"loginContext";a:7:{s:4:"name";s:12:"loginContext";s:4:"desc";s:15:"ha.loginContext";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:11:"addContexts";a:7:{s:4:"name";s:11:"addContexts";s:4:"desc";s:14:"ha.addContexts";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:15:"loginResourceId";a:7:{s:4:"name";s:15:"loginResourceId";s:4:"desc";s:18:"ha.loginResourceId";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:16:"logoutResourceId";a:7:{s:4:"name";s:16:"logoutResourceId";s:4:"desc";s:19:"ha.logoutResourceId";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}s:11:"redirectUri";a:7:{s:4:"name";s:11:"redirectUri";s:4:"desc";s:14:"ha.redirectUri";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:21:"hybridauth:properties";s:4:"area";s:0:"";}}'
static_file: core/components/hybridauth/elements/snippets/snippet.hybridauth.php

-----

/** @var array $scriptProperties */

$modx->error->message = null;
if (!$modx->loadClass('hybridauth', MODX_CORE_PATH . 'components/hybridauth/model/hybridauth/', false, true)) {
	return;
}
$HybridAuth = new HybridAuth($modx, $scriptProperties);
$HybridAuth->initialize($modx->context->key);

if ($modx->error->hasError()) {
	return $modx->error->message;
}
// For compatibility with old snippet
elseif (!empty($action)) {
	$tmp = strtolower($action);
	if ($tmp == 'getprofile' || $tmp == 'updateprofile') {
		return $modx->runSnippet('haProfile', $scriptProperties);
	}
}

if (empty($loginTpl)) {
	$loginTpl = 'tpl.HybridAuth.login';
}
if (empty($logoutTpl)) {
	$logoutTpl = 'tpl.HybridAuth.logout';
}
if (empty($providerTpl)) {
	$providerTpl = 'tpl.HybridAuth.provider';
}
if (empty($activeProviderTpl)) {
	$activeProviderTpl = 'tpl.HybridAuth.provider.active';
}

$url = $HybridAuth->getUrl();
$error = '';
if (!empty($_SESSION['HA']['error'])) {
	$error = $_SESSION['HA']['error'];
	unset($_SESSION['HA']['error']);
}

if ($modx->user->isAuthenticated($modx->context->key)) {
	$add = array();
	if ($services = $modx->user->getMany('Services')) {
		/* @var haUserService $service */
		foreach ($services as $service) {
			$add = array_merge($add, $service->toArray(strtolower($service->get('provider') . '.')));
		}
	}

	$user = $modx->user->toArray();
	$profile = $modx->user->Profile->toArray();
	unset($profile['id']);
	$arr = array_merge(
		$user,
		$profile,
		$add,
		array(
			'login_url' => $url . 'login',
			'logout_url' => $url . 'logout',
			'providers' => $HybridAuth->getProvidersLinks($providerTpl, $activeProviderTpl),
			'error' => $error,
			'gravatar' => 'https://gravatar.com/avatar/' . md5(strtolower($profile['email'])),
		)
	);

	return $modx->getChunk($logoutTpl, $arr);
}
else {
	$arr = array(
		'login_url' => $url . 'login',
		'logout_url' => $url . 'logout',
		'providers' => $HybridAuth->getProvidersLinks($providerTpl, $activeProviderTpl),
		'error' => $error,
	);

	return $modx->getChunk($loginTpl, $arr);
}