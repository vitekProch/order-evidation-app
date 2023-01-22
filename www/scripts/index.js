document.addEventListener(
    'DOMContentLoaded',
    () => {
        naja.addEventListener('complete', () => {
            document.body.style.backgroundColor = `#$(Math.floor(Math.random() * (2**24)).toString(16)`;
        });

    }
);