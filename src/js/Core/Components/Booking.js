
// Internal Dependencies.
import Forms from "./Forms";

const Booking = {
	InitForm(formNode) {
		Forms.InitializeForm(formNode, '/wp-json/svitmov/booking/submit');
		// Initialize form subtype switch.
		const switcherArea = formNode.querySelector('.subtype-switch');
		if (switcherArea) {
			// Find all type switches.
			const switches = switcherArea.querySelectorAll('.type-switch');
			// Find active switch.
			let activeSwitch = formNode.querySelector('.type-switch.active');

			// Initialize switches.
			switches.forEach((switchNode) => {
				// Get form subtype.
				const subtype = switchNode.getAttribute('type');
				// Initialize clicking action.
				switchNode.addEventListener('click', (e) => {
					e.preventDefault();
					// Check if user clicked on already selected option.
					if (activeSwitch.isSameNode(switchNode)) {
						return;
					}
					// Remove 'active' class from old active switch.
					activeSwitch.classList.remove('active');
					// Update value of the active switch variable.
					activeSwitch = switchNode;
					// Add 'active' class to newly activated switch.
					activeSwitch.classList.add('active');

					switch (subtype) {
						case 'kid':
							// Activate child-related fields.
							formNode.modFields(
								(field) => ['guardian-name', 'birth-date'].indexOf(field.name) !== -1,
								(field) => {
									// Make field required.
									field.required = true;
									// Enable field.
									field.disabled = false;
									// Show field area.
									field.parentNode.classList.remove('disabled');
									// Run checks for field.
									field.checkFieldValue();
								}
							);

							break;
						case 'adult':
							// Deactivate child-related fields.
							formNode.modFields(
								(field) => ['guardian-name', 'birth-date'].indexOf(field.name) !== -1,
								(field) => {
									// Make field required.
									field.required = false;
									// Enable field.
									field.disabled = true;
									// Hide field area.
									field.parentNode.classList.add('disabled');
									// Run checks for field.
									field.checkFieldValue();
								}
							);

							break;
					}
				});
			});
		}
	},
};

document.addEventListener('DOMContentLoaded', () => {
	// Initialize every initial booking form on the page.
	document.querySelectorAll('.booking-form').forEach(Booking.InitForm);
});

export default Booking;
