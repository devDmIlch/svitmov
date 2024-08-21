
document.addEventListener('DOMContentLoaded', () => {
	// Find search area.
	document.querySelectorAll('.site-search').forEach((siteSearch) => {
		// Find search toggle button.
		const searchToggle = siteSearch.querySelector('.search-toggle');
		// Find search submit button.
		const searchSubmit = siteSearch.querySelector('.search-submit');
		// Find search search field.
		const searchField = siteSearch.querySelector('.search-input');

		// Update class to reveal search field upon clicking the toggle search button.
		searchToggle.addEventListener('click', (e) => {
			e.preventDefault();
			// Toggle visibility class.
			const isToggledOn = siteSearch.classList.toggle('active');
			// If the visibility is toggled on, force focus the search field.
			if (isToggledOn) {
				searchField.focus();
				// Show submit button if the search is not empty.
				if (searchField.value.length > 0) {
					setTimeout(() => searchSubmit.classList.add('active'), 500);
				}
				// Add event to close search on clicking outside.
			}
			// Hide the submit button on toggling off.
			if (!isToggledOn) {
				searchSubmit.classList.remove('active');
			}
		});

		// Update class of the submit button when input changes.
		searchField.addEventListener('keyup', (e) => {
			const isEmpty = searchField.value.length === 0;
			// Toggle visibility of the submit button based on the emptiness of input.
			if (isEmpty) {
				searchSubmit.classList.remove('active');
			} else {
				searchSubmit.classList.add('active');
			}

			// Submit on clicking 'Enter'.
			if (e.keyCode === 13 && !isEmpty) {
				searchSubmit.click();
			}
		});

		// Initialize submit button.
		searchSubmit.addEventListener('click', (e) => {
			e.preventDefault();
			// Redirect to search page.
			console.log(window.location);
			window.location.replace(window.location.origin + '/search/' + searchField.value);
		});
	});
});
