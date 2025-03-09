(function () {
    const TRACKING_URL = "https://andalio.work/api/track/visit";

    function generateUserHash() {
        return btoa(navigator.userAgent + Math.floor(Date.now() / 86400000));
    }

    function trackVisit() {
        const pageUrl = window.location.href;
        const userHash = generateUserHash();
        const visitDate = new Date().toISOString().split("T")[0];

        const visitKey = "tracked_" + visitDate + "_" + pageUrl;

        if (localStorage.getItem(visitKey)) {
            console.log("Visit already registered for today.");
            return;
        }

        const data = {
            pageUrl: pageUrl,
            userHash: userHash,
            visitDate: visitDate
        };

        fetch(TRACKING_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                console.log("Tracking success:", data);
                localStorage.setItem(visitKey, "true");
            })
            .catch(error => {
                console.log("Tracking error:", error);
            });
    }

    trackVisit();
})();
