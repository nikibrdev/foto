/**
 * Live Customizer preview: updates the four colour CSS custom properties
 * instantly, without a full preview reload. All other settings use the
 * Customizer's default full-refresh behaviour.
 */
( function ( wp ) {
	if ( ! wp || ! wp.customize ) {
		return;
	}

	var colorSettings = {
		sf_color_primary: '--primary-color',
		sf_color_background: '--background-color',
		sf_color_accent: '--green-color',
		sf_color_secondary: '--secondary-color',
	};

	Object.keys( colorSettings ).forEach( function ( settingId ) {
		wp.customize( settingId, function ( value ) {
			value.bind( function ( newValue ) {
				document.documentElement.style.setProperty( colorSettings[ settingId ], newValue );
			} );
		} );
	} );
} )( window.wp );
