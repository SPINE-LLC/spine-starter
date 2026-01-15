import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Detection
import { init as initAtTop } from "./detection/at-top";

// Initialize all modules
document.addEventListener('DOMContentLoaded', () => {
  // Detection
	initAtTop();
});
