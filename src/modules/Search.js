class Search {
	constructor() {
		this.openButton = document.querySelectorAll(".js-search-trigger");
		this.closeButton = document.querySelector(".search-overlay__close");
		this.searchOverlay = document.querySelector(".search-overlay");
		this.resultsDiv = document.querySelector(".search-overlay__results");
		this.searchTerm = document.querySelector(".search-term");
		this.typingTimer;
		this.showLoader = false;

		this.openButton.forEach((ele) => {
			ele.addEventListener("click", () => {
				console.log("Direct click on openButton");
			});
		});

		this.events();
	}

	events() {
		this.openButton.forEach((ele) => {
			ele.addEventListener("click", this.openOverlay.bind(this));
		});

		this.closeButton.addEventListener("click", this.closeOverlay.bind(this));

		document.addEventListener("keyup", this.keyPressDispatcher.bind(this));

		this.searchTerm.addEventListener("keyup", this.typingLogic.bind(this));
	}

	openOverlay(event) {
		event.stopPropagation();
		event.preventDefault();
		console.log("Open button clicked");
		if (this.searchOverlay) {
			this.searchOverlay.classList.add("search-overlay--active");
			document.querySelector("body").classList.add("body-no-scroll");
			console.log("Overlay should be active now");
		} else {
			console.error("Search overlay not found");
		}
	}

	closeOverlay() {
		console.log("Close button clicked");
		if (this.searchOverlay) {
			this.searchOverlay.classList.remove("search-overlay--active");
			document.querySelector("body").classList.remove("body-no-scroll");
			console.log("Overlay should be inactive now");
		} else {
			console.error("Search overlay not found");
		}
	}

	keyPressDispatcher(event) {
		const activeElement = document.activeElement;
		if (
			event.key === "s" &&
			activeElement.tagName !== "INPUT" &&
			activeElement.tagName !== "TEXTAREA"
		) {
			this.openOverlay(event);
		} else if (event.key === "Escape") {
			this.closeOverlay();
		}
	}

	typingLogic() {
		console.log("called!");

		if (this.showLoader) {
			this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
		} else {
			this.resultsDiv.innerHTML = "";
		}

		this.typingTimer = setTimeout(this.getResults.bind(this), 500);
	}

	async getResults() {
		const searchTerm = this.searchTerm.value;

		if (searchTerm !== "") {
			try {
				const [posts, events, programs, professors] = await Promise.all([
					fetch(
						`http://localhost:10013/wp-json/wp/v2/posts?search=${searchTerm}`
					).then((response) => response.json()),
					fetch(
						`http://localhost:10013/wp-json/wp/v2/event?search=${searchTerm}`
					).then((response) => response.json()),
					fetch(
						`http://localhost:10013/wp-json/wp/v2/program?search=${searchTerm}`
					).then((response) => response.json()),
					fetch(
						`http://localhost:10013/wp-json/wp/v2/professor?search=${searchTerm}`
					).then((response) => response.json()),
				]);

				console.log(posts);
				console.log(events);
				console.log(programs);
				console.log(professors);

				const combinedResults = [
					...(posts || []),
					...(events || []),
					...(programs || []),
					...(professors || []),
				];

				this.resultsDiv.innerHTML = `
                <h2 class="search-overlay__section-title">Search Results</h2>
                <ul class="link-list min-list">
                    ${combinedResults
											.map(
												(item) => `
                                <li><a href="${item.link}">${item.title.rendered}</a> (${item.type})</li>
                            `
											)
											.join("")}
                </ul>
            `;
			} catch (error) {
				console.error("Error:", error);
				this.resultsDiv.innerHTML =
					"<p>Sorry, something went wrong. Please try again.</p>";
			}
		}
	}
}

export default Search;
