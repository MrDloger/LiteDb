document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("select[name='type_val']").addEventListener('change', function (event) {
        let type =  event.target.value;
        let inputs = document.querySelectorAll('input');
        for (let input of inputs) {
            let name = input.getAttribute('name');
            if (name.indexOf(type) > 0) {
                input.parentNode.style.display = 'block';
            } else {
                input.parentNode.style.display = 'none';
            }
        }

    })
});