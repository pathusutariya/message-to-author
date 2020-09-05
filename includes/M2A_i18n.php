<?php

class M2A_i18n {
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'M2A',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
