// Listen for messages from the popup
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === 'fetchVideoInfo') {
        const url = request.url;
        
        fetch('https://hdvideosaver.com/extract', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ url: url })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            sendResponse({ success: true, data: data });
        })
        .catch(error => {
            sendResponse({ success: false, error: error.message });
        });

        return true; // Keep the messaging channel open for asynchronous sendResponse
    }
});
