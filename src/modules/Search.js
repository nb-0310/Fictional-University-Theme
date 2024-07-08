class Search {
	constructor() {
		this.addSearchHTML();
        console.log('after fn call')

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
        this.searchTerm.value = ''
        this.resultsDiv.innerHTML = '<h2 class="search-overlay__section-title">Search Results</h2>'
		console.log("Open button clicked");
		if (this.searchOverlay) {
			this.searchOverlay.classList.add("search-overlay--active");
			document.querySelector("body").classList.add("body-no-scroll");
            setTimeout(() => this.searchTerm.focus(), 301)
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
        this.showLoader = true
		const searchTerm = this.searchTerm.value;

		try {
			const res = await fetch(`http://localhost:10013/wp-json/university/search?term=${searchTerm}`)
			const data = await res.json()

			console.log(data)

			this.resultsDiv.innerHTML = `
				<div class="row">
					<div class="one-third">
						<h2 class="search-overlay__section-title">General Information</h2>
						 <ul class="link-list min-list">
						${
							data['general_info']
								.map((item) => `<li><a href="${item.permalink}">${item.title}</a> ${item.type === 'post' ? `(By ${item.authorName})` : ''}</li>`)
								.join("")
						}
                		</ul>
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Programs</h2>
						<ul class="link-list min-list">
						${
							data['programs'].length ? data['programs']
							.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`)
							.join("") : `<p>No programs match that search. <a href="${data.root_url}/programs">View all programs</a></p>`
						}
                		</ul>

						<h2 class="search-overlay__section-title">Professors</h2>
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Events</h2>
					</div>
				</div>
			`
			this.showLoader = false
		} catch (error) {
			
		}

		// delete this code later

		// if (searchTerm !== "") {
		// 	try {
		// 		const [posts, events, programs, professors, pages] = await Promise.all([
		// 			fetch(
		// 				`http://localhost:10013/wp-json/wp/v2/posts?search=${searchTerm}`
		// 			).then((response) => response.json()),
		// 			fetch(
		// 				`http://localhost:10013/wp-json/wp/v2/event?search=${searchTerm}`
		// 			).then((response) => response.json()),
		// 			fetch(
		// 				`http://localhost:10013/wp-json/wp/v2/program?search=${searchTerm}`
		// 			).then((response) => response.json()),
		// 			fetch(
		// 				`http://localhost:10013/wp-json/wp/v2/professor?search=${searchTerm}`
		// 			).then((response) => response.json()),
        //             fetch(
		// 				`http://localhost:10013/wp-json/wp/v2/pages?search=${searchTerm}`
		// 			).then((response) => response.json()),
		// 		]);

		// 		const combinedResults = [
		// 			...(posts || []),
		// 			...(events || []),
		// 			...(programs || []),
		// 			...(professors || []),
        //             ...(pages || [])
		// 		];

		// 		this.resultsDiv.innerHTML = `
        //         <h2 class="search-overlay__section-title">Search Results</h2>
        //         <ul class="link-list min-list">
        //             ${
        //                 combinedResults
        //                     .map((item) => `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type === 'post' ? `(By ${item.authorName})` : ''}</li>`)
        //                     .join("")
        //             }
        //         </ul>
        //     `;
		// 	} catch (error) {
		// 		console.error("Error:", error);
		// 		this.resultsDiv.innerHTML =
		// 			"<p>Sorry, something went wrong. Please try again.</p>";
		// 	} finally {
        //         this.showLoader = false
        //     }
		// }
	}

	addSearchHTML() {
        console.log('fn called')
		const searchHTML = document.createElement("div");

		searchHTML.innerHTML = `
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay_icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
    
                <div class="container">
                    <div class="search-overlay__results"></div>
                </div>
        `;
		document.body.appendChild(searchHTML);
		searchHTML.classList.add("search-overlay");
	}
}

export default Search;
