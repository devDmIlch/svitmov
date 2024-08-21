
const PopUps = {
	InitPopUp(triggerNode, targetNode) {
		// Initialize click outside event.
		const handleClickOutside = (e) => {
			// Check whether a user clicked inside of the pop-up.
			if (!targetNode.isSameNode(e.target.closest('.pop-up-target'))) {
				// Remove class toggle off pop-up visibility.
				targetNode.classList.remove('active');
				// Remove this event.
				document.removeEventListener('click', this);
			}
		}

		// Initialize click on the trigger.
		triggerNode.addEventListener('click', (e) => {
			e.preventDefault();
			// Add class to the target to toggle it's visibility on.
			targetNode.classList.add('active');

			// Initialize clicking outside of the pop-up to close it.
			document.addEventListener('click', function handleClickOutside(e) {
				// Check whether a user clicked inside of the pop-up.
				if (!targetNode.isSameNode(e.target.closest('.pop-up-target'))) {
					// Remove class toggle off pop-up visibility.
					targetNode.classList.remove('active');
					// Remove this event.
					document.removeEventListener('click', handleClickOutside, {capture: true});
				}
			}, {capture: true});
		});

		// Find and initialize 'close pop-up' button.
		const closeButton = targetNode.querySelector('.pop-up-close');
		if (closeButton !== null) {
			closeButton.addEventListener('click', (e) => {
				e.preventDefault();
				// Toggle off pop-up by removing class.
				targetNode.classList.remove('active');
				// Remove click outside action.
				document.removeEventListener('click', handleClickOutside, {capture: true});
			})
		}
	}
}

// Initialize initial pop-ups.
document.addEventListener('DOMContentLoaded', () => {
	// Initialize all of the trigger buttons.
	document.querySelectorAll('.pop-up-trigger').forEach((triggerNode) => {
		// Get relation value from the trigger to search for target.
		const relValue = triggerNode.getAttribute('rel');
		// Find corresponding target.
		const targetNode = document.querySelector('.pop-up-target[rel="' + relValue + '"]');

		// Bail if the target was not found.
		if (targetNode === null) {
			return;
		}

		PopUps.InitPopUp(triggerNode, targetNode);
	});
});

export default PopUps;
