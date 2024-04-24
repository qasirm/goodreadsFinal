document.addEventListener("DOMContentLoaded", function () {
    let startIndex = 24; // Adjust this initial value based on your setup
    let loading = false;

    window.onscroll = function () {
        if (
            window.innerHeight + window.pageYOffset >=
                document.body.offsetHeight - 200 &&
            !loading
        ) {
            loading = true;
            const query =
                document.getElementById("searchQuery").value || "defaultQuery"; // Get the search query or default
            fetch(
                `/dashboard?query=${encodeURIComponent(
                    query
                )}&startIndex=${startIndex}&maxResults=24`,
                {
                    headers: { "X-Requested-With": "XMLHttpRequest" },
                }
            )
                .then((response) => response.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    document
                        .querySelector(".grid")
                        .appendChild(doc.querySelector(".grid"));
                    startIndex += 24;
                    loading = false;
                })
                .catch((error) => {
                    console.error("Error loading more books:", error);
                    loading = false;
                });
        }
    };
});
