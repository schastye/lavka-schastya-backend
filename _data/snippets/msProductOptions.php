id: 26
source: 1
name: msProductOptions
category: miniShop2
properties: "a:9:{s:7:\"product\";a:7:{s:4:\"name\";s:7:\"product\";s:4:\"desc\";s:16:\"ms2_prop_product\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:6:\"tplRow\";a:7:{s:4:\"name\";s:6:\"tplRow\";s:4:\"desc\";s:15:\"ms2_prop_tplRow\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:24:\"tpl.msProductOptions.row\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:8:\"tplOuter\";a:7:{s:4:\"name\";s:8:\"tplOuter\";s:4:\"desc\";s:17:\"ms2_prop_tplOuter\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:26:\"tpl.msProductOptions.outer\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:15:\"valuesSeparator\";a:7:{s:4:\"name\";s:15:\"valuesSeparator\";s:4:\"desc\";s:24:\"ms2_prop_valuesSeparator\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:2:\", \";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:15:\"outputSeparator\";a:7:{s:4:\"name\";s:15:\"outputSeparator\";s:4:\"desc\";s:24:\"ms2_prop_outputSeparator\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:1:\"\n\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:13:\"ignoreOptions\";a:7:{s:4:\"name\";s:13:\"ignoreOptions\";s:4:\"desc\";s:22:\"ms2_prop_ignoreOptions\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:9:\"hideEmpty\";a:7:{s:4:\"name\";s:9:\"hideEmpty\";s:4:\"desc\";s:18:\"ms2_prop_hideEmpty\";s:4:\"type\";s:13:\"combo-boolean\";s:7:\"options\";a:0:{}s:5:\"value\";b:0;s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:6:\"groups\";a:7:{s:4:\"name\";s:6:\"groups\";s:4:\"desc\";s:15:\"ms2_prop_groups\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:8:\"tplValue\";a:7:{s:4:\"name\";s:8:\"tplValue\";s:4:\"desc\";s:17:\"ms2_prop_tplValue\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:18:\"@INLINE [[+value]]\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}}"
static: 1
static_file: core/components/minishop2/elements/snippets/snippet.ms_product_options.php

-----

/** @var array $scriptProperties */
/** @var miniShop2 $miniShop2 */
$miniShop2 = $modx->getService('miniShop2');
$miniShop2->initialize($modx->context->key);

/** @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$output = '';

if (empty($product) && !empty($input)) {$product = $input;}
if (empty($outputSeparator)) {$outputSeparator = "\n";}
$options = explode(",",$modx->getOption('options',$scriptProperties,''));

$product = !empty($product) ? $modx->getObject('msProduct', $product) : $product = $modx->resource;
if (!($product instanceof msProduct)) {
    $output = 'This resource is not instance of msProduct class.';
}

$optionKeys = $product->getOptionKeys();
$productData = $product->toArray();

$ignoreOptions = explode(',', trim($modx->getOption('ignoreOptions', $scriptProperties, '')));

if (!empty($groups)) {
    $groups = explode(',', trim($groups));
    $groups = array_map('trim', $groups);
} else if ($groups === '0') {
    $groups = array(0);
}

$rows = array();
if(count($optionKeys) > 0) {
    foreach ($optionKeys as $key) {
        if (in_array($key, $ignoreOptions)) continue;
        $productOption = array();
        foreach ($productData as $dataKey => $dataValue) {
            $dataKey = explode('.', $dataKey);
            if ($dataKey[0] == $key && (count($dataKey) > 1)) {
                $productOption[$dataKey[1]] = $dataValue;
            }
        }

        // Пропускаем, если характеристика группы не указана в параметре &groups
        if (!empty($groups) && !in_array($productOption['category'], $groups) && !in_array($productOption['category_name'], $groups)) continue;
        if (isset($groups[0]) && ($groups[0] == 0) && ($productOption['category'] != 0)) continue;

        if (is_array($productData[$key])) {
            $values = array();
            foreach ($productData[$key] as $value) {
                $params = array_merge($productData, $productOption, array('value' => $value));
                $values[] = $pdoFetch->getChunk($tplValue, $params);
            }
            $productOption['value'] = implode($valuesSeparator, $values);
        } else {
            $productOption['value'] = $productData[$key];
        }

        // Пропускаем, если значение пустое
        if ($hideEmpty && empty($productOption['value'])) continue;

        $rows[] = $pdoFetch->getChunk($tplRow, array_merge($productData, $productOption));
    }
}

if (count($rows) > 0) {
    $rows = implode($outputSeparator, $rows);
    $output = empty($tplOuter)
        ? $pdoFetch->getChunk('', array_merge($productData, array('rows' => $rows)))
        : $pdoFetch->getChunk($tplOuter, array_merge($scriptProperties, $productData, array('rows' => $rows)));
}
else{
    $output = !empty($tplEmpty)
        ? $pdoFetch->getChunk($tplEmpty, array_merge($scriptProperties, $productData))
        : '';
}

return $output;