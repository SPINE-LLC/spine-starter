const ariaControls = {
	// Function to toggle the visibility of the content
	toggleContent(button) {
		const targetIds = button.getAttribute("aria-controls").split(" ");
		const targets = targetIds
			.map((id) => document.getElementById(id))
			.filter((el) => el !== null);

		if (!targets.length) return;

		const isExpanded = button.getAttribute("aria-expanded") === "true";

		// Update all buttons that control any of the same targets
		document.querySelectorAll('[aria-controls]').forEach((btn) => {
			const btnTargetIds = btn.getAttribute("aria-controls").split(" ");
			const hasCommonTarget = targetIds.some(id => btnTargetIds.includes(id));
			if (hasCommonTarget) {
				btn.setAttribute("aria-expanded", !isExpanded);
			}
		});

		if (!isExpanded) {
			// Show content and focus the first focusable element
			targets.forEach((target) => target.removeAttribute("hidden"));
			const firstFocusable = targets[0]?.querySelector(
				'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
			);
			if (firstFocusable) firstFocusable.focus();
		} else {
			// Hide content and return focus to the button
			targets.forEach((target) => target.setAttribute("hidden", ""));
			button.focus();
		}
	},

	// Init function to set up event listeners for current DOM elements
	init() {
		document.querySelectorAll(`[aria-controls]:not([role="tab"])`).forEach((button) => {
			button.addEventListener("click", () => this.toggleContent(button));
		});
	},

	// Observe function to monitor dynamically added elements and attribute changes
	observe() {
		const observer = new MutationObserver((mutations) => {
			mutations.forEach((mutation) => {
				if (mutation.type === "childList" && mutation.addedNodes.length) {
					mutation.addedNodes.forEach((node) => {
						if (
							node.nodeType === Node.ELEMENT_NODE &&
							node.matches(`[aria-controls]:not([role="tab"])`)
						) {
							// Attach event listener to the newly added element
							node.addEventListener("click", () => this.toggleContent(node));
						} else if (node.nodeType === Node.ELEMENT_NODE) {
							// If it's not the button itself, search for descendants with aria-controls
							node.querySelectorAll(`[aria-controls]:not([role="tab"])`).forEach((button) => {
								button.addEventListener("click", () =>
									this.toggleContent(button)
								);
							});
						}
					});
				} else if (mutation.type === "attributes" && mutation.attributeName === "aria-controls") {
					const target = mutation.target;
					if (
						target.nodeType === Node.ELEMENT_NODE &&
						target.matches &&
						target.matches(`[aria-controls]:not([role="tab"])`)
					) {
						// Attach event listener to the element that now has aria-controls
						target.addEventListener("click", () => this.toggleContent(target));
					}
				}
			});
		});

		observer.observe(document.body, {
			childList: true,
			subtree: true, // Ensures it observes changes deep within the DOM
			attributes: true,
			attributeFilter: ['aria-controls'], // Observe changes to aria-controls attribute
		});
	},
};

export const init = () => {
	// Initialize and observe dynamically added elements
	ariaControls.init();
	ariaControls.observe();
};
