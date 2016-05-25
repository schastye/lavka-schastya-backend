id: 21
source: 1
name: msMiniCart
category: miniShop2
properties: 'a:1:{s:3:"tpl";a:7:{s:4:"name";s:3:"tpl";s:4:"desc";s:12:"ms2_prop_tpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:14:"tpl.msMiniCart";s:7:"lexicon";s:20:"minishop2:properties";s:4:"area";s:0:"";}}'
static: 1
static_file: core/components/minishop2/elements/snippets/snippet.ms_minicart.php

-----

/** @var miniShop2 $miniShop2 */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->initialize($modx->context->key);

$cart = $miniShop2->cart->status();
$cart['total_cost'] = $miniShop2->formatPrice($cart['total_cost']);
$cart['total_weight'] = $miniShop2->formatWeight($cart['total_weight']);

return !empty($tpl) ? $modx->getChunk($tpl, $cart) : print_r($cart,1);