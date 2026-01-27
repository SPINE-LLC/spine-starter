import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Detection
import { init as initAtTop } from "./detection/at-top";
import { init as initDeviceInput } from "./detection/device-input";

// Initialize all modules
document.addEventListener('DOMContentLoaded', () => {
  // Detection
	initAtTop();
	initDeviceInput();
});
