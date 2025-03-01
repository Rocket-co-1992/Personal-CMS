async function fetchData(endpoint) {
    const response = await fetch(endpoint);
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
}

async function fetchConfig() {
    return fetchData('/api/new-config');
}
