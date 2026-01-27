const ariaToggleExpanded = (menu) => {
	function expOn(target) {
		target.setAttribute('aria-expanded', 'true');
	}

	function expOff(target) {
		target.setAttribute('aria-expanded', 'false');
	}

	menu.forEach(bar => {
		var exp = bar.querySelectorAll('[aria-expanded]');

		exp.forEach(item => {
			// Keyboard and mouse actions
			item.addEventListener('mouseenter', () => expOn(item));
			item.addEventListener('mouseleave', () => expOff(item));
			item.addEventListener('focusin', () => expOn(item));
			item.addEventListener('focusout', () => expOff(item));
		});
	});
};

const ariaAccordionToggleExpanded = (menu) => {
	menu.forEach(bar => {
		var details = bar.querySelectorAll('details');

		details.forEach(detail => {
			// Find the closest parent element with aria-expanded attribute
			var parentWithAriaExpanded = detail.closest('[aria-expanded]');

			// Check if the details element is open and set aria-expanded accordingly on the closest parent
			if (detail.hasAttribute('open')) {
				parentWithAriaExpanded.setAttribute('aria-expanded', 'true');
			} else {
				parentWithAriaExpanded.setAttribute('aria-expanded', 'false');
			}

			// Listen for toggle events on the details element
			detail.addEventListener('toggle', function () {
				// Find the closest parent element with aria-expanded attribute
				var parentWithAriaExpanded = this.closest('[aria-expanded]');

				if (this.hasAttribute('open')) {
					parentWithAriaExpanded.setAttribute('aria-expanded', 'true');
				} else {
					parentWithAriaExpanded.setAttribute('aria-expanded', 'false');
				}
			});
		});
	});
};

const runAriaMenu = (selector) => {
	const menu = document.querySelectorAll(selector);
	ariaToggleExpanded(menu);
};

const runAriaAccordionMenu = (selector) => {
	const menu = document.querySelectorAll(selector);
	ariaAccordionToggleExpanded(menu);
};

export const init = () => {
	// Typical menu
	runAriaMenu('.nav:has([aria-expanded]):not(:has(details))');

	// Accordion menu
	runAriaAccordionMenu('.nav:has([aria-expanded]):has(details)');
};
