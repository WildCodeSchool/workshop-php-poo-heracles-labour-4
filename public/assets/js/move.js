document.addEventListener('keydown', (event) => {
    const keyName = event.key;
    const directions = { ArrowUp: 'N', ArrowDown: 'S', ArrowRight: 'E', ArrowLeft: 'W' };

    if (keyName in directions) {
        event.preventDefault();
        fetch('http://localhost:8000/?move=' + directions[keyName])
            .then(response => response.text())
            .then(html => document.documentElement.innerHTML = html);
    }
});