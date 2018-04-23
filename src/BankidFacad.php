<?php

namespace Anwar\Rfeedback\Facades;

/**
 * @Author: anwar
 * @Date:   2018-04-23 13:56:15
 * @Last Modified by:   anwar
 * @Last Modified time: 2018-04-23 13:57:03
 */

use Illuminate\Support\Facades\Facade;

class BankidFacad extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'BankID';
	}
}
