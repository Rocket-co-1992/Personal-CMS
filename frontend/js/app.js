document.addEventListener('DOMContentLoaded', async () => {
    const config = await fetchConfig();

    await loadComponent('navbar', 'components/navbar.html');
    const navbarList = document.getElementById('navbar-list');
    config.navbar.forEach(item => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = item.link;
        a.textContent = item.label;
        li.appendChild(a);
        navbarList.appendChild(li);
    });

    document.getElementById('customize-navbar').addEventListener('click', async () => {
        await loadComponent('settings', 'components/settings.html');
        const settingsForm = document.getElementById('settings-form');
        settingsForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const newLabel = document.getElementById('navbar-label').value;
            const newLink = document.getElementById('navbar-link').value;
            if (newLabel && newLink) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = newLink;
                a.textContent = newLabel;
                li.appendChild(a);
                navbarList.appendChild(li);
                config.navbar.push({ label: newLabel, link: newLink });
            }
        });
    });

    await loadComponent('header', 'components/header.html');
    await loadComponent('sidebar', 'components/sidebar.html');
    await loadComponent('content', 'components/content.html');
    document.getElementById('date').textContent = formatDate(new Date());
    await loadComponent('footer', 'components/footer.html');
    await loadComponent('modal', 'components/modal.html');
    const modal = document.getElementById('modal');
    const closeButton = document.querySelector('.close-button');
    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });
    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    await loadComponent('profile', 'components/profile.html');
    document.getElementById('user-name').textContent = config.userProfile.name;
    document.getElementById('user-email').textContent = config.userProfile.email;
});

async function loadComponent(id, url) {
    const response = await fetch(url);
    const text = await response.text();
    document.getElementById(id).innerHTML = text;
}

async function fetchConfig() {
    const response = await fetch('/config');
    return response.json();
}
