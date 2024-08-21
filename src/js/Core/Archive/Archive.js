/* global wpApiSettings, archiveSettings */

// External dependencies.
import axios from "axios";

// Internal dependencies.
import PopUps from "../Components/Popups";
import Booking from "../Components/Booking";

// WordPress functions.
const { __ } = wp.i18n;

document.addEventListener('DOMContentLoaded', () => {
	// Check whether archive settings were provided via localization script.
	if (typeof archiveSettings === 'undefined') {
		return;
	}

	// Prepare path to archive-related endpoints.
	const archivePath = '/wp-json/svitmov/archive/';
	// Prepare request header parameters.
	const requestParams = {
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		}
	}

	// Prepare archive parameters with the parameters from localization script.
	const archiveParams = {};
	switch (archiveSettings.type) {
		case 'course':
			Object.assign(archiveParams, {
				// Base parameters.
				post_type: 'course',
				number:     4,
				page:       1,
				// Filter parameters.
				filters:   ['is_online', 'is_individual', 'language'],
				selected:  {},
			});
			break;
		case 'news':
			Object.assign(archiveParams, {
				// Base parameters.
				post_type:  'news',
				number:     6,
				page:       1,
				pagination: true,
			});
			break;
	}

	if (typeof archiveParams.post_type === 'undefined') {
		return;
	}

	// Add search parameter if it was provided in the localization script.
	if (archiveSettings.search) {
		archiveParams.search = archiveSettings.search;
	}
	// Add 'exclude' parameter if it was provided in the localization script.
	if (archiveSettings.exclude) {
		archiveParams.exclude = archiveSettings.exclude;
	}
	// Add selected parameters if any was provided in the localization script.
	if (archiveSettings.selected) {
		archiveParams.selected = archiveSettings.selected;
		// Initially set filters should not be changed.
		if (Array.isArray(archiveParams.filters)) {
			const excludedFilters = Object.keys(archiveParams.selected);
			archiveParams.filters = archiveParams.filters.filter((value) => !excludedFilters.includes(value));
		}
	}

	// Prepare 'is active' flag to prevent overlapping of the different loaded elements.
	let isLoadingActive = false;
	// Prepare 'initial load' flag to track whether archive content part should be refreshed.
	let isInitialLoad = true;
	// Retrieve 'paged' flag to determine whether content should be displayed with pagination or endless scroll.
	const isPaged = archiveSettings.paged;

	// Find the DOM elements which should be filled with data.
	const archiveContentEl = document.querySelector('.archive-content');
	const archiveFiltersEl = document.querySelector('.archive-filters');

	// Find controls elements.
	const loadMoreButton = document.querySelector('.archive-load-more');
	const paginationEl = document.querySelector('.archive-pagination');

	// Find information elements.
	const totalEntriesEl = document.querySelector('.total-entries');

	// Loads content of a single page.
	const LoadArchivePage = () => {
		// Check if the loading is still in process.
		if (isLoadingActive) {
			return;
		}
		// Check loading flag until the content is loaded.
		isLoadingActive = true;

		// Set page to 1, if the load is initial.
		if (isInitialLoad) {
			archiveParams.page = 1
		}

		// Hide 'Load More' button until all of the content is loaded.
		if (loadMoreButton) {
			loadMoreButton.classList.add('hidden');
		}

		// Hide pagination if 'initial load' flag is set.
		if (isInitialLoad && paginationEl) {
			paginationEl.classList.add('hidden');
		}

		axios.post(archivePath + 'get-posts', archiveParams, requestParams).then((response) => {
			if (response.data.status === 200) {
				const animationDelay = 200;
				const itemDelay = 50;
				// Prepare delay time tracker for the animation.
				let displayDelay = 0;

				// Save min height to avoid pagination section jumps.
				if (isPaged) {
					archiveContentEl.style.minHeight = archiveContentEl.offsetHeight + 'px';
				}

				// Remove old elements from the archive if initially loaded.
				if (isInitialLoad || isPaged) {
					// Remove elements in reverse order.
					Array.prototype.slice.call(archiveContentEl.querySelectorAll('.single-el')).reverse().forEach((el) => {
						// Add time to total delay.
						displayDelay += itemDelay;
						// Schedule the disappearing animation.
						setTimeout(() => {
							// Add element 'unloaded' class to reverse-play animation.
							el.classList.add('unloaded');
							// Remove element after the animation finished playing.
							setTimeout(() => {
								el.remove();
							}, animationDelay);
						}, displayDelay);
					});
				}

				// If the delay is not 0, account for animation duration.
				if (displayDelay > 0) {
					displayDelay += animationDelay;
				}

				// Add new elements from the response.
				if (response.data.content) {
					// Account for the possible delay with animation.
					setTimeout(() => {
						// Add the content itself.
						archiveContentEl.insertAdjacentHTML('beforeend', response.data.content);
						// Refresh display delay for the items.
						let localDelay = 0;
						// Load animations for each of the element.
						archiveContentEl.querySelectorAll('.single-el').forEach((el) => {
							// Check if the element has 'unloaded' class which sets item into an unloaded display state.
							if (!el.classList.contains('unloaded')) {
								return;
							}
							// Add time to the delay.
							localDelay += itemDelay;
							// Schedule appearing animation.
							setTimeout(() => {
								// Remove 'unloaded' class to play loading animation.
								el.classList.remove('unloaded');
							}, localDelay);
						});
					}, displayDelay);
				}

				// Remove temporary min-height property after the content has been loaded.
				if (isPaged) {
					setTimeout(() => {
						archiveContentEl.style.minHeight = null;
					}, displayDelay);
				}

				// Display filters.
				if (isInitialLoad && archiveFiltersEl && response.data.filters) {
					// Remove old filters.
					archiveFiltersEl.innerHTML = '';
					// Insert new filters.
					archiveFiltersEl.insertAdjacentHTML('beforeend', response.data.filters);
					// Initialize filter actions.
					LoadArchiveFilters();
				}

				// Update value with the total entries.
				if (totalEntriesEl && response.data.total !== null) {
					totalEntriesEl.innerHTML = response.data.total + ' ' + response.data.total_suffix;
				}

				// Display 'Load More' button if it exist and all content has not been loaded.
				if (loadMoreButton && archiveParams.page * archiveParams.number < response.data.total) {
					setTimeout(() => {
						loadMoreButton.classList.remove('hidden');
					}, displayDelay + animationDelay * 2 + itemDelay * archiveParams.number);
				}

				// Display pagination if container exists and html has been returned in response.
				if (isInitialLoad && paginationEl && response.data.pagination) {
					// Remove old pagination.
					paginationEl.innerHTML = '';
					// Add content from request.
					paginationEl.insertAdjacentHTML('afterbegin', response.data.pagination);
					// Initialize pagination actions.
					LoadArchivePagination();
					// Display pagination.
					setTimeout(() => {
						paginationEl.classList.remove('hidden');
					}, displayDelay + animationDelay * 2 + itemDelay * archiveParams.number);
				}

				if (archiveParams.post_type === 'course') {
					setTimeout(() => {
						InitCourseCards();
					}, displayDelay + animationDelay * 2 + itemDelay * archiveParams.number);
				}

				// Update page in the archive parameters.
				if (!isPaged) {
					archiveParams.page++;
				}
				// Set 'initial load' flag to false.
				isInitialLoad = false;
				// Uncheck loading flag.
				isLoadingActive = false;
			}
		});
	};

	// Initializes archive filters.
	const LoadArchiveFilters = () => {
		archiveFiltersEl.querySelectorAll('.single-filter').forEach((el) => {
			// Get the relative name of the filter.
			const filterName = el.getAttribute('filter');
			// Get the type of the filter.
			const filterType = el.getAttribute('type');

			switch (filterType) {
				case 'radio':
					// Find the options for this filter
					const filterOptions = el.querySelectorAll('.single-option');
					// Create a variable to store the selected option, to uncheck if when required.
					let prevValue = el.querySelector('.single-option.selected');

					// Initialize actions for each of the filter options.
					filterOptions.forEach((option) => {
						// Save the value of the option.
						const optionValue = option.getAttribute('value');
						// Initialize clicking the option.
						option.addEventListener('click', () => {
							// Check if the user clicked the already selected option.
							if (prevValue.isSameNode(option)) {
								return;
							}
							// Check if the previous load has finished.
							if (isLoadingActive) {
								return;
							}
							// Update selected value in the archiveParams object.
							archiveParams.selected[filterName] = optionValue;
							// Remove selected class from the previous filter.
							prevValue.classList.remove('selected');
							// Add selected class to the newly selected filter.
							option.classList.add('selected');
							// Update value of the selected filter.
							prevValue = option;
							// Set 'initial loading' flag to true, to start querying from the first page.
							isInitialLoad = true;
							// Load new posts.
							LoadArchivePage();
						});
					});

					break;
				case 'range':
					// Find the range bar.
					const rangeBar = el.querySelector('.range-bar');
					// Get minimum and maximum values from the bar attributes.
					const absMin = Number(rangeBar.getAttribute('min'));
					const absMax = Number(rangeBar.getAttribute('max'));

					const minMaxDelta = 0.1;

					// Get current minimum and maximum elements.
					const minEl = el.querySelector('.min-value');
					const maxEl = el.querySelector('.max-value');
					// Get current minimum and maximum values.
					let currMin = Number(minEl.innerHTML);
					let currMax = Number(maxEl.innerHTML);
					// Calculate current percentage wise position of the minimum and maximum values.
					let percentMin = (currMin - absMin) / (absMax - absMin);
					let percentMax = (currMax - absMin) / (absMax - absMin);

					// Find the handles.
					const handles = rangeBar.querySelectorAll('.handle');

					// Find 'apply-filter' button.
					const applyFilter = el.querySelector('.apply-filter');

					// Initialize handles.
					handles.forEach((handle) => {
						// Check whether handle is minimum value or maximum.
						const isMinHandle = handle.classList.contains('min-handle');
						// Set value display element.
						const displayEl = isMinHandle ? minEl : maxEl;

						handle.addEventListener('mousedown', (e) => {
							// Prevent default to avoid event collisions with the text.
							e.preventDefault();

							// Get bounding box for the range bar.
							const rect = rangeBar.getBoundingClientRect();
							// Get width of the range bar.
							const rangeBarWidth = rangeBar.clientWidth;

							const movementHandler = (e) => {
								// Get percentage-wise position of the cursor.
								let relPos = (e.clientX - rect.left) / rangeBarWidth;
								if (relPos < 0) {
									relPos = 0;
								}
								if (relPos > 1) {
									relPos = 1;
								}

								// Force handles to have % delta value between their values.
								if (isMinHandle && relPos + minMaxDelta > percentMax) {
									relPos = percentMax - minMaxDelta;
								}
								if (!isMinHandle && relPos - minMaxDelta < percentMin) {
									relPos = percentMin + minMaxDelta;
								}

								// Save percentage position.
								isMinHandle ? percentMin = relPos : percentMax = relPos;

								// Get price value.
								const price = Math.round(absMin + (absMax - absMin) * relPos);
								// Update 'current value'.
								isMinHandle ? currMin = price : currMax = price;
								// Update display element with the new price.
								displayEl.innerHTML = String(price);

								// Set position of the handle.
								isMinHandle ? handle.style.left = relPos * 100 + '%' : handle.style.right = (1 - relPos) * 100 + '%';

								// Show 'apply-filter' button.
								applyFilter.classList.remove('hidden');
							}

							// Initialize handle movement.
							document.addEventListener('mousemove', movementHandler);

							// Remove handle movement action of mouse up.
							document.addEventListener('mouseup', () => {
								document.removeEventListener('mousemove', movementHandler);
							}, {once: true});
						});
					});

					// Initialize apply filter button.
					applyFilter.addEventListener('click', () => {
						// Set archive parameter value.
						archiveParams.selected.price = {min: currMin, max: currMax};
						// Set 'initial load' flag to true.
						isInitialLoad = true;
						// Reload content.
						LoadArchivePage();
					});

					break;
			}
		});
	}

	// Initializes archive pagination.
	const LoadArchivePagination = () => {
		// Find the numbered navigation buttons.
		const pagNavItems = paginationEl.querySelectorAll('.page-jump');
		// Find currently selected page button.
		let currentPage = paginationEl.querySelector('.page-jump.current');

		// Initialize numbered buttons.
		pagNavItems.forEach((navButton) => {
			// Get page value of the button.
			const pageValue = Number(navButton.getAttribute('value'));

			// Add event on click.
			navButton.addEventListener('click', (e) => {
				e.preventDefault();

				if (isLoadingActive) {
					return;
				}

				// Set page in archive parameters.
				archiveParams.page = pageValue;
				// Remove class from previous page button.
				if (currentPage) {
					currentPage.classList.remove('current');
				}
				// Set page button as active.
				navButton.classList.add('current');
				// Save button as current page button.
				currentPage = navButton;
				// Reload page.
				LoadArchivePage();
			})
		});

		// Initialize 'previous page' button.
		paginationEl.querySelectorAll('.page-prev').forEach((prevButton) => {
			prevButton.addEventListener('click', (e) => {
				e.preventDefault();

				if (isLoadingActive || currentPage.previousElementSibling.isSameNode(prevButton)) {
					return;
				}

				// Remove class from previous page button.
				if (currentPage) {
					currentPage.classList.remove('current');
				}
				// Update current page button.
				currentPage = currentPage.previousElementSibling;
				currentPage.classList.add('current');
				// Update archive parameters.
				--archiveParams.page;
				// Load new page.
				LoadArchivePage();
			})
		});

		// Initialize 'next page' button.
		paginationEl.querySelectorAll('.page-next').forEach((nextButton) => {
			nextButton.addEventListener('click', (e) => {
				e.preventDefault();

				if (isLoadingActive || currentPage.nextElementSibling.isSameNode(nextButton)) {
					return;
				}

				// Remove class from previous page button.
				if (currentPage) {
					currentPage.classList.remove('current');
				}
				// Update current page button.
				currentPage = currentPage.nextElementSibling;
				currentPage.classList.add('current');
				// Update archive parameters.
				++archiveParams.page;
				// Load new page.
				LoadArchivePage();
			})
		});
	}

	// Initializes 'Load More' button.
	const InitLoadMoreButton = () => {
		// Check if 'Load More' button exist.
		if (loadMoreButton === null) {
			return;
		}

		// Load new page on clicking.
		loadMoreButton.addEventListener('click', () => {
			LoadArchivePage();
		});
	}

	// Initialize Course cards.
	const InitCourseCards = () => {

		// Get all card items from content.
		archiveContentEl.querySelectorAll('.single-el').forEach((cardNode) => {
			// Check whether teh card was already initialize.
			if (cardNode.bookFormInitialized) {
				return;
			}
			// Flag card as initialized.
			cardNode.bookFormInitialized = true;

			// Get the booking form trigger button.
			const formTrigger = cardNode.querySelector('.create-form');
			// Check if the form trigger exists.
			if (!formTrigger) {
				return;
			}

			// Get course id from the button.
			const courseId = formTrigger.getAttribute('course');

			// Initialize clicking the button.
			formTrigger.addEventListener('click', (e) => {
				e.preventDefault();
				// Create pop-up.
				axios.post('/wp-json/svitmov/booking/create-form', { course: courseId }, requestParams).then((response) => {
					if (response.data.status === 200) {
						// Insert pop-up into page.
						archiveContentEl.insertAdjacentHTML('afterbegin', response.data.form);
						// Get the pop-up.
						const popUpForm = archiveContentEl.firstElementChild;
						// Initialize pop-up functionality.
						PopUps.InitPopUp(formTrigger, popUpForm);
						// Initialize form functionality.
						Booking.InitForm(popUpForm);
						// Activate pop-up by simulating clicking the trigger.
						formTrigger.click();
					}
				});
			}, {once: true});
		});
	};

	// Do an initial loading animation.
	LoadArchivePage();
	// Initialize 'Load more' button.
	InitLoadMoreButton();
});
