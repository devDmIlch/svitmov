import Forms from "./Forms";

document.addEventListener('DOMContentLoaded', () => {
	// Initialize every initial booking form on the page.
	document.querySelectorAll('.contact-form').forEach((el) => Forms.InitializeForm(el, '/wp-json/svitmov/contact/submit'));
});
