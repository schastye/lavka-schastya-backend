id: 2
source: 1
name: pdoTools
category: pdoTools
properties: null
static_file: core/components/pdotools/elements/plugins/plugin.pdotools.php

-----

switch ($modx->event->name) {

    case 'OnMODXInit':
        $fqn = $modx->getOption('pdoTools.class', null, 'pdotools.pdotools', true);
        $path = $modx->getOption('pdotools_class_path', null, MODX_CORE_PATH . 'components/pdotools/model/', true);
        $modx->loadClass($fqn, $path, false, true);

        $fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
        $path = $modx->getOption('pdofetch_class_path', null, MODX_CORE_PATH . 'components/pdotools/model/', true);
        $modx->loadClass($fqn, $path, false, true);
        break;

}