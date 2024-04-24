document.addEventListener("DOMContentLoaded", function () {
    let startIndex = 24; // Adjust this initial value based on your setup
    let loading = false;

    window.onscroll = function () {
        // Check if the user is near the bottom of the page and if not currently loading
        if (
            window.innerHeight + window.pageYOffset >=
                document.body.offsetHeight - 2 &&
            !loading
        ) {
            loading = true;
            fetch(`/dashboard?startIndex=${startIndex}&query=programming`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const newBooks = doc.querySelector(".grid");
                    if (newBooks) {
                        document.querySelector(".grid").appendChild(newBooks);
                        startIndex += 24; // Increment to fetch the next set of books
                    }
                    loading = false;
                })
                .catch((error) => {
                    console.error("Error loading more books:", error);
                    loading = false;
                });
        }
    };
});
