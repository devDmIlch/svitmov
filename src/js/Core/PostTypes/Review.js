/* global wpApiSettings */

// External dependencies.
import axios from "axios";

// Internal dependencies.
import Forms from "../Components/Forms";

// WordPress functions.
const { __ } = wp.i18n;

document.addEventListener('DOMContentLoaded', () => {
	// Find and initialize review form.
	document.querySelectorAll('.review-form').forEach((formNode) => {
		Forms.InitializeForm(formNode, '/wp-json/svitmov/review/submit');
	});
});
