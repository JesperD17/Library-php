function openCloseMenu(e) {
    e.preventDefault();

    const div = e.currentTarget;
    const parent = div.parentElement;
    const icon = div.querySelector('.bx');
    if (!div || !parent || !icon) return;
    console.log(parent);
    

    parent.classList.toggle('open');
    icon.classList.toggle('turnDiv', parent.classList.contains('open'));

    if (parent.classList.contains('open')) {
        const handleOutsideClick = (ev) => {
            console.log(ev);
            
            if (!div.contains(ev.target)) {
                parent.classList.remove('open');
                icon.classList.remove('turnDiv');
                document.removeEventListener('click', handleOutsideClick);
            }
            document.removeEventListener('click', handleOutsideClick);
        };
        setTimeout(() => document.addEventListener('click', handleOutsideClick), 0);
    }
}
