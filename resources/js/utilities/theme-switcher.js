/**
 * This function requires a <select> element with 3 values. One <option> with name='light'
 * & another with name='dark'. A 3rd is preferred to allow picking the OS Default.
 */
import { UAParser } from 'ua-parser-js';

const manageSiteTheme = (selectID) => {
	// Get theme switcher by ID
	const themeSwitcher = document.getElementById(selectID);

	// Check if element exists
	if (themeSwitcher) {
		// Watch for change to the theme switcher
		themeSwitcher.addEventListener('change', () => {
			// Set the theme value
			localStorage.theme = themeSwitcher.value;

			// Switch the theme to the value
			switchTheme(themeSwitcher, 'data-theme');
		});

		// Set to light theme when there's no localstorage & is a mobile device
		if (!localStorage.theme) {
			const parser = new UAParser();
			const device = parser.getDevice();
			if (device.type === 'mobile') {
				localStorage.theme = 'light';
			}
		}

		// Check if localstorage exists
		if (localStorage.theme) {
			// Set the value from localstorage
			themeSwitcher.value = localStorage.theme;

			// Run event to switch <select> to match active theme
			themeSwitcher.dispatchEvent(new Event('change'));
		}
	}
};

const switchTheme = (select, attr) => {
	const html = document.documentElement;
	const value = select.value;
	return value === 'light' || value === 'dark' ? html.setAttribute(attr, value) : html.removeAttribute(attr);
};

export const init = () => {
	// Run the theme management
	manageSiteTheme('theme-switcher');
};
