id: 23
source: 1
name: msOptions
category: miniShop2
properties: "a:7:{s:7:\"product\";a:7:{s:4:\"name\";s:7:\"product\";s:4:\"desc\";s:16:\"ms2_prop_product\";s:4:\"type\";s:11:\"numberfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:6:\"tplRow\";a:7:{s:4:\"name\";s:6:\"tplRow\";s:4:\"desc\";s:15:\"ms2_prop_tplRow\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:17:\"tpl.msOptions.row\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:8:\"tplOuter\";a:7:{s:4:\"name\";s:8:\"tplOuter\";s:4:\"desc\";s:17:\"ms2_prop_tplOuter\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:19:\"tpl.msOptions.outer\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:8:\"tplEmpty\";a:7:{s:4:\"name\";s:8:\"tplEmpty\";s:4:\"desc\";s:17:\"ms2_prop_tplEmpty\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:4:\"name\";a:7:{s:4:\"name\";s:4:\"name\";s:4:\"desc\";s:13:\"ms2_prop_name\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:8:\"selected\";a:7:{s:4:\"name\";s:8:\"selected\";s:4:\"desc\";s:17:\"ms2_prop_selected\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:0:\"\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}s:15:\"outputSeparator\";a:7:{s:4:\"name\";s:15:\"outputSeparator\";s:4:\"desc\";s:24:\"ms2_prop_outputSeparator\";s:4:\"type\";s:9:\"textfield\";s:7:\"options\";a:0:{}s:5:\"value\";s:1:\"\n\";s:7:\"lexicon\";s:20:\"minishop2:properties\";s:4:\"area\";s:0:\"\";}}"
static: 1
static_file: core/components/minishop2/elements/snippets/snippet.ms_options.php

-----

/** @var array $scriptProperties */
/** @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

if (empty($product) && !empty($input)) {$product = $input;}
if (empty($selected)) {$selected = '';}
if (empty($outputSeparator)) {$outputSeparator = "\n";}
if ((empty($name) || $name == 'id') && !empty($options)) {$name = $options;}

$output = '';
$product = !empty($product) ? $modx->getObject('msProduct', $product) : $product = $modx->resource;
if (!($product instanceof msProduct)) {
	$output = 'This resource is not instance of msProduct class.';
}
elseif (!empty($name) && $options = $product->get($name)) {
    if (!is_array($options)) {
        $options = array($options);
    }
	if ($options[0] == '') {
		$output = !empty($tplEmpty)
			? $pdoFetch->getChunk($tplEmpty, $scriptProperties)
			: '';
	}
	else {
		$rows = array();
		foreach ($options as $value) {
			$pls = array(
				'value' => $value
				,'selected' => $value == $selected ? 'selected' : ''
			);
			$rows[] = empty($tplRow) ? $value : $pdoFetch->getChunk($tplRow, $pls);
		}

		$rows = implode($outputSeparator, $rows);
		$output = empty($tplOuter)
			? $pdoFetch->getChunk('', array('name' => $name, 'rows' => $rows))
			: $pdoFetch->getChunk($tplOuter, array_merge($scriptProperties, array('name' => $name, 'rows' => $rows)));
	}
}

return $output;