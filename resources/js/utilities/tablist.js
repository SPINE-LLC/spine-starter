// Reference for HTML
// https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/tab_role

const ariaTablist = {
	// Function to handle the behavior of the tablist and tabs
	handleTabList(tabList) {
		const tabs = tabList.querySelectorAll('[role="tab"]');
		const tabGroup = tabList.parentNode; // Get the tab group

		let tabFocus = 0;

		// Add a click event handler to each tab
		tabs.forEach((tab) => {
			tab.addEventListener("click", changeTabs);
		});

		// Enable arrow navigation between tabs in the tab list
		tabList.addEventListener("keydown", (e) => {
			if (e.key === "ArrowRight" || e.key === "ArrowLeft") {
				tabs[tabFocus].setAttribute("tabindex", -1);
				if (e.key === "ArrowRight") {
					tabFocus++;
					if (tabFocus >= tabs.length) {
						tabFocus = 0;
					}
				} else if (e.key === "ArrowLeft") {
					tabFocus--;
					if (tabFocus < 0) {
						tabFocus = tabs.length - 1;
					}
				}
				tabs[tabFocus].setAttribute("tabindex", 0);
				tabs[tabFocus].focus();
			}
		});

		function changeTabs(e) {
			const targetTab = e.target;

			// Remove all current selected tabs
			tabList.querySelectorAll('[aria-selected="true"]').forEach((t) => {
				t.setAttribute("aria-selected", "false");
				t.classList.remove("is-active");
				t.setAttribute("tabindex", "-1");
			});

			// Set this tab as selected
			targetTab.setAttribute("aria-selected", "true");
			targetTab.classList.add("is-active");
			targetTab.setAttribute("tabindex", "0");

			// Hide all tab panels
			tabGroup
				.querySelectorAll('[role="tabpanel"]')
				.forEach((p) => {
					p.setAttribute("hidden", true);
					p.classList.remove("is-active");
				});

			// Show the selected panel and toggle the is-active class
			const panel = tabGroup.querySelector(
				`#${targetTab.getAttribute("aria-controls")}`
			);
			if (panel) {
				panel.removeAttribute("hidden");
				panel.classList.add("is-active");
			}
		}

		// Initialize the first tab as active
		const activeTab =
			tabList.querySelector('[aria-selected="true"]') || tabs[0];
		activeTab.setAttribute("aria-selected", "true");
		activeTab.classList.add("is-active");
		activeTab.setAttribute("tabindex", "0");

		// Set tabindex -1 on other tabs
		tabs.forEach((tab) => {
			if (tab !== activeTab) {
				tab.setAttribute("tabindex", "-1");
			}
		});

		// Set the corresponding panel to be visible
		const activePanel = tabGroup.querySelector(
			`#${activeTab.getAttribute("aria-controls")}`
		);
		if (activePanel) {
			activePanel.removeAttribute("hidden");
			activePanel.classList.add("is-active");
		}
	},

	// Init function to set up event listeners for current DOM elements
	init() {
		document.querySelectorAll('[role="tablist"]').forEach((tabList) => {
			this.handleTabList(tabList);
		});
	},

	// Observe function to monitor dynamically added elements
	observe() {
		const observer = new MutationObserver((mutations) => {
			mutations.forEach((mutation) => {
				if (mutation.type === "childList" && mutation.addedNodes.length) {
					mutation.addedNodes.forEach((node) => {
						if (
							node.nodeType === Node.ELEMENT_NODE &&
							node.getAttribute("role") === "tablist"
						) {
							// Attach the tablist handler to the newly added tablist
							this.handleTabList(node);
						} else if (node.nodeType === Node.ELEMENT_NODE) {
							// If it's not a tablist, search for tablist elements within the node
							node.querySelectorAll('[role="tablist"]').forEach((tabList) => {
								this.handleTabList(tabList);
							});
						}
					});
				}
			});
		});

		observer.observe(document.body, {
			childList: true,
			subtree: true, // Ensures it observes changes deep within the DOM
		});
	},
};

export const init = () => {
	// Initialize and observe dynamically added elements
	ariaTablist.init();
	ariaTablist.observe();
};
