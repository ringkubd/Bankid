<?php

namespace Anwar\Bankid;

use Illuminate\Support\ServiceProvider;

class BankidServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->make('Anwar\Bankid\BankidController');
		$this->app->bind('BankID', function () {
			return new BankidController;
		});
	}
}
