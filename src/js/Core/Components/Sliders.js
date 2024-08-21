
import Splide from '@splidejs/splide';

const InitSlider = (sliderEl, config, isGallery = false) => {
	// Check if slider exists.
	if (sliderEl === null) {
		return;
	}

	// Initialize slider.
	const sliderObj = new Splide(sliderEl, config);
	// Mount slider.
	sliderObj.mount();

	// Find the pagination element.
	const pagination = sliderEl.querySelector('.splide__pagination');
	if (pagination) {
		// Attach navigation arrows.
		const prevSlide = document.createElement('div');
		prevSlide.classList.add('prev-slide');
		prevSlide.innerHTML =
			'<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
			'<path d="M6.53125 12.0625L1.46875 7L6.53125 1.9375" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>\n' +
			'</svg>';
		pagination.insertAdjacentElement('afterbegin', prevSlide);
		prevSlide.addEventListener('click', (e) => {
			e.preventDefault();
			sliderObj.go('-1');
		});

		const nextSlide = document.createElement('div');
		nextSlide.classList.add('next-slide');
		nextSlide.innerHTML =
			'<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
			'<path d="M1.46875 12.0625L6.53125 7L1.46875 1.9375" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>\n' +
			'</svg>';
		pagination.insertAdjacentElement('beforeend', nextSlide);
		nextSlide.addEventListener('click', (e) => {
			e.preventDefault();
			sliderObj.go('+1');
		});
	}

	// Initialize gallery functionality.
	if (isGallery) {
		// Create a flag to track whether pop-up is active.
		let isPopUpActive = false;
		// Create pop-up element for gallery.
		const popUpEl = document.createElement('div');
		popUpEl.classList.add('pop-up-target', 'large');
		// Create empty image element and insert it inside of the pop-up.
		const imageEl = document.createElement('img');
		imageEl.classList.add('gallery-image');
		popUpEl.insertAdjacentElement('afterbegin', imageEl);
		// Insert pop-up on the page.
		document.body.insertAdjacentElement('beforeend', popUpEl);

		// Initialize each gallery item.
		sliderEl.querySelectorAll('.gallery-trigger').forEach((triggerEl) => {
			// Save link to full size version of the image.
			const fullSizeLink = triggerEl.getAttribute('fullsize');
			// Add event on click to update a pop-up class and image source.
			triggerEl.addEventListener('click', (e) => {
				e.preventDefault();
				// Set active flag to true.
				isPopUpActive = true;
				// Update image source attribute.
				imageEl.setAttribute('src', fullSizeLink);
				// Wait until the image is loaded to avoid pop-in's.
				imageEl.onload = () => {
					// Display pop-up by adding a class.
					popUpEl.classList.add('active');
				}
			});
		});

		// Add event to close pop-up on clicking outside.
		document.addEventListener('click', (e) => {
			// Bail if pop-up wasn't activated.
			if (!isPopUpActive) {
				return;
			}
			// Check if clicked outside the pop-up to close it.
			if (!popUpEl.isSameNode(e.target.closest('.pop-up-target'))) {
				// Remove class to hide element.
				popUpEl.classList.remove('active');
				// Update flag.
				isPopUpActive = false;
			}
		}, {capture: true});

		// Add event to close pop-up on clicking 'escape' button.
		document.addEventListener('keyup', (e) => {
			// Bail if pop-up wasn't activated.
			if (!isPopUpActive) {
				return;
			}
			// Check if the key is right one.
			if (e.key === 'Escape') {
				// Remove class to hide element.
				popUpEl.classList.remove('active');
				// Update flag.
				isPopUpActive = false;
			}
		});
	}
}

document.addEventListener('DOMContentLoaded', () => {
	// Initialize teacher slider.
	InitSlider(document.querySelector('.teacher-slider'), {
		type      : 'slide',
		perPage   : 4,
		gap       : 40,
		arrows    : false,
		pagination: true,
		focus     : 1,
		breakpoints: {
			1200: {
				perPage: 3,
			},
			800: {
				perPage: 2,
			},
			450: {
				perPage: 1,
			}
		},
	});

	// Initialize news slider.
	InitSlider(document.querySelector('.news-slider'), {
		type      : 'slide',
		perPage   : 3,
		clones    : 0,
		gap       : 40,
		arrows    : false,
		pagination: true,
		focus     : 1,
		breakpoints: {
			800: {
				perPage: 2,
			},
			450: {
				perPage: 1,
			}
		}
	});

	// Initialize news slider.
	InitSlider(document.querySelector('.reviews-slider'), {
		type      : 'slide',
		perPage   : 2.5,
		clones    : 0,
		gap       : 40,
		arrows    : false,
		pagination: false,
		focus     : 1,
		breakpoints: {
			600: {
				perPage: 1.5,
			},
			450: {
				perPage: 1,
			},
		}
	});

	// Initialize gallery slider.
	InitSlider(document.querySelector('.gallery-slider'), {
		type      : 'slide',
		perPage   : 5,
		clones    : 0,
		gap       : 40,
		arrows    : false,
		pagination: true,
		focus     : 1,
		breakpoints: {
			1200: {
				perPage: 3,
			},
			800: {
				perPage: 2,
			},
			450: {
				perPage: 1,
			}
		},
	}, true);

	// Initialize front page slider.
	InitSlider(document.querySelector('.front-slider'), {
		type      : 'loop',
		perPage   : 1,
		gap       : '100vw',
		arrows    : false,
		pagination: true,
	});

	// Initialize certificates slider.
	InitSlider(document.querySelector('.certificates-slider'), {
		type      : 'loop',
		perPage   : 1,
		gap       : 40,
		arrows    : false,
		pagination: true,
	});
});
