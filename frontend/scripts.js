document.addEventListener('DOMContentLoaded', function() {
    // Adicione interatividade aqui
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Button clicked!');
        });
    });
});
