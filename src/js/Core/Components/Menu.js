
document.addEventListener('DOMContentLoaded', () => {
	// Search site header.
	const siteHeader = document.querySelector('.site-header');
	// Search for the main menu.
	const mainMenuEl = siteHeader.querySelector('div#svitmov-main-menu');
	// Abort if the menu was not found.
	if (mainMenuEl === null) {
		return;
	}

	console.log(mainMenuEl);

	// Save last opened dropdown.
	let lastOpenedDropdown = [];
	// Initialize all of the dropdown triggers.
	mainMenuEl.querySelectorAll('.dropdown-trigger').forEach((triggerEl) => {
		// Get relation attribute.
		const relValue = triggerEl.getAttribute('rel');
		// Find dropdown target correspondent to the trigger.
		const targetEl = mainMenuEl.querySelector('.dropdown-target[rel="' + relValue + '"]');
		// Bail if the target was not found.
		if (targetEl === null) {
			return;
		}

		const hideMenuOnClickOutside = (e) => {
			// Hide dropdown on clicking outside of the header.
			if (!siteHeader.isSameNode(e.target.closest('.site-header'))) {
				// Toggle class for the trigger element to indicate selection.
				triggerEl.classList.remove('active');
				// Toggle class for the target to display/hide it.
				targetEl.classList.remove('active');
				// Set last opened dropdown to empty.
				lastOpenedDropdown = [];
				// Remove event manually, using {once: true} doesn't work as it triggers on initial click for some reason.
				document.removeEventListener('click', hideMenuOnClickOutside);
			}
		}

		// Initialize actions for the trigger.
		triggerEl.addEventListener('click', (e) => {
			e.preventDefault();
			// Check if attempted to open other dropdown.
			if (lastOpenedDropdown.length > 0 && ! triggerEl.isSameNode(lastOpenedDropdown[0])) {
				lastOpenedDropdown.forEach((el) => el.classList.remove('active'));
			}
			// Toggle class for the trigger element to indicate selection.
			const isActive = triggerEl.classList.toggle('active');
			// Toggle class for the target to display/hide it.
			targetEl.classList.toggle('active');

			if (isActive) {
				// Set last opened dropdown.
				lastOpenedDropdown = [triggerEl, targetEl];
				// Add event handler to close menu when clicked outside.
				document.addEventListener('click', hideMenuOnClickOutside);
			} else {
				lastOpenedDropdown = [];
				// Remove handler to close menu when clicked outside.
				document.removeEventListener('click', hideMenuOnClickOutside);
			}
		});
	});

	// Initialize variable to store last hover activate element.
	let lastHoverActive = [];
	// Initialize all of the hover activators.
	mainMenuEl.querySelectorAll('.hover-activator').forEach((triggerEl) => {
		// Get relation attribute.
		const relValue = triggerEl.getAttribute('rel');
		// Find dropdown target correspondent to the trigger.
		const targetEl = mainMenuEl.querySelector('.hover-activated[rel="' + relValue + '"]');

		// Initialize actions for the trigger.
		triggerEl.addEventListener('mouseover', (e) => {
			e.preventDefault();
			// Check if the last activated element matches current one.
			if (lastHoverActive.length > 0 && triggerEl.isSameNode(lastHoverActive[0])) {
				return;
			}
			// Remove active status from last activated elements.
			lastHoverActive.forEach((el) => el.classList.remove('active'));
			// Bail if the target was not found.
			if (targetEl === null) {
				// Set active to nothing.
				lastHoverActive = [];
				return;
			}
			// Add class for the trigger element to indicate selection.
			triggerEl.classList.add('active');
			// Add class for the target to display it.
			targetEl.classList.add('active');
			// Save these elements to disable later.
			lastHoverActive = [triggerEl, targetEl];
		});
	});
});
