import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Utilities
import { init as initControls } from "./utilities/controls";
import { init as initTablist } from "./utilities/tablist";
import { init as initThemeSwitcher } from "./utilities/theme-switcher";
import { init as initVideoController } from "./utilities/video-controller";

// Detection
import { init as initAtTop } from "./detection/at-top";
import { init as initDeviceInput } from "./detection/device-input";

// Components
import { init as initAriaMenu } from "./components/aria-menu";



// Initialize all modules
document.addEventListener('DOMContentLoaded', () => {

  // Utilities
	initControls();
	initTablist();
  initThemeSwitcher();
	initVideoController();

  // Detection
	initAtTop();
	initDeviceInput();

  // Components
  initAriaMenu();
});
