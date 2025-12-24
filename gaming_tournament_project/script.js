// Simple example: highlight table row on hover
document.querySelectorAll('table tr').forEach(row => {
    row.addEventListener('mouseenter', () => row.style.background='#e0e0ff');
    row.addEventListener('mouseleave', () => row.style.background='white');
});
