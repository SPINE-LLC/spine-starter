import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Detection
import { init as initAtTop } from "./detection/at-top";
import { init as initDeviceInput } from "./detection/device-input";

// Components
import { init as initAriaMenu } from "./components/aria-menu";

// Initialize all modules
document.addEventListener('DOMContentLoaded', () => {
  // Detection
	initAtTop();
	initDeviceInput();

  // Components
  initAriaMenu();
});
