const config = {
    activeSection: 'home', // Pode ser 'home', 'about', 'contact', ou 'services'
    modules: {
        home: true,
        about: true,
        contact: false,
        services: true
    },
    navbar: [
        { label: 'Home', link: '#' },
        { label: 'About', link: '#' },
        { label: 'Services', link: '#' },
        { label: 'Contact', link: '#' }
    ]
};
