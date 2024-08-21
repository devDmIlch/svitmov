/* global wpApiSettings */

// External dependencies.
import axios from "axios";

// WordPress functions.
const { __ } = wp.i18n;

const Forms = {
	InitializeForm (formNode, requestPath) {
		// Find form fields.
		const formFields = formNode.querySelectorAll('input, textarea');
		// Find submit button.
		const submitButton = formNode.querySelector('.submit-form');

		// Save the number of fields with empty values to track whether all of them are filled in.
		let invalidFields = 0;

		// Create a method to modify fields
		formNode.modFields = (filterCallback, actionCallback) => {
			[...formFields].filter(filterCallback).forEach(actionCallback);
		};

		// Initialize field checks.
		formFields.forEach((fieldNode) => {
			// Add flag to keep track whether input value is ok.
			let isValueOk = !fieldNode.required || (fieldNode.value.length > 0 && fieldNode.value.trim() > 0);
			// Set initial error message.
			let errorMessage = __('Це поле не може бути пустим', 'svitmov');
			// If value is not ok increment invalid fields counter.
			if (!isValueOk) {
				++invalidFields;
			}

			// Get field type.
			const fieldType = fieldNode.getAttribute('type');

			// Initializes custom selectors for hidden fields.
			const initializeSelector = () => {
				// Check if the next element is dropdown trigger.
				if (fieldNode.nextElementSibling === null || ! fieldNode.nextElementSibling.classList.contains('pseudo-select')) {
					return;
				}

				// Save dropdown trigger reference into a variable for easy access.
				const dropdownTrigger = fieldNode.nextElementSibling;
				// Find the dropdown target node.
				const dropdownTarget = dropdownTrigger.nextElementSibling;

				// Find all options.
				const options = dropdownTarget.querySelectorAll('.option');
				// Initialize options in the dropdown.
				options.forEach((optionNode) => {
					// Save value of the node.
					const optionValue = optionNode.getAttribute('value');
					// Create event handler for option selection.
					const handleSelect = (e) => {
						e.preventDefault();
						// Update value of the field on click.
						fieldNode.value = optionValue;
						// Update text inside the trigger to indicate selection to user.
						dropdownTrigger.innerHTML = optionNode.innerHTML;
						// Close the dropdown.
						dropdownTarget.classList.remove('active');
						// Hide field errors if any exist.
						fieldNode.checkFieldValue();
						fieldNode.displayFieldErrors();
					}
					// Initialize click action for each of the nodes.
					optionNode.addEventListener('click', handleSelect);
					// Initialize enter pressing to select option.
					optionNode.addEventListener('keyup', (e) => {
						// Check if clicked enter.
						if (e.key !== 'Enter') {
							return;
						}
						// Call handler function.
						handleSelect(e);
						// Crete one-time focus action to high-jack propagation.
						options[options.length - 1].addEventListener('focusin', (e) => {
							e.stopImmediatePropagation();
							// Instant blur the option to hide focus change.
							e.target.blur();
						}, {once: true});
						// Focus on next element.
						options[options.length - 1].focus();
					});
				});

				// Show dropdown on focus dropdown trigger.
				dropdownTrigger.addEventListener('focusin', (e) => {
					e.preventDefault();
					// Toggle on active class to display the dropdown.
					dropdownTarget.classList.add('active');
				});

				// Hide dropdown on focus out.
				dropdownTrigger.addEventListener('focusout', (e) => {
					e.preventDefault();
					// Check if moved inside the dropdown.
					if (e.relatedTarget && dropdownTarget.isSameNode(e.relatedTarget.closest('.pseudo-select-dropdown'))) {
						return;
					}
					// Toggle off active class to hide the dropdown.
					dropdownTarget.classList.remove('active');
				})
			}

			// Checks field value.
			fieldNode.checkFieldValue = () => {
				// Save last state of the flag.
				const prevState = isValueOk;
				// Set flag as ok initially.
				isValueOk = true;
				// Check if the field is empty.
				if (fieldNode.required && fieldNode.value.length < 1) {
					isValueOk = false;
					// Set error message.
					errorMessage = __('Це поле не може бути пустим', 'svitmov');
				}
				// Check if the email is okay.
				if (fieldNode.value.length > 0 && fieldType === 'email') {
					// Check if the email complies with simple regex.
					if (!(/.+@.+\..+/i).test(fieldNode.value)) {
						isValueOk = false;
						// Set error message.
						errorMessage = __('Невірний формат електронної пошти', 'svitmov');
					}
				}
				// Check if the phone is right format.
				if (fieldNode.value.length > 0 && fieldType === 'tel') {
					// Check if phone complies with regex.
					if (!(/^(\+380|380|0)[0-9]{9}/).test(fieldNode.value)) {
						isValueOk = false;
						// Set error message.
						errorMessage = __('Невірний формат номеру телефону', 'svitmov');
					}
				}
				// If the state has changed update number of the invalid fields.
				if (prevState !== isValueOk) {
					isValueOk ? --invalidFields : ++invalidFields;
				}
			}
			// Displays any errors for field.
			fieldNode.displayFieldErrors = () => {
				// Add/Remove invalid class based on value checks.
				if (isValueOk) {
					// Remove class if the field value is a-ok.
					fieldNode.classList.remove('invalid');
					// Remove error message.
					if (fieldNode.previousElementSibling !== null && fieldNode.previousElementSibling.classList.contains('field-error')) {
						fieldNode.previousElementSibling.innerHTML = '';
					}
				} else {
					// Add class to show issue with empty field.
					fieldNode.classList.add('invalid');
					// Add error message.
					if (fieldNode.previousElementSibling !== null && fieldNode.previousElementSibling.classList.contains('field-error')) {
						fieldNode.previousElementSibling.innerHTML = errorMessage;
					}
				}
			}

			// Check value on each update.
			fieldNode.addEventListener('keyup', fieldNode.checkFieldValue);
			// Add event on focus out to display issues with value of the field.
			fieldNode.addEventListener('focusout', fieldNode.displayFieldErrors);

			// Attempt to initialize selector if the field type is hidden.
			if (fieldType === 'hidden') {
				initializeSelector();
			}

			// Create an event to externally run a check.
			fieldNode.addEventListener('checkfield', () => {
				// Do default checks.
				fieldNode.checkFieldValue();
				fieldNode.displayFieldErrors();
			});
		});

		submitButton.addEventListener('click', () => {

			grecaptcha.ready(function() {
				grecaptcha.execute(wpApiSettings.captcha, {action: 'submit'}).then(function(token) {
					// Prepare form values.
					const requestArgs = {
						post_id: wpApiSettings.post_id,
						captcha_token: token,
					};
					// Populate arguments array with values from input fields.
					formFields.forEach((fieldNode) => {
						// Check whether the field is disabled.
						if (fieldNode.disabled) {
							return;
						}
						// Get the field value name.
						requestArgs[fieldNode.getAttribute('name')] = fieldNode.value;
						// Check the field and display errors.
						fieldNode.dispatchEvent(new CustomEvent('checkfield'));
					});

					// Check if the all of the fields are filled in.
					if (invalidFields > 0) {
						return;
					}

					// Check the honeypot.
					if (formNode.querySelector('input.test-question').value.length > 0) {
						return;
					}

					// Make request to submit review form.
					axios.post(requestPath, requestArgs,  { headers: { 'X-WP-Nonce': wpApiSettings.nonce } }).then((response) => {
						if (response.data.status === 200) {
							// Set height of the pop-up window.
							formNode.style.height = formNode.offsetHeight + 'px';
							// Find success message node.
							const successMessage = formNode.querySelector('.success-message');
							// Find form content node.
							const formContent = formNode.querySelector('.form-content');

							if (formContent !== null && successMessage !== null) {
								// Set success message node to height of the form to retain overall height.
								successMessage.style.height = formContent.offsetHeight + 'px';
								// Display success message;
								successMessage.classList.remove('hidden');
								// Remove form node.
								formContent.remove();
							}
						}

						if (response.data.status === 500) {
							// Display submit form error.
							const errorMessage = formNode.querySelector('.submit-error');
							if (errorMessage) {
								errorMessage.classList.remove('hidden');
							}
						}
					}).catch((exceptions) => {
						console.log(exceptions);
					});
				});
			});
		});
	},
}

export default Forms;

