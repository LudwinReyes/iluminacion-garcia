<?php

$tab = isset( $_GET['tab'] ) ? strtolower( $_GET['tab'] ) : '';

switch ( $tab ) {
	case 'display_settings':
		include_once( 'CleverFloatingWidgetDisplaySettings.php' );
		break;
	case 'auto_display':
		include_once( 'CleverFloatingWidgetAutoDisplay.php' );
		break;
	case 'consent_confirmation':
		include_once( 'CleverFloatingWidgetConsentConfirmation.php' );
		break;
	default :
		include_once( 'CleverFloatingWidgetSelectedAccounts.php' );
		break;
}

?>
