id: 6
source: 1
name: officeProfile
category: Office
properties: null
static_file: core/components/office/elements/plugins/plugin.office.profile.php

-----

switch ($modx->event->name) {

	case 'OnLoadWebDocument':
		if ($modx->user->isAuthenticated($modx->context->key)) {
			if (!$modx->user->active || $modx->user->Profile->blocked) {
				$modx->runProcessor('security/logout');
				$modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'),'','','full'));
			}
			elseif ($page_id = $modx->getOption('office_profile_page_id', null, false, true)) {
				if ($modx->resource->id != $page_id && $modx->resource->parent != $page_id && @urldecode($_REQUEST['action']) != 'auth/logout') {
					$required = array_map('trim', explode(',', $modx->getOption('office_profile_required_fields', null)));
					if (!in_array('email', $required)) {$required[] = 'email';}
					$user = array_merge($modx->user->Profile->toArray(), $modx->user->toArray());
					$need = array();
					foreach ($required as $field) {
						if (isset($user[$field]) && trim($user[$field]) == '') {
							$need[] = $field;
						}
						elseif (preg_match('/(.*?)\[(.*?)\]/', $field, $matches)) {
							if (empty($user[$matches[1]][$matches[2]])) {
								$need[$matches[1].'.'.$matches[2]] = $field;
							}
						}
					}
					if (!empty($need)) {
						$modx->sendRedirect($modx->makeUrl($page_id,'',array('off_req' => implode('-',$need)),'full'));
						@session_write_close();
						die;
					}
				}
			}
			if ($modx->getOption('office_profile_force_email_as_username', null, false)) {
				if (!empty($modx->user->Profile->email) && $modx->user->username != $modx->user->Profile->email) {
					$modx->user->set('username', $modx->user->Profile->email);
					$modx->user->save();
				}
			}
		};
		break;
}