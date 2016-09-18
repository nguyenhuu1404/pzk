<?php
/**
 * 
 * @param string $key
 * @param string $value
 * @param string $timeout
 * @return PzkSGStoreSession
 */
function pzk_session($key = NULL, $value = NULL, $timeout = NULL) {
	static $session;
	if (! $session)
		$session = new PzkSGStoreSession ( new PzkSGStoreFormatJson ( new PzkSGStoreDriverFile ( 'cache/session' ) ) ) ;
	if ($key === NULL) {
		return $session;
	} else {
		if ($value === NULL) {
			return $session->get ( $key, $timeout );
		} else {
			return $session->set ( $key, $value );
		}
	}
	return $session;
}

/**
 *
 * @return PzkSGStoreFormatSerialize
 */
function pzk_memcache($key = NULL, $value = NULL, $timeout = NULL) {
	static $memcache;
	if (! $memcache)
		$memcache = new PzkSGStoreDomain (new PzkSGStoreDriverMemcache ());
	if ($key === NULL) {
		return $memcache;
	} else {
		if ($value === NULL) {
			return $memcache->get ( $key, $timeout );
		} else {
			return $memcache->set ( $key, $value );
		}
	}
	return $memcache;
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @return PzkSGStoreDriverPhp
 */
function pzk_element($key = NULL, $value = NULL) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreDriverPhp ();
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @return PzkSGStoreDriverPhp
 */
function pzk_global($key = NULL, $value = NULL) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreDriverPhp ();
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}
function pzk_store_instance($storeName) {
	static $stores = array ();
	
	if (! isset ( $stores [$storeName] )) {
		$store = new PzkSGStoreDriverPhp ();
		$stores [$storeName] = $store;
	}
	return $stores [$storeName];
}
function pzk_app_store() {
	return pzk_store_instance ( pzk_request ()->getAppPath () );
}
function pzk_package_store() {
	return pzk_store_instance ( pzk_request ()->getPackagePath () );
}
function pzk_site_store() {
	return pzk_store_instance ( pzk_request ()->getAppPath () . '/' . pzk_request ()->getSoftwareId () );
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @param string $timeout        	
 * @return PzkSGStoreDomain
 */
function pzk_filecache($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store) {
		//$store = pzk_memcache();
		$store = new PzkSGStoreDomain ( new PzkSGStoreDriverFile ( 'cache' ) );
	}
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}
/**
 *
 * @param string $key        	
 * @param string $value        	
 * @param string $timeout        	
 * @return PzkSGStoreDomain
 */
function pzk_rediscache($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store) {
		//$store = pzk_memcache();
		$store = new PzkSGStoreDomain ( new PzkSGStoreDriverRedis () );
	}
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}

function pzk_controllercache($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store) {
		//$store = pzk_memcache();
		$store = new PzkSGStoreDomain ( new PzkSGStoreDriverFile ( 'cache/controller' ) );
	}
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @param string $timeout        	
 * @return PzkSGStoreFormatSerialize
 */
function pzk_filevar($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreFormatSerialize ( new PzkSGStoreDomain ( new PzkSGStoreDriverFile ( 'cache' ) ) );
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @param string $timeout        	
 * @return PzkSGStoreFormatSerialize
 */
function pzk_stat($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreStat(new PzkSGStoreFormatSerialize ( new PzkSGStoreDomain ( new PzkSGStoreDriverFile ( 'cache/stat' ) ) ));
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}

/**
 *
 * @param string $key        	
 * @param string $value        	
 * @param string $timeout        	
 * @return PzkSGStoreFormatSerialize
 */
function pzk_uservar($key = NULL, $value = NULL, $timeout = null) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreFormatSerialize ( new PzkSGStoreDomain ( new PzkSGStoreDriverFile ( 'cache/user' ) ) );
	if ($key === NULL) {
		return $store;
	} else {
		if ($value === NULL) {
			return $store->get ( $key, $timeout );
		} else {
			return $store->set ( $key, $value );
		}
	}
	return $store;
}
function pzk_cachetag($store, $tag, $key) {
	$cacheTags = pzk_filevar ()->getCacheTags ();
	if (! is_array ( $cacheTags ))
		$cacheTags = array ();
	if (! isset ( $cacheTags [$store] ))
		$cacheTags [$store] = array ();
	if (! isset ( $cacheTags [$store] [$tag] ))
		$cacheTags [$store] [$tag] = array ();
	$cacheTags [$store] [$tag] [$key] = true;
	pzk_filevar ()->setCacheTags ( $cacheTags );
}
function pzk_cachetag_clear($store, $tag) {
	$cacheTags = pzk_filevar ()->getCacheTags ();
	if (! is_array ( $cacheTags ))
		$cacheTags = array ();
	if (isset ( $cacheTags [$store] ) && isset ( $cacheTags [$store] [$tag] )) {
		$storeObj = $store ();
		foreach ( $cacheTags [$store] [$tag] as $key => $existed ) {
			$storeObj->del ( $key );
			unset ( $cacheTags [$store] [$tag] [$key] );
		}
		pzk_filevar ()->setCacheTags ( $cacheTags );
	}
}

/**
 *
 * @return PzkEntityUserAccountUserModel
 */
function pzk_user() {
	static $user;
	if ($user)
		return $user;
	$user = _db ()->getEntity ( 'user.account.user' );
	$session = pzk_session();
	if ($userId = $session->getUserId ()) {
		$login_ip = getIPAndAgent();
		$logined_ip = pzk_uservar()->get($_SERVER['HTTP_HOST'] . $session->getUsername() . '_login_ip');
		if($logined_ip !== NULL && $login_ip !== $logined_ip) {
			$user->logout();
		} else {
			$user->setId($userId);
			$user->setUsername($session->getUsername());
			$user->setAvatar($session->getAvatar());
			$user->setIpClient($session->getIpClient());
			$user->setLogin_id($session->getLogin_id());
		}
		
	} else {
		$login_ip = getIPAndAgent();
		$logined_ip = pzk_uservar()->get($session->getUsername() . '_login_ip');
		if($logined_ip !== NULL && $login_ip !== $logined_ip) {
			$user->logout();
		}
	}
	return $user;
}

/**
 *
 * @param unknown $key        	
 * @return unknown|NULL
 */
function pzk_config($key = NULL) {
	static $siteConfig;
	static $appConfig;
	static $packageConfig;
	if (! $siteConfig)
		$siteConfig = pzk_site_store ()->getConfig ();
	if (! $appConfig)
		$appConfig = pzk_app_store ()->getConfig ();
	if (! $packageConfig)
		$packageConfig = pzk_package_store ()->getConfig ();
	if($key === NULL) {

		return merge_array(array(), $packageConfig, $appConfig, $siteConfig);
	}
	if (isset ( $siteConfig [$key] )) {
		if ($siteConfig [$key] !== 'default-config' && $siteConfig [$key] !== '') {
			return $siteConfig [$key];
		} else if (isset ( $appConfig [$key] )) {
			if ($appConfig [$key] !== 'default-config' && $appConfig [$key] !== '') {
				return $appConfig [$key];
			} else if (isset ( $packageConfig [$key] )) {
				return $packageConfig [$key];
			}
		}
	}
	return NULL;
}
function pzk_js($src = NULL) {
	static $jsStore;
	if (! $jsStore) {
		$jsStore = pzk_filevar ()->get ( pzk_app ()->name . 'jsStore' );
		if (! $jsStore) {
			$jsStore = array ();
		}
	}
	if ($src) {
		if (isset ( $jsStore [$src] )) {
			return true;
		} else {
			if (file_exists ( BASE_DIR . $src )) {
				$commonJsFile = BASE_DIR . '/default/skin/' . pzk_app ()->name . '.js';
				if (! file_exists ( $commonJsFile )) {
					file_put_contents ( $commonJsFile, '' );
				}
				$content = file_get_contents ( $commonJsFile );
				$content .= "\r\n" . file_get_contents ( BASE_DIR . $src );
				file_put_contents ( $commonJsFile, $content );
				$jsStore [$src] = true;
				pzk_filevar ()->set ( pzk_app ()->name . 'jsStore', $jsStore );
			}
			return false;
		}
	}
}

/**
 *
 * @param unknown $subStore        	
 * @return PzkSGStoreApp
 */
function pzk_appscope($subStore) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreApp ( null );
	$store->storage = $subStore;
	return $store;
}

/**
 *
 * @param unknown $subStore        	
 * @return PzkSGStoreDomain
 */
function pzk_domainscope($subStore) {
	static $store;
	if (! $store)
		$store = new PzkSGStoreDomain ( null );
	$store->storage = $subStore;
	return $store;
}

/**
 *
 * @param unknown $subStore        	
 * @return PzkSGStore
 */
function pzk_globalscope($subStore) {
	static $store;
	if (! $store)
		$store = new PzkSGStore ( null );
	$store->storage = $subStore;
	return $store;
}