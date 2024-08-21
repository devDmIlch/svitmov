
document.addEventListener('DOMContentLoaded', () => {
	// Find mobile menu trigger.
	const mobileMenuTrigger = document.querySelector('.main-menu-trigger');
	// Find mobile menu trigger.
	const mobileMenuNode = document.querySelector('.main-menu-mobile');
	// Find close menu button.
	const closeMenuNode = mobileMenuNode.querySelector('.close-menu');

	// Initialize clicking the trigger.
	mobileMenuTrigger.addEventListener('click', (e) => {
		e.preventDefault();
		// Show/Hide menu.
		mobileMenuNode.classList.toggle('active');
	});

	// Initialize menu closing node.
	closeMenuNode.addEventListener('click', (e) => {
		e.preventDefault();
		// Hide menu.
		mobileMenuNode.classList.remove('active');
	});

	mobileMenuNode.querySelectorAll('.menu-item-has-children').forEach((linkNode) => {
		// Find the dropdown trigger link.
		const dropdownTrigger = linkNode.querySelector('a');
		// Initialize clicking the link.
		dropdownTrigger.addEventListener('click', (e) => {
			e.preventDefault();
			// Change the class of the element.
			linkNode.classList.toggle('active');
		});
	});
});
